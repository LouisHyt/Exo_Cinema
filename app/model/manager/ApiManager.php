<?php

    namespace Model\Manager;
    use Model\Connect;

    class ApiManager {

        public function getMoviesByName(string $name) {
            $pdo = Connect::seConnecter();
            $request = $pdo->prepare("
                SELECT id_movie, title
                FROM movie
                WHERE title LIKE :name
                ORDER BY title DESC
            ");
            $request->bindValue(":name", "%$name%", \PDO::PARAM_STR);
            $request->execute();
            $movies = $request->fetchAll(\PDO::FETCH_ASSOC);
            return $movies;
           
        }
    }