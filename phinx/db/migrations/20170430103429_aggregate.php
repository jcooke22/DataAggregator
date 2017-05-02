<?php

use Phinx\Migration\AbstractMigration;

class Aggregate extends AbstractMigration
{
    public function up()
    {
        $this->execute(
            "
        CREATE TABLE `aggregate` (
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `unit_id` INT(11) NOT NULL,
          `hour` INT(11) NOT NULL,
          `metric` ENUM('download','upload','latency','packet_loss') DEFAULT NULL,
          `min` double DEFAULT NULL,
          `max` double DEFAULT NULL,
          `mean` double DEFAULT NULL,
          `median` double DEFAULT NULL,
          `total_data_points` INT(11) DEFAULT NULL,
          PRIMARY KEY (`id`),
          KEY `unit_id_index` (`unit_id`),
          KEY `hour_index` (`hour`),
          KEY `metric_index` (`metric`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;;
        "
        );
    }

    public function down()
    {
        $this->execute("DROP TABLE `aggregate`;");
    }
}
