<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Tests\Serializer\Block;

use BitWasp\Bitcoin\Math\Math;
use BitWasp\Bitcoin\Serializer\Block\BlockHeaderSerializer;
use BitWasp\Bitcoin\Serializer\Block\BlockSerializer;
use BitWasp\Bitcoin\Serializer\Transaction\TransactionSerializer;
use BitWasp\Bitcoin\Tests\AbstractTestCase;
use BitWasp\Buffertools\Buffer;

class BlockSerializerTest extends AbstractTestCase
{
    public function testInvalidParse()
    {
        $this->expectException(\BitWasp\Buffertools\Exceptions\ParserOutOfRange::class);

        $serializer = new BlockSerializer(
            new Math,
            new BlockHeaderSerializer,
            new TransactionSerializer()
        );
        $serializer->parse(new Buffer());
    }
}
