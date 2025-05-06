<?php

namespace tests\AccessTests;


use DateTimeInterface;
use kalanis\kw_files\Interfaces\IProcessNodes;


class XProcessNode implements IProcessNodes
{
    public function exists(array $entry): bool
    {
        return false;
    }

    public function isReadable(array $entry): bool
    {
        return false;
    }

    public function isWritable(array $entry): bool
    {
        return false;
    }

    public function isDir(array $entry): bool
    {
        return false;
    }

    public function isFile(array $entry): bool
    {
        return false;
    }

    public function size(array $entry): ?int
    {
        return null;
    }

    public function created(array $entry): ?DateTimeInterface
    {
        return null;
    }
}
