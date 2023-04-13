<?php

    abstract class TableHelper
    {
        private $connection;

        function __construct()
        {
            $settings_file = fopen('settings.csv', 'r');
            $settings = explode(',', fread($settings_file));
            $connection = new mysqli($settings[0], $settings[1], $settings[2]);

            if ($connection->connect_error) die($conn->connect_error);
            $connection->select_db('lejadorDB');
        }

        function __destruct()
        {
            $connection->close();
        }
    }


?>
