<?php

namespace StorageDirsTests;


use kalanis\kw_files\FilesException;


class FileTest extends AStorageTest
{
    protected function tearDown(): void
    {
        if (is_file($this->getTestPath() . DIRECTORY_SEPARATOR . 'extra.txt')) {
            unlink($this->getTestPath() . DIRECTORY_SEPARATOR . 'extra.txt');
        }
        if (is_file($this->getTestPath() . DIRECTORY_SEPARATOR . 'extra1.txt')) {
            unlink($this->getTestPath() . DIRECTORY_SEPARATOR . 'extra1.txt');
        }
        if (is_file($this->getTestPath() . DIRECTORY_SEPARATOR . 'extra2.txt')) {
            unlink($this->getTestPath() . DIRECTORY_SEPARATOR . 'extra2.txt');
        }
    }

    /**
     * @throws FilesException
     */
    public function testFreeName(): void
    {
        $lib = $this->getFileLib();
        $this->assertEquals('no-change.nope', $lib->findFreeName([], 'no-change', '.nope'));
        $this->assertEquals('other1_0.txt', $lib->findFreeName([], 'other1', '.txt'));
    }

    /**
     * @throws FilesException
     */
    public function testRead(): void
    {
        $lib = $this->getFileLib();
        $this->assertEquals('qwertzuiopasdfghjklyxcvbnm0123456789', $lib->readFile(['dummy2.txt']));
        $this->assertEquals('asdfghjklyxcvbnm0123456789', $lib->readFile(['dummy2.txt'], 10));
        $this->assertEquals('asdfghjkly', $lib->readFile(['dummy2.txt'], 10, 10));
        $this->assertEquals('qwertzuiop', $lib->readFile(['dummy2.txt'], null, 10));
    }

    /**
     * @throws FilesException
     */
    public function testReadNonExist(): void
    {
        $lib = $this->getFileLib();
        $this->expectException(FilesException::class);
        $lib->readFile(['unknown']);
    }

    /**
     * @throws FilesException
     */
    public function testSave(): void
    {
        $lib = $this->getFileLib();
        $this->assertTrue($lib->saveFile(['extra.txt'], 'qwertzuiopasdfghjklyxcvbnm0123456789'));
    }

    /**
     * @throws FilesException
     */
    public function testCopyMoveDelete(): void
    {
        $lib = $this->getFileLib();
        $this->assertTrue($lib->copyFile(['dummy2.txt'], ['extra1.txt']));
        $this->assertTrue($lib->moveFile(['extra1.txt'], ['extra2.txt']));
        $this->assertTrue($lib->deleteFile(['extra2.txt']));
    }
}
