<?php

namespace tests\StorageDirsTests;


use kalanis\kw_storage\Storage\StorageDirs;
use kalanis\kw_storage\StorageException;
use Traversable;


class XFailStorageDirs extends StorageDirs
{
    public function write(string $sharedKey, $data, ?int $timeout = null): bool
    {
        throw new StorageException('mock');
    }

    public function read(string $sharedKey): string
    {
        throw new StorageException('mock');
    }

    public function remove(string $sharedKey): bool
    {
        throw new StorageException('mock');
    }

    public function exists(string $sharedKey): bool
    {
        throw new StorageException('mock');
    }

    public function lookup(string $mask): Traversable
    {
        throw new StorageException('mock');
    }

    public function increment(string $key): bool
    {
        throw new StorageException('mock');
    }

    public function decrement(string $key): bool
    {
        throw new StorageException('mock');
    }

    public function removeMulti(array $keys): array
    {
        throw new StorageException('mock');
    }

    public function isDir(string $key): bool
    {
        throw new StorageException('mock');
    }

    public function isFile(string $key): bool
    {
        throw new StorageException('mock');
    }

    public function isReadable(string $key): bool
    {
        throw new StorageException('mock');
    }

    public function isWritable(string $key): bool
    {
        throw new StorageException('mock');
    }

    public function mkDir(string $key, bool $recursive = false): bool
    {
        throw new StorageException('mock');
    }

    public function rmDir(string $key, bool $recursive = false): bool
    {
        throw new StorageException('mock');
    }

    public function copy(string $source, string $dest): bool
    {
        throw new StorageException('mock');
    }

    public function move(string $source, string $dest): bool
    {
        throw new StorageException('mock');
    }

    public function size(string $key): ?int
    {
        throw new StorageException('mock');
    }

    public function created(string $key): ?\DateTimeInterface
    {
        throw new StorageException('mock');
    }
}
