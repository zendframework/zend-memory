# Memory Objects

## Movable

Create movable memory objects using the `create([$data])` method of the memory manager:

```php
$memObject = $memoryManager->create($data);
```

"Movable" means that such objects may be swapped and unloaded from memory and then loaded when
application code accesses the object.

## Locked

Create locked memory objects using the `createLocked([$data])` method of the memory manager:

```php
$memObject = $memoryManager->createLocked($data);
```

"Locked" means that such objects are never swapped and unloaded from memory.

Locked objects provides the same interface as movable objects (`Zend\Memory\Container\Interface`).
So locked object can be used in any place instead of movable objects.

It's useful if an application or developer can decide, that some objects should never be swapped,
based on performance considerations.

Access to locked objects is faster, because the memory manager doesn't need to track changes for
these objects.

The locked objects class (`Zend\Memory\Container\Locked`) guarantees virtually the same performance
as working with a string variable. The overhead is a single dereference to get the class property.

## Memory container 'value' property

Use the memory container (movable or locked) '`value`' property to operate with memory object data:

```php
$memObject = $memoryManager->create($data);

echo $memObject->value;

$memObject->value = $newValue;

$memObject->value[$index] = '_';

echo ord($memObject->value[$index1]);

$memObject->value = substr($memObject->value, $start, $length);
```

An alternative way to access memory object data is to use the getRef()
&lt;zend.memory.memory-objects.api.getRef&gt; method. This method **must** be used for *PHP*
versions before 5.2. It also may have to be used in some other cases for performance reasons.

## Memory container interface

Memory container provides the following methods:

### getRef() method

```php
public function &getRef();
```

The `getRef()` method returns reference to the object value.

Movable objects are loaded from the cache at this moment if the object is not already in memory. If
the object is loaded from the cache, this might cause swapping of other objects if the memory limit
would be exceeded by having all the managed objects in memory.

The `getRef()` method **must** be used to access memory object data for *PHP* versions before 5.2.

Tracking changes to data needs additional resources. The `getRef()` method returns reference to
string, which is changed directly by user application. So, it's a good idea to use the `getRef()`
method for value data processing:

```php
$memObject = $memoryManager->create($data);

$value = &$memObject->getRef();

for ($count = 0; $count < strlen($value); $count++) {
    $char = $value[$count];
    ...
}
```

### touch() method

```php
public function touch();
```

The `touch()` method should be used in common with `getRef()`. It signals that object value has been
changed:

```php
$memObject = $memoryManager->create($data);
...

$value = &$memObject->getRef();

for ($count = 0; $count < strlen($value); $count++) {
    ...
    if ($condition) {
        $value[$count] = $char;
    }
    ...
}

$memObject->touch();
```

### lock() method

```php
public function lock();
```

The `lock()` methods locks object in memory. It should be used to prevent swapping of some objects
you choose. Normally, this is not necessary, because the memory manager uses an intelligent
algorithm to choose candidates for swapping. But if you exactly know, that at this part of code some
objects should not be swapped, you may lock them.

Locking objects in memory also guarantees that reference returned by the `getRef()` method is valid
until you unlock the object:

```php
$memObject1 = $memoryManager->create($data1);
$memObject2 = $memoryManager->create($data2);
...

$memObject1->lock();
$memObject2->lock();

$value1 = &$memObject1->getRef();
$value2 = &$memObject2->getRef();

for ($count = 0; $count < strlen($value2); $count++) {
    $value1 .= $value2[$count];
}

$memObject1->touch();
$memObject1->unlock();
$memObject2->unlock();
```

### unlock() method

```php
public function unlock();
```

`unlock()` method unlocks object when it's no longer necessary to be locked. See the example above.

### isLocked() method

```php
public function isLocked();
```

The `isLocked()` method can be used to check if object is locked. It returns `TRUE` if the object is
locked, or `FALSE` if it is not locked. This is always `TRUE` for "locked" objects, and may be
either `TRUE` or `FALSE` for "movable" objects.
