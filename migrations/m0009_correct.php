<?php


use app\core\Application;

class m0009_correct
{
    public function up()
    {
        $db = Application::$app->db;

        $SQL = "ALTER TABLE solutions ADD COLUMN correct BOOL DEFAULT 0 AFTER dateTried";
        $db->pdo->exec($SQL);
    }

    public function down()
    {

    }
}