## DataAggregator

#### Description
Aggregates data points from a given JSON file and imports aggregated data into MySQL.

**Aggregate data is for all data points are:**
- min
- max
- mean
- median
- total_data_points

#### Dependencies
- `phpspec/phpspec` (dev)
    - Unit testing framework
- `symfony/var-dumper` (dev)
    - Simple replacement for var_dump, useful for development
- `symfony/console`
    - Used to handle input argument validation and output styling on the CLI
- `maxakawizard/json-collection-parser`
    - A JSON parser which supports streaming. Meaning that tha system does not have to load a potentially very large JSON document into memory to parse it. Instead the JSON is parsed object by object.
- `robmorgan/phinx`
    - Used to manage DB migrations and source control the DB schema
- `doctrine/orm`
    - ORM used to abstract the database away from the application. Manages fetching and persisting entities.
- `pimple/pimple`
    - Simple Dependency Injection container
- `vlucas/phpdotenv`
    - Loads config variables into PHP as environment variables. This should be managed by release tools with real env vars in a production environment

#### Requirements
- MySQL
- PHP 7.x
- Composer (https://getcomposer.org/)

#### Usage

*Composer*

`composer install`

*DB Migrations*

Edit `phinx.yml`, add your MySQL database connection details then run phinx migrate to create the database tables 

`./bin/phinx migrate`

*Unit tests* 

`./bin/phpspec run`

*Import data, aggregate, and persist to database*

`php console.php Unit:ProcessAggregate`

*Query aggregate database*

- `php console.php Unit:QueryAggregate 2 download 18`
- `php console.php Unit:QueryAggregate 1 upload 16`
- `php console.php Unit:QueryAggregate 3 packet_loss 13`
- `php console.php Unit:QueryAggregate 1 latency 07`


#### Limitations
- The system does not check if data points have already been aggregated and persisted. If the `Unit:ProcessAggregate` command is executed twice then the aggregate data will be duplicated in the DB. 
- Ideally the system should be covered by integration tests via Behat.
- The system could be made more scalable by reading from a message queue (such as RabbitMQ) rather than a JSON file. This way there could be multiple nodes running the application and consuming the same queue.
