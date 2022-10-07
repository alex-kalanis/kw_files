<?php

namespace ProcessingTests;


use CommonTestClass;
use kalanis\kw_files\FilesException;
use kalanis\kw_files\Processing\TNameFinder;
use kalanis\kw_files\Processing\TPathTransform;


class FinderTest extends CommonTestClass
{
    /**
     * @param string[] $known
     * @param string[] $path
     * @param string $name
     * @param string $result
     * @dataProvider finderProvider
     */
    public function testCompactFrom(array $known, array $path, string $name, string $result): void
    {
        $lib = new XNameFinder($known);
        $this->assertEquals($result, $lib->findFreeName($path, $name, ''));
    }

    public function finderProvider(): array
    {
        return [
            // basic one - not exists, no change
            [['wsx', 'edc', 'rfv', ], [], 'uhb', 'uhb', ],
            // basic one - somewhere in subdir, no change need
            [['wsx', 'edc', 'rfv', ], ['edc', ], 'rfv', 'rfv', ],
            // a bit complicated one - somewhere in subdir, change need
            [['edc' . DIRECTORY_SEPARATOR . 'wsx', 'edc' . DIRECTORY_SEPARATOR . 'edc', 'edc' . DIRECTORY_SEPARATOR . 'rfv', ], ['edc', ], 'rfv', 'rfv--#0', ],
            // already exists - simple
            [['okmijnuhb', ], [], 'okmijnuhb', 'okmijnuhb--#0', ],
            // already exists - more examples
            [['wsx', 'wsx--#0', 'wsx--#1', ], [], 'wsx', 'wsx--#2', ],
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

    /**
     * @param string[] $path
     * @param string $added
     * @throws FilesException
     * @return bool
     */
    protected function targetExists(array $path, string $added): bool
    {
        return in_array($this->compactName($path) . $added, $this->knownNames);
    }
}
