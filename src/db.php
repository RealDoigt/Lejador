<?php

    class TableHelper
    {
        private $connection;

        function __construct(protected $attributes, protected $name, private $id_name)
        {
            $settings_file = fopen('settings.csv', 'r');
            $settings = explode(',', fread($settings_file));
            $this->connection = new mysqli($settings[0], $settings[1], $settings[2]);

            if ($this->connection->connect_error) die($connection->connect_error);
            $this->connection->select_db('lejadorDB');
        }

        function __destruct()
        {
            $connection->close();
        }

        protected function insert_into($values)
        {
            $query = "insert into $this->name (" . implode(',', $this->attributes) . 'values (' . implode(',', $values) . ');';
            if (!$this->connection->query($query)) echo $query;
        }

        procected function get_values($fields = ['*'])
        {
            return $this->connection->query('select ' . implode(',', $fields) . " from $this->name;");
        }
    }
?>
