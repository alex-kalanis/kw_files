<?php

namespace StorageDirsTests;


use CommonTestClass;
use kalanis\kw_files\Interfaces\IProcessDirs;
use kalanis\kw_files\Interfaces\IProcessFiles;
use kalanis\kw_files\Interfaces\IProcessNodes;
use kalanis\kw_files\Processing\Storage\ProcessDir;
use kalanis\kw_files\Processing\Storage\ProcessFile;
use kalanis\kw_files\Processing\Storage\ProcessNode;
use kalanis\kw_storage\Storage\Key\DirKey;
use kalanis\kw_storage\Storage\StorageDirs;
use kalanis\kw_storage\Storage\Target\Volume;
use kalanis\kw_storage\StorageException;
use Traversable;


abstract class AStorageTest extends CommonTestClass
{
    protected function getNodeLib(): IProcessNodes
    {
        DirKey::setDir($this->getTestPath());
        return new ProcessNode(new StorageDirs(new DirKey(), new Volume()));
    }

    protected function getNodeFailLib(): IProcessNodes
    {
        DirKey::setDir($this->getTestPath());
        return new ProcessNode(new XFailStorageDirs(new DirKey(), new Volume()));
    }

    protected function getFileLib(): IProcessFiles
    {
        DirKey::setDir($this->getTestPath());
        return new ProcessFile(new StorageDirs(new DirKey(), new Volume()));
    }

    protected function getFileFailLib(): IProcessFiles
    {
        DirKey::setDir($this->getTestPath());
        return new ProcessFile(new XFailStorageDirs(new DirKey(), new Volume()));
    }

    protected function getDirLib(): IProcessDirs
    {
        DirKey::setDir($this->getTestPath());
        return new ProcessDir(new StorageDirs(new DirKey(), new Volume()));
    }

    protected function getDirFailLib(): IProcessDirs
    {
        DirKey::setDir($this->getTestPath());
        return new ProcessDir(new XFailStorageDirs(new DirKey(), new Volume()));
    }

    protected function getTestPath(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree';
    }
}


class XFailStorageDirs extends StorageDirs
{
    public function write(string $sharedKey, $data, ?int $timeout = null): bool
    {
        throw new StorageException('mock');
    }

    public function read(string $sharedKey)
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

    public function created(string $key): ?int
    {
        throw new StorageException('mock');
    }
}
