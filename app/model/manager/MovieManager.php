<?php

    namespace Model\Manager;
    use Model\Connect;

    class MovieManager {

        // Get all movies
        public function getMovies() {

            $pdo = Connect::seConnecter();
            $request = $pdo->query("
                SELECT 
                    mo.title, 
                    mo.release_date, 
                    mo.duration, 
                    mo.synopsis, 
                    mo.note, 
                    mo.poster_image, 
                    CONCAT(pe.first_name, ' ', pe.last_name) as director_name,
                    mo.id_movie
                FROM movie mo
                LEFT JOIN director di ON mo.id_director = di.id_director 
                LEFT JOIN person pe ON di.id_person = pe.id_person
            ");
            $movies = $request->fetchAll(\PDO::FETCH_ASSOC);
            return $movies;
        }

        // Find a specific movie by id
        public function getMovieById($id) {
            $pdo = Connect::seConnecter();
            $requestMovie = $pdo->prepare("
                SELECT 
                    mo.title, 
                    mo.release_date, 
                    mo.release_date, 
                    mo.duration, 
                    mo.synopsis, 
                    mo.note, 
                    mo.poster_image, 
                    CONCAT(pe.first_name, ' ', pe.last_name) as director_name,
                    pe.id_person as director_id,
                    GROUP_CONCAT(ca.label) as categories

                FROM movie mo
                LEFT JOIN director di ON mo.id_director = di.id_director 
                LEFT JOIN person pe ON di.id_person = pe.id_person 
                LEFT JOIN belongs be ON mo.id_movie = be.id_movie
                LEFT JOIN category ca ON be.id_category = ca.id_category
                WHERE mo.id_movie = :id
            ");
            $requestMovie->bindValue(":id", $id, \PDO::PARAM_INT);
            $requestMovie->execute();
            $movie = $requestMovie->fetch(\PDO::FETCH_ASSOC);

            $requestCast = $pdo->prepare("
                SELECT 
                    CONCAT(pe.first_name, ' ', pe.last_name) as actor_name,
                    pe.profile_image,
                    pe.id_person,
                    cr.role_name
                FROM movie mo
                INNER JOIN play pl ON mo.id_movie = pl.id_movie
                INNER JOIN actor ac ON pl.id_actor = ac.id_actor
                INNER JOIN person pe ON ac.id_person = pe.id_person
                INNER JOIN casting_role cr ON pl.id_role = cr.id_role
                WHERE mo.id_movie = :id
                 
            ");
            $requestCast->bindValue(":id", $id, \PDO::PARAM_INT);
            $requestCast->execute();
            $casting = $requestCast->fetchAll(\PDO::FETCH_ASSOC);

            $data = [
                "movie" => $movie,
                "casting" => $casting
            ];

            return $data;
        }

        //Get movies by category
        public function getMoviesByCategory($id) {
            $pdo = Connect::seConnecter();

            //Get movies of the selected category
            if($id !== null){
                $request = $pdo->prepare("
                    SELECT mo.title, mo.poster_image, mo.id_movie
                    FROM movie mo
                    INNER JOIN belongs be ON mo.id_movie = be.id_movie
                    INNER JOIN category ca ON be.id_category = ca.id_category
                    WHERE ca.id_category = :id
                ");
                $request->bindValue(":id", $id, \PDO::PARAM_INT);
                $request->execute();
                $movies = $request->fetchAll(\PDO::FETCH_ASSOC);
            } else {
                $request = $pdo->query("
                    SELECT DISTINCT mo.title, mo.poster_image, mo.id_movie
                    FROM movie mo
                    INNER JOIN belongs be ON mo.id_movie = be.id_movie
                    INNER JOIN category ca ON be.id_category = ca.id_category
                ");
                $movies = $request->fetchAll(\PDO::FETCH_ASSOC);
            }

            //Get all existing categories
            $request = $pdo->query("
                SELECT id_category, label
                FROM category
            ");
            $categories = $request->fetchAll(\PDO::FETCH_ASSOC);

            $data = [
                "movies" => $movies,
                "categories" => $categories
            ];
            return $data;

        }

        public function deleteMovie($id) {
            $pdo = Connect::seConnecter();
            $request = $pdo->prepare("
                DELETE FROM movie
                WHERE id_movie = :id
            ");
            $request->bindValue(":id", $id, \PDO::PARAM_INT);
            $request->execute();
        }
        
    }