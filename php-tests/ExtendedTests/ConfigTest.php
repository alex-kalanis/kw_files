<?php

namespace ExtendedTests;


use CommonTestClass;
use kalanis\kw_files\Extended\Config;


class ConfigTest extends CommonTestClass
{
    /**
     * @param array<string> $params
     * @param string $descDir
     * @param string $descFile
     * @param string $descExt
     * @param string $thumbDir
     * @param string $thumbExt
     * @param string $thumbTemp
     * @dataProvider configProvider
     */
    public function testConfig(array $params, string $descDir, string $descFile, string $descExt, string $thumbDir, string $thumbExt, string $thumbTemp): void
    {
        $lib = new Config();
        $lib->setData($params);
        $this->assertEquals($descDir, $lib->getDescDir());
        $this->assertEquals($descFile, $lib->getDescFile());
        $this->assertEquals($descExt, $lib->getDescExt());
        $this->assertEquals($thumbDir, $lib->getThumbDir());
        $this->assertEquals($thumbExt, $lib->getThumbExt());
        $this->assertEquals($thumbTemp, $lib->getThumbTemp());
    }

    public function configProvider(): array
    {
        return [
            // empty settings
            [['desc_dir' => '', 'desc_file' => '', 'desc_ext' => '', 'thumb_dir' => '', 'tmb_ext' => '', 'tmb_temp' => '', 'outside' => '', ], '.txt', 'index', '.dsc', '.tmb', '.png', '.tmp', ],
            // some values
            [['desc_dir' => 123, 'desc_file' => 'foo', 'desc_ext' => 'bar', 'thumb_dir' => 456.789, 'tmb_ext' => 'nope', 'tmb_temp' => 'huh', ], '123', 'foo', 'bar', '456.789', 'nope', 'huh', ],
        ];
    }
}
