<?php

namespace Mdojr\EmailProvider\Tests\Entity\Helper;

use PHPUnit\Framework\TestCase;
use Mdojr\EmailProvider\Entity\Helper\ArrayCopy;

class ArrayCopyTest extends TestCase
{
    public function testArrayCopy()
    {
        $fakeArrayCopy = $this->createMock(ArrayCopy::class);
        $reflection = new \ReflectionClass(get_class($fakeArrayCopy));

        $this->assertTrue($reflection->hasMethod('getArrayCopy'));
        $method = $reflection->getMethod('getArrayCopy');
        $this->assertSame($method->getNumberOfParameters(), 0);
        $this->assertTrue($method->getReturnType() == gettype([]));
    }
}
