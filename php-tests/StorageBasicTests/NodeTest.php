<?php

namespace tests\StorageBasicTests;


use kalanis\kw_files\FilesException;
use kalanis\kw_paths\PathsException;


class NodeTest extends AStorageTest
{
    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testThrough(): void
    {
        $lib = $this->getNodeLib();
        $this->assertFalse($lib->exists(['unknown']));
        $this->assertTrue($lib->exists(['dummy2.txt']));
        $this->assertTrue($lib->exists(['sub']));
        $this->assertTrue($lib->exists(['sub', 'dummy3.txt']));

        $this->assertFalse($lib->isDir(['unknown']));
        $this->assertTrue($lib->isReadable(['unknown'])); // because cannot check real status on flat k-v storage
        $this->assertTrue($lib->isWritable(['unknown']));
        $this->assertFalse($lib->isDir(['dummy2.txt']));
        $this->assertTrue($lib->isDir(['sub']));
        $this->assertTrue($lib->isReadable(['sub']));
        $this->assertTrue($lib->isWritable(['sub']));

        $this->assertFalse($lib->isFile(['unknown']));
        $this->assertTrue($lib->isFile(['dummy2.txt']));
        $this->assertFalse($lib->isFile(['sub']));

        $this->assertNull($lib->size(['unknown']));
        $this->assertEquals(36, $lib->size(['dummy2.txt']));
        $this->assertEquals(36, $lib->size(['other1.txt']));
        $this->assertEquals(6, $lib->size(['sub']));

        $this->assertNull($lib->created(['unknown']));
        $this->assertNull($lib->created(['sub'])); // no data here
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testRoot(): void
    {
        $lib = $this->getNodeLib();
        $this->assertTrue($lib->exists([]));
        $this->assertTrue($lib->isDir([]));
        $this->assertFalse($lib->isFile([]));
        $this->assertNull($lib->size([]));
        $this->assertNull($lib->created([]));
    }
}
