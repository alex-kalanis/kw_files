<?php

namespace TraitsTests;


use kalanis\kw_files\FilesException;
use kalanis\kw_files\Traits\TToStream;


class ToStreamTest extends \CommonTestClass
{
    /**
     * @param mixed $ext
     * @param string $result
     * @throws FilesException
     * @dataProvider filterDataProvider
     */
    public function testSimple($ext, string $result): void
    {
        $lib = new XToStream();
        $str = $lib->toStr($ext);
        $this->assertEquals($result, stream_get_contents($str, -1, 0));
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
        ];
    }

    /**
     * @param mixed $ext
     * @throws FilesException
     * @dataProvider dieProvider
     */
    public function testDie($ext): void
    {
        $lib = new XToStream();
        $this->expectException(FilesException::class);
        $lib->toStr($ext);
    }

    public function dieProvider(): array
    {
        return [
            [new StrObj2()],
            [new \stdClass()],
            [true],
            [false],
            [null],
        ];
    }
}


class XToStream
{
    use TToStream;

    /**
     * @param mixed $content
     * @throws FilesException
     * @return resource
     */
    public function toStr($content)
    {
        return $this->toStream('test', $content);
    }
}


class StrObj2
{
    public function __toString(): string
    {
        return 'test';
    }
}