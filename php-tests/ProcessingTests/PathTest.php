<?php

namespace ProcessingTests;


use CommonTestClass;
use kalanis\kw_files\Processing\TPath;


class PathTest extends CommonTestClass
{
    /**
     * @param array<string> $from
     * @param string $to
     * @dataProvider transformProvider
     */
    public function testPaths(/** @scrutinizer ignore-unused */array $from, string $to): void
    {
        $lib = new XPath();
        $this->assertEmpty($lib->getPath());
        $lib->setPath($to);
        $this->assertEquals($to, $lib->getPath());
    }

    public function transformProvider(): array
    {
        return [
            [['okmijnuhb', ], 'okmijnuhb', ],
            // just dirs
            [['wsx', 'edc', 'rfv', ], 'wsx' . DIRECTORY_SEPARATOR . 'edc' . DIRECTORY_SEPARATOR . 'rfv', ],
            // dir slash
            [['wsx/', 'edc', 'r f v', ], 'wsx\/' . DIRECTORY_SEPARATOR . 'edc' . DIRECTORY_SEPARATOR . 'r f v', ],
            // too many slashes
            [['wsx\\', 'e-dc', 'r&f&v', ], 'wsx\\\\' . DIRECTORY_SEPARATOR . 'e-dc' . DIRECTORY_SEPARATOR . 'r&f&v', ],
            // empty path
            [['', ], '', ],
        ];
    }
}


class XPath
{
    use TPath;
}
