<?php

use app\core\Application;

class m0002_unique
{
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "ALTER TABLE users MODIFY username varchar(30) UNIQUE";
        $db->pdo->exec($SQL);
    }

    public function down()
    {

    }
}