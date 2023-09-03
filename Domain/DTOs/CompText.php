<?php

namespace Aplag\Domain\DTOs;

use Illuminate\Support\Collection;

class CompText
{
    private Collection $segs;

    public function __construct()
    {
        $this->segs = new Collection();
    }

    public function addSeg(
        int $id,
        string $orig,
        string $matchedSentence,
        float $matchVal,
        int $wordsLength,
        int $matchedWordsLength,
        int $wordCount,
        int $matchedWordCount
    ) {
        $this->segs->add([
            "id" => $id,
            "orig" => $orig,
            "matchedSentence" => $matchedSentence,
            "matchVal" => $matchVal,
            "wordsLength" => $wordsLength,
            "matchedWordsLength" => $matchedWordsLength,
            "wordCount"=>$wordCount,
            "matchedWordCount"=>$matchedWordCount
        ]);
    }

    public function getSegs(): Collection
    {
        return $this->segs;
    }

    public function getSegsCount(): int
    {
        return $this->segs->count();
    }

}
