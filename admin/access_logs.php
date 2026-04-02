<?php
// 1. KONFIGURATION & AUTH
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../includes/load_colors.php';

// Admin Check
$sql = "SELECT role FROM user WHERE user_name = :user_name";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_name', $_SESSION['user_name'], PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || $user['role'] !== 'admin') {
    http_response_code(403);
    die('Forbidden');
}

// 2. LOGIK-KLASSE (Kapselung der Funktionen)
class LogAnalyzer
{

    private $cacheDir;

    public function __construct()
    {
        $this->cacheDir = __DIR__ . '/../cache';
        if (!is_dir($this->cacheDir)) {
            @mkdir($this->cacheDir, 0777, true);
        }
    }

    // Liest Zeilen speicherschonend (Generator)
    public function readLogLines(string $filePath): Generator
    {
        $isGz = strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) === 'gz';

        if ($isGz) {
            $handle = @gzopen($filePath, 'rb');
            if (!$handle)
                throw new RuntimeException('Konnte GZ-Datei nicht öffnen: ' . basename($filePath));
            try {
                while (!gzeof($handle))
                    yield gzgets($handle);
            } finally {
                gzclose($handle);
            }
        } else {
            $handle = @fopen($filePath, 'rb');
            if (!$handle)
                throw new RuntimeException('Konnte Datei nicht öffnen: ' . basename($filePath));
            try {
                while (!feof($handle))
                    yield fgets($handle);
            } finally {
                fclose($handle);
            }
        }
    }

    // Parst eine Zeile (Common/Combined Log Format)
    public function parseLogLine(string $line): ?array
    {
        $line = trim($line);
        if ($line === '')
            return null;

        // Regex für Standard Apache/Nginx Logs
        $pattern = '/^(?P<ip>\S+)\s+\S+\s+\S+\s+\[(?P<time>[^\]]+)\]\s+"(?P<request>[^"]*)"\s+(?P<status>\d{3})\s+(?P<size>\S+)(?:\s+"(?P<referer>[^"]*)")?(?:\s+"(?P<agent>[^"]*)")?/';

        if (!preg_match($pattern, $line, $matches))
            return null;

        $method = $path = '';
        if (!empty($matches['request'])) {
            $parts = explode(' ', $matches['request'], 3);
            $method = $parts[0] ?? '';
            $path = $parts[1] ?? '';
        }

        return [
            'ip' => $matches['ip'] ?? '',
            'time' => $matches['time'] ?? '',
            'method' => $method,
            'path' => $path,
            'status' => isset($matches['status']) ? (int) $matches['status'] : 0,
            'size' => $matches['size'] ?? '-',
            'referer' => $matches['referer'] ?? '',
            'agent' => $matches['agent'] ?? '',
        ];
    }

    // Holt Geo-Daten inkl. ISP/AS
    // Holt Geo-Daten inkl. ISP/AS
    public function geolocateIps(array $ips): array
    {
        $cacheFile = $this->cacheDir . '/ip_geo_cache.json';
        $cache = [];

        if (is_file($cacheFile)) {
            $json = file_get_contents($cacheFile);
            $cache = json_decode($json, true) ?: [];
        }

        $now = time();
        $ttl = 60 * 60 * 24 * 14; // 14 Tage Cache
        $result = [];
        $toLookup = [];

        foreach ($ips as $ip) {
            if (!filter_var($ip, FILTER_VALIDATE_IP))
                continue;

            // CHECK: Ist der Cache aktuell UND enthält er schon die ISP-Daten?
            // Wenn 'isp' fehlt, erzwingen wir ein Neuladen!
            $hasIspData = isset($cache[$ip]['isp']);
            $isFresh = isset($cache[$ip]['_ts']) && ($now - (int) $cache[$ip]['_ts'] < $ttl);

            if ($hasIspData && $isFresh) {
                $result[$ip] = $cache[$ip];
            } else {
                $toLookup[] = $ip;
            }
        }

        // Limit API Calls (max 100 pro Seitenaufruf)
        $toLookup = array_slice(array_values(array_unique($toLookup)), 0, 100);

        foreach ($toLookup as $ip) {
            // Wir fragen explizit nach 'isp' und 'as'
            $url = 'http://ip-api.com/json/' . urlencode($ip) . '?fields=status,country,regionName,city,lat,lon,isp,as,query';

            $ctx = stream_context_create(['http' => ['timeout' => 3]]);
            $resp = @file_get_contents($url, false, $ctx);
            $data = json_decode($resp ?? '', true) ?: [];

            if (($data['status'] ?? '') === 'success') {
                $entry = [
                    'country' => $data['country'] ?? '',
                    'region' => $data['regionName'] ?? '',
                    'city' => $data['city'] ?? '',
                    'lat' => $data['lat'] ?? null,
                    'lon' => $data['lon'] ?? null,
                    'isp' => $data['isp'] ?? '',
                    'as' => $data['as'] ?? '',
                    '_ts' => $now,
                ];
                $cache[$ip] = $entry;
                $result[$ip] = $entry;
            } else {
                // Bei Fehler oder Rate-Limit merken wir uns das, damit wir nicht sofort wieder fragen
                // Wir behalten alte Daten falls vorhanden, sonst 'Unknown'
                $oldData = $cache[$ip] ?? [];
                $entry = array_merge($oldData, ['_ts' => $now]);
                if (empty($entry['country']))
                    $entry['country'] = 'Unknown';

                $cache[$ip] = $entry;
                $result[$ip] = $entry;
            }
            // Kurze Pause für die API
            usleep(100000);
        }

        file_put_contents($cacheFile, json_encode($cache, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $result;
    }
}

// 3. DATENVERARBEITUNG
$analyzer = new LogAnalyzer();
$logDir = realpath(__DIR__ . '/../logs');

// Log Dateien finden
$logFiles = [];
if ($logDir) {
    $patterns = ["$logDir/access.log", "$logDir/access.log.*", "$logDir/access.log.*.gz"];
    foreach ($patterns as $pattern) {
        foreach (glob($pattern) ?: [] as $path) {
            if (is_file($path))
                $logFiles[$path] = basename($path);
        }
    }
    uksort($logFiles, fn($a, $b) => filemtime($b) <=> filemtime($a));
}

// Request Parameter
$selectedBase = $_GET['file'] ?? '';
$selectedPath = '';
foreach ($logFiles as $path => $base) {
    if ($base === $selectedBase) {
        $selectedPath = $path;
        break;
    }
}
$limit = isset($_GET['limit']) ? max(50, min(5000, (int) $_GET['limit'])) : 500;

// Analyse durchführen
$viewData = [
    'rows' => [],
    'stats' => ['status' => [], 'ip' => [], 'country' => [], 'endpoint' => [], 'hours' => []],
    'geo' => [],
    'error' => null
];

if ($selectedPath) {
    try {
        $count = 0;
        foreach ($analyzer->readLogLines($selectedPath) as $line) {
            $entry = $analyzer->parseLogLine((string) $line);
            if (!$entry)
                continue;

            $viewData['rows'][] = $entry;

            // Statistiken sammeln
            $st = $entry['status'];
            $viewData['stats']['status'][$st] = ($viewData['stats']['status'][$st] ?? 0) + 1;

            $ip = $entry['ip'];
            $viewData['stats']['ip'][$ip] = ($viewData['stats']['ip'][$ip] ?? 0) + 1;

            $ep = $entry['method'] . ' ' . $entry['path'];
            $viewData['stats']['endpoint'][$ep] = ($viewData['stats']['endpoint'][$ep] ?? 0) + 1;

            if (!empty($entry['time'])) {
                $dt = DateTime::createFromFormat('d/M/Y:H:i:s O', $entry['time']);
                if ($dt) {
                    $h = $dt->format('Y-m-d H:00');
                    $viewData['stats']['hours'][$h] = ($viewData['stats']['hours'][$h] ?? 0) + 1;
                }
            }

            if (++$count >= $limit)
                break;
        }

        // Geo Location für gefundene IPs holen
        $uniqueIps = array_keys($viewData['stats']['ip']);
        $viewData['geo'] = $analyzer->geolocateIps($uniqueIps);

        // Länder Statistik aufbauen
        foreach ($viewData['rows'] as $r) {
            $c = $viewData['geo'][$r['ip']]['country'] ?? 'Unbekannt';
            $viewData['stats']['country'][$c] = ($viewData['stats']['country'][$c] ?? 0) + 1;
        }

        // Sortieren
        arsort($viewData['stats']['ip']);
        arsort($viewData['stats']['country']);
        arsort($viewData['stats']['endpoint']);
        ksort($viewData['stats']['hours']);

    } catch (Exception $e) {
        $viewData['error'] = $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <title>Access Logs Analyse</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        /* Ein bisschen lokales CSS für Layout-Korrekturen */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-box {
            background:
                <?= $c2_main ?>
            ;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .stat-box h5 {
            margin-top: 0;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        .log-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9em;
        }

        .log-table th,
        .log-table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        /* .log-table tr:hover { background-color: <?= $c_white ?>
        }

        */ .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.8em;
            background: #eee;
        }

        .isp-info {
            color:
                <?= $c_white ?>
            ;
            font-size: 0.85em;
            display: block;
        }
    </style>
</head>

<body>
    <div class="nav">
        <a href="../dashboard"><button class="btn btn--main btn--nav">Zurück</button></a>
        <a href="../logout"><button class="btn btn--main btn--nav">Abmelden</button></a>
    </div>

    <div class="container_dashboard">
        <div class="container__title">
            <h4 class="container__title--text">Access Logs</h4>
            <span>Logdatei-Analyse & Geolocation</span>
        </div>

        <div class="stat-box mb-8">
            <form method="get">
                <label for="file">Datei:</label>
                <select name="file" id="file" onchange="this.form.submit()">
                    <option value="">-- Datei wählen --</option>
                    <?php foreach ($logFiles as $base): ?>
                        <option value="<?= htmlspecialchars($base) ?>" <?= $base === $selectedBase ? 'selected' : '' ?>>
                            <?= htmlspecialchars($base) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="limit" style="margin-left: 15px">Zeilen:</label>
                <input type="number" name="limit" value="<?= $limit ?>" min="50" max="5000" style="width: 80px">
                <button class="btn btn--main" type="submit">Laden</button>
            </form>
        </div>

        <?php if ($viewData['error']): ?>
            <div style="color:<?= $c_red ?>; padding: 20px; background: #fee; border: 1px solid red; margin-bottom: 20px;">
                Fehler: <?= htmlspecialchars($viewData['error']) ?>
            </div>
        <?php endif; ?>

        <?php if ($selectedPath): ?>

            <div class="dashboard-grid">
                <div class="stat-box">
                    <h5>Übersicht</h5>
                    <p>Zeilen: <strong><?= count($viewData['rows']) ?></strong></p>
                    <p>Unique IPs: <strong><?= count($viewData['stats']['ip']) ?></strong></p>
                    <hr>
                    <?php foreach ($viewData['stats']['status'] as $code => $cnt): ?>
                        <span class="badge" style="background: <?= $code == 200 ? $c_success : ($code >= 400 ? $c_error : $c_warn) ?>">
                            <?= $code ?>: <?= $cnt ?>
                        </span>
                    <?php endforeach; ?>
                </div>

                <div class="stat-box">
                    <h5>Top Länder</h5>
                    <?php
                    $i = 0;
                    foreach ($viewData['stats']['country'] as $c => $cnt):
                        if (++$i > 8)
                            break;
                        ?>
                        <div style="display:flex; justify-content:space-between">
                            <span><?= htmlspecialchars($c) ?></span>
                            <strong><?= $cnt ?></strong>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="stat-box">
                    <h5>Top IPs & ISPs</h5>
                    <?php
                    $i = 0;
                    foreach ($viewData['stats']['ip'] as $ip => $cnt):
                        if (++$i > 10)
                            break;
                        $geo = $viewData['geo'][$ip] ?? [];
                        $isp = $geo['isp'] ?? '';
                        $as = $geo['as'] ?? '';
                        ?>
                        <div style="margin-bottom: 8px; border-bottom: 1px dashed #eee; padding-bottom: 4px;">
                            <div style="display:flex; justify-content:space-between">
                                <strong><?= htmlspecialchars($ip) ?></strong>
                                <span><?= $cnt ?> Hits</span>
                            </div>
                            <?php if ($isp): ?>
                                <small class="isp-info"><?= htmlspecialchars($isp) ?> (<?= htmlspecialchars($as) ?>)</small>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="stat-box">
                <h5>Log Details</h5>
                <div style="overflow-x: auto;">
                    <table class="log-table">
                        <thead>
                            <tr>
                                <th>Zeit</th>
                                <th>IP / Ort / ISP</th>
                                <th>Request</th>
                                <th>Status</th>
                                <th>UA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input id="time" type="text" placeholder="Zeit"></td>
                                <td><input id="ip" type="text" placeholder="IP / Ort / ISP"></td>
                                <td><input id="request" type="text" placeholder="Request"></td>
                                <td><input id="status" type="text" placeholder="Status"></td>
                                <td><input id="ua" type="text" placeholder="UA"></td>
                            </tr>
                            <?php foreach ($viewData['rows'] as $r):
                                $geo = $viewData['geo'][$r['ip']] ?? [];
                                $loc = implode(', ', array_filter([$geo['city'] ?? '', $geo['country'] ?? '']));
                                $isp = $geo['isp'] ?? '';
                                ?>
                                <tr>
                                    <td class="time"><?= htmlspecialchars(substr($r['time'], 0, 20)) ?></td>
                                    <td class="ip">
                                        <strong><?= htmlspecialchars($r['ip']) ?></strong><br>
                                        <small><?= htmlspecialchars($loc) ?></small><br>
                                        <small><?= htmlspecialchars($isp) ?></small>
                                    </td>
                                    <td class="request">
                                        <div style="max-width: 300px; word-wrap: break-word;">
                                            <?= htmlspecialchars($r['method'] . ' ' . $r['path']) ?>
                                        </div>
                                        <small><?= htmlspecialchars($r['referer']) ?></small>
                                    </td>
                                    <td class="status"><?= $r['status'] ?></td>
                                    <td class="ua" title="<?= htmlspecialchars($r['agent']) ?>">
                                        <?= htmlspecialchars(substr($r['agent'], 0, 30)) ?>...
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php endif; ?>
    </div>
    </div>
    <script>
        const ipInput = document.getElementById('ip');
        const requestInput = document.getElementById('request');
        const statusInput = document.getElementById('status');
        const timeInput = document.getElementById('time');
        const uaInput = document.getElementById('ua');

        inputList = [[ipInput, '.ip'], [requestInput, '.request'], [statusInput, '.status'], [timeInput, '.time'], [uaInput, '.ua']]
        inputList.forEach(input => {
            input[0].addEventListener('input', function () {
                rows = document.querySelectorAll(input[1]);

                rows.forEach(row => {
                    if (!row.textContent.includes(input[0].value)) {
                        row.parentElement.style.display = "none"
                    } else
                        row.parentElement.style.display = "table-row"
                    if (input[0].value == "") {
                        row.parentElement.style.display = "table-row"
                    }

                })
            });
        });
    </script>
</body>

</html>