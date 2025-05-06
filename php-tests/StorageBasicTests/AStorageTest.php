<?php

namespace tests\StorageBasicTests;


use tests\CommonTestClass;
use kalanis\kw_files\Interfaces;
use kalanis\kw_files\Processing\Storage\ProcessDir;
use kalanis\kw_files\Processing\Storage\ProcessFile;
use kalanis\kw_files\Processing\Storage\ProcessFileStream;
use kalanis\kw_files\Processing\Storage\ProcessNode;
use kalanis\kw_storage\Interfaces\Target\ITarget;
use kalanis\kw_storage\Storage\Key\StaticPrefixKey;
use kalanis\kw_storage\Storage\Storage;
use kalanis\kw_storage\Storage\Target\Memory;


abstract class AStorageTest extends CommonTestClass
{
    protected function getNodeLib(): Interfaces\IProcessNodes
    {
        StaticPrefixKey::setPrefix($this->getTestPath());
        return new ProcessNode(new Storage(new StaticPrefixKey(), $this->filledMemory()));
    }

    protected function getNodeFailLib(): Interfaces\IProcessNodes
    {
        StaticPrefixKey::setPrefix($this->getTestPath());
        return new ProcessNode(new XFailStorage(new StaticPrefixKey(), new Memory()));
    }

    protected function getFileLib(): Interfaces\IProcessFiles
    {
        StaticPrefixKey::setPrefix($this->getTestPath());
        return new ProcessFile(new Storage(new StaticPrefixKey(), $this->filledMemory()));
    }

    protected function getFileFailLib(): Interfaces\IProcessFiles
    {
        StaticPrefixKey::setPrefix($this->getTestPath());
        return new ProcessFile(new XFailStorage(new StaticPrefixKey(), new Memory()));
    }

    protected function getDirLib(): Interfaces\IProcessDirs
    {
        StaticPrefixKey::setPrefix($this->getTestPath());
        return new ProcessDir(new Storage(new StaticPrefixKey(), $this->filledMemory()));
    }

    protected function getDirFailLib(): Interfaces\IProcessDirs
    {
        StaticPrefixKey::setPrefix($this->getTestPath());
        return new ProcessDir(new XFailStorage(new StaticPrefixKey(), new Memory()));
    }

    protected function getDirTreeLib(): Interfaces\IProcessDirs
    {
        StaticPrefixKey::setPrefix('');
        return new ProcessDir(new Storage(new StaticPrefixKey(), $this->filledMemory()));
    }

    protected function getStreamLib(): Interfaces\IProcessFileStreams
    {
        StaticPrefixKey::setPrefix($this->getTestPath());
        return new ProcessFileStream(new Storage(new StaticPrefixKey(), $this->filledMemory()));
    }

    protected function getStreamFailLib(): Interfaces\IProcessFileStreams
    {
        StaticPrefixKey::setPrefix($this->getTestPath());
        return new ProcessFileStream(new XFailStorage(new StaticPrefixKey(), new Memory()));
    }

    protected function getStreamFailRemoveLib(): Interfaces\IProcessFileStreams
    {
        StaticPrefixKey::setPrefix($this->getTestPath());
        return new ProcessFileStream(new XFailRemoveStorage(new StaticPrefixKey(), $this->filledMemory()));
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
        $lib = new Memory();
        $lib->save('', Interfaces\IProcessNodes::STORAGE_NODE_KEY); // root has empty file name - his name is defined by its mountpoint
        $lib->save('' . DIRECTORY_SEPARATOR . 'data', Interfaces\IProcessNodes::STORAGE_NODE_KEY);
        $lib->save('' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree', Interfaces\IProcessNodes::STORAGE_NODE_KEY);
        $lib->save(DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'last_one', Interfaces\IProcessNodes::STORAGE_NODE_KEY);
        $lib->save(DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'last_one' . DIRECTORY_SEPARATOR . '.gitkeep', '');
        $lib->save(DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'next_one', Interfaces\IProcessNodes::STORAGE_NODE_KEY);
        $lib->save(DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'next_one' . DIRECTORY_SEPARATOR . 'sub_one', Interfaces\IProcessNodes::STORAGE_NODE_KEY);
        $lib->save(DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'next_one' . DIRECTORY_SEPARATOR . 'sub_one' . DIRECTORY_SEPARATOR . '.gitkeep', '');
        $lib->save(DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'sub', Interfaces\IProcessNodes::STORAGE_NODE_KEY);
        $lib->save(DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'sub' . DIRECTORY_SEPARATOR . 'dummy3.txt', 'qwertzuiopasdfghjklyxcvbnm0123456789');
        $lib->save(DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'sub' . DIRECTORY_SEPARATOR . 'dummy4.txt', false); // intentionally!!!
        $lib->save(DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'dummy1.txt', 'qwertzuiopasdfghjklyxcvbnm0123456789');
        $lib->save(DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'dummy2.txt', 'qwertzuiopasdfghjklyxcvbnm0123456789');
        $lib->save(DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'other1.txt', 'qwertzuiopasdfghjklyxcvbnm0123456789');
        $lib->save(DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree' . DIRECTORY_SEPARATOR . 'other2.txt', 'qwertzuiopasdfghjklyxcvbnm0123456789');
        return $lib;
    }
}
