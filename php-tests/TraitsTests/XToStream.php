<?php

namespace tests\TraitsTests;


use kalanis\kw_files\FilesException;
use kalanis\kw_files\Traits\TToStream;


class XToStream
{
    use TToStream;

    /**
     * @param mixed $content
     * @throws FilesException
     * @return resource
     */
    public function toStr($content)
    {
        return $this->toStream('test', $content);
    }
}
