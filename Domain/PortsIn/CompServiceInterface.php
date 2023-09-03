<?php

namespace Aplag\Domain\PortsIn;

use Aplag\Domain\DTOs\CompText;
use Aplag\Domain\DTOs\Report;

interface CompServiceInterface
{
    function getCompText(string $checked, string $source): CompText;
    function getReport(CompText $compText): Report;
}
