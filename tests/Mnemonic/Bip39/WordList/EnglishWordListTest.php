<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Tests\Mnemonic\Bip39\WordList;

use BitWasp\Bitcoin\Mnemonic\Bip39\Wordlist\EnglishWordList;
use BitWasp\Bitcoin\Tests\AbstractTestCase;

class EnglishWordListTest extends AbstractTestCase
{
    public function testGetWordList()
    {
        $wl = new EnglishWordList();
        $this->assertEquals(2048, count($wl));
        $this->assertEquals(2048, count($wl->getWords()));
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

        $word = $wl->getIndex('able');
        $this->assertIsInt($word);

        $wl->getIndex('unknownword');
    }
}
