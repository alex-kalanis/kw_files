<?php

namespace TraitsTests;


use CommonTestClass;
use kalanis\kw_files\FilesException;
use kalanis\kw_files\Interfaces\IProcessDirs;
use kalanis\kw_files\Traits\TDir;


class DirTest extends CommonTestClass
{
    /**
     * @throws FilesException
     */
    public function testPass(): void
    {
        $lib = new XDir();
        $lib->setProcessDir(new XProcessDir());
        $this->assertNotEmpty($lib->getProcessDir());
    }

    /**
     * @throws FilesException
     */
    public function testFail(): void
    {
        $lib = new XDir();
        $this->expectException(FilesException::class);
        $lib->getProcessDir();
    }
}


class XDir
{
    use TDir;
}


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
