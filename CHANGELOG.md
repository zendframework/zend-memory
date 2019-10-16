# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 2.6.1 - 2019-10-16

### Added

- [#19](https://github.com/zendframework/zend-memory/pull/19) adds support for PHP 7.3.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 2.6.0 - 2018-04-30

### Added

- [#18](https://github.com/zendframework/zend-memory/pull/18) adds support for PHP 7.1 and 7.2.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- [#18](https://github.com/zendframework/zend-memory/pull/18) removes support for PHP 5.5.

- [#18](https://github.com/zendframework/zend-memory/pull/18) removes support for HHVM.

### Fixed

- [#13](https://github.com/zendframework/zend-memory/pull/13) fixes the `Zend\Memory\Container\Movable::markAsSwapped()` method to correctly set
  the SWAPPPED bit instead of the LOADED bit.

## 2.5.2 - 2016-05-11

### Added

- [#11](https://github.com/zendframework/zend-memory/pull/11) and
  [#12](https://github.com/zendframework/zend-memory/pull/12) add and publish
  the documentation to https://zendframework.github.io/zend-memory/

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#12](https://github.com/zendframework/zend-memory/pull/12) updates the
  PHP requirement to allow either 5.5+ or 7.0+, and pins the zend-cache version
  for testing to 2.7+.
