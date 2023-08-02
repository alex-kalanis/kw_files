<?php

namespace StorageBasicTests;


use CommonTestClass;
use kalanis\kw_files\Interfaces\IProcessDirs;
use kalanis\kw_files\Interfaces\IProcessFiles;
use kalanis\kw_files\Interfaces\IProcessNodes;
use kalanis\kw_files\Processing\Storage\ProcessDir;
use kalanis\kw_files\Processing\Storage\ProcessFile;
use kalanis\kw_files\Processing\Storage\ProcessNode;
use kalanis\kw_storage\Interfaces\ITarget;
use kalanis\kw_storage\Storage\Key\StaticPrefixKey;
use kalanis\kw_storage\Storage\Storage;
use kalanis\kw_storage\Storage\Target\Memory;
use kalanis\kw_storage\StorageException;
use Traversable;


abstract class AStorageTest extends CommonTestClass
{
    protected function getNodeLib(): IProcessNodes
    {
        StaticPrefixKey::setPrefix($this->getTestPath());
        return new ProcessNode(new Storage(new StaticPrefixKey(), $this->filledMemory()));
    }

    protected function getNodeFailLib(): IProcessNodes
    {
        StaticPrefixKey::setPrefix($this->getTestPath());
        return new ProcessNode(new XFailStorage(new StaticPrefixKey(), new Memory()));
    }

    protected function getFileLib(): IProcessFiles
    {
        StaticPrefixKey::setPrefix($this->getTestPath());
        return new ProcessFile(new Storage(new StaticPrefixKey(), $this->filledMemory()));
    }

    protected function getFileFailLib(): IProcessFiles
    {
        StaticPrefixKey::setPrefix($this->getTestPath());
        return new ProcessFile(new XFailStorage(new StaticPrefixKey(), new Memory()));
    }

    protected function getDirLib(): IProcessDirs
    {
        StaticPrefixKey::setPrefix($this->getTestPath());
        return new ProcessDir(new Storage(new StaticPrefixKey(), $this->filledMemory()));
    }

    protected function getDirFailLib(): IProcessDirs
    {
        StaticPrefixKey::setPrefix($this->getTestPath());
        return new ProcessDir(new XFailStorage(new StaticPrefixKey(), new Memory()));
    }

    protected function getDirTreeLib(): IProcessDirs
    {
        StaticPrefixKey::setPrefix('');
        return new ProcessDir(new Storage(new StaticPrefixKey(), $this->filledMemory()));
    }

    protected function getStorageLib(): Storage
    {
        StaticPrefixKey::setPrefix('');
        return new Storage(new StaticPrefixKey(), new Memory());
    }

    protected function getTestPath(): string
    {
        return DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree';
    }

    protected function filledMemory(): ITarget
    {
        $res = fopen('php://memory', 'r+');
        fwrite($res, 'qwertzuiopasdfghjklyxcvbnm0123456789');
        $lib = new Memory();
        $lib->save('', IProcessNodes::STORAGE_NODE_KEY); // root has empty file name - his name is defined by its mountpoint
        $lib->save('' . DIRECTORY_SEPARATOR . 'data', IProcessNodes::STORAGE_NODE_KEY);
        $lib->save('' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree', IProcessNodes::STORAGE_NODE_KEY);
        $lib->save(DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'last_one', IProcessNodes::STORAGE_NODE_KEY);
        $lib->save(DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'last_one' . DIRECTORY_SEPARATOR . '.gitkeep', '');
        $lib->save(DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'next_one', IProcessNodes::STORAGE_NODE_KEY);
        $lib->save(DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'next_one' . DIRECTORY_SEPARATOR . 'sub_one', IProcessNodes::STORAGE_NODE_KEY);
        $lib->save(DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'next_one' . DIRECTORY_SEPARATOR . 'sub_one' . DIRECTORY_SEPARATOR . '.gitkeep', '');
        $lib->save(DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'sub', IProcessNodes::STORAGE_NODE_KEY);
        $lib->save(DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'sub' . DIRECTORY_SEPARATOR . 'dummy3.txt', 'qwertzuiopasdfghjklyxcvbnm0123456789');
        $lib->save(DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'sub' . DIRECTORY_SEPARATOR . 'dummy4.txt', false); // intentionally!!!
        $lib->save(DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'dummy1.txt', 'qwertzuiopasdfghjklyxcvbnm0123456789');
        $lib->save(DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'dummy2.txt', 'qwertzuiopasdfghjklyxcvbnm0123456789');
        $lib->save(DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'other1.txt', $res);
        $lib->save(DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'other2.txt', 'qwertzuiopasdfghjklyxcvbnm0123456789');
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
