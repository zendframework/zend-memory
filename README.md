# zend-memory

> ## Repository abandoned 2019-12-31
>
> This repository has moved to [laminas/laminas-memory](https://github.com/laminas/laminas-memory).

[![Build Status](https://secure.travis-ci.org/zendframework/zend-memory.svg?branch=master)](https://secure.travis-ci.org/zendframework/zend-memory)
[![Coverage Status](https://coveralls.io/repos/github/zendframework/zend-memory/badge.svg?branch=master)](https://coveralls.io/github/zendframework/zend-memory?branch=master)

zend-memory manages data in an environment with limited memory.

Memory objects (memory containers) are generated by the memory manager, and
transparently swapped/loaded when required.

For example, if creating or loading a managed object would cause the total memory
usage to exceed the limit you specify, some managed objects are copied to cache
storage outside of memory. In this way, the total memory used by managed objects
does not exceed the limit you need to enforce.

## Installation

Run the following to install this library:

```bash
$ composer require zendframework/zend-memory
```

## Documentation

Browse the documentation online at https://docs.zendframework.com/zend-memory/

## Support

* [Issues](https://github.com/zendframework/zend-memory/issues/)
* [Chat](https://zendframework-slack.herokuapp.com/)
* [Forum](https://discourse.zendframework.com/)
