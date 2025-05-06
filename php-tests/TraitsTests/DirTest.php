<?php

namespace tests\TraitsTests;


use tests\CommonTestClass;
use kalanis\kw_files\FilesException;


class DirTest extends CommonTestClass
{
    /**
     * @throws FilesException
     */
    public function testPass(): void
    {
        $lib = new XDir();
        $lib->setProcessDir(new XProcessDir());
        $this->assertNotEmpty($lib->getProcessDir());
    }

    /**
     * @throws FilesException
     */
    public function testFail(): void
    {
        $lib = new XDir();
        $this->expectException(FilesException::class);
        $lib->getProcessDir();
    }
}
