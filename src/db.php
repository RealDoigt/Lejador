<?php

    class Table_Helper
    {
        private $connection;
        private $salt = 'fouehwq8p9637436rfewapqo38284372yrewrhjud';

        function __construct(protected $attributes, protected $name)
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

        protected function get_values($fields = ['*'])
        {
            return $this->connection->query('select ' . implode(',', $fields) . " from $this->name;");
        }

        protected function get_salt()
        {
            return $salt;
        }
    }

    class User_Helper extends Table_Helper
    {
        function __construct()
        {
            parent::__construct(['name', 'pass', 'is_admin', 'is_moderator', 'is_creator'], 'Users');
        }

        function create_user($username, $password)
        {
            $this->insert_into([$username, crypt($password, $this->get_salt()), $this->get_user_count() == 0 ? 1 : 0, 0, 0]);
        }

        private function get_user_count()
        {
            return $this->get_values(['count(user_id)']);
        }
    }
?>
