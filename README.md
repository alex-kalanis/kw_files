# kw_files

![Build Status](https://github.com/alex-kalanis/kw_storage/actions/workflows/code_checks.yml/badge.svg)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-kalanis/kw_files/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-kalanis/kw_files/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alex-kalanis/kw_files/v/stable.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_files)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.4-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/alex-kalanis/kw_files.svg?v1)](https://packagist.org/packages/alex-kalanis/kw_files)
[![License](https://poser.pugx.org/alex-kalanis/kw_files/license.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_files)
[![Code Coverage](https://scrutinizer-ci.com/g/alex-kalanis/kw_files/badges/coverage.png?b=master&v=1)](https://scrutinizer-ci.com/g/alex-kalanis/kw_files/?branch=master)

Manage access to storage with emulation of tree structure of real filesystem.
Necessary for key-value storages. Also can behave the correct way when storing
in classical filesystems.

## PHP Installation

```bash
composer.phar require alex-kalanis/kw_files
```

(Refer to [Composer Documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction) if you are not
familiar with composer)


## PHP Usage

1.) Use your autoloader (if not already done via Composer autoloader)

2.) Add some external packages with connection to the local or remote services.

3.) Connect the correct processing libraries from "kalanis\kw_files\Processing" into your app. The correct one depends on your storage.

4.) Extend your libraries by interfaces inside the package.

5.) Just call setting and render


### Changes

- v2 has difference in interface and class tree building for free name lookup
- v3 has extended support of actions over files, got some things from other repositories
- v4 changed behavior against streams

Notes to self: - all entries starts internally with the separators (usually slashes). It is not necessary
and sometimes counter-productive to add them when setting the starting dir. It behaves like a prefix.
