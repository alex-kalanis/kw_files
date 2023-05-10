<?php

namespace TraitsTests;


use CommonTestClass;
use kalanis\kw_files\Traits\TSubPart;


class SubPartTest extends CommonTestClass
{
    /**
     * @param string[] $what
     * @param string[] $in
     * @param bool $result
     * @dataProvider subPartProvider
     */
    public function testProcess(array $what, array $in, bool $result): void
    {
        $lib = new XSubPart();
        $this->assertEquals($result, $lib->is($what, $in));
    }

    public function subPartProvider(): array
    {
        return [
            [[], [], true],
            [['foo'], [], true],
            [['foo'], ['foo'], true],
            [['foo', 'bar'], ['foo'], true],
            [['foo'], ['foo', 'bar'], true],
            [['baz'], ['bar'], false],
            [['baz', 'foo'], ['bar', 'foo'], false],
            [['foo', 'bar'], ['foo', 'baz'], false],
            [['foo', 'bar', 'baz'], ['foo', 'baz'], false],
        ];
    }
}


class XSubPart
{
    use TSubPart;

    public function is(array $what, array $in): bool
    {
        return $this->isSubPart($what, $in);
    }
}
