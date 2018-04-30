<?php
/**
 * @see       https://github.com/zendframework/zend-memory for the canonical source repository
 * @copyright Copyright (c) 2005-2018 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-memory/blob/master/LICENSE.md New BSD License
 */

namespace ZendTest\Memory;

use PHPUnit\Framework\TestCase;
use Zend\Memory\Container;

/**
 * @group      Zend_Memory
 */
class LockedTest extends TestCase
{
    /**
     * tests the Movable memory container object creation
     */
    public function testCreation()
    {
        $memObject = new Container\Locked('0123456789');

        $this->assertInstanceOf('Zend\Memory\Container\Locked', $memObject);
    }

    /**
     * tests the value access methods
     */
    public function testValueAccess()
    {
        $memObject = new Container\Locked('0123456789');

        // getRef() method
        $this->assertEquals($memObject->getRef(), '0123456789');

        $valueRef = &$memObject->getRef();
        $valueRef[3] = '_';
        $this->assertEquals($memObject->getRef(), '012_456789');

        // value property
        $this->assertEquals((string) $memObject->value, '012_456789');

        $memObject->value[7] = '_';
        $this->assertEquals((string) $memObject->value, '012_456_89');

        $memObject->value = 'another value';
        $this->assertEquals((string) $memObject->value, 'another value');
    }

    /**
     * tests lock()/unlock()/isLocked() functions
     */
    public function testLock()
    {
        $memObject = new Container\Locked('0123456789');

        // It's always locked
        $this->assertTrue($memObject->isLocked());

        $memObject->lock();
        $this->assertTrue($memObject->isLocked());

        $memObject->unlock();
        // It's always locked
        $this->assertTrue($memObject->isLocked());
    }

    /**
     * tests the touch() method
     */
    public function testTouch()
    {
        $memObject = new Container\Locked('0123456789');

        $memObject->touch();

        // Nothing to check
    }
}
