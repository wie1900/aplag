<?php

namespace Aplag\Domain\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Sentence extends Model
{
    use HasFactory;
    public Collection $Words;
    public float $matchPerc = 0;

    public function __construct(
        public string $orig,
        public int $id
        )
    {
        $this->Words = new Collection();
        $words_array = $this->prepareWordsArray($orig);

        foreach ($words_array as $a) {
            $this->Words->add(new Word($a));
        }
    }

    private function prepareWordsArray(string $for_return): array
    {
        $replacer = [
            [",", " "],
            ["(", " "],
            [")", " "],
            ["[", " "],
            ["]", " "],
            ["{", " "],
            ["}", " "],
            ["/", " "],
            ["\"", " "],
            ["\'", " "],
            ["=", " "],
            ["-", " "],
            ["–", " "],
            ["—", " "],
            ["" . chr(34), " "],
            ["" . chr(10), " "],
            ["" . chr(13), " "],
            ["" . chr(9), " "],
            ["\n", " "]
        ];

        foreach ($replacer as $r) {
            $for_return = str_replace($r[0], $r[1], $for_return);
        }

        while (str_contains($for_return, "  ")) {
            $for_return = str_replace("  ", " ", $for_return);
        }

        if (str_starts_with($for_return, " ")) $for_return = substr($for_return, 1, strlen($for_return));
        if (str_ends_with($for_return, " ")) $for_return = substr($for_return, 0, strlen($for_return) - 1);

        $arr = explode(" ", $for_return);

        return $arr;
    }
}
