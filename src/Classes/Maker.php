<?php

namespace Helium\SpreadsheetManager\Classes;

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Maker
{
    private function makeSheet(array $header = [], array $data = [], ?string $nameExt, string $format) : string
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $startingRow = 0;

        //If there is a header, offset the row by 1
        if($header && is_array($header)){
            $columnLetter = 'A';

            foreach($header as $key => $value){
                $sheet->setCellValue($columnLetter . '1', $value);
                $columnLetter = chr(ord($columnLetter) + 1);
            }

            $startingRow = 1;
        }

        foreach($data as $row  => $rowData){

            $columnLetter = 'A';
            foreach($rowData as $column => $value) {

                $sheet->setCellValue($columnLetter . ($row + $startingRow + 1), $value);
                $columnLetter = chr(ord($columnLetter) + 1);
            }

        }

        //create an output file in the temp directory
        $fileName = $nameExt ? $nameExt : uniqId();
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        rename($tempFile, $tempFile .= '.'. $format);


        $writer = $format == 'xls' ? new Xlsx($spreadsheet) : new Csv($spreadsheet);
        $writer->save($tempFile);

        //clean up sheet from memory
        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);

        //return spreadsheet file
        return $tempFile;
    }

    public function makeXls(array $header = [], array $data = [], ?string $nameExt) : string
    {
        return $this->makeSheet($header, $data, $nameExt, 'xls');
    }

    public function makeCsv(array $header = [], array $data = [], ?string $nameExt) : string
    {
        return $this->makeSheet($header, $data, $nameExt, 'csv');
    }
}