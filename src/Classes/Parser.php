<?php

namespace Helium\SpreadsheetManager\Classes;

use Helium\SpreadsheetManager\Exceptions\ParserException;

class Parser
{
    public static function csvToArray(string $filePath) : array
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw new ParserException;
        }

        $header = null;
        $data = array();
        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }
}