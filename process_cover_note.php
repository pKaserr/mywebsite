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

    $templatePathCoverNote = __DIR__ . '/includes/cover_note_template.docx';

    $tempDir = sys_get_temp_dir();
    $baseFileName = 'Motivationsschreiben_' . preg_replace('/[^a-zA-Z0-9]/', '_', $login) . '_patrick_kaserer';
    $docxFile = $tempDir . DIRECTORY_SEPARATOR . $baseFileName . '.docx';

    try {
        $templateProcessor = new TemplateProcessor($templatePathCoverNote);
        $templateProcessor->setValue('p_salutation', $salutation);
        $templateProcessor->setValue('p_login', $login);
        $templateProcessor->setValue('p_passwort', $password);

        $raw_text = $_POST['p_text'] ?? '';


        $text_step1 = str_replace("\r\n", "\n", $raw_text);
        $text_step2 = str_replace("\r", "\n", $text_step1);

        $text_safe = htmlspecialchars($text_step2);
        $text_final = str_replace("\n", "</w:t><w:br/><w:t>", $text_safe);


        $templateProcessor->setValue('p_text', $text_final);
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
