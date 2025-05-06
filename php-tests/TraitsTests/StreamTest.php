<?php

namespace tests\TraitsTests;


use tests\CommonTestClass;
use kalanis\kw_files\FilesException;


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
