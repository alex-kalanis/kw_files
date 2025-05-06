<?php

namespace tests\TraitsTests;


use kalanis\kw_files\Traits\TSubPart;


class XSubPart
{
    use TSubPart;

    public function is(array $what, array $in): bool
    {
        return $this->isSubPart($what, $in);
    }
}
