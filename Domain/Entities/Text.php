<?php

namespace Aplag\Domain\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Text extends Model
{
    use HasFactory;
    public Collection $Sentences;

    public function __construct(
        public string $text
        )
    {
        $this->Sentences = new Collection();
        $sentences_array = $this->prepareSentencesArray($text);
        
        foreach ($sentences_array as $key=>$a) {
            if (strlen($a) > 1) {
                $this->Sentences->add(new Sentence($a, $key));
            }
        }
    }

    private function prepareSentencesArray(string $text): array
    {
        // add shortcuts as arrays for multiple languages !!! to avoid cutting sentences by points !!!
        $sep = "[aplag-end]";
        $for_array = str_replace("\n", $sep, $text);

        $replacer = [
            ["np.", "np"],
            ["cd.", "cd"],
            ["lek.", "lek"],
            ["tj.", "tj"],
            ["tzn.", "tzn"],
            ["tzw.", "tzw"],
            ["str.", "str"],
            ["itd.", "itd"],
            ["m.in.", "min"],
            ["ang.", "ang"],
            ["?", $sep],
            ["!", $sep],
            [";", $sep],
            [":", $sep],
            ["...", $sep],
            ["..", $sep],
            [". ", $sep],
            [".", $sep],
        ];

        foreach ($replacer as $r) {
            $for_array = str_replace($r[0], $r[1], $for_array);
        }

        $arr = explode($sep, $for_array);
        if (strlen($arr[count($arr) - 1]) == "") {
            $arr = array_slice($arr, 0, -1);
        }

        return $arr;
    }
}
