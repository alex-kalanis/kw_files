<?php

namespace StorageDirsTests;


use kalanis\kw_files\FilesException;
use kalanis\kw_files\Interfaces\ITypes;
use kalanis\kw_files\Node;


class DirTest extends AStorageTest
{
    protected function setUp(): void
    {
        $this->clearData();
    }

    protected function tearDown(): void
    {
        $this->clearData();
    }

    protected function clearData(): void
    {
        clearstatcache();
        $this->rmFile('another' . DIRECTORY_SEPARATOR . 'sub_one' . DIRECTORY_SEPARATOR . '.gitkeep');
        $this->rmDir('another' . DIRECTORY_SEPARATOR . 'sub_one');
        $this->rmDir('another');
        clearstatcache();
        $this->rmDir('sub' . DIRECTORY_SEPARATOR . 'added');
        $this->rmDir('more' . DIRECTORY_SEPARATOR . 'added');
        clearstatcache();
        $this->rmFile('more' . DIRECTORY_SEPARATOR . 'sub_one' . DIRECTORY_SEPARATOR . '.gitkeep');
        $this->rmDir('more' . DIRECTORY_SEPARATOR . 'sub_one');
        $this->rmDir('more');
        clearstatcache();
    }

    protected function rmDir(string $path): void
    {
        if (is_dir($this->getTestPath() . DIRECTORY_SEPARATOR . $path)) {
            rmdir($this->getTestPath() . DIRECTORY_SEPARATOR . $path);
        }
    }

    protected function rmFile(string $path): void
    {
        if (is_file($this->getTestPath() . DIRECTORY_SEPARATOR . $path)) {
            unlink($this->getTestPath() . DIRECTORY_SEPARATOR . $path);
        }
    }

    /**
     * @throws FilesException
     */
    public function testCreate(): void
    {
        $lib = $this->getDirLib();
        $this->assertTrue($lib->createDir(['another'], false));
        $this->assertTrue($lib->createDir(['sub', 'added'], false)); // not exists in sub dir
        $this->assertFalse($lib->createDir(['sub', 'added'], true)); // already exists in sub dir
        $this->assertFalse($lib->createDir(['more', 'added'], false)); // not exists both dirs, cannot deep
        $this->assertTrue($lib->createDir(['more', 'added'], true)); // not exists both dirs, can deep
    }

    /**
     * @throws FilesException
     */
    public function testRead1(): void
    {
        $lib = $this->getDirLib();
        $subList = $lib->readDir([''], false, true);
        usort($subList, [$this, 'sortingPaths']);

        $entry = reset($subList);
        /** @var Node $entry */
        $name = array_slice($entry->getPath(), -1);
        $this->assertEquals('', reset($name));
        $this->assertEquals(ITypes::TYPE_DIR, $entry->getType());
        $this->assertTrue($entry->isDir());
        $this->assertFalse($entry->isFile());

        $entry = next($subList);
        $name = array_slice($entry->getPath(), -1);
        $this->assertEquals('dummy1.txt', reset($name));
        $this->assertEquals(36, $entry->getSize());
        $this->assertEquals(ITypes::TYPE_FILE, $entry->getType());
        $this->assertFalse($entry->isDir());
        $this->assertTrue($entry->isFile());

        $entry = next($subList);
        $name = array_slice($entry->getPath(), -1);
        $this->assertEquals('dummy2.txt', reset($name));
        $this->assertEquals(36, $entry->getSize());
        $this->assertEquals(ITypes::TYPE_FILE, $entry->getType());

        $entry = next($subList);
        $name = array_slice($entry->getPath(), -1);
        $this->assertEquals('last_one', reset($name));
        $this->assertEquals(ITypes::TYPE_DIR, $entry->getType());

        $entry = next($subList);
        $name = array_slice($entry->getPath(), -1);
        $this->assertEquals('next_one', reset($name));
        $this->assertEquals(ITypes::TYPE_DIR, $entry->getType());

        $entry = next($subList);
        $name = array_slice($entry->getPath(), -1);
        $this->assertEquals('other1.txt', reset($name));
        $this->assertEquals(36, $entry->getSize());
        $this->assertEquals(ITypes::TYPE_FILE, $entry->getType());

        $entry = next($subList);
        $name = array_slice($entry->getPath(), -1);
        $this->assertEquals('other2.txt', reset($name));
        $this->assertEquals(36, $entry->getSize());
        $this->assertEquals(ITypes::TYPE_FILE, $entry->getType());

        $entry = next($subList);
        $name = array_slice($entry->getPath(), -1);
        $this->assertEquals('sub', reset($name));
        $this->assertEquals(ITypes::TYPE_DIR, $entry->getType());

        $this->assertFalse(next($subList));
    }

    /**
     * @throws FilesException
     */
    public function testRead2(): void
    {
        $lib = $this->getDirLib();
        $subList = $lib->readDir(['next_one'], true);
        $entry = reset($subList);
        /** @var Node $entry */
        $name = array_slice($entry->getPath(), -1);
        $this->assertEquals('next_one', reset($name));
        $this->assertEquals(ITypes::TYPE_DIR, $entry->getType());

        $entry = next($subList);
        $name = array_slice($entry->getPath(), -1);
        $this->assertEquals('sub_one', reset($name));
        $this->assertEquals(ITypes::TYPE_DIR, $entry->getType());

        $entry = next($subList);
        $name = array_slice($entry->getPath(), -1);
        $this->assertEquals('.gitkeep', reset($name));
        $this->assertEquals(0, $entry->getSize());
        $this->assertEquals(ITypes::TYPE_FILE, $entry->getType());

        $this->assertFalse(next($subList));
    }

    /**
     * @throws FilesException
     */
    public function testRead3(): void
    {
        $lib = $this->getDirLib();
        $subList = $lib->readDir(['last_one'], false);
        $entry = reset($subList);
        /** @var Node $entry */
        $name = array_slice($entry->getPath(), -1);
        $this->assertEquals('last_one', reset($name));
        $this->assertEquals(ITypes::TYPE_DIR, $entry->getType());

        $entry = next($subList);
        $name = array_slice($entry->getPath(), -1);
        $this->assertEquals('.gitkeep', reset($name));
        $this->assertEquals(0, $entry->getSize());
        $this->assertEquals(ITypes::TYPE_FILE, $entry->getType());

        $this->assertFalse(next($subList));
    }

    /**
     * @throws FilesException
     */
    public function testReadFail(): void
    {
        $lib = $this->getDirLib();
        $this->expectException(FilesException::class);
        $lib->readDir(['dummy2.txt']);
    }

    /**
     * @throws FilesException
     */
    public function testCopyMoveDelete(): void
    {
        $lib = $this->getDirLib();
        $this->assertTrue($lib->copyDir(['next_one'], ['more']));
        $this->assertTrue($lib->moveDir(['more'], ['another']));
        $this->assertTrue($lib->deleteDir(['another'], true));
        $this->assertFalse($lib->deleteDir(['another']));
    }
}
