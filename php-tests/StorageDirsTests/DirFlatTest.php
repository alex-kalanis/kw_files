<?php

namespace tests\StorageDirsTests;


use kalanis\kw_files\FilesException;
use kalanis\kw_files\Interfaces\ITypes;
use kalanis\kw_files\Node;
use kalanis\kw_files\Processing;
use kalanis\kw_paths\PathsException;


class DirFlatTest extends AStorageTest
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
        $this->rmFile('tmp' . DIRECTORY_SEPARATOR . 'other' . DIRECTORY_SEPARATOR . 'sus');
        $this->rmFile('tmp' . DIRECTORY_SEPARATOR . 'red');
        $this->rmDir('tmp' . DIRECTORY_SEPARATOR . 'other' . DIRECTORY_SEPARATOR . 'amogus');
        $this->rmDir('tmp' . DIRECTORY_SEPARATOR . 'other');
        $this->rmDir('tmp');
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
     * @throws PathsException
     */
    public function testCreate(): void
    {
        $lib = $this->getDirFlatLib();
        $this->assertTrue($lib->createDir(['another'], false));
        $this->assertTrue($lib->createDir(['sub', 'added'], false)); // not exists in sub dir
        $this->assertFalse($lib->createDir(['sub', 'added'], true)); // already exists in sub dir
        $this->assertFalse($lib->createDir(['more', 'added'], false)); // not exists both dirs, cannot deep
        $this->assertTrue($lib->createDir(['more', 'added'], true)); // not exists both dirs, can deep
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testRead0(): void
    {
        // fill with own tree, then getting that tree
        $storage = $this->getStorageFlatLib();
        $procFile = new Processing\Storage\ProcessFile($storage);
        $lib = new Processing\Storage\ProcessDir($storage);

        $this->assertTrue($lib->createDir(['tmp', 'other', 'amogus'], true));
        $this->assertTrue($procFile->saveFile(['tmp', 'other', 'sus'], 'abcdef123456'));
        $this->assertTrue($procFile->saveFile(['tmp', 'red'], '123456789abcdefghi'));
        clearstatcache();

        $subList = $lib->readDir(['tmp']);
        usort($subList, [$this, 'sortingPaths']);

        $entry = reset($subList);
        /** @var Node $entry */
        $this->assertEquals([], $entry->getPath());
        $this->assertEquals(ITypes::TYPE_DIR, $entry->getType());
        $this->assertTrue($entry->isDir());
        $this->assertFalse($entry->isFile());

        $entry = next($subList);
        $this->assertEquals(['other'], $entry->getPath());
        $this->assertEquals(ITypes::TYPE_DIR, $entry->getType());
        $this->assertTrue($entry->isDir());
        $this->assertFalse($entry->isFile());

        $entry = next($subList);
        $this->assertEquals(['red'], $entry->getPath());
        $this->assertEquals(ITypes::TYPE_FILE, $entry->getType());
        $this->assertFalse($entry->isDir());
        $this->assertTrue($entry->isFile());

        $this->assertFalse(next($subList));

        $subList = $lib->readDir(['tmp', 'other'], true);
        usort($subList, [$this, 'sortingPaths']);

        $entry = reset($subList);
        /** @var Node $entry */
        $this->assertEquals([], $entry->getPath());
        $this->assertEquals(ITypes::TYPE_DIR, $entry->getType());

        $entry = next($subList);
        $this->assertEquals(['amogus'], $entry->getPath());
        $this->assertEquals(ITypes::TYPE_DIR, $entry->getType());

        $entry = next($subList);
        $this->assertEquals(['sus'], $entry->getPath());
        $this->assertEquals(ITypes::TYPE_FILE, $entry->getType());

        $this->assertFalse(next($subList));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testRead1(): void
    {
        $lib = $this->getDirFlatLib();
        $subList = $lib->readDir([], false, true);
        usort($subList, [$this, 'sortingPaths']);

        $entry = reset($subList);
        /** @var Node $entry */
        $this->assertEquals([], $entry->getPath());
        $this->assertEquals(ITypes::TYPE_DIR, $entry->getType());
        $this->assertTrue($entry->isDir());
        $this->assertFalse($entry->isFile());

        $entry = next($subList);
        $this->assertEquals(['dummy1.txt'], $entry->getPath());
        $this->assertEquals(36, $entry->getSize());
        $this->assertEquals(ITypes::TYPE_FILE, $entry->getType());
        $this->assertFalse($entry->isDir());
        $this->assertTrue($entry->isFile());

        $entry = next($subList);
        $this->assertEquals(['dummy2.txt'], $entry->getPath());
        $this->assertEquals(36, $entry->getSize());
        $this->assertEquals(ITypes::TYPE_FILE, $entry->getType());

        $entry = next($subList);
        $this->assertEquals(['last_one'], $entry->getPath());
        $this->assertEquals(ITypes::TYPE_DIR, $entry->getType());

        $entry = next($subList);
        $this->assertEquals(['next_one'], $entry->getPath());
        $this->assertEquals(ITypes::TYPE_DIR, $entry->getType());

        $entry = next($subList);
        $this->assertEquals(['other1.txt'], $entry->getPath());
        $this->assertEquals(36, $entry->getSize());
        $this->assertEquals(ITypes::TYPE_FILE, $entry->getType());

        $entry = next($subList);
        $this->assertEquals(['other2.txt'], $entry->getPath());
        $this->assertEquals(36, $entry->getSize());
        $this->assertEquals(ITypes::TYPE_FILE, $entry->getType());

        $entry = next($subList);
        $this->assertEquals(['sub'], $entry->getPath());
        $this->assertEquals(ITypes::TYPE_DIR, $entry->getType());

        $this->assertFalse(next($subList));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testRead2(): void
    {
        $lib = $this->getDirFlatLib();
        $subList = $lib->readDir(['next_one'], true);
        usort($subList, [$this, 'sortingPaths']);

        $entry = reset($subList);
        /** @var Node $entry */
        $this->assertEquals([], $entry->getPath());
        $this->assertEquals(ITypes::TYPE_DIR, $entry->getType());

        $entry = next($subList);
        $this->assertEquals(['sub_one'], $entry->getPath());
        $this->assertEquals(ITypes::TYPE_DIR, $entry->getType());

        $entry = next($subList);
        $this->assertEquals(['sub_one', '.gitkeep'], $entry->getPath());
        $this->assertEquals(0, $entry->getSize());
        $this->assertEquals(ITypes::TYPE_FILE, $entry->getType());

        $this->assertFalse(next($subList));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testRead3(): void
    {
        $lib = $this->getDirFlatLib();
        $subList = $lib->readDir(['last_one'], false);
        usort($subList, [$this, 'sortingPaths']);

        $entry = reset($subList);
        /** @var Node $entry */
        $this->assertEquals([], $entry->getPath());
        $this->assertEquals(ITypes::TYPE_DIR, $entry->getType());

        $entry = next($subList);
        $this->assertEquals(['.gitkeep'], $entry->getPath());
        $this->assertEquals(0, $entry->getSize());
        $this->assertEquals(ITypes::TYPE_FILE, $entry->getType());

        $this->assertFalse(next($subList));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testReadFail(): void
    {
        $lib = $this->getDirFlatLib();
        $this->expectException(FilesException::class);
        $lib->readDir(['dummy2.txt']);
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testCopyMoveDelete(): void
    {
        $lib = $this->getDirFlatLib();
        $this->assertTrue($lib->copyDir(['next_one'], ['more']));
        $this->assertTrue($lib->moveDir(['more'], ['another']));
        $this->assertTrue($lib->deleteDir(['another'], true));
        $this->assertFalse($lib->deleteDir(['another']));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testDeleteShallow(): void
    {
        $lib = $this->getDirRecursiveLib();
        $this->assertTrue($lib->createDir(['another']));
        $this->assertTrue($lib->deleteDir(['another']));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testDeleteDeep(): void
    {
        $lib = $this->getDirRecursiveLib();
        $this->assertTrue($lib->createDir(['another', 'sub_one'], true));
        $this->assertTrue($lib->deleteDir(['another'], true));
    }
}
