<?php

namespace kalanis\kw_files\Processing\Storage\Nodes;


use kalanis\kw_files\FilesException;
use kalanis\kw_storage\Interfaces\IPassDirs;
use kalanis\kw_storage\Storage\Storage;
use kalanis\kw_storage\StorageException;


/**
 * Class CanDir
 * @package kalanis\kw_files\Processing\Storage\Nodes
 * Process dirs via predefined api
 */
class CanDir extends ANodes
{
    /** @var IPassDirs|Storage */
    protected $storage = null;

    public function __construct(IPassDirs $storage)
    {
        $this->storage = $storage;
    }

    public function exists(array $entry): bool
    {
        $path = $this->compactName($entry, $this->getStorageSeparator());
        try {
            return $this->storage->exists($path);
        } catch (StorageException $ex) {
            throw new FilesException($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    public function isDir(array $entry): bool
    {
        $path = $this->compactName($entry, $this->getStorageSeparator());
        try {
            return $this->storage->isDir($path);
        } catch (StorageException $ex) {
            throw new FilesException($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    public function isFile(array $entry): bool
    {
        $path = $this->compactName($entry, $this->getStorageSeparator());
        try {
            return $this->storage->isFile($path);
        } catch (StorageException $ex) {
            throw new FilesException($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    public function size(array $entry): ?int
    {
        $path = $this->compactName($entry, $this->getStorageSeparator());
        try {
            return $this->storage->size($path);
        } catch (StorageException $ex) {
            throw new FilesException($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    public function created(array $entry): ?int
    {
        $path = $this->compactName($entry, $this->getStorageSeparator());
        try {
            return $this->storage->created($path);
        } catch (StorageException $ex) {
            throw new FilesException($ex->getMessage(), $ex->getCode(), $ex);
        }
    }
}
