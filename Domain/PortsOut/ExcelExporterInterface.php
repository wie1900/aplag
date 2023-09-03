<?php

namespace Aplag\Domain\PortsOut;

use Illuminate\Http\Request;

interface ExcelExporterInterface
{
    function exportExcel(Request $request): string;
}
