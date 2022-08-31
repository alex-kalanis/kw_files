<?php

namespace StorageBasicTests;


use CommonTestClass;
use kalanis\kw_files\Interfaces\IProcessDirs;
use kalanis\kw_files\Interfaces\IProcessFiles;
use kalanis\kw_files\Interfaces\IProcessNodes;
use kalanis\kw_files\Processing\Storage\ProcessDir;
use kalanis\kw_files\Processing\Storage\ProcessFile;
use kalanis\kw_files\Processing\Storage\ProcessNode;
use kalanis\kw_storage\Interfaces\IStorage;
use kalanis\kw_storage\Storage\Key\DirKey;
use kalanis\kw_storage\Storage\Storage;
use kalanis\kw_storage\Storage\Target\Memory;
use kalanis\kw_storage\StorageException;
use Traversable;


abstract class AStorageTest extends CommonTestClass
{
    const STORAGE_NODE_KEY_TEST = "\eNODE\e";

    protected function getNodeLib(): IProcessNodes
    {
        DirKey::setDir($this->getTestPath());
        return new ProcessNode(new Storage(new DirKey(), $this->filledMemory()));
    }

    protected function getNodeFailLib(): IProcessNodes
    {
        DirKey::setDir($this->getTestPath());
        return new ProcessNode(new XFailStorage(new DirKey(), new Memory()));
    }

    protected function getFileLib(): IProcessFiles
    {
        DirKey::setDir($this->getTestPath());
        return new ProcessFile(new Storage(new DirKey(), $this->filledMemory()));
    }

    protected function getFileFailLib(): IProcessFiles
    {
        DirKey::setDir($this->getTestPath());
        return new ProcessFile(new XFailStorage(new DirKey(), new Memory()));
    }

    protected function getDirLib(): IProcessDirs
    {
        DirKey::setDir($this->getTestPath());
        return new ProcessDir(new Storage(new DirKey(), $this->filledMemory()));
    }

    protected function getDirFailLib(): IProcessDirs
    {
        DirKey::setDir($this->getTestPath());
        return new ProcessDir(new XFailStorage(new DirKey(), new Memory()));
    }

    protected function getTestPath(): string
    {
        return 'data' . DIRECTORY_SEPARATOR . 'tree';
    }

    protected function filledMemory(): IStorage
    {
        $res = fopen('php://memory', 'r+');
        fwrite($res, 'qwertzuiopasdfghjklyxcvbnm0123456789');
        $lib = new Memory();
        $lib->save('data', static::STORAGE_NODE_KEY_TEST);
        $lib->save('data' . DIRECTORY_SEPARATOR . 'tree', static::STORAGE_NODE_KEY_TEST);
        $lib->save('data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'last_one', static::STORAGE_NODE_KEY_TEST);
        $lib->save('data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'last_one' . DIRECTORY_SEPARATOR . '.gitkeep', '');
        $lib->save('data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'next_one', static::STORAGE_NODE_KEY_TEST);
        $lib->save('data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'next_one' . DIRECTORY_SEPARATOR . 'sub_one', static::STORAGE_NODE_KEY_TEST);
        $lib->save('data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'next_one' . DIRECTORY_SEPARATOR . 'sub_one' . DIRECTORY_SEPARATOR . '.gitkeep', '');
        $lib->save('data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'sub', static::STORAGE_NODE_KEY_TEST);
        $lib->save('data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'sub' . DIRECTORY_SEPARATOR . 'dummy3.txt', 'qwertzuiopasdfghjklyxcvbnm0123456789');
        $lib->save('data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'sub' . DIRECTORY_SEPARATOR . 'dummy4.txt', false); // intentionally!!!
        $lib->save('data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'dummy1.txt', 'qwertzuiopasdfghjklyxcvbnm0123456789');
        $lib->save('data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'dummy2.txt', 'qwertzuiopasdfghjklyxcvbnm0123456789');
        $lib->save('data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'other1.txt', $res);
        $lib->save('data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'other2.txt', 'qwertzuiopasdfghjklyxcvbnm0123456789');
        return $lib;
    }
}


class XFailStorage extends Storage
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
}
