<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Tests\Transaction\Factory;

use BitWasp\Bitcoin\Script\ScriptFactory;
use BitWasp\Bitcoin\Script\ScriptInterface;
use BitWasp\Bitcoin\Tests\AbstractTestCase;
use BitWasp\Bitcoin\Transaction\Factory\SignData;

class SignDataTest extends AbstractTestCase
{
    public function getVectors()
    {
        $fixtures = $this->jsonDataFile('signdata_fixtures.json');
        $vectors = [];
        foreach ($fixtures['fixtures'] as $fixture) {
            $vectors[] = [
                $fixture['redeemScript'] !== '' ? ScriptFactory::fromHex($fixture['redeemScript']) : null,
                $fixture['witnessScript'] !== '' ? ScriptFactory::fromHex($fixture['witnessScript']) : null,
                $fixture['signaturePolicy'] !== '' ? $this->getScriptFlagsFromString($fixture['signaturePolicy']) : null
            ];
        }
        return $vectors;
    }

    /**
     * @param ScriptInterface|null $rs
     * @param ScriptInterface|null $ws
     * @param int|null $flags
     * @dataProvider getVectors
     */
    public function testCase(ScriptInterface $rs = null, ScriptInterface $ws = null, int $flags = null)
    {
        $signData = new SignData();
        $this->assertFalse($signData->hasRedeemScript());
        $this->assertFalse($signData->hasWitnessScript());
        $this->assertFalse($signData->hasSignaturePolicy());

        if ($rs !== null) {
            $signData->p2sh($rs);
            $this->assertTrue($signData->hasRedeemScript());
            $this->assertEquals($rs, $signData->getRedeemScript());
        }

        if ($ws!== null) {
            $signData->p2wsh($ws);
            $this->assertTrue($signData->hasWitnessScript());
            $this->assertEquals($ws, $signData->getWitnessScript());
        }

        if ($flags !== null) {
            $signData->signaturePolicy($flags);
            $this->assertTrue($signData->hasSignaturePolicy());
            $this->assertEquals($flags, $signData->getSignaturePolicy());
        }
    }

    public function testThrowsIfUnknownWSRequested()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage("Witness script requested but not set");

        $signData = new SignData();
        $signData->getWitnessScript();
    }

    public function testThrowsIfUnknownRSRequested()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage("Redeem script requested but not set");

        $signData = new SignData();
        $signData->getRedeemScript();
    }

    public function testThrowsIfUnknownSignaturePolicyRequested()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage("Signature policy requested but not set");

        $signData = new SignData();
        $signData->getSignaturePolicy();
    }
}
