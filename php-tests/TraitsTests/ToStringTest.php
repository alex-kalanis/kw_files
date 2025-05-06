<?php

namespace tests\TraitsTests;


use tests\CommonTestClass;
use kalanis\kw_files\FilesException;


class ToStringTest extends CommonTestClass
{
    /**
     * @param mixed $ext
     * @param string $result
     * @throws FilesException
     * @dataProvider filterDataProvider
     */
    public function testSimple($ext, string $result): void
    {
        $lib = new XToString();
        $this->assertEquals($result, $lib->toStr($ext));
    }

    public function filterDataProvider(): array
    {
        $stream1 = fopen('php://memory', 'r+');
        fwrite($stream1,'Just for unable read');
        return [
            [$stream1, 'Just for unable read'],
            ['there is no string', 'there is no string'],
            [123456, '123456'],
            [123.456, '123.456'],
            [new StrObj(), 'test'],
        ];
    }

    /**
     * @param mixed $ext
     * @throws FilesException
     * @dataProvider dieProvider
     */
    public function testDie($ext): void
    {
        $lib = new XToString();
        $this->expectException(FilesException::class);
        $lib->toStr($ext);
    }

    public function dieProvider(): array
    {
        return [
            [new \stdClass()],
            [true],
            [false],
            [null],
        ];
    }
}
