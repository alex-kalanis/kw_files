<?php

namespace StorageDirsTests;


use kalanis\kw_files\FilesException;


class NodeTest extends AStorageTest
{
    /**
     * @throws FilesException
     */
    public function testThrough(): void
    {
        $lib = $this->getNodeLib();
        $this->assertFalse($lib->exists(['unknown']));
        $this->assertTrue($lib->exists(['dummy2.txt']));
        $this->assertTrue($lib->exists(['sub']));
        $this->assertTrue($lib->exists(['sub', 'dummy3.txt']));

        $this->assertFalse($lib->isDir(['unknown']));
        $this->assertFalse($lib->isDir(['dummy2.txt']));
        $this->assertTrue($lib->isDir(['sub']));

        $this->assertFalse($lib->isFile(['unknown']));
        $this->assertTrue($lib->isFile(['dummy2.txt']));
        $this->assertFalse($lib->isFile(['sub']));

        $this->assertNull($lib->size(['unknown']));
        $this->assertEquals(36, $lib->size(['dummy2.txt']));
        $this->assertEquals(4096, $lib->size(['sub']));

        $this->assertNull($lib->created(['unknown']));
    }
}
