<?php

namespace ProcessingTests;


use CommonTestClass;
use kalanis\kw_files\Processing\TNameFinder;
use kalanis\kw_files\Processing\TPathTransform;


class FinderTest extends CommonTestClass
{
    /**
     * @param array<string> $known
     * @param array<string> $adding
     * @param string $result
     * @dataProvider finderProvider
     */
    public function testCompactFrom(array $known, array $adding, string $result): void
    {
        $lib = new XNameFinder($known);
        $this->assertEquals($result, $lib->findFreeName($adding, ''));
    }

    public function finderProvider(): array
    {
        return [
            // basic one - somewhere in subdir
            [['wsx', 'edc', 'rfv', ], ['edc', 'rfv', ], 'edc' . DIRECTORY_SEPARATOR . 'rfv', ],
            // already exists - simple
            [['okmijnuhb', ], ['okmijnuhb', ], 'okmijnuhb--#0', ],
            // already exists - more
            [['wsx', 'wsx--#0', 'wsx--#1', ], ['wsx', ], 'wsx--#2', ],
        ];
    }
}


class XNameFinder
{
    use TNameFinder;
    use TPathTransform;

    protected $knownNames;

    /**
     * @param array<string> $knownNames
     */
    public function __construct(array $knownNames)
    {
        $this->knownNames = $knownNames;
    }

    protected function getNameSeparator(): string
    {
        return '--#';
    }

    protected function targetExists(array $path, string $added): bool
    {
        return in_array($this->compactName($path) . $added, $this->knownNames);
    }
}
