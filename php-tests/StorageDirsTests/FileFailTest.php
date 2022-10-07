<?php

namespace StorageDirsTests;


use kalanis\kw_files\FilesException;


class FileFailTest extends AStorageTest
{
    /**
     * @throws FilesException
     */
    public function testFreeName(): void
    {
        $lib = $this->getFileFailLib();
        $this->expectException(FilesException::class);
        $lib->findFreeName([], 'no-change', '.nope');
    }

    /**
     * @throws FilesException
     */
    public function testRead(): void
    {
        $lib = $this->getFileFailLib();
        $this->expectException(FilesException::class);
        $lib->readFile(['dummy2.txt']);
    }

    /**
     * @throws FilesException
     */
    public function testSave(): void
    {
        $lib = $this->getFileFailLib();
        $this->expectException(FilesException::class);
        $lib->saveFile(['extra.txt'], 'qwertzuiopasdfghjklyxcvbnm0123456789');
    }

    /**
     * @throws FilesException
     */
    public function testCopy(): void
    {
        $lib = $this->getFileFailLib();
        $this->expectException(FilesException::class);
        $lib->copyFile(['dummy2.txt'], ['extra1.txt']);
    }

    /**
     * @throws FilesException
     */
    public function testMove(): void
    {
        $lib = $this->getFileFailLib();
        $this->expectException(FilesException::class);
        $lib->moveFile(['extra1.txt'], ['extra2.txt']);
    }

    /**
     * @throws FilesException
     */
    public function testDelete(): void
    {
        $lib = $this->getFileFailLib();
        $this->expectException(FilesException::class);
        $lib->deleteFile(['extra2.txt']);
    }
}
