<?php

namespace tests\TraitsTests;


use kalanis\kw_files\Interfaces\IProcessFiles;


class XProcessFile implements IProcessFiles
{
    public function saveFile(array $entry, string $content, ?int $offset = null, int $mode = 0): bool
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
