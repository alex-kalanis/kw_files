<?php

namespace ProcessingTests;


use CommonTestClass;
use kalanis\kw_files\FilesException;
use kalanis\kw_files\Processing\TPath;
use kalanis\kw_files\Processing\TPathTransform;


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

    /**
     * @param array<string> $from
     * @param string $to
     * @throws FilesException
     * @dataProvider transformProvider
     */
    public function testCompactFrom(array $from, string $to): void
    {
        $lib = new XPathTransform();
        $this->assertEquals($to, $lib->compactName($from));
    }

    /**
     * @param array<string> $to
     * @param string $from
     * @throws FilesException
     * @dataProvider transformProvider
     */
    public function testExpandFrom(array $to, string $from): void
    {
        $lib = new XPathTransform();
        $this->assertEquals($to, $lib->expandName($from));
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

    /**
     * @throws FilesException
     */
    public function testEmptyCompact(): void
    {
        $lib = new XPathTransform();
        $this->expectException(FilesException::class);
        $lib->compactName(['any', 'where'], '');
    }

    /**
     * @throws FilesException
     */
    public function testEmptyExpand(): void
    {
        $lib = new XPathTransform();
        $this->expectException(FilesException::class);
        $lib->expandName('any/where', '');
    }
}


class XPath
{
    use TPath;
}


class XPathTransform
{
    use TPathTransform;
}
