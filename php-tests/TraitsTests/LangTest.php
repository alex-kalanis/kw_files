<?php

namespace tests\TraitsTests;


use tests\CommonTestClass;
use kalanis\kw_files\Translations;


class LangTest extends CommonTestClass
{
    public function testPass(): void
    {
        $lib = new XLang();
        $lib->setFlLang(new XTrans());
        $this->assertNotEmpty($lib->getFlLang());
        $this->assertInstanceOf(XTrans::class, $lib->getFlLang());
        $lib->setFlLang(null);
        $this->assertInstanceOf(Translations::class, $lib->getFlLang());
    }
}
