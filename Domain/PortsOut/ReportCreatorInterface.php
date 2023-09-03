<?php

namespace Aplag\Domain\PortsOut;

use Aplag\Domain\DTOs\CompText;
use Aplag\Domain\DTOs\Report;

interface ReportCreatorInterface
{
    function getReport(CompText $compText): Report;
}
