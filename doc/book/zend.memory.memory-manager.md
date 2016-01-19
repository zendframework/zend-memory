# Memory Manager

## Creating a Memory Manager

You can create new a memory manager (`Zend\Memory\MemoryManager` object) using its constructor:
`Zend\Memory\MemoryManager::__construct(Zend\Cache\Storage\StorageInterface $cache = null)`.

```php
$cache = Zend\Cache\StorageFactory::factory(array(
    'adapter' => array(
        'name' => 'Filesystem',
        'options' => array(
            'cache_dir' => './tmp/', // Directory where to put the swapped memory blocks
        ),
    ),
));

$memoryManager = new Zend\Memory\MemoryManager($cache);
```

`Zend\Memory\MemoryManager` uses \[ZendCache storage adapters\](zend.cache.storage.adapter) to cache
memory blocks; if no cache instance is provided the system temporary directory is used.

```php
$memoryManager = new Zend\Memory\MemoryManager();
```

This is useful if you know that memory is not limited or the overall size of objects never reaches
the memory limit.

## Managing Memory Objects

This section describes creating and destroying objects in the managed memory, and settings to
control memory manager behavior.

### Creating Movable Objects

Create movable objects (objects, which may be swapped) using the
`Zend\Memory\MemoryManager::create([$data])` method:

```php
$memObject = $memoryManager->create($data);
```

The `$data` argument is optional and used to initialize the object value. If the `$data` argument is
omitted, the value is an empty string.

### Creating Locked Objects

Create locked objects (objects, which are not swapped) using the
`Zend\Memory\MemoryManager::createLocked([$data])` method:

```php
$memObject = $memoryManager->createLocked($data);
```

The `$data` argument is optional and used to initialize the object value. If the `$data` argument is
omitted, the value is an empty string.

### Destroying Objects

Memory objects are automatically destroyed and removed from memory when they go out of scope:

```php
function foo()
{
    global $memoryManager, $memList;

    ...

    $memObject1 = $memoryManager->create($data1);
    $memObject2 = $memoryManager->create($data2);
    $memObject3 = $memoryManager->create($data3);

    ...

    $memList[] = $memObject3;

    ...

    unset($memObject2); // $memObject2 is destroyed here

    ...
    // $memObject1 is destroyed here
    // but $memObject3 object is still referenced by $memList
    // and is not destroyed
}
```

This applies to both movable and locked objects.

## Memory Manager Settings

### Memory Limit

Memory limit is a number of bytes allowed to be used by loaded movable objects.

If loading or creation of an object causes memory usage to exceed of this limit, then the memory
manager swaps some other objects.

You can retrieve or set the memory limit setting using the `getMemoryLimit()` and
`setMemoryLimit($newLimit)` methods:

```php
$oldLimit = $memoryManager->getMemoryLimit();  // Get memory limit in bytes
$memoryManager->setMemoryLimit($newLimit);     // Set memory limit in bytes
```

A negative value for memory limit means 'no limit'.

The default value is two-thirds of the value of 'memory\_limit' in php.ini or 'no limit' (-1) if
'memory\_limit' is not set in php.ini.

### MinSize

MinSize is a minimal size of memory objects, which may be swapped by memory manager. The memory
manager does not swap objects that are smaller than this value. This reduces the number of swap/load
operations.

You can retrieve or set the minimum size using the `getMinSize()` and `setMinSize($newSize)`
methods:

```php
$oldMinSize = $memoryManager->getMinSize();  // Get MinSize in bytes
$memoryManager->setMinSize($newSize);        // Set MinSize limit in bytes
```

The default minimum size value is 16KB (16384 bytes).
