<?php

namespace Helium\SpreadsheetManager\Exceptions;

use Exception;

class ParserException extends Exception
{
    public function __construct()
    {
        $message = 'This file could not be parsed because it is not valid.';

        parent::__construct($message);
    }
}