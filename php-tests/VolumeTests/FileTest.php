<?php

namespace VolumeTests;


use CommonTestClass;
use kalanis\kw_files\FilesException;
use kalanis\kw_files\Interfaces\IProcessFiles;
use kalanis\kw_files\Processing\Volume\ProcessFile;
use kalanis\kw_paths\PathsException;


class FileTest extends CommonTestClass
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
     * @throws PathsException
     */
    public function testRead(): void
    {
        $lib = $this->getLib();
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
        $lib = $this->getLib();
        $this->expectException(FilesException::class);
        $lib->readFile(['unknown']);
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testSave(): void
    {
        $lib = $this->getLib();
        $this->assertTrue($lib->saveFile(['extra.txt'], 'qwertzuiopasdfghjklyxcvbnm0123456789'));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testSaveNonWritable(): void
    {
        $lib = $this->getLib();
        $this->assertTrue($lib->saveFile(['extra.txt'], 'qwertzuiopasdfghjklyxcvbnm0123456789'));
        chmod($this->getTestPath() . DIRECTORY_SEPARATOR . 'extra.txt', 0555);
        $this->expectException(FilesException::class);
        $lib->saveFile(['extra.txt'], '0123456789qwertzuiopasdfghjklyxcvbnm');
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testCopyMoveDelete(): void
    {
        $lib = $this->getLib();
        $this->assertTrue($lib->copyFile(['dummy2.txt'], ['extra1.txt']));
        $this->assertTrue($lib->moveFile(['extra1.txt'], ['extra2.txt']));
        $this->assertTrue($lib->deleteFile(['extra2.txt']));
    }

    protected function getLib(): IProcessFiles
    {
        return new ProcessFile($this->getTestPath());
    }

    protected function getTestPath(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree';
    }
}
