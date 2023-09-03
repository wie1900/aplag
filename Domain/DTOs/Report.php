<?php

namespace Aplag\Domain\DTOs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    public function __construct(
        private float $totalMatch,
        private int $totalWordsLength,
        private int $totalMatchedWordsLength,
        private int $segsCount,
        private int $segMidCount,
        private int $segHighCount,
        private int $totalWordCount,
        private int $totalMatchedWordCount
        )
    {}

    public function getTotalMatch(): float
    {
        return $this->totalMatch;
    }

    public function getSegsCount(): int
    {
        return $this->segsCount;
    }

    public function getSegMidCount(): int
    {
        return $this->segMidCount;
    }

    public function getSegHighCount(): int
    {
        return $this->segHighCount;
    }

    public function getTotalWordsLength(): int
    {
        return $this->totalWordsLength;
    }

    public function getTotalMatchedWordsLength(): int
    {
        return $this->totalMatchedWordsLength;
    }

    public function getTotalWordCount(): int
    {
        return $this->totalWordCount;
    }

    public function getTotalMatchedWordCount(): int
    {
        return $this->totalMatchedWordCount;
    }

}
