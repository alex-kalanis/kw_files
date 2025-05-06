<?php

namespace tests\TraitsTests;


use kalanis\kw_files\Interfaces\IFLTranslations;


class XTrans implements IFLTranslations
{
    public function flCannotProcessNode(string $name): string
    {
        return 'mock';
    }

    public function flBadMode(int $mode): string
    {
        return 'mock';
    }

    public function flCannotLoadFile(string $fileName): string
    {
        return 'mock';
    }

    public function flCannotSaveFile(string $fileName): string
    {
        return 'mock';
    }

    public function flCannotOpenFile(string $fileName): string
    {
        return 'mock';
    }

    public function flCannotSeekFile(string $fileName): string
    {
        return 'mock';
    }

    public function flCannotWriteFile(string $fileName): string
    {
        return 'mock';
    }

    public function flCannotGetFilePart(string $fileName): string
    {
        return 'mock';
    }

    public function flCannotGetSize(string $fileName): string
    {
        return 'mock';
    }

    public function flCannotCopyFile(string $sourceFileName, string $destFileName): string
    {
        return 'mock';
    }

    public function flCannotMoveFile(string $sourceFileName, string $destFileName): string
    {
        return 'mock';
    }

    public function flCannotRemoveFile(string $fileName): string
    {
        return 'mock';
    }

    public function flCannotCreateDir(string $dirName): string
    {
        return 'mock';
    }

    public function flCannotReadDir(string $dirName): string
    {
        return 'mock';
    }

    public function flCannotCopyDir(string $sourceDirName, string $destDirName): string
    {
        return 'mock';
    }

    public function flCannotMoveDir(string $sourceDirName, string $destDirName): string
    {
        return 'mock';
    }

    public function flCannotRemoveDir(string $dirName): string
    {
        return 'mock';
    }

    public function flNoDirectoryDelimiterSet(): string
    {
        return 'mock';
    }

    public function flNoProcessNodeSet(): string
    {
        return 'mock';
    }

    public function flNoProcessFileSet(): string
    {
        return 'mock';
    }

    public function flNoProcessStreamSet(): string
    {
        return 'mock';
    }

    public function flNoProcessDirSet(): string
    {
        return 'mock';
    }

    public function flNoAvailableClasses(): string
    {
        return 'mock';
    }
}
