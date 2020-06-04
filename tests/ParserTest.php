<?php

namespace Helium\SpreadsheetManager;
use Helium\SpreadsheetManager\Classes\Maker;
use Helium\SpreadsheetManager\Classes\Parser;
use Helium\SpreadsheetManager\Exceptions\ParserException;
use Orchestra\Testbench\TestCase;

class ParserTest extends TestCase
{
    private $_testHeader = ['name', 'hair_color', 'age'];

    private $_testData = [
        ['lorenzo', 'black', 25],
        ['julie', 'brown', 55]
    ];

    private $_expectedArray = [
        [
            'name' => 'lorenzo',
            'hair_color' => 'black',
            'age' => 25
        ],
        [
            'name' => 'julie',
            'hair_color' => 'brown',
            'age' => 55
        ]
    ];

    public function testCsvToArray()
    {
        $csv = Maker::makeCsv($this->_testHeader, $this->_testData, null);

        $dataArray = Parser::csvToArray($csv);

        $this->assertEquals($this->_expectedArray, $dataArray);
    }

    public function testExceptions()
    {
        try{
            Parser::csvToArray('/fakepath');
            $this->assertTrue(false);
        } catch(\Exception $e){
            $this->assertInstanceOf(ParserException::class, $e);
        }
    }
}