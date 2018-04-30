<?php
/**
 * @see       https://github.com/zendframework/zend-memory for the canonical source repository
 * @copyright Copyright (c) 2005-2018 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-memory/blob/master/LICENSE.md New BSD License
 */

namespace ZendTest\Memory\TestAsset;

use Zend\Memory\Container;
use Zend\Memory\MemoryManager;

/**
 * Memory manager helper
 */
class DummyMemoryManager extends MemoryManager
{
    /**
     * @var bool
     */
    public $processUpdatePassed = false;

    /**
     * @var integer
     */
    public $processedId;

    /**
     * @var Container\Movable
     */
    public $processedObject;

    /**
     * Empty constructor
     */
    public function __construct()
    {
        // Do nothing
    }

    /**
     * DummyMemoryManager value update callback method
     *
     * @param Container\Movable $container
     * @param int|string $id
     */
    public function processUpdate(Container\Movable $container, $id)
    {
        $this->processUpdatePassed = true;
        $this->processedId         = $id;
        $this->processedObject     = $container;
    }
}
