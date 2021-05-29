<?php

use app\core\Application;

class m0011_firstSolver
{
    public function up()
    {
        $db = Application::$app->db;

        $SQL = "ALTER TABLE solutions ADD COLUMN firstSolver BOOL DEFAULT 0 AFTER correct";
        $db->pdo->exec($SQL);
    }

    public function down()
    {

    }
}