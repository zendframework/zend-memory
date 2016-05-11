<?php
/**
 * @link      http://github.com/zendframework/zend-memory for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
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
