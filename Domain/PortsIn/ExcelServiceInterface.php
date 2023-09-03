<?php

namespace Aplag\Domain\PortsIn;

use Illuminate\Http\Request;

interface ExcelServiceInterface
{
    function getExcel(Request $request): string;
}
