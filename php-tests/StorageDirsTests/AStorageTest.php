<?php

namespace tests\StorageDirsTests;


use tests\CommonTestClass;
use kalanis\kw_files\Interfaces\IProcessDirs;
use kalanis\kw_files\Interfaces\IProcessFiles;
use kalanis\kw_files\Interfaces\IProcessNodes;
use kalanis\kw_files\Processing\Storage\ProcessDir;
use kalanis\kw_files\Processing\Storage\ProcessFile;
use kalanis\kw_files\Processing\Storage\ProcessNode;
use kalanis\kw_storage\Storage\Key;
use kalanis\kw_storage\Storage\StorageDirs;
use kalanis\kw_storage\Storage\Target;


abstract class AStorageTest extends CommonTestClass
{
    protected function getNodeLib(): IProcessNodes
    {
        Key\StaticPrefixKey::setPrefix($this->getTestPath());
        return new ProcessNode(new StorageDirs(new Key\StaticPrefixKey(), new Target\Volume()));
    }

    protected function getNodeFailLib(): IProcessNodes
    {
        Key\StaticPrefixKey::setPrefix($this->getTestPath());
        return new ProcessNode(new XFailStorageDirs(new Key\StaticPrefixKey(), new Target\Volume()));
    }

    protected function getFileLib(): IProcessFiles
    {
        Key\StaticPrefixKey::setPrefix($this->getTestPath());
        return new ProcessFile(new StorageDirs(new Key\StaticPrefixKey(), new Target\Volume()));
    }

    protected function getFileFailLib(): IProcessFiles
    {
        Key\StaticPrefixKey::setPrefix($this->getTestPath());
        return new ProcessFile(new XFailStorageDirs(new Key\StaticPrefixKey(), new Target\Volume()));
    }

    protected function getDirRecursiveLib(): IProcessDirs
    {
        Key\StaticPrefixKey::setPrefix($this->getTestPath());
        return new ProcessDir(new StorageDirs(new Key\StaticPrefixKey(), new Target\Volume()));
    }

    protected function getDirRecursiveFailLib(): IProcessDirs
    {
        Key\StaticPrefixKey::setPrefix($this->getTestPath());
        return new ProcessDir(new XFailStorageDirs(new Key\StaticPrefixKey(), new Target\Volume()));
    }

    protected function getDirFlatLib(): IProcessDirs
    {
        Key\StaticPrefixKey::setPrefix($this->getTestPath());
        return new ProcessDir(new StorageDirs(new Key\StaticPrefixKey(), new Target\VolumeTargetFlat()));
    }

    protected function getDirFlatFailLib(): IProcessDirs
    {
        Key\StaticPrefixKey::setPrefix($this->getTestPath());
        return new ProcessDir(new XFailStorageDirs(new Key\StaticPrefixKey(), new Target\VolumeTargetFlat()));
    }

    protected function getStorageRecursiveLib(): StorageDirs
    {
        Key\StaticPrefixKey::setPrefix($this->getTestPath());
        return new StorageDirs(new Key\StaticPrefixKey(), new Target\Volume());
    }

    protected function getStorageFlatLib(): StorageDirs
    {
        Key\StaticPrefixKey::setPrefix($this->getTestPath());
        return new StorageDirs(new Key\StaticPrefixKey(), new Target\VolumeTargetFlat());
    }

    protected function getTestPath(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree';
    }
}
