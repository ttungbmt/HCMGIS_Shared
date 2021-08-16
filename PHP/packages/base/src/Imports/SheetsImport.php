<?php
namespace Larabase\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SheetsImport implements WithMultipleSheets
{
    protected $sheetClasses = [];

    public function __construct($sheetClasses = [])
    {
        $this->sheetClasses = $sheetClasses;
    }

    public function sheets(): array
    {
        return $this->sheetClasses;
    }
}