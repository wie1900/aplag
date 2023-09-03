<?php

namespace Aplag\Domain\PortsOut;

use Aplag\Domain\DTOs\CompText;
use Aplag\Domain\Entities\Text;

interface CompTextCreatorInterface
{
    function getCompText(Text $t1, Text $t2): CompText;
}
