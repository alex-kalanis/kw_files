<?php

namespace StorageBasicTests;


use kalanis\kw_files\FilesException;
use kalanis\kw_files\Interfaces\ITypes;
use kalanis\kw_files\Node;
use kalanis\kw_files\Processing;
use kalanis\kw_paths\PathsException;


class DirTest extends AStorageTest
{
    /**
     * @throws FilesException
     * @throws PathsException
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
     * @throws PathsException
     */
    public function testRead0(): void
    {
        // fill with own tree, then getting that tree
        $storage = $this->getStorageLib();
        $procFile = new Processing\Storage\ProcessFile($storage);
        $lib = new Processing\Storage\ProcessDir($storage);

        $lib->createDir([]);
        $lib->createDir(['other', 'amogus'], true);
        $procFile->saveFile(['other', 'sus'], 'abcdef123456');
        $procFile->saveFile(['red'], '123456789abcdefghi');

        $subList = $lib->readDir([]);
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

        $subList = $lib->readDir(['other'], true);
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
        $lib = $this->getDirLib();
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
        $lib = $this->getDirLib();
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
        $lib = $this->getDirLib();
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
    public function testRead4(): void
    {
        $lib = $this->getDirTreeLib();
        $subList = $lib->readDir([], false);
        $entry = reset($subList);
        usort($subList, [$this, 'sortingPaths']);

        /** @var Node $entry */
        $this->assertEquals([], $entry->getPath());
        $this->assertEquals(ITypes::TYPE_DIR, $entry->getType());

        $entry = next($subList);
        $this->assertEquals(['data'], $entry->getPath());
        $this->assertEquals(0, $entry->getSize());
        $this->assertEquals(ITypes::TYPE_DIR, $entry->getType());

        $this->assertFalse(next($subList));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testReadFail(): void
    {
        $lib = $this->getDirLib();
        $this->expectException(FilesException::class);
        $lib->readDir(['dummy2.txt']);
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testCopyMoveDelete(): void
    {
        $lib = $this->getDirLib();
        $this->assertTrue($lib->copyDir(['next_one'], ['more']));
        $this->assertTrue($lib->moveDir(['more'], ['another']));
        $this->assertTrue($lib->deleteDir(['another'], true));
        $this->assertFalse($lib->deleteDir(['another']));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testCopyFail(): void
    {
        $lib = $this->getDirLib();
        $this->assertFalse($lib->copyDir(['next_one'], ['other2.txt'])); // dest exists
        $this->assertFalse($lib->copyDir(['more'], ['another'])); // source is not exists
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testMoveFail(): void
    {
        $lib = $this->getDirLib();
        $this->assertFalse($lib->moveDir(['next_one'], ['other2.txt'])); // dest exists
        $this->assertFalse($lib->moveDir(['more'], ['another'])); // source not exists
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testDeleteFail(): void
    {
        $lib = $this->getDirLib();
        $this->assertFalse($lib->deleteDir(['other2.txt']));
        $this->assertFalse($lib->deleteDir(['more']));
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
    }
}
