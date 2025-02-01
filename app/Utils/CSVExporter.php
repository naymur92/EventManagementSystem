<?php

namespace App\Utils;

class CSVExporter
{
    private array $data;
    private string $filename;
    private array $headers;

    public function __construct(array $data, string $filename = "export.csv")
    {
        $this->data = $data;
        $this->filename = $filename;
        $this->headers = array();
    }

    /**
     * Generate CSV and force download
     *
     * @return void
     */
    public function download(): void
    {
        // Set HTTP headers for file download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $this->filename . '"');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Open output stream
        $output = fopen('php://output', 'w');

        // set headers from array key
        if (!empty($this->data) && empty($this->headers)) {
            fputcsv($output, array_keys($this->data[0]));
        }

        // set custom headers
        if (!empty($this->headers)) {
            fputcsv($output, $this->headers);
        }

        foreach ($this->data as $row) {
            fputcsv($output, $row);
        }

        fclose($output);
        exit;
    }


    /**
     * Set headers
     *
     * @param array $headers
     * @return void
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }


    /**
     * Save to file
     *
     * @param string $filepath
     * @return void
     */
    public function saveToFile(string $filepath): void
    {
        $file = fopen($filepath, 'w');

        if (!empty($this->data)) {
            fputcsv($file, array_keys($this->data[0])); // Header row
        }

        foreach ($this->data as $row) {
            fputcsv($file, $row);
        }

        fclose($file);
    }
}
