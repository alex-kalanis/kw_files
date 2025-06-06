<?php

namespace tests\StorageBasicTests;


use kalanis\kw_files\FilesException;
use kalanis\kw_paths\PathsException;


class FileTest extends AStorageTest
{
    /**
     * @throws FilesException
     * @throws PathsException
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
     * @throws PathsException
     */
    public function testReadNonExist(): void
    {
        $lib = $this->getFileLib();
        $this->expectException(FilesException::class);
        $lib->readFile(['unknown']);
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testSave(): void
    {
        $lib = $this->getFileLib();
        $this->assertTrue($lib->saveFile(['extra.txt'], 'qwertzuiopasdfghjklyxcvbnm0123456789'));
        $this->assertEquals('qwertzuiopasdfghjklyxcvbnm0123456789', $lib->readFile(['extra.txt']));
    }

    /**
     * Insert content
     * @throws FilesException
     * @throws PathsException
     */
    public function testSave2(): void
    {
        $lib = $this->getFileLib();
        $this->assertTrue($lib->saveFile(['extra1.txt'], 'qwertzuiopasdfghjklyxcvbnm0123456789'));
        $this->assertEquals('qwertzuiopasdfghjklyxcvbnm0123456789', $lib->readFile(['extra1.txt']));
        $this->assertTrue($lib->saveFile(['extra1.txt'], '0123456789', 15, FILE_APPEND));
        $this->assertEquals('qwertzuiopasdfg0123456789', $lib->readFile(['extra1.txt']));
        $this->assertTrue($lib->saveFile(['extra1.txt'], 'mnbvcxy', null, FILE_APPEND));
        $this->assertEquals('qwertzuiopasdfg0123456789mnbvcxy', $lib->readFile(['extra1.txt']));
    }

    /**
     * Create file with moved content
     * @throws FilesException
     * @throws PathsException
     */
    public function testSave3(): void
    {
        $lib = $this->getFileLib();
        $this->assertTrue($lib->saveFile(['extra2.txt'], 'qwertzuiopasdfgh01234567890123456789', 5));
        $this->assertEquals("\0\0\0\0\0" . 'qwertzuiopasdfgh01234567890123456789', $lib->readFile(['extra2.txt']));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testCopyMoveDelete(): void
    {
        $lib = $this->getFileLib();
        $this->assertTrue($lib->copyFile(['dummy2.txt'], ['extra1.txt']));
        $this->assertTrue($lib->moveFile(['extra1.txt'], ['extra2.txt']));
        $this->assertTrue($lib->deleteFile(['extra2.txt']));
    }
}
