<?php
/**
 * @see       https://github.com/zendframework/zend-memory for the canonical source repository
 * @copyright Copyright (c) 2005-2018 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-memory/blob/master/LICENSE.md New BSD License
 */

namespace ZendTest\Memory\TestAsset;

use Zend\Memory\Container\Movable;

class DummyMovableContainer extends Movable
{
    /**
     * Empty constructor
     */
    public function __construct()
    {
        // Do nothing
    }

    /**
     * Dummy value update callback method
     */
    public function processUpdate()
    {
        // Do nothing
    }
}
