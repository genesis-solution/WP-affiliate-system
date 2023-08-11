# Changelog

All notable changes of wp-api are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.1] - 2023-02-27

### Fixed

* Fixed a issue where the current WP_Hook method would return a boolean instead of an array.
* Fixed an issue with turning off the log.

## [1.0.0] - 2023-01-13

### Added

* Request base class for all requests. Should be extended by all requests that want to use this library.
* Logger class that will be used to log all requests and responses, along with parameters passed to the request.
* Extended debugging for the logger class that will log the entire stack trace of the request, including the values of the parameters passed to the methods in the stack trace.
