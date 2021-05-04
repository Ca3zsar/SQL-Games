<?php


use app\core\Application;

class m0001_initial
{
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE users (id INT PRIMARY KEY,
                   username VARCHAR(30),
                   password VARCHAR(40),
                   firstName VARCHAR(20),
                   lastName VARCHAR(30),
                   email VARCHAR(70) UNIQUE,
                   phone VARCHAR(10) UNIQUE,
                   birthday DATE,
                   description TEXT,
                   address VARCHAR(200));      
                CREATE TABLE exercises (id INT PRIMARY KEY,
                                        title VARCHAR(30),
                                        difficulty VARCHAR(7),
                                        timesSolved INT,
                                        timesBought INT,
                                        authorId INT,
                                        price INT,
                                        requirement TEXT,
                                        createdAt DATE,
                                        correctQuery TEXT,
                                        stars INT);
                CREATE TABLE userExercises(idUser INT,
                                           idExercise INT,
                                           FOREIGN KEY (idUser) REFERENCES users(id),
                                           FOREIGN KEY (idExercise) REFERENCES exercises(id),
                                           UNIQUE (idUser, idExercise));               
                CREATE TABLE unverifiedEx (id INT PRIMARY KEY,
                                           title VARCHAR(30),
                                           difficulty VARCHAR(7),
                                           authorId INT,
                                           price INT,
                                           requirement TEXT,
                                           correctQuery TEXT);
                CREATE TABLE solutions (id INT PRIMARY KEY,
                                        idExercise INT,
                                        idUser INT,
                                        solve TEXT,
                                        dateTried DATE,
                                        FOREIGN KEY (idExercise) REFERENCES exercises(id),
                                        FOREIGN KEY (idUser) REFERENCES users(id));                  
                CREATE TABLE achievements (id INT PRIMARY KEY,
                                           name VARCHAR(100),
                                           description VARCHAR(150),
                                           image VARCHAR(40));         
                CREATE TABLE userAchievements (idUser INT,
                                               idAchievement INT,
                                               FOREIGN KEY (idUser) REFERENCES users(id),
                                               FOREIGN KEY (idAchievement) REFERENCES achievements(id),
                                               UNIQUE (idUser, idAchievement));                            
                CREATE TABLE statistics (idUser INT UNIQUE,
                                         accountCreatedAt DATE,
                                         esqlids INT,
                                         solvedExNum INT,
                                         boughtExNum INT,
                                         attempts INT,
                                         FOREIGN KEY (idUser) REFERENCES users(id));
                ";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;
        $SQL = "
           DROP table solutions;
           DROP table statistics;
           DROP table unverifiedex;
           DROP table userachievements;
           DROP table userexercises;
           DROP table users;
           DROP table exercises;
           DROP table achievements;
        ";
        $db->pdo->exec($SQL);
    }

}