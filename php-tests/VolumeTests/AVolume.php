<?php

namespace tests\VolumeTests;


use tests\CommonTestClass;
use kalanis\kw_files\Interfaces\IProcessDirs;
use kalanis\kw_files\Processing\Volume\ProcessDir;
use kalanis\kw_paths\PathsException;


class AVolume extends CommonTestClass
{
    protected function setUp(): void
    {
        $this->clearData();
    }

    protected function tearDown(): void
    {
        $this->clearData();
    }

    protected function clearData(): void
    {
        clearstatcache();
        $this->rmFile('another' . DIRECTORY_SEPARATOR . 'sub_one' . DIRECTORY_SEPARATOR . '.gitkeep');
        $this->rmDir('another' . DIRECTORY_SEPARATOR . 'sub_one');
        $this->rmDir('another');
        clearstatcache();
        $this->rmDir('sub' . DIRECTORY_SEPARATOR . 'added');
        $this->rmDir('more' . DIRECTORY_SEPARATOR . 'added');
        clearstatcache();
        $this->rmFile('more' . DIRECTORY_SEPARATOR . 'sub_one' . DIRECTORY_SEPARATOR . '.gitkeep');
        $this->rmDir('more' . DIRECTORY_SEPARATOR . 'sub_one');
        $this->rmDir('more');
        clearstatcache();
    }

    protected function rmDir(string $path): void
    {
        if (is_dir($this->getTestPath() . DIRECTORY_SEPARATOR . $path)) {
            rmdir($this->getTestPath() . DIRECTORY_SEPARATOR . $path);
        }
    }

    protected function rmFile(string $path): void
    {
        if (is_file($this->getTestPath() . DIRECTORY_SEPARATOR . $path)) {
            unlink($this->getTestPath() . DIRECTORY_SEPARATOR . $path);
        }
    }

    /**
     * @throws PathsException
     * @return IProcessDirs
     */
    protected function getDirLib(): IProcessDirs
    {
        return new ProcessDir($this->getTestPath());
    }

    protected function getTestPath(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'tree';
    }
}
