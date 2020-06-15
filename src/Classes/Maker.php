<?php

namespace Helium\SpreadsheetManager\Classes;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Maker
{
    private static function makeSheet(array $header = [], array $data = [], ?string $nameExt, string $format) : string
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $startingRow = 0;

        //If there is a header, offset the row by 1
        //Increment column indexes by integer
        if($header && is_array($header)){
            $columnNumber = 1;
            foreach($header as $key => $value){
                $sheet->setCellValueByColumnAndRow($columnNumber, 1,  $value);
                $columnNumber++;
            }
            $startingRow = 1;
        }

        foreach($data as $row  => $rowData){
            $columnNumber = 1;
            foreach($rowData as $column => $value) {
                $sheet->setCellValueByColumnAndRow($columnNumber, ($row + $startingRow + 1), $value);
                $columnNumber++;
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

    public static function makeXls(array $header = [], array $data = [], ?string $nameExt) : string
    {
        return self::makeSheet($header, $data, $nameExt, 'xls');
    }

    public static function makeCsv(array $header = [], array $data = [], ?string $nameExt) : string
    {
        return self::makeSheet($header, $data, $nameExt, 'csv');
    }
}