<?php

namespace tests\TraitsTests;


use kalanis\kw_files\Interfaces\IProcessDirs;


class XProcessDir implements IProcessDirs
{
    public function createDir(array $entry, bool $deep = false): bool
    {
        return true;
    }

    public function readDir(array $entry, bool $loadRecursive = false, bool $wantSize = false): array
    {
        return [];
    }

    public function copyDir(array $source, array $dest): bool
    {
        return true;
    }

    public function moveDir(array $source, array $dest): bool
    {
        return true;
    }

    public function deleteDir(array $entry, bool $deep = false): bool
    {
        return true;
    }
}
