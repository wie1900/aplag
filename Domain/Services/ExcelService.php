<?php

namespace Aplag\Domain\Services;

use Aplag\Domain\PortsIn\ExcelServiceInterface;
use Aplag\Domain\PortsOut\ExcelExporterInterface;
use Illuminate\Http\Request;

class ExcelService implements ExcelServiceInterface
{
    public function __construct(
        private ExcelExporterInterface $excelExporterInterface
        )
    {
        
    }

    public function getExcel(Request $request): string
    {
        return $this->excelExporterInterface->exportExcel($request);
    }




}
