<?php

namespace Aplag\Domain\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;

    public int $matchPerc = 0;

    public function __construct(
        public string $text
        )
    {
    }
}
