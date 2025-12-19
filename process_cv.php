<?php
require './includes/auth.php';
require 'vendor/autoload.php';

use PhpOffice\PhpWord\TemplateProcessor;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $salutation = $_POST['p_salutation'] ?? '';
    $text_raw = $_POST['p_text'] ?? '';
    $login = $_POST['p_login'] ?? '';
    $password = $_POST['p_passwort'] ?? '';
    $format = $_POST['format'] ?? 'docx';

    $templatePathCoverNote = __DIR__ . '/includes/cv_template.docx';

    $tempDir = sys_get_temp_dir();
    $baseFileName = 'Lebenslauf_patrick_kaserer';
    $docxFile = $tempDir . DIRECTORY_SEPARATOR . $baseFileName . '.docx';

    try {
        $templateProcessor = new TemplateProcessor($templatePathCoverNote);
        $templateProcessor->setValue('p_login', $login);
        $templateProcessor->setValue('p_passwort', $password);

        $templateProcessor->saveAs($docxFile);
        if ($format === 'pdf') {
            // PDF GENERIERUNG VIA LIBREOFFICE
            // Befehl: libreoffice --headless --convert-to pdf --outdir [ZIEL] [QUELLE]

            // Prüfen, ob shell_exec verfügbar ist
            if (!function_exists('shell_exec')) {
                throw new Exception("shell_exec ist deaktiviert. PDF kann nicht lokal generiert werden.");
            }

            $command = 'libreoffice --headless --convert-to pdf --outdir ' . escapeshellarg($tempDir) . ' ' . escapeshellarg($docxFile);

            // Befehl ausführen
            shell_exec($command);

            $pdfFile = $tempDir . DIRECTORY_SEPARATOR . $baseFileName . '.pdf';

            if (file_exists($pdfFile)) {
                // PDF ausliefern
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="' . $baseFileName . '.pdf"');
                header('Content-Length: ' . filesize($pdfFile));
                readfile($pdfFile);

                // Aufräumen
                unlink($pdfFile);
                unlink($docxFile);
                exit;
            } else {
                throw new Exception("PDF-Datei wurde nicht erstellt. Ist LibreOffice installiert?");
            }
        } else {
            // DOCX ausliefern
            header('Content-Description: File Transfer');
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment; filename="' . $baseFileName . '.docx"');
            header('Content-Length: ' . filesize($docxFile));
            readfile($docxFile);

            // Aufräumen
            unlink($docxFile);
            exit;
        }
    } catch (Exception $e) {
        die("Fehler: " . $e->getMessage());
    }
}
