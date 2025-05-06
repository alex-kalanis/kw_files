<?php

namespace tests\ProcessingTests;


use DateTimeInterface;
use kalanis\kw_files\Interfaces\IProcessNodes;
use kalanis\kw_paths\Extras\TPathTransform;


class XNameFinder implements IProcessNodes
{
    use TPathTransform;

    protected $knownNames;

    /**
     * @param array<string> $knownNames
     */
    public function __construct(array $knownNames)
    {
        $this->knownNames = $knownNames;
    }

    public function exists(array $entry): bool
    {
        return in_array($this->compactName($entry), $this->knownNames);
    }

    public function isReadable(array $entry): bool
    {
        return false;
    }

    public function isWritable(array $entry): bool
    {
        return false;
    }

    public function isDir(array $entry): bool
    {
        return false;
    }

    public function isFile(array $entry): bool
    {
        return false;
    }

    public function size(array $entry): ?int
    {
        return null;
    }

    public function created(array $entry): ?DateTimeInterface
    {
        return null;
    }

    protected function noDirectoryDelimiterSet(): string
    {
        return 'mock no dir';
    }
}
