<?php

namespace tests\ExtendedTests;


use kalanis\kw_files\Access\Factory;


class XAccessFactory extends Factory
{
    public static function init(): self
    {
        return new self();
    }
}
