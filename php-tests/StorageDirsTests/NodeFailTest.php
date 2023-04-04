<?php

namespace StorageDirsTests;


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
    public function testReadable(): void
    {
        $lib = $this->getNodeFailLib();
        $this->expectException(FilesException::class);
        $lib->isReadable(['unknown']);
    }

    /**
     * @throws FilesException
     */
    public function testWritable(): void
    {
        $lib = $this->getNodeFailLib();
        $this->expectException(FilesException::class);
        $lib->isWritable(['unknown']);
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

    /**
     * @throws FilesException
     */
    public function testCreated(): void
    {
        $lib = $this->getNodeFailLib();
        $this->expectException(FilesException::class);
        $lib->created(['unknown']);
    }
}
