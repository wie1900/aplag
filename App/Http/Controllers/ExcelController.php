<?php

namespace Aplag\App\Http\Controllers;

use Aplag\Domain\PortsIn\ExcelServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExcelController extends Controller
{
    public function __construct(
        public ExcelServiceInterface $excelServiceInterface){}
    
    public function export(Request $request)
    {
        return response()->download($this->excelServiceInterface->getExcel($request))->deleteFileAfterSend();
    }

}
