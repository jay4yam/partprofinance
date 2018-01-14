<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 13/01/2018
 * Time: 22:53
 */
namespace App\Helpers;

use Illuminate\Foundation\Application;
use Maatwebsite\Excel\Excel;
use \Maatwebsite\Excel\Files\ExcelFile;

class ImportCSV extends ExcelFile
{
    public $fileName;
    public $defaultFileName;

    protected $delimiter  = ';';
    protected $enclosure  = '"';
    protected $lineEnding = '\r\n';

    public function getFile()
    {
        if ($this->fileName == null){
            $this->defaultFileName = storage_path('app/public/csvimport/default.csv');
            return $this->defaultFileName;
        }
        return $this->fileName;
    }
}