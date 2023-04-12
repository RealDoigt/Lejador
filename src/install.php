<?php
function create_db($connection)
{
    if ($connection->query('create database lejadorDB;'))
        return 0;

    echo $connection->error;
    return -1;
}

class Table
{
    private $attributes;
    private $name;

    function __construct($attributes, $name)
    {
        $this->attributes = $attributes;
        $this->name = $name;
    }

    function create($connection)
    {
        $query = "create table $this->name (";

        foreach ($this->attributes as $att)
            $query .= "$att,";

        $query .= ');';

        $connection->query($query);
    }
}

function create_tables($connection)
{
    $tables = array
    (
        new Table
        (
            array
            (
                'user_id int not null auto_increment',
                'name varchar(20) not null',
                'is_admin bool not null',
                'is_moderator bool not null',
                'is_creator bool not null',
                'primary key(user_id)'
            ),

            'Users'
        ),

        new Table
        (
            array
            (
                'comic_id int not null auto_increment',
                'name varchar(50) not null',
                'description varchar(500) not null',
                'creator_id int not null',
                'primary key(comic_id)',
                'foreign key(creator_id) references Users(user_id)'
            ),

            'Comics'
        ),

        new Table
        (
            array
            (
                'page_id int not null auto_increment',
                'page_number int not null',
                'image_path varchar not null',
                'date_published date not null',
                'comic_id int not null',
                'primary key(page_id)',
                'foreign key(comic_id) references(comic_id)'
            ),

            'Pages'
        ),

        new Table
        (
            array
            (
                'comment_id int not null auto_increment',
                'content tinytext not null',
                'date_published date not null',
                'commenter_id int not null',
                'page_id int not null',
                'primary key(comment_id)',
                'foreign key(commenter_id) references Users(user_id)',
                'foreign key(page_id) references Pages(page_id)'
            ),

            'Comments'
        ),

        new Table
        (
            array
            (
                'feedback_id int not null auto_increment',
                'review varchar(500)',
                'date_published date',
                'stars int not null',
                'reviewer_id int not null',
                'comic_id int not null',
                'primary key(feedback_id)',
                'foreign key(reviewer_id) references Users(user_id)',
                'foreign key(comic_id) references Comics(comic_id)'
            ),

            'Feedbacks'
        ),
    );

    foreach ($tables as $t) $t->create($connection);
}

function main()
{
    if (!isset($_POST['host']))
    {
        header('location: install.htm');
        exit;
    }

    //$connection = new mysqli('localhost', 'root', '');
    $server = $_POST['host'];
    $username = $_POST['user'];
    $password = $_POST['pass'];

    $connection = new mysqli($server, $username, $password);

    if ($connection->connect_error) die($conn->connect_error);

    if (create_db($connection) === 0)
    {
        $settings_file = fopen('settings.csv', 'w');
        fwrite($settings_file, "$server,$username,$password");
        fclose($settings_file);

        create_tables($connection);
    }

    $connection->close();
}

main();
?>
