# REST Products & Cart API

RESTful API for:

- Product CRUD
- Cart related operations

## Instructions

1. Clone repository
1. Run `composer install`

### Tests

1. Run `composer test`

### Start dev server

1. Run `./start.sh`

## Description

- RESTful API created with [Slim 3](https://github.com/slimphp/Slim)
    - First time using it, found it really fun and simple in execution. At first
    the PSR-7 is a bit weird, but ended up loving it.
- SQLite used for database
    - Just because I wanted to keep it really really simple
- [Propel 2](https://github.com/propelorm/Propel2) used as ORM
    - Made super easy to handle Slim 3 parsed body with Models
- API Tests created with Codeception/REST
- Code linted with PHPCS, custom standard based off PSR-2 standard
- Simple UI with VueJS
    - Only used it a few times before, hence my inexperience with it
    - Wanted to keep the UI completely standalone, no toolchain required

## Pending or Wanted TODO

- Required env-based Propel settings
    - On local/tests sqlite is nice
    - Maybe in stage/prod, it could use mysql or other
- Improved logging, right now its limited and manual
    - Maybe we can rig Slim to log every request and/or middleware step in DEBUG
- Tests for UI
    - The UI is very very simple, but should possible to add Codeception tests
    for it
- Explore creating a Middleware for Propel objects, so controllers
    could just return Collections and Objects
    - Just for fun, not sure is a good idea
- Stress the API, it might be interesting to see how much it holds up with the
    current ORM-driven approach.
