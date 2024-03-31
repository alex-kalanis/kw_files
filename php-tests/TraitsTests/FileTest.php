<?php

namespace TraitsTests;


use CommonTestClass;
use kalanis\kw_files\FilesException;
use kalanis\kw_files\Interfaces\IProcessFiles;
use kalanis\kw_files\Traits\TFile;


class FileTest extends CommonTestClass
{
    /**
     * @throws FilesException
     */
    public function testPass(): void
    {
        $lib = new XFile();
        $lib->setProcessFile(new XProcessFile());
        $this->assertNotEmpty($lib->getProcessFile());
    }

    /**
     * @throws FilesException
     */
    public function testFail(): void
    {
        $lib = new XFile();
        $this->expectException(FilesException::class);
        $lib->getProcessFile();
    }
}


class XFile
{
    use TFile;
}


class XProcessFile implements IProcessFiles
{
    public function saveFile(array $entry, string $content, ?int $offset = null, int $mode = 0): bool
    {
        return true;
    }

    public function readFile(array $entry, ?int $offset = null, ?int $length = null): string
    {
        return '';
    }

    public function copyFile(array $source, array $dest): bool
    {
        return true;
    }

    public function moveFile(array $source, array $dest): bool
    {
        return true;
    }

    public function deleteFile(array $entry): bool
    {
        return true;
    }
}
