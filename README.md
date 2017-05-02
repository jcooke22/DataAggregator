## DataAggregator

#### Description
Aggregates datapoints from a given JSON file and imports aggregated data into MySQL.

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

#### Requirements
- MySQL
- PHP 7.x
- Composer (https://getcomposer.org/)

#### Usage

**Composer**

`composer install`

**DB Migrations**

Edit `phinx.yml`, add your MySQL database connection details then run phinx migrate to create the database tables 

`./bin/phinx migrate`



#### Limitations
