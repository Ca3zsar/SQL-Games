<?php

use app\core\Application;

class m0010_targetAchievement
{
    public function up()
    {
        $db = Application::$app->db;

        $SQL = "ALTER TABLE achievements ADD COLUMN target INT NOT NULL AFTER image";
        $db->pdo->exec($SQL);
    }

    public function down()
    {

    }
}