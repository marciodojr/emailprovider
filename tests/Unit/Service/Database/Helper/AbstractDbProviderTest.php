<?php

namespace Mdojr\EmailProvider\Test\Unit\Service\Database\Helper;

use Mdojr\EmailProvider\Service\Database\Helper\AbstractDbProvider;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;

class AbstractDbProviderTest extends TestCase
{
    public function testCreateInstance()
    {
        $fakeEntityManager = $this->createMock(EntityManager::class);
        $fakeDbProvider = $this->getMockForAbstractClass(AbstractDbProvider::class, [$fakeEntityManager]);

        $reflection = new \ReflectionClass(get_class($fakeDbProvider));
        $property = $reflection->getProperty('em');
        $property->setAccessible(true);

        $this->assertInstanceOf(AbstractDbProvider::class, $fakeDbProvider);
        $this->assertSame($fakeEntityManager, $property->getValue($fakeDbProvider));
    }
}
