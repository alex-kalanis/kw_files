<?php

namespace tests\ProcessingTests;


use tests\CommonTestClass;
use DateTimeInterface;
use kalanis\kw_files\Extended\FindFreeName;
use kalanis\kw_files\FilesException;
use kalanis\kw_files\Interfaces\IProcessNodes;
use kalanis\kw_paths\Extras\TPathTransform;
use kalanis\kw_paths\PathsException;


class FinderTest extends CommonTestClass
{
    /**
     * @param string[] $known
     * @param string[] $path
     * @param string $name
     * @param string $result
     * @throws FilesException
     * @throws PathsException
     * @dataProvider finder1Provider
     */
    public function testCompactFrom1(array $known, array $path, string $name, string $result): void
    {
        $lib = new FindFreeName(new XNameFinder($known));
        $this->assertEquals($result, $lib->findFreeName($path, $name, ''));
    }

    public function finder1Provider(): array
    {
        return [
            // basic one - not exists, no change
            [['wsx', 'edc', 'rfv', ], [], 'uhb', 'uhb', ],
            // basic one - somewhere in subdir, no change need
            [['wsx', 'edc', 'rfv', ], ['edc', ], 'rfv', 'rfv', ],
            // a bit complicated one - somewhere in subdir, change need
            [['edc' . DIRECTORY_SEPARATOR . 'wsx', 'edc' . DIRECTORY_SEPARATOR . 'edc', 'edc' . DIRECTORY_SEPARATOR . 'rfv', ], ['edc', ], 'rfv', 'rfv_0', ],
            // already exists - simple
            [['okmijnuhb', ], [], 'okmijnuhb', 'okmijnuhb_0', ],
            // already exists - more examples
            [['wsx', 'wsx_0', 'wsx_1', ], [], 'wsx', 'wsx_2', ],
        ];
    }

    /**
     * @param string[] $known
     * @param string[] $path
     * @param string $name
     * @param string $result
     * @throws FilesException
     * @throws PathsException
     * @dataProvider finder2Provider
     */
    public function testCompactFrom2(array $known, array $path, string $name, string $result): void
    {
        $lib = new XFindFreeName(new XNameFinder($known));
        $this->assertEquals($result, $lib->findFreeName($path, $name, ''));
    }

    public function finder2Provider(): array
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
