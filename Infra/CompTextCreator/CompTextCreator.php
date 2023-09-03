<?php

namespace Aplag\Infra\CompTextCreator;

use Aplag\Domain\DTOs\CompText;
use Aplag\Domain\Entities\Sentence;
use Aplag\Domain\Entities\Text;
use Aplag\Domain\PortsOut\CompTextCreatorInterface;
use Ramsey\Uuid\Type\Decimal;

class CompTextCreator implements CompTextCreatorInterface
{
    public function __construct()
    {
    }

    public function getCompText(Text $text1, Text $text2): CompText
    {

        $comparedText = new CompText();

        foreach ($text1->Sentences as $index => $s1) {

            $foundPerc = 0;
            $foundMatched = "";
            $matchedWordsLength = 0;
            $matchedWordCount = 0;

            // here can be insterted if-condition: compare only e.g. strlen($s1->orig) > 10
            // if(strlen($s1->orig)>10){
                
                foreach ($text2->Sentences as $s2) {
    
                    $matchingIndex = $this->findMatching($s1, $s2)[0];
    
                    if ($matchingIndex > $foundPerc) {
                        $foundPerc = $matchingIndex;
                        $foundMatched = $s2->orig;
                        
                        // take only matched words if matching factor > 49%
                        if($matchingIndex > 49){
                            $matchedWordsLength = $this->findMatching($s1, $s2)[1];
                            $matchedWordCount = $this->findMatching($s1, $s2)[2];
                        }
                    }
                }

            // }

            $s1WordsLength = 0;
            $wordCount = 0;
            foreach ($s1->Words as $w) {
                $s1WordsLength += mb_strlen($w->text, "utf-8");
                $wordCount++;
            }

            $comparedText->addSeg(
                $index,
                $s1->orig,
                $foundMatched,
                (float)$foundPerc,
                $s1WordsLength,
                $matchedWordsLength,
                $wordCount,
                $matchedWordCount
            );
        }
        return $comparedText;
    }

    private function findMatching(Sentence $s1, Sentence $s2): array
    {
        foreach ($s2->Words as &$word) {
            $word->matchPerc = 0;
        }

        $matchedLength = 0;
        $sentenceWordsLength = 0;
        $matchedWordCount = 0;

        foreach ($s1->Words as $word) {
            $sentenceWordsLength += mb_strlen($word->text, "utf-8");
        }

        foreach ($s1->Words as $w1) {

            foreach ($s2->Words as &$w2) {
                if (strtolower($w1->text) == strtolower($w2->text) && $w1->matchPerc == 0 && $w2->matchPerc == 0) {
                    $w2->matchPerc = 1;
                    $matchedLength += mb_strlen($w1->text, "utf-8");
                    $matchedWordCount++;
                    break (1);
                }
            }
        }

        if ($sentenceWordsLength > 0) {
            $result = $matchedLength / $sentenceWordsLength * 100;
        } else {
            $result = 0;
        }
        return [$result, $matchedLength, $matchedWordCount];
    }
}
