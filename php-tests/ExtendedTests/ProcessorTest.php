<?php

namespace ExtendedTests;


use CommonTestClass;
use kalanis\kw_files\Extended\Config;
use kalanis\kw_files\Extended\Processor;
use kalanis\kw_files\FilesException;
use kalanis\kw_files\Processing\Storage;
use kalanis\kw_storage\Storage\Key\DefaultKey;
use kalanis\kw_storage\Storage\Target\Memory;


class ProcessorTest extends CommonTestClass
{
    /**
     * @throws FilesException
     */
    public function testProcess(): void
    {
        $memory = new Memory();
        $storage = new \kalanis\kw_storage\Storage\Storage(new DefaultKey(), $memory);
        $dir = new Storage\ProcessDir($storage);
        $node = new Storage\ProcessNode($storage);
        $lib = new Processor($dir, $node, new Config());

        $this->assertFalse($node->exists(['foo', 'bar']));
        $this->assertTrue($lib->createDir(['foo', 'bar']));
        $this->assertTrue($node->exists(['foo', 'bar']));
        $this->assertFalse($node->exists(['foo', 'bar', '.txt']));
        $this->assertFalse($lib->createDir(['foo', 'bar'], true));
        $this->assertTrue($lib->makeExtended(['foo', 'bar']));
        $this->assertTrue($node->exists(['foo', 'bar', '.txt']));

        $this->assertTrue($lib->removeExtended(['foo', 'bar']));
        $this->assertFalse($node->exists(['foo', 'bar', '.txt']));
        $this->assertTrue($lib->removeDir(['foo', 'bar']));
        $this->assertFalse($node->exists(['foo', 'bar']));
    }

    /**
     * @throws FilesException
     */
    public function testMakeThumbExists(): void
    {
        $config = new Config();
        $memory = new Memory();
        $storage = new \kalanis\kw_storage\Storage\Storage(new DefaultKey(), $memory);
        $dir = new Storage\ProcessDir($storage);
        $file = new Storage\ProcessFile($storage);
        $node = new Storage\ProcessNode($storage);
        $lib = new Processor($dir, $node, $config);

        $this->assertFalse($node->exists(['meek']));
        $this->assertTrue($lib->createDir(['meek']));
        $this->assertTrue($file->saveFile(['meek', $config->getThumbDir()], 'abcdef'));
        $this->assertFalse($lib->makeExtended(['meek']));
    }

    /**
     * @throws FilesException
     */
    public function testMakeDescExists(): void
    {
        $config = new Config();
        $memory = new Memory();
        $storage = new \kalanis\kw_storage\Storage\Storage(new DefaultKey(), $memory);
        $dir = new Storage\ProcessDir($storage);
        $file = new Storage\ProcessFile($storage);
        $node = new Storage\ProcessNode($storage);
        $lib = new Processor($dir, $node, $config);

        $this->assertFalse($node->exists(['meek']));
        $this->assertTrue($lib->createDir(['meek']));
        $this->assertTrue($file->saveFile(['meek', $config->getDescDir()], 'abcdef'));
        $this->assertFalse($lib->makeExtended(['meek']));
    }

    /**
     * @throws FilesException
     */
    public function testRemoveThumbExists(): void
    {
        $config = new Config();
        $memory = new Memory();
        $storage = new \kalanis\kw_storage\Storage\Storage(new DefaultKey(), $memory);
        $dir = new Storage\ProcessDir($storage);
        $file = new Storage\ProcessFile($storage);
        $node = new Storage\ProcessNode($storage);
        $lib = new Processor($dir, $node, $config);

        $this->assertFalse($node->exists(['meek']));
        $this->assertTrue($lib->createDir(['meek']));
        $this->assertTrue($file->saveFile(['meek', $config->getThumbDir()], 'abcdef'));
        $this->assertFalse($lib->removeExtended(['meek']));
    }

    /**
     * @throws FilesException
     */
    public function testRemoveDescExists(): void
    {
        $config = new Config();
        $memory = new Memory();
        $storage = new \kalanis\kw_storage\Storage\Storage(new DefaultKey(), $memory);
        $dir = new Storage\ProcessDir($storage);
        $file = new Storage\ProcessFile($storage);
        $node = new Storage\ProcessNode($storage);
        $lib = new Processor($dir, $node, $config);

        $this->assertFalse($node->exists(['meek']));
        $this->assertTrue($lib->createDir(['meek']));
        $this->assertTrue($file->saveFile(['meek', $config->getDescDir()], 'abcdef'));
        $this->assertFalse($lib->removeExtended(['meek']));
    }
}
