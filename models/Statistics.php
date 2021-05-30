<?php

namespace app\models;

use app\core\Application;
use app\core\DBModel;
use PDO;

class Statistics extends DBModel
{
    public array $usersOrderedIds;
    public array $finalStats;

    public function cmp($firstUser,  $secondUser) {
        if($firstUser["solved"] === $secondUser["solved"]){
            if($firstUser["successRate"] <= $secondUser["successRate"]) {
                return 1;
            }
            else{
                return -1;
            }
        }

        return ($firstUser["solved"] < $secondUser["solved"]) ? 1 : -1;
    }

    public function loadStats()
    {
        $statement = Application::$app->db->prepare("Select id from users");
        $statement->execute();

        $this->usersOrderedIds = $statement->fetchAll(PDO::FETCH_ASSOC);
        $temporary = array();
        foreach ($this->usersOrderedIds as $row)
        {
            $temporary[] = $row["id"];
        }
        $this->usersOrderedIds = $temporary;
        $this->finalStats = array();

        foreach ($this->usersOrderedIds as $id)
        {
            $tempStats = new History();
            $tempStats = $tempStats->loadHistory($id);
            $tempStats["username"] = User::getUsername($id);

            $this->finalStats[] = $tempStats;
        }

        usort($this->finalStats, array($this,"cmp"))    ;
    }



    public function tableName(): string
    {
        return "users";
    }

    public function attributes(): array
    {
        // TODO: Implement attributes() method.
    }

    public function primaryKey(): string
    {
        // TODO: Implement primaryKey() method.
    }

}