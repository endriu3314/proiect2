<?php

include_once '002_create_users_table.php';

class RunMigrations
{
    public function migrate()
    {
        $usersTable = new \CreateUsersTable();
        $usersTable->createTable();
    }
}
