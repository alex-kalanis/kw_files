<?php

namespace StorageDirsTests;


use kalanis\kw_files\FilesException;


class DirFailTest extends AStorageTest
{
    /**
     * @throws FilesException
     */
    public function testCreate(): void
    {
        $lib = $this->getDirFailLib();
        $this->expectException(FilesException::class);
        $lib->createDir(['another'], false);
    }

    /**
     * @throws FilesException
     */
    public function testRead(): void
    {
        $lib = $this->getDirFailLib();
        $this->expectException(FilesException::class);
        $lib->readDir([''], false, true);
    }

    /**
     * @throws FilesException
     */
    public function testCopy(): void
    {
        $lib = $this->getDirFailLib();
        $this->expectException(FilesException::class);
        $lib->copyDir(['next_one'], ['more']);
    }

    /**
     * @throws FilesException
     */
    public function testMove(): void
    {
        $lib = $this->getDirFailLib();
        $this->expectException(FilesException::class);
        $lib->moveDir(['more'], ['another']);
    }

    /**
     * @throws FilesException
     */
    public function testDelete(): void
    {
        $lib = $this->getDirFailLib();
        $this->expectException(FilesException::class);
        $lib->deleteDir(['another'], true);
    }
}
