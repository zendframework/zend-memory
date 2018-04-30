<?php
/**
 * @see       https://github.com/zendframework/zend-memory for the canonical source repository
 * @copyright Copyright (c) 2005-2018 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-memory/blob/master/LICENSE.md New BSD License
 */

namespace ZendTest\Memory;

use PHPUnit\Framework\TestCase;
use Zend\Memory;

/**
 * @group      Zend_Memory
 */
class ValueTest extends TestCase
{
    /**
     * tests the Value object creation
     */
    public function testCreation()
    {
        $valueObject = new Memory\Value('data data data ...', new TestAsset\DummyMovableContainer());
        $this->assertInstanceOf(Memory\Value::class, $valueObject);
        $this->assertEquals($valueObject->getRef(), 'data data data ...');
    }

    /**
     * tests the value reference retrieval
     */
    public function testGetRef()
    {
        $valueObject = new Memory\Value('0123456789', new TestAsset\DummyMovableContainer());
        $valueRef = &$valueObject->getRef();
        $valueRef[3] = '_';

        $this->assertEquals($valueObject->getRef(), '012_456789');
    }

    /**
     * tests the __toString() functionality
     */
    public function testToString()
    {
        $valueObject = new Memory\Value('0123456789', new TestAsset\DummyMovableContainer());
        $this->assertEquals($valueObject->__toString(), '0123456789');

        $this->assertEquals(strlen($valueObject), 10);
        $this->assertEquals((string) $valueObject, '0123456789');
    }

    /**
     * tests the access through ArrayAccess methods
     */
    public function testArrayAccess()
    {
        $valueObject = new Memory\Value('0123456789', new TestAsset\DummyMovableContainer());
        $this->assertEquals($valueObject[8], '8');

        $valueObject[2] = '_';
        $this->assertEquals((string) $valueObject, '01_3456789');


        $error_level = error_reporting();
        error_reporting($error_level & ~E_NOTICE);
        $valueObject[10] = '_';
        $this->assertEquals((string) $valueObject, '01_3456789_');
        error_reporting($error_level);
    }
}
