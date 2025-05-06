<?php

namespace tests\TraitsTests;


use tests\CommonTestClass;
use kalanis\kw_files\FilesException;


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
