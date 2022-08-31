<?php

namespace VolumeTests;


use CommonTestClass;
use kalanis\kw_files\FilesException;
use kalanis\kw_files\Processing\Volume\ProcessNode;


class NodeTest extends CommonTestClass
{
    /**
     * @throws FilesException
     */
    public function testThrough(): void
    {
        $lib = new ProcessNode(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree');
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
