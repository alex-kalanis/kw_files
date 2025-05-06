<?php

namespace tests\AccessTests;


use tests\CommonTestClass;
use kalanis\kw_files\Access\CompositeAdapter;
use kalanis\kw_files\FilesException;
use kalanis\kw_paths\PathsException;


class CompositeTest extends CommonTestClass
{
    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testBasic(): void
    {
        $lib = new CompositeAdapter(new XProcessNode(), new XProcessDir(), new XProcessFile(), new XProcessStream());
        $this->assertInstanceOf(XProcessNode::class, $lib->getNode());
        $this->assertInstanceOf(XProcessDir::class, $lib->getDir());
        $this->assertInstanceOf(XProcessFile::class, $lib->getFile());
        $this->assertInstanceOf(XProcessStream::class, $lib->getStream());

        $this->assertFalse($lib->exists([]));
        $this->assertFalse($lib->isReadable([]));
        $this->assertFalse($lib->isReadable([]));
        $this->assertFalse($lib->isWritable([]));
        $this->assertFalse($lib->isDir([]));
        $this->assertFalse($lib->isFile([]));
        $this->assertNull($lib->size([]));
        $this->assertNull($lib->created([]));

        $this->assertTrue($lib->createDir([]));
        $this->assertEmpty($lib->readDir([]));
        $this->assertTrue($lib->copyDir([], []));
        $this->assertTrue($lib->moveDir([], []));
        $this->assertTrue($lib->deleteDir([]));

        $this->assertTrue($lib->saveFile([], ''));
        $this->assertEmpty($lib->readFile([]));
        $this->assertTrue($lib->copyFile([], []));
        $this->assertTrue($lib->moveFile([], []));
        $this->assertTrue($lib->deleteFile([]));

        $this->assertTrue($lib->saveFileStream([], fopen('php://memory', 'rb+')));
        $this->assertNotEmpty($lib->readFileStream([]));
        $this->assertTrue($lib->copyFileStream([], []));
        $this->assertTrue($lib->moveFileStream([], []));
    }
}
