<?php

namespace tests\StorageBasicTests;


use kalanis\kw_storage\Storage\Storage;
use kalanis\kw_storage\StorageException;


class XFailRemoveStorage extends Storage
{
    public function remove(string $sharedKey): bool
    {
        throw new StorageException('mock');
    }
}
