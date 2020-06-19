<?php
include_once '001_base_migration.php';

class CreateUsersTable extends BaseMigration
{
    public function createTable()
    {
        $database = new DB();
        $db = $database->db;

        $table = 'users';

        try {
            $query = "CREATE TABLE $table(
                id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR( 50 ) NOT NULL, 
                email VARCHAR( 150 ) NOT NULL UNIQUE, 
                password VARCHAR( 250 ) NOT NULL,
                hash VARCHAR ( 250 ) NOT NULL );" ;
            $db->exec($query);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        var_dump($db);
    }
}
