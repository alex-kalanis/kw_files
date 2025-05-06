<?php

namespace tests\StorageBasicTests;


use kalanis\kw_files\FilesException;
use kalanis\kw_paths\PathsException;


class StreamTest extends AStorageTest
{
    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testRead(): void
    {
        $lib = $this->getStreamLib();
        $this->assertEquals('qwertzuiopasdfghjklyxcvbnm0123456789', $this->streamToString($lib->readFileStream(['dummy2.txt'])));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testSave(): void
    {
        $lib = $this->getStreamLib();
        $this->assertTrue($lib->saveFileStream(['extra.txt'], $this->stringToStream('qwertzuiopasdfghjklyxcvbnm0123456789')));
    }

    /**
     * Create file and append another content
     * @throws FilesException
     * @throws PathsException
     */
    public function testSave2(): void
    {
        $lib = $this->getStreamLib();
        $this->assertTrue($lib->saveFileStream(['extra3.txt'], $this->stringToStream('qwertzuiopasdfgh01234567890123456789'), FILE_APPEND));
        $this->assertTrue($lib->saveFileStream(['extra3.txt'], $this->stringToStream('qwertzuiopasdfgh01234567890123456789'), FILE_APPEND));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testCopyMoveDelete(): void
    {
        $lib = $this->getStreamLib();
        $this->assertTrue($lib->copyFileStream(['dummy2.txt'], ['extra1.txt']));
        $this->assertTrue($lib->moveFileStream(['extra1.txt'], ['extra2.txt']));
    }
}
