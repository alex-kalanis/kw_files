<?php

namespace tests\StorageDirsTests;


use kalanis\kw_files\FilesException;
use kalanis\kw_paths\PathsException;


class NodeFailTest extends AStorageTest
{
    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testExists(): void
    {
        $lib = $this->getNodeFailLib();
        $this->expectException(FilesException::class);
        $lib->exists(['unknown']);
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testDir(): void
    {
        $lib = $this->getNodeFailLib();
        $this->expectException(FilesException::class);
        $lib->isDir(['unknown']);
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testFile(): void
    {
        $lib = $this->getNodeFailLib();
        $this->expectException(FilesException::class);
        $lib->isFile(['unknown']);
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testReadable(): void
    {
        $lib = $this->getNodeFailLib();
        $this->expectException(FilesException::class);
        $lib->isReadable(['unknown']);
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testWritable(): void
    {
        $lib = $this->getNodeFailLib();
        $this->expectException(FilesException::class);
        $lib->isWritable(['unknown']);
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testSize(): void
    {
        $lib = $this->getNodeFailLib();
        $this->expectException(FilesException::class);
        $lib->size(['unknown']);
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testCreated(): void
    {
        $lib = $this->getNodeFailLib();
        $this->expectException(FilesException::class);
        $lib->created(['unknown']);
    }
}
