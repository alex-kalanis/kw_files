<?php

namespace tests\AccessTests;


use kalanis\kw_files\Interfaces\IProcessFileStreams;


class XProcessStream implements IProcessFileStreams
{
    public function saveFileStream(array $entry, $content, int $mode = 0): bool
    {
        return true;
    }

    public function readFileStream(array $entry)
    {
        return fopen('php://memory', 'rb+');
    }

    public function copyFileStream(array $source, array $dest): bool
    {
        return true;
    }

    public function moveFileStream(array $source, array $dest): bool
    {
        return true;
    }
}
