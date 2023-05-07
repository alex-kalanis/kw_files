<?php

namespace StorageDirsTests;


use kalanis\kw_files\FilesException;
use kalanis\kw_paths\PathsException;


class DirFailTest extends AStorageTest
{
    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testCreate(): void
    {
        $lib = $this->getDirFailLib();
        $this->expectException(FilesException::class);
        $lib->createDir(['another'], false);
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testRead(): void
    {
        $lib = $this->getDirFailLib();
        $this->expectException(FilesException::class);
        $lib->readDir([''], false, true);
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testCopy(): void
    {
        $lib = $this->getDirFailLib();
        $this->expectException(FilesException::class);
        $lib->copyDir(['next_one'], ['more']);
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testMove(): void
    {
        $lib = $this->getDirFailLib();
        $this->expectException(FilesException::class);
        $lib->moveDir(['more'], ['another']);
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testDelete(): void
    {
        $lib = $this->getDirFailLib();
        $this->expectException(FilesException::class);
        $lib->deleteDir(['another'], true);
    }
}
