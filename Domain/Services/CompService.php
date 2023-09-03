<?php

namespace Aplag\Domain\Services;

use Aplag\Domain\DTOs\CompText;
use Aplag\Domain\DTOs\Report;
use Aplag\Domain\Entities\Text;
use Aplag\Domain\PortsIn\CompServiceInterface;
use Aplag\Domain\PortsOut\CompTextCreatorInterface;
use Aplag\Domain\PortsOut\ReportCreatorInterface;

class CompService implements CompServiceInterface
{

    public function __construct(
        public CompTextCreatorInterface $ctCreatorInterface,
        public ReportCreatorInterface $reportCreatorInterface
        )
    {
        
    }

    public function getCompText(string $checked, string $source): CompText
    {
        return $this->ctCreatorInterface->getCompText(new Text($checked), new Text($source));
    }

    public function getReport(CompText $comptext): Report
    {
        return $this->reportCreatorInterface->getReport($comptext);
    }



}
