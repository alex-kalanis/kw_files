<?php

namespace VolumeTests;


use kalanis\kw_files\FilesException;
use kalanis\kw_paths\PathsException;


class DirFailTest extends AVolume
{
    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testCopyUnknown(): void
    {
        $lib = $this->getDirLib();
        $this->assertFalse($lib->copyDir(['not source'], ['extra2']));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testCopyToUnknownDir(): void
    {
        $lib = $this->getDirLib();
        $this->assertFalse($lib->copyDir(['next_one', 'sub_one'], ['unknown', 'last_one']));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testCopyToExisting(): void
    {
        $lib = $this->getDirLib();
        $this->assertFalse($lib->copyDir(['next_one', 'sub_one'], ['last_one']));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testCopyToSub(): void
    {
        $lib = $this->getDirLib();
        $this->assertFalse($lib->copyDir(['next_one', 'sub_one'], ['next_one', 'sub_one', 'deeper']));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testMoveUnknown(): void
    {
        $lib = $this->getDirLib();
        $this->assertFalse($lib->moveDir(['not source'], ['extra2']));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testMoveToUnknownDir(): void
    {
        $lib = $this->getDirLib();
        $this->assertFalse($lib->moveDir(['next_one', 'sub_one'], ['unknown', 'last_one']));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testMoveToExisting(): void
    {
        $lib = $this->getDirLib();
        $this->assertFalse($lib->moveDir(['next_one', 'sub_one'], ['last_one']));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testMoveToSub(): void
    {
        $lib = $this->getDirLib();
        $this->assertFalse($lib->moveDir(['next_one', 'sub_one'], ['next_one', 'sub_one', 'deeper']));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testDeleteFile(): void
    {
        $lib = $this->getDirLib();
        $this->assertFalse($lib->deleteDir(['sub', 'dummy3.txt']));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testDeleteNonEmpty(): void
    {
        $lib = $this->getDirLib();
        $this->assertFalse($lib->deleteDir(['next_one']));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testDeepDeleteFail(): void
    {
        $lib = $this->getDirLib();
        $this->assertTrue($lib->createDir(['some', 'more'], true));
        $this->assertFalse($lib->deleteDir(['some']));
        $this->assertTrue($lib->deleteDir(['some'], true));
    }
}
