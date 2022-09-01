# kw_files

Manage access to storage with emulation of tree structure of real filesystem.
Necessary for key-value storages. Also can behave the correct way when storing
in classical filesystems.

## PHP Installation

```
{
    "require": {
        "alex-kalanis/kw_files": "1.0"
    }
}
```

(Refer to [Composer Documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction) if you are not
familiar with composer)


## PHP Usage

1.) Use your autoloader (if not already done via Composer autoloader)

2.) Add some external packages with connection to the local or remote services.

3.) Connect the "kalanis\kw_mapper\Records\ARecord" into your app. Extends it for setting your case.

4.) Extend your libraries by interfaces inside the package.

5.) Just call setting and render


Notes to self: - all entries starts internally with the separators (usually slashes). It is not necessary
and sometimes counter-productive to add them when setting the staring dir. It behaves like prefix.
