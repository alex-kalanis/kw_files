<?php

namespace VolumeTests;


use CommonTestClass;
use kalanis\kw_files\FilesException;
use kalanis\kw_files\Interfaces\IProcessFileStreams;
use kalanis\kw_files\Processing\Volume\ProcessFile;
use kalanis\kw_paths\PathsException;


class FileStreamTest extends CommonTestClass
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
        if (is_file($this->getTestPath() . DIRECTORY_SEPARATOR . 'extra3.txt')) {
            unlink($this->getTestPath() . DIRECTORY_SEPARATOR . 'extra3.txt');
        }
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testRead(): void
    {
        $lib = $this->getLib();
        $this->assertEquals('qwertzuiopasdfghjklyxcvbnm0123456789', $this->streamToString($lib->readFileStream(['dummy2.txt'])));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testReadNonExist(): void
    {
        $lib = $this->getLib();
        $this->expectException(FilesException::class);
        $lib->readFileStream(['unknown']);
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testSave(): void
    {
        $lib = $this->getLib();
        $this->assertTrue($lib->saveFileStream(['extra.txt'], $this->stringToStream('qwertzuiopasdfghjklyxcvbnm0123456789')));
    }

    /**
     * Create file and append another content
     * @throws FilesException
     * @throws PathsException
     */
    public function testSave2(): void
    {
        $lib = $this->getLib();
        $this->assertTrue($lib->saveFileStream(['extra3.txt'], $this->stringToStream('qwertzuiopasdfgh01234567890123456789'), FILE_APPEND));
        $this->assertTrue($lib->saveFileStream(['extra3.txt'], $this->stringToStream('qwertzuiopasdfgh01234567890123456789'), FILE_APPEND));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testSaveBadMode(): void
    {
        $lib = $this->getLib();
        $this->expectException(FilesException::class);
        $lib->saveFileStream(['extra.txt'], $this->stringToStream('0123456789qwertzuiopasdfghjklyxcvbnm'), 666);
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testSaveNonWritable(): void
    {
        $lib = $this->getLib();
        $this->assertTrue($lib->saveFileStream(['extra.txt'],  $this->stringToStream('qwertzuiopasdfghjklyxcvbnm0123456789')));
        chmod($this->getTestPath() . DIRECTORY_SEPARATOR . 'extra.txt', 0555);
        $this->expectException(FilesException::class);
        $lib->saveFileStream(['extra.txt'],  $this->stringToStream('0123456789qwertzuiopasdfghjklyxcvbnm'));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testCopyMoveDelete(): void
    {
        $lib = $this->getLib();
        $this->assertTrue($lib->copyFileStream(['dummy2.txt'], ['extra1.txt']));
        $this->assertTrue($lib->moveFileStream(['extra1.txt'], ['extra2.txt']));
    }

    protected function getLib(): IProcessFileStreams
    {
        return new ProcessFile($this->getTestPath());
    }

    protected function getTestPath(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree';
    }
}
