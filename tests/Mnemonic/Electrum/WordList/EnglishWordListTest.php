<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Tests\Mnemonic\Electrum\WordList;

use BitWasp\Bitcoin\Mnemonic\Electrum\Wordlist\EnglishWordList;
use BitWasp\Bitcoin\Tests\AbstractTestCase;

class EnglishWordListTest extends AbstractTestCase
{
    public function testGetWordList()
    {
        $wl = new EnglishWordList();
        $this->assertEquals(1626, count($wl));
        $this->assertEquals(1626, count($wl->getWords()));
    }

    public function testUnknownWord()
    {
        $this->expectException(\InvalidArgumentException::class);

        $wl = new EnglishWordList();
        $wl->getWord(101010101);
    }

    public function testExceptionOutOfRange()
    {
        $this->expectException(\InvalidArgumentException::class);

        $wl = new EnglishWordList();

        $word = $wl->getIndex('just');
        $this->assertIsInt($word);

        $wl->getIndex('unknownword');
    }
}
