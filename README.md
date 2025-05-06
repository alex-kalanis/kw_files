# kw_files

![Build Status](https://github.com/alex-kalanis/kw_storage/actions/workflows/code_checks.yml/badge.svg)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-kalanis/kw_files/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-kalanis/kw_files/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alex-kalanis/kw_files/v/stable.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_files)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.4-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/alex-kalanis/kw_files.svg?v1)](https://packagist.org/packages/alex-kalanis/kw_files)
[![License](https://poser.pugx.org/alex-kalanis/kw_files/license.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_files)
[![Code Coverage](https://scrutinizer-ci.com/g/alex-kalanis/kw_files/badges/coverage.png?b=master&v=1)](https://scrutinizer-ci.com/g/alex-kalanis/kw_files/?branch=master)

Manage access to storage with emulation of tree structure of real filesystem.
Necessary for key-value storages. It can also behave the correct way when storing
data on classical filesystems. Basically it equalize access to storage structure
as tree without need to care if it is an actual tree.


## PHP Installation

```bash
composer.phar require alex-kalanis/kw_files
```

(Refer to [Composer Documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction) if you are not
familiar with composer)


## PHP Usage

1.) Use your autoloader (if not already done via Composer autoloader)

2.) Add some external packages with connection to the local or remote storages.
    If you use local volume you can skip this step. If you use memory as storage
    (like for tests) you also need underlying package ```kw_storage```. Or package
    which implements local interfaces for things like AWS or your custom CDN.

3.) Connect the correct processing libraries into your app. The correct one depends
    on your storage. You can use directly ```kalanis\kw_files\Access\Factory``` with
    pass of configuration values which set the correct adapter. Or in your DI set
    the implementing classes of interfaces from ```kalanis\kw_files\Interfaces```
    which will access your storage and use them in custom extension of
    ```kalanis\kw_files\Access\CompositeAdapter```. This is the way when you use more
    storages at once. Each storage will have own instance of adapter.

4.) Call adapter via DI and use storage to access files. Beware that paths are
    defined as arrays of strings. The final separator of each level in tree
    depends on your storage! This way it is possible to emulate trees even on
    flat key-value storages.

```php
// DI-like
return function (array $params): \kalanis\kw_files\Access\CompositeAdapter {
    return (new \kalanis\kw_files\Access\Factory())->getClass($params);
}
```

```php
// Classes
use \kalanis\kw_files\Access;

class FileOperations
{
    public function __construct(
        // ...
        protected readonly Access\CompositeAdapter $files,
        // ...
    ) {}

    public function upload(string $name, string $content): bool
    {
        $objName = (new \kalanis\kw_paths\ArrayPath())->setString($name);
        if (!$this->files->isDir($objName->getArrayDirectory())) {
            return false;
        }
        if ($this->files->exists($objName->getArray())) {
            return false;
        }
        return $this->files->saveFile($objName->getArray(), $content);
    }

    public function move(string $from, string $to): bool
    {
        $arrFrom = (new \kalanis\kw_paths\ArrayPath())->setString($from)->getArray();
        $objTo = (new \kalanis\kw_paths\ArrayPath())->setString($to);
        if (!$this->files->exists($arrFrom)) {
            return false;
        }
        if (!$this->files->exists($objTo->getArrayDirectory())) {
            return false;
        }
        if ($this->files->exists($objTo->getArray())) {
            return false;
        }
        return $this->files->isDir($arrFrom)
            ? $this->files->moveDir($arrFrom, $objTo->getArray())
            : $this->files->moveFile($arrFrom, $objTo->getArray())
        ;
    }
}
```


### Changes

* 5.0 - uses DateTime, tests with separated classes
* 4.0 - changed behavior against streams
* 3.0 - has extended support of actions over files, got some things from other repositories
* 2.0 - has difference in interface and class tree building for free name lookup
* 1.0 - initial version

Notes to self: - all entries starts internally with the separators (usually slashes). It is not necessary
and sometimes counter-productive to add them when setting the starting dir. It behaves like a prefix.
