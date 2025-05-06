<?php

namespace tests\TraitsTests;


use tests\CommonTestClass;
use kalanis\kw_files\FilesException;


class NodeTest extends CommonTestClass
{
    /**
     * @throws FilesException
     */
    public function testPass(): void
    {
        $lib = new XNode();
        $lib->setProcessNode(new XProcessNode());
        $this->assertNotEmpty($lib->getProcessNode());
    }

    /**
     * @throws FilesException
     */
    public function testFail(): void
    {
        $lib = new XNode();
        $this->expectException(FilesException::class);
        $lib->getProcessNode();
    }
}
