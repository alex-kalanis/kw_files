<?php

namespace AccessTests;


use CommonTestClass;
use kalanis\kw_files\Access\CompositeAdapter;
use kalanis\kw_files\FilesException;
use kalanis\kw_files\Interfaces\IProcessDirs;
use kalanis\kw_files\Interfaces\IProcessFiles;
use kalanis\kw_files\Interfaces\IProcessNodes;
use kalanis\kw_paths\PathsException;


class CompositeTest extends CommonTestClass
{
    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testBasic(): void
    {
        $lib = new CompositeAdapter(new XProcessNode(), new XProcessDir(), new XProcessFile());
        $this->assertInstanceOf(XProcessNode::class, $lib->getNode());
        $this->assertInstanceOf(XProcessDir::class, $lib->getDir());
        $this->assertInstanceOf(XProcessFile::class, $lib->getFile());

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
    }
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


class XProcessDir implements IProcessDirs
{
    public function createDir(array $entry, bool $deep = false): bool
    {
        return true;
    }

    public function readDir(array $entry, bool $loadRecursive = false, bool $wantSize = false): array
    {
        return [];
    }

    public function copyDir(array $source, array $dest): bool
    {
        return true;
    }

    public function moveDir(array $source, array $dest): bool
    {
        return true;
    }

    public function deleteDir(array $entry, bool $deep = false): bool
    {
        return true;
    }
}


class XProcessFile implements IProcessFiles
{
    public function saveFile(array $entry, $content): bool
    {
        return true;
    }

    public function readFile(array $entry, ?int $offset = null, ?int $length = null)
    {
        return '';
    }

    public function copyFile(array $source, array $dest): bool
    {
        return true;
    }

    public function moveFile(array $source, array $dest): bool
    {
        return true;
    }

    public function deleteFile(array $entry): bool
    {
        return true;
    }
}

