<?php
use app\core\Application;

class m0001_initial
{
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE users (id INT AUTO_INCREMENT PRIMARY KEY,
                   username VARCHAR(30),
                   password VARCHAR(100),
                   firstName VARCHAR(20),
                   lastName VARCHAR(30),
                   email VARCHAR(70) UNIQUE,
                   phone VARCHAR(10) UNIQUE,
                   birthday DATE,
                   description TEXT,
                   address VARCHAR(200));      
                CREATE TABLE exercises (id INT AUTO_INCREMENT PRIMARY KEY,
                                        title VARCHAR(30),
                                        difficulty VARCHAR(7),
                                        timesSolved INT DEFAULT 0,
                                        timesBought INT DEFAULT 0,
                                        authorId INT,
                                        price INT,
                                        requirement TEXT,
                                        createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                        correctQuery TEXT,
                                        stars INT);
                CREATE TABLE userExercises(idUser INT,
                                           idExercise INT,
                                           FOREIGN KEY (idUser) REFERENCES users(id),
                                           FOREIGN KEY (idExercise) REFERENCES exercises(id),
                                           UNIQUE (idUser, idExercise));               
                CREATE TABLE unverifiedEx (id INT AUTO_INCREMENT PRIMARY KEY,
                                           title VARCHAR(30),
                                           difficulty VARCHAR(7),
                                           authorId INT,
                                           price INT,
                                           requirement TEXT,
                                           correctQuery TEXT);
                CREATE TABLE solutions (id INT AUTO_INCREMENT PRIMARY KEY,
                                        idExercise INT,
                                        idUser INT,
                                        solve TEXT,
                                        dateTried TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                        FOREIGN KEY (idExercise) REFERENCES exercises(id),
                                        FOREIGN KEY (idUser) REFERENCES users(id));                  
                CREATE TABLE achievements (id INT AUTO_INCREMENT PRIMARY KEY,
                                           name VARCHAR(100),
                                           description VARCHAR(150),
                                           image VARCHAR(40));         
                CREATE TABLE userAchievements (idUser INT,
                                               idAchievement INT,
                                               FOREIGN KEY (idUser) REFERENCES users(id),
                                               FOREIGN KEY (idAchievement) REFERENCES achievements(id),
                                               UNIQUE (idUser, idAchievement));                            
                CREATE TABLE statistics (idUser INT UNIQUE,
                                         accountCreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                         esqlids INT DEFAULT 0,
                                         solvedExNum INT DEFAULT 0,
                                         boughtExNum INT DEFAULT 0,
                                         attempts INT DEFAULT 0 ,
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