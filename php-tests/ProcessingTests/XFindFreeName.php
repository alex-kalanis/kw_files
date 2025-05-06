<?php

namespace tests\ProcessingTests;


use kalanis\kw_files\Extended\FindFreeName;


class XFindFreeName extends FindFreeName
{
    protected function getNameSeparator(): string
    {
        return '--#';
    }
}
