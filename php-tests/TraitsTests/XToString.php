<?php

namespace tests\TraitsTests;


use kalanis\kw_files\FilesException;
use kalanis\kw_files\Traits\TToString;


class XToString
{
    use TToString;

    /**
     * @param mixed $content
     * @throws FilesException
     * @return string
     */
    public function toStr($content): string
    {
        return $this->toString('test', $content);
    }
}
