<?php

namespace TraitsTests;


use CommonTestClass;
use kalanis\kw_files\FilesException;
use kalanis\kw_files\Interfaces\IProcessFileStreams;
use kalanis\kw_files\Traits\TStream;


class StreamTest extends CommonTestClass
{
    /**
     * @throws FilesException
     */
    public function testPass(): void
    {
        $lib = new XStream();
        $lib->setProcessStream(new XProcessStream());
        $this->assertNotEmpty($lib->getProcessStream());
    }

    /**
     * @throws FilesException
     */
    public function testFail(): void
    {
        $lib = new XStream();
        $this->expectException(FilesException::class);
        $lib->getProcessStream();
    }
}


class XStream
{
    use TStream;
}


class XProcessStream implements IProcessFileStreams
{
    public function saveFileStream(array $entry, $content, int $mode = 0): bool
    {
        return true;
    }

    public function readFileStream(array $entry)
    {
        return fopen('php://memory', 'rb+');
    }

    public function copyFileStream(array $source, array $dest): bool
    {
        return true;
    }

    public function moveFileStream(array $source, array $dest): bool
    {
        return true;
    }
}
