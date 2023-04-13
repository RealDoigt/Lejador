<?php

    class DB
    {
        private $connection;

        function __construct()
        {
            $settings_file = fopen('settings.csv', 'r');
            $settings = explode(',', fread($settings_file));
            $connection = new msqli($settings[0], $settings[1], $settings[2]);

            if ($connection->connect_error) die($conn->connect_error);
        }
    }
?>
