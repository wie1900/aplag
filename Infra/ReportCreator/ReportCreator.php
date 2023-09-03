<?php

namespace Aplag\Infra\ReportCreator;

use Aplag\Domain\DTOs\CompText;
use Aplag\Domain\DTOs\Report;
use Aplag\Domain\PortsOut\ReportCreatorInterface;

class ReportCreator implements ReportCreatorInterface
{

    public function __construct()
    {
    }

    public function getReport(CompText $compText): Report
    {
        return new Report(
            $this->getTotalMatchVal($compText),
            $this->getTotalWordsLength($compText),
            $this->getTotalMatchedWordsLength($compText),
            $compText->getSegsCount(),
            $this->getMidCount($compText),
            $this->getHighCount($compText),
            $this->getTotalWordCount($compText),
            $this->getTotalMatchedWordCount($compText)
        );
    }

    private function getTotalWordsLength(CompText $compText): int
    {
        $totalLength = 0;
        foreach ($compText->getSegs() as $seg) {
            $totalLength += $seg['wordsLength'];
        }

        return $totalLength;
    }

    private function getTotalMatchedWordsLength(CompText $compText): int
    {
        $totalMatchedWordsLength = 0;
        foreach ($compText->getSegs() as $seg) {
            $totalMatchedWordsLength += $seg['matchedWordsLength'];
        }
        return $totalMatchedWordsLength;
    }

    public function getTotalWordCount(CompText $compText): int
    {
        $totalWordCount = 0;
        foreach ($compText->getSegs() as $seg) {
            $totalWordCount += $seg['wordCount'];
        }
        return $totalWordCount;
    }

    public function getTotalMatchedWordCount(CompText $compText): int
    {
        $totalMatchedWordCount = 0;
        foreach ($compText->getSegs() as $seg) {
            $totalMatchedWordCount += $seg['matchedWordCount'];
        }
        return $totalMatchedWordCount;
    }

    private function getTotalMatchVal(CompText $compText): float
    {
        return bcdiv($this->getTotalMatchedWordsLength($compText)*100, $this->getTotalWordsLength($compText),2);
    }

    private function getMidCount(CompText $compText)
    {
        $midCount = 0;
        foreach ($compText->getSegs() as $seg) {
            if($seg['matchVal'] > 49 && $seg['matchVal'] < 100){
                $midCount++;
            }
        }
        return $midCount;
    }

    private function getHighCount(CompText $compText)
    {
        $highCount = 0;
        foreach ($compText->getSegs() as $seg) {
            if($seg['matchVal'] == 100){
                $highCount++;
            }
        }
        return $highCount;
    }

}
