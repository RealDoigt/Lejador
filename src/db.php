<?php

    class Table_Helper
    {
        private $connection;
        private $salt = 'fouehwq8p9637436rfewapqo38284372yrewrhjud';

        function __construct(protected $attributes, protected $name, private $id)
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
            return mysqli_fetch_assoc($this->connection->query('select ' . implode(',', $fields) . " from $this->name;"));
        }

        protected function get_all_values_by_id($id)
        {
            return mysqli_fetch_assoc($this->connection->query("select * from $this->name where $this->id = '$id';");
        }

        protected function get_salt()
        {
            return $this->salt;
        }

        protected function get_name()
        {
            return $this->name;
        }
    }

    class User_Helper extends Table_Helper
    {
        function __construct()
        {
            parent::__construct(['name', 'pass', 'is_admin', 'is_moderator', 'is_creator', 'is_banned'], 'Users', 'user_id');
        }

        function create($username, $password)
        {
            if (user_exists($username)) return -1;

            $this->insert_into([$username, crypt($password, $this->get_salt()), $this->get_user_count() == 0 ? 1 : 0, 0, 0]);
            return 0;
        }

        private function get_user_count()
        {
            return $this->get_values(['count(user_id)']);
        }

        private function get_value($username, $attribute)
        {
            return $this->connection->query("select $attribute from " . $this->get_name() . " where name = '$username';");
        }

        private function user_exists($username)
        {
            return $this->get_value($username, 'name') !== '';
        }

        private function user_banned($username)
        {
            return $this->get_value($username, 'is_banned') == 1;
        }

        function validate_user($username)
        {
            if ($this->user_exists($username))
            {
                if (!$this->user_banned($username))
                    return 0;

                return -1;
            }

            return -2;
        }

        function get_user($username)
        {
            switch ($this->validate_user($username))
            {
                case  0: return $this->get_all_values_by_id($this->get_value($username, 'user_id'));
                case -1: return ['code' => -1, 'error' => 'La usor no ave la permete de usa esta loca ueb!'];
                case -2: return ['code' => -2, 'error' => 'La usor no esiste!'];
                default: return ['code' => -999, 'error' => 'ERA!'];
            }
        }
    }
?>
