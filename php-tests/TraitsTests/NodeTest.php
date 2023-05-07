<?php

namespace TraitsTests;


use CommonTestClass;
use kalanis\kw_files\FilesException;
use kalanis\kw_files\Interfaces\IProcessNodes;
use kalanis\kw_files\Traits\TNode;


class NodeTest extends CommonTestClass
{
    /**
     * @throws FilesException
     */
    public function testPass(): void
    {
        $lib = new XNode();
        $lib->setProcessNode(new XProcessNode());
        $this->assertNotEmpty($lib->getProcessNode());
    }

    /**
     * @throws FilesException
     */
    public function testFail(): void
    {
        $lib = new XNode();
        $this->expectException(FilesException::class);
        $lib->getProcessNode();
    }
}


class XNode
{
    use TNode;
}


class XProcessNode implements IProcessNodes
{
    public function exists(array $entry): bool
    {
        return false;
    }

    public function isReadable(array $entry): bool
    {
        return false;
    }

    public function isWritable(array $entry): bool
    {
        return false;
    }

    public function isDir(array $entry): bool
    {
        return false;
    }

    public function isFile(array $entry): bool
    {
        return false;
    }

    public function size(array $entry): ?int
    {
        return null;
    }

    public function created(array $entry): ?int
    {
        return null;
    }
}
