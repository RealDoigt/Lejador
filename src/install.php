<?php

function create_db($server, $username, $password, $connection)
{
    $result = -1;

    if ($connection->query('create database lejadorDB;'))
    {
        $settings_file = fopen('settings.csv', 'w');

        fwrite($settings_file, "$server,$username,$password");
        fclose($settings_file);
        $result = 0;
    }

    else echo $connection->error;
    return $result;
}

class Table
{
    $attributes;
    $name;

    function __construct($attributes, $name)
    {
        $this->attributes = array();
        array_push($this->attributes, $attributes);

        $this->name = $name;
    }

    function create($connection)
    {
        $query = "create table $name (";

        for ($this->attributes as $att)
            $query .= "$att,";

        $query .= ');';

        $connection->query($query);
    }
}

function main()
{
    $connection = new mysqli('localhost', 'root', '');
    if ($connection->connect_error) die($conn->connect_error);
    if (
    
}

main();
?>
