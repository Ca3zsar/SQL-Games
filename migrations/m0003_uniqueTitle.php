<?php

use app\core\Application;

class m0003_uniqueTitle
{
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "ALTER TABLE unverifiedex MODIFY title varchar(30) UNIQUE";
        $db->pdo->exec($SQL);
    }

    public function down()
    {

    }
}