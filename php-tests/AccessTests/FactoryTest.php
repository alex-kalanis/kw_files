<?php

namespace AccessTests;


use CommonTestClass;
use kalanis\kw_files\Access\CompositeAdapter;
use kalanis\kw_files\Access\Factory;
use kalanis\kw_files\FilesException;
use kalanis\kw_paths\PathsException;
use kalanis\kw_storage\Storage\Key\DefaultKey;
use kalanis\kw_storage\Storage\Storage;
use kalanis\kw_storage\Storage\Target\Memory;


class FactoryTest extends CommonTestClass
{
    /**
     * @param $param
     * @throws FilesException
     * @throws PathsException
     * @dataProvider passProvider
     */
    public function testPass($param): void
    {
        $lib = new Factory();
        $this->assertInstanceOf(CompositeAdapter::class, $lib->getClass($param));
    }

    public function passProvider(): array
    {
        $storage = new Storage(new DefaultKey(), new Memory());
        return [
            ['somewhere'],
            [__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree'],
            [['path' => __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree']],
            [['source' => __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree']],
            [$storage],
            [['files' => ['source' => $storage]]],
            [(new Factory())->getClass($storage)], // deep init - already have composite
        ];
    }

    /**
     * @param mixed $param
     * @throws PathsException
     * @throws FilesException
     * @dataProvider failProvider
     */
    public function testFail($param): void
    {
        $lib = new Factory();
        $this->expectException(FilesException::class);
        $lib->getClass($param);
    }

    public function failProvider(): array
    {
        return [
            [true],
            [false],
            [null],
            [new \stdClass()],
            [['what' => 'irrelevant']],
            [['path' => []]],
            [['path' => null]],
            [['path' => new \stdClass()]],
            [['source' => []]],
            [['source' => null]],
            [['source' => new \stdClass()]],
        ];
    }
}
