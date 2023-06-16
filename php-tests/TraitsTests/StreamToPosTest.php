<?php

namespace TraitsTests;


use kalanis\kw_files\FilesException;
use kalanis\kw_files\Traits\TStreamToPos;


class StreamToPosTest extends \CommonTestClass
{
    /**
     * @param string $original
     * @param string $add
     * @param int|null $offset
     * @param string $expect
     * @throws FilesException
     * @dataProvider filterDataProvider
     */
    public function testSimple(string $original, string $add, ?int $offset, string $expect): void
    {
        $lib = new XToPos();
        // create streams
        $orig = fopen('php://memory', 'r+');
        fwrite($orig, $original);
        rewind($orig);
        $cont = fopen('php://memory', 'r+');
        fwrite($cont, $add);
        rewind($cont);
        // process
        $result = $lib->addStreamToPosition($orig, $cont, $offset);
        // get stream content
        $this->assertEquals($expect, stream_get_contents($result, -1, 0));
    }

    public function filterDataProvider(): array
    {
        return [
            ['abcdabcd', 'ABCD', null, 'ABCD'], // full replace
            ['abcdabcd', 'ABCD', 2, 'abABCDcd'], // replace inside
            ['abcd', 'ABCD', 6, "abcd\0\0ABCD"], // append at the end
            ['abcdabcd', 'ABCDABCD', 0, 'ABCDABCD'], // overwrite
            ['abcdabcd', 'ABCD', 6, 'abcdabABCD'], // replace overflow
            ['abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxy', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', null, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'], // full replace
            ['abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxy', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 13, 'abcdefghijklmABCDEFGHIJKLMNOPQRSTUVWXYZnopqrstuvwxy'], // replace inside
            ['abcdefghijklmnopqrstuvwxy', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 30, "abcdefghijklmnopqrstuvwxy\0\0\0\0\0ABCDEFGHIJKLMNOPQRSTUVWXYZ"], // append at the end
        ];
    }
}


class XToPos
{
    use TStreamToPos;
}
