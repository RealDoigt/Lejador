<?php

    class TableHelper
    {
        private $connection;

        function __construct(protected $attributes, protected $name)
        {
            $settings_file = fopen('settings.csv', 'r');
            $settings = explode(',', fread($settings_file));
            $connection = new mysqli($settings[0], $settings[1], $settings[2]);

            if ($connection->connect_error) die($connection->connect_error);
            $connection->select_db('lejadorDB');
        }

        function __destruct()
        {
            $connection->close();
        }

        protected function insert_into($values)
        {
            $query = "insert into $name (" . implode(',', $attributes) . 'values (' . implode(',', $values) . ');';
            if (!$connection->query($query)) echo $query;

        }
    }
?>
