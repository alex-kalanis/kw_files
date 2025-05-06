<?php

namespace tests\AccessTests;


use kalanis\kw_files\Interfaces\IProcessFiles;


class XProcessFile implements IProcessFiles
{
    public function saveFile(array $entry, $content, ?int $offset = null, int $mode = 0): bool
    {
        return true;
    }

    public function readFile(array $entry, ?int $offset = null, ?int $length = null): string
    {
        return '';
    }

    public function copyFile(array $source, array $dest): bool
    {
        return true;
    }

    public function moveFile(array $source, array $dest): bool
    {
        return true;
    }

    public function deleteFile(array $entry): bool
    {
        return true;
    }
}
