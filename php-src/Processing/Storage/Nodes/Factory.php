<?php

namespace kalanis\kw_files\Processing\Storage\Nodes;


use kalanis\kw_files\Interfaces\IFLTranslations;
use kalanis\kw_storage\Interfaces\IPassDirs;
use kalanis\kw_storage\Storage\Storage;


/**
 * Class Factory
 * @package kalanis\kw_files\Processing\Storage\Nodes
 * Process nodes in storages - get correct one
 */
class Factory
{
    public function getClass(Storage $storage, ?IFLTranslations $lang = null): ANodes
    {
        if ($storage instanceof IPassDirs) {
            return new CanDir($storage);
        } else {
            return new Basic($storage, $lang);
        }
    }
}
