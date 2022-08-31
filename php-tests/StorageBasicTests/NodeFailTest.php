<?php

namespace StorageBasicTests;


use kalanis\kw_files\FilesException;


class NodeFailTest extends AStorageTest
{
    /**
     * @throws FilesException
     */
    public function testExists(): void
    {
        $lib = $this->getNodeFailLib();
        $this->expectException(FilesException::class);
        $lib->exists(['unknown']);
    }

    /**
     * @throws FilesException
     */
    public function testDir(): void
    {
        $lib = $this->getNodeFailLib();
        $this->expectException(FilesException::class);
        $lib->isDir(['unknown']);
    }

    /**
     * @throws FilesException
     */
    public function testFile(): void
    {
        $lib = $this->getNodeFailLib();
        $this->expectException(FilesException::class);
        $lib->isFile(['unknown']);
    }

    /**
     * @throws FilesException
     */
    public function testSize(): void
    {
        $lib = $this->getNodeFailLib();
        $this->expectException(FilesException::class);
        $lib->size(['unknown']);
    }
}
