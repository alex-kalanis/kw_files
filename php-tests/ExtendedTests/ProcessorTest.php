<?php

namespace ExtendedTests;


use CommonTestClass;
use kalanis\kw_files\Access\Factory;
use kalanis\kw_files\Extended\Config;
use kalanis\kw_files\Extended\Processor;
use kalanis\kw_files\FilesException;
use kalanis\kw_paths\PathsException;
use kalanis\kw_storage\Storage\Storage;
use kalanis\kw_storage\Storage\Key\DefaultKey;
use kalanis\kw_storage\Storage\Target\Memory;


class ProcessorTest extends CommonTestClass
{
    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testProcess(): void
    {
        $lib = new Processor(XAccessFactory::init()->getClass(new Storage(new DefaultKey(), new Memory())), new Config());

        $this->assertFalse($lib->exists(['foo', 'bar']));
        $this->assertFalse($lib->dirExists(['foo', 'bar']));
        $this->assertFalse($lib->fileExists(['foo', 'bar']));
        $this->assertTrue($lib->createDir(['foo', 'bar']));
        $this->assertTrue($lib->exists(['foo', 'bar']));
        $this->assertFalse($lib->fileExists(['foo', 'bar']));
        $this->assertTrue($lib->dirExists(['foo', 'bar']));
        $this->assertFalse($lib->exists(['foo', 'bar', '.txt']));
        $this->assertFalse($lib->createDir(['foo', 'bar'], true));
        $this->assertTrue($lib->makeExtended(['foo', 'bar']));
        $this->assertTrue($lib->exists(['foo', 'bar', '.txt']));
        $this->assertTrue($lib->dirExists(['foo', 'bar', '.txt']));
        $this->assertFalse($lib->fileExists(['foo', 'bar', '.txt']));

        $this->assertTrue($lib->removeExtended(['foo', 'bar']));
        $this->assertFalse($lib->exists(['foo', 'bar', '.txt']));
        $this->assertTrue($lib->removeDir(['foo', 'bar']));
        $this->assertFalse($lib->exists(['foo', 'bar']));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testMakeThumbExists(): void
    {
        $config = new Config();
        $access = XAccessFactory::init()->getClass(new Storage(new DefaultKey(), new Memory()));
        $lib = new Processor($access, $config);

        $this->assertFalse($access->exists(['meek']));
        $this->assertTrue($lib->createDir(['meek']));
        $this->assertTrue($access->saveFile(['meek', $config->getThumbDir()], 'abcdef'));
        $this->assertFalse($lib->makeExtended(['meek']));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testMakeDescExists(): void
    {
        $config = new Config();
        $access = XAccessFactory::init()->getClass(new Storage(new DefaultKey(), new Memory()));
        $lib = new Processor($access, $config);

        $this->assertFalse($access->exists(['meek']));
        $this->assertTrue($lib->createDir(['meek']));
        $this->assertTrue($access->saveFile(['meek', $config->getDescDir()], 'abcdef'));
        $this->assertFalse($lib->makeExtended(['meek']));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testRemoveThumbExists(): void
    {
        $config = new Config();
        $access = XAccessFactory::init()->getClass(new Storage(new DefaultKey(), new Memory()));
        $lib = new Processor($access, $config);

        $this->assertFalse($access->exists(['meek']));
        $this->assertTrue($lib->createDir(['meek']));
        $this->assertTrue($access->saveFile(['meek', $config->getThumbDir()], 'abcdef'));
        $this->assertFalse($lib->removeExtended(['meek']));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testRemoveDescExists(): void
    {
        $config = new Config();
        $storage = new Storage(new DefaultKey(), new Memory());
        $access = XAccessFactory::init()->getClass($storage);
        $lib = new Processor($access, $config);

        $this->assertFalse($access->exists(['meek']));
        $this->assertTrue($lib->createDir(['meek']));
        $this->assertTrue($access->saveFile(['meek', $config->getDescDir()], 'abcdef'));
        $this->assertFalse($lib->removeExtended(['meek']));
    }
}


class XAccessFactory extends Factory
{
    public static function init(): self
    {
        return new self();
    }
}
