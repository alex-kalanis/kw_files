<?php

namespace StorageBasicTests;


use kalanis\kw_files\FilesException;
use kalanis\kw_paths\PathsException;


class StreamFailTest extends AStorageTest
{
    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testRead(): void
    {
        $lib = $this->getStreamFailLib();
        $this->expectException(FilesException::class);
        $lib->readFileStream(['dummy2.txt']);
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testReadNonExist(): void
    {
        $lib = $this->getStreamLib();
        $this->expectException(FilesException::class);
        $lib->readFileStream(['unknown']);
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testSave(): void
    {
        $lib = $this->getStreamFailLib();
        $this->expectException(FilesException::class);
        $lib->saveFileStream(['extra.txt'], $this->stringToStream('qwertzuiopasdfghjklyxcvbnm0123456789'));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testSave2(): void
    {
        $lib = $this->getStreamFailLib();
        $this->expectException(FilesException::class);
        $lib->saveFileStream([], $this->stringToStream('qwertzuiopasdfghjklyxcvbnm0123456789'));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testSave3(): void
    {
        $lib = $this->getStreamLib();
        $this->expectException(FilesException::class);
        $lib->saveFileStream(['not existent', 'directory', 'with file'], $this->stringToStream('qwertzuiopasdfghjklyxcvbnm0123456789'));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testSaveBadMode(): void
    {
        $lib = $this->getStreamLib();
        $this->expectException(FilesException::class);
        $lib->saveFileStream(['extra.txt'], $this->stringToStream('0123456789qwertzuiopasdfghjklyxcvbnm'), 666);
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testSaveNonWritable(): void
    {
        $lib = $this->getStreamFailLib();
        $this->expectException(FilesException::class);
        $lib->saveFileStream(['extra.txt'],  $this->stringToStream('0123456789qwertzuiopasdfghjklyxcvbnm'));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testCopy(): void
    {
        $lib = $this->getStreamFailLib();
        $this->expectException(FilesException::class);
        $lib->copyFileStream(['dummy2.txt'], ['extra1.txt']);
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testCopyToExisting(): void
    {
        $lib = $this->getStreamLib();
        $this->assertFalse($lib->copyFileStream(['dummy2.txt'], ['dummy1.txt']));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testMove(): void
    {
        $lib = $this->getStreamFailRemoveLib();
        $this->expectException(FilesException::class);
        $lib->moveFileStream(['dummy1.txt'], ['extra2.txt']);
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testMoveUnknownSource(): void
    {
        $lib = $this->getStreamLib();
        $this->expectException(FilesException::class);
        $lib->moveFileStream(['not source.txt'], ['extra2.txt']);
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testMoveToUnknownDir(): void
    {
        $lib = $this->getStreamLib();
        $this->assertFalse($lib->moveFileStream(['sub', 'dummy3.txt'], ['whatabout', 'other2.txt']));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testMoveToExisting(): void
    {
        $lib = $this->getStreamLib();
        $this->assertFalse($lib->moveFileStream(['sub', 'dummy3.txt'], ['other2.txt']));
    }
}
