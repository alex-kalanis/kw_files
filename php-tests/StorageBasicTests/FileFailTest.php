<?php

namespace StorageBasicTests;


use kalanis\kw_files\FilesException;
use kalanis\kw_paths\PathsException;


class FileFailTest extends AStorageTest
{
    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testRead(): void
    {
        $lib = $this->getFileFailLib();
        $this->expectException(FilesException::class);
        $lib->readFile(['dummy2.txt']);
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testSave(): void
    {
        $lib = $this->getFileFailLib();
        $this->expectException(FilesException::class);
        $lib->saveFile(['extra.txt'], 'qwertzuiopasdfghjklyxcvbnm0123456789');
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testCopy(): void
    {
        $lib = $this->getFileFailLib();
        $this->expectException(FilesException::class);
        $lib->copyFile(['dummy2.txt'], ['extra1.txt']);
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testMove(): void
    {
        $lib = $this->getFileFailLib();
        $this->expectException(FilesException::class);
        $lib->moveFile(['extra1.txt'], ['extra2.txt']);
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testDelete(): void
    {
        $lib = $this->getFileFailLib();
        $this->expectException(FilesException::class);
        $lib->deleteFile(['extra2.txt']);
    }
}
