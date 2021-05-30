<?php

use app\core\Application;

class m0008_deleteStatistics
{
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "DROP TABLE statistics";
        $db->pdo->exec($SQL);

        $SQL = "ALTER TABLE users ADD COLUMN createdAt timestamp DEFAULT current_timestamp AFTER coins";
        $db->pdo->exec($SQL);
    }

    public function down()
    {

    }
}