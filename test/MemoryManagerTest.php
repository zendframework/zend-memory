<?php
/**
 * @see       https://github.com/zendframework/zend-memory for the canonical source repository
 * @copyright Copyright (c) 2005-2018 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-memory/blob/master/LICENSE.md New BSD License
 */

namespace ZendTest\Memory;

use PHPUnit\Framework\TestCase;
use Zend\Cache\Storage\Adapter\AdapterInterface as CacheAdapter;
use Zend\Cache\StorageFactory as CacheFactory;
use Zend\Memory;

/**
 * @group      Zend_Memory
 */
class MemoryManagerTest extends TestCase
{
    /**
     * Cache object
     *
     * @var CacheAdapter
     */
    private $cache = null;

    public function setUp()
    {
        $this->cache = CacheFactory::adapterFactory('memory', ['memory_limit' => 0]);
    }

    /**
     * tests the Memory ManagerInterface creation
     */
    public function testCreation()
    {
        /** Without caching */
        $memoryManager = new Memory\MemoryManager();
        $this->assertInstanceOf(Memory\MemoryManager::class, $memoryManager);
        unset($memoryManager);

        /** Caching using 'File' backend */
        $memoryManager = new Memory\MemoryManager($this->cache);
        $this->assertInstanceOf(Memory\MemoryManager::class, $memoryManager);
        unset($memoryManager);
    }

    /**
     * tests the Memory ManagerInterface settings
     */
    public function testSettings()
    {
        $memoryManager = new Memory\MemoryManager($this->cache);

        // MemoryLimit
        $memoryManager->setMemoryLimit(2 * 1024 * 1024 /* 2Mb */);
        $this->assertEquals($memoryManager->getMemoryLimit(), 2 * 1024 * 1024);

        // MinSize
        $this->assertEquals($memoryManager->getMinSize(), 16 * 1024); // check for default value (16K)
        $memoryManager->setMinSize(4 * 1024 /* 4Kb */);
        $this->assertEquals($memoryManager->getMinSize(), 4 * 1024);
    }

    /**
     * tests the memory Objects creation
     */
    public function testCreate()
    {
        $memoryManager = new Memory\MemoryManager($this->cache);

        $memObject1 = $memoryManager->create('Value of object 1');
        $this->assertInstanceOf(Memory\Container\AccessController::class, $memObject1);
        $this->assertEquals($memObject1->getRef(), 'Value of object 1');

        $memObject2 = $memoryManager->create();
        $this->assertInstanceOf(Memory\Container\AccessController::class, $memObject2);
        $this->assertEquals($memObject2->getRef(), '');

        $memObject3 = $memoryManager->createLocked('Value of object 3');
        $this->assertInstanceOf(Memory\Container\Locked::class, $memObject3);
        $this->assertEquals($memObject3->getRef(), 'Value of object 3');

        $memObject4 = $memoryManager->createLocked();
        $this->assertInstanceOf(Memory\Container\Locked::class, $memObject4);
        $this->assertEquals($memObject4->getRef(), '');
    }

    /**
     * tests the processing of data
     */
    public function testProcessing()
    {
        $memoryManager = new Memory\MemoryManager($this->cache);

        $memoryManager->setMinSize(256);
        $memoryManager->setMemoryLimit(1024 * 32);

        $memObjects = [];
        for ($count = 0; $count < 64; $count++) {
            $memObject = $memoryManager->create(str_repeat((string)($count % 10), 1024) /* 1K */);
            $memObjects[] = $memObject;
        }

        for ($count = 0; $count < 64; $count += 2) {
            $this->assertEquals($memObjects[$count]->value[16], (string)($count % 10));
        }

        for ($count = 63; $count > 0; $count -= 2) {
            $memObjects[$count]->value[16] = '_';
        }

        for ($count = 1; $count < 64; $count += 2) {
            $this->assertEquals($memObjects[$count]->value[16], '_');
        }
    }

    public function testNotEnoughSpaceThrowException()
    {
        $memoryManager = new Memory\MemoryManager($this->cache);

        $memoryManager->setMinSize(128);
        $memoryManager->setMemoryLimit(1024);

        $memObjects = [];
        for ($count = 0; $count < 8; $count++) {
            $memObject = $memoryManager->create(str_repeat((string)($count % 10), 128) /* 1K */);
            $memObjects[] = $memObject;
        }

        $this->expectException(Memory\Exception\RuntimeException::class);
        $memoryManager->create('a');
    }
}
