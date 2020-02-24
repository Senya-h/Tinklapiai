<?php
function db_connect() {
    try {
        global $dsn, $username, $password, $options;
        $conn = new PDO($dsn, $username, $password, $options);
        return $conn;
    } catch(PDOException $e) {
        echo $e->getMessage();
        return null;
    }
}

function db_query_get_all($query,  $params = []) {
    try {
        $conn = db_connect();
        if($conn) {
            $stmt = $conn->prepare($query);
            //$stmt->bindValue(1, "%$title%", PDO::PARAM_STR);
            $stmt->execute($params);
            $values = $stmt->fetchAll();
            $conn = null;
            return $values;
        }
        return null;
    } catch(PDOException $e) {
        echo $e->getMessage();
        $conn = null;
        return null;
    }
};

function db_query_get_one($query, $params = []) {
    try {
        $conn = db_connect();
        if($conn) {
            $stmt = $conn->prepare($query);
            //$stmt->bindValue(1, "%$title%", PDO::PARAM_STR);
            $stmt->execute($params);
            $values = $stmt->fetch();
            $conn = null;
            return $values;
        }
        return null;
    } catch(PDOException $e) {
        echo $e->getMessage();
        $conn = null;
        return null;
    }
}

function db_query_params_set($query, $params = []) {
    try {
        $conn = db_connect();
        if ($conn) {
            $conn->prepare($query)->execute($params);
            $conn = null;
            return true;
        }
        return null;
    } catch (PDOException $e) {
        echo $e->getMessage();
        $conn = null;
        return null;
    }
};


function db_update_movie($post) {
    global $dsn, $username, $password, $options;
    try {
        $conn = new PDO($dsn, $username, $password, $options);
        if ($conn) {
            $query = "UPDATE movies SET
                        movies.title = ?,
                        movies.description = ?,
                        movies.year = ?,
                        movies.director = ?,
                        movies.imdb = ?,
                        movies.genre_id = ?
                        WHERE movies.id = ?";
            foreach($post as $movie) { //Kiekvienas filmas
                if($movie['change'] === 'edit') {
                    $conn->prepare($query)->execute([
                        $movie['title'],
                        $movie['description'],
                        $movie['year'],
                        $movie['director'],
                        $movie['imdb'],
                        $movie['genre_id'],
                        $movie['id']
                    ]);
                } elseif($movie['change'] === 'delete') {
                    $query = "DELETE FROM movies WHERE movies.id = ?";
                    $conn->prepare($query)->execute([$movie['id']]);
                }
            }
            return true;
        }
        return false;
    } catch(PDOException $e) {
        echo $e->getMessage();
        return false;
    }
};

function db_add_genre($post) {
    $errors = [];
    try {
        $conn = db_connect();
        if ($conn) {
            foreach($post['genres'] as $item => $genre) {
                if($item === "newGenre") { //Naujam zanrui

                    foreach($genre as $newGenre) {
                        if($newGenre['change'] === 'create') {

                            $query = "INSERT INTO genres (id, genre)
                                  VALUES(?, ?)";
                            $newGenre['genre'] = trim(htmlspecialchars($newGenre['genre']));

                            if(!preg_match("/^.{1,200}$/", $newGenre['genre'])) {
                                $errors[] = "Aprašymas negali būti tuščias ir privalo būti iki 200 simbolių ilgumo";
                            } else {
                                $conn->prepare($query)->execute(["NULL", $newGenre['genre']]);
                            }
                        }
                    }
                } else { //Egzistuojanciam zanrui
                    if($genre['change'] === 'delete') {
                        $query = "SELECT genre_id FROM movies 
                                      JOIN genres ON movies.genre_id = genres.id
                                      WHERE genre_id = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->execute([$genre['id']]);
                        if($stmt->fetch()) {
                            $errors[] = "Negalima istrinti zanro, kuriam yra priklausianciu filmu";
                        } else {
                            $query = "DELETE FROM genres WHERE genres.id = ?";
                            $conn->prepare($query)->execute([$genre['id']]);
                        }
                    }
                }
            }
        }
        $conn = null;
        return $errors;

    } catch(PDOException $e) {
        $conn = null;
        foreach($e as $item => $value) {
            foreach($value as $item2=>$error) {
                if($error === "23000") {
                    $errors[] = "Toks žanras jau egzistuoja";
                    return $errors;
                }
            }
        }

        return $e->getMessage();
    }
}

function db_search_movies_get_all($title) {
    try {
        $conn = db_connect();
        if($conn) {
            $query = "SELECT movies.id, movies.title, movies.description, movies.year,
              movies.director, movies.imdb, movies.genre_id, genres.genre FROM movies 
              JOIN genres ON movies.genre_id = genres.id
              WHERE movies.title LIKE ?";
            $stmt = $conn->prepare($query);
            $stmt->execute(["%$title%"]);
            return $stmt->fetchAll();
        }
        $conn = null;
        return null;
    } catch(PDOException $e) {
        echo $e->getMessage();
        $conn = null;
        return null;
    }

}


function validateAll($post) {
    foreach($post as $item => $value) {
        $post[$item] = trim(htmlspecialchars($value));
    }
    return $post;
}

function validateEditedMovies($post) {
    foreach($post as $movieKey => $movie) {
        foreach($movie as $valueKey => $value) {
            $post[$movieKey][$valueKey] = trim(htmlspecialchars($value));
        }
    }
    return $post;
}


function checkForMovieInputErrors($post) {
    $errors = [];
    foreach($post as $item => $value) {
        if(strpos($item, "title") !== false) {
            if(!preg_match("/^.{1,45}$/", $value)) {
                $errors[] = "Pavadinimas negali būti tuščias ir privalo būti iki 45 simbolių ilgumo";
            }
        }
        elseif(strpos($item, "description") !== false) {
            if(!preg_match("/^.{1,200}$/", $value)) {
                $errors[] = "Aprašymas negali būti tuščias ir privalo būti iki 200 simbolių ilgumo";
            }
        }
        elseif(strpos($item, "director") !== false) {
            if(!preg_match("/^.{1,200}$/", $value)) {
                $errors[] = "Režisierius negali būti tuščias ir privalo būti iki 200 simbolių ilgumo";
            }
        }
        elseif(strpos($item, "year") !== false) {
            if(!preg_match('/^[0-9]*$/', $value) || empty($value)) {
                $errors[] = "Metai negali būti tušti ir turi būti sudaryti iš skaičių";
            }
        }
        elseif(strpos($item, "imdb") !== false) {
            if(!is_numeric($value) || $value < 0 || $value > 10) {
                $errors[] = "IMDB įvertinimas turi būti nuo 0 iki 10";
            } else {
                $value = round($value, 1);
            }
        }
        elseif(strpos($item, "genre_id") !== false) {
            if(empty($value)) {
                $errors[] = "Žanras turi būti parinktas";
            }
        }
    }
    return $errors;
}

function checkForEditedMoviesInputErrors($post) {
    $errors = [];
    foreach($post as $movie) {
        foreach($movie as $item => $value) {
            if(strpos($item, "title") !== false) {
                if(!preg_match("/^.{1,45}$/", $value)) {
                    $errors[] = "Pavadinimas negali būti tuščias ir privalo būti iki 45 simbolių ilgumo";
                }
            }
            elseif(strpos($item, "description") !== false) {
                if(!preg_match("/^.{1,200}$/", $value)) {
                    $errors[] = "Aprašymas negali būti tuščias ir privalo būti iki 200 simbolių ilgumo";
                }
            }
            elseif(strpos($item, "director") !== false) {
                if(!preg_match("/^.{1,200}$/", $value)) {
                    $errors[] = "Režisierius negali būti tuščias ir privalo būti iki 200 simbolių ilgumo";
                }
            }
            elseif(strpos($item, "year") !== false) {
                if(!preg_match('/^[0-9]*$/', $value) || empty($value)) {
                    $errors[] = "Metai negali būti tušti ir turi būti sudaryti iš skaičių";
                }
            }
            elseif(strpos($item, "imdb") !== false) {
                if(!is_numeric($value) || $value < 0 || $value > 10) {
                    $errors[] = "IMDB įvertinimas turi būti nuo 0 iki 10";
                } else {
                    $value = round($value, 1);
                }
            }
            elseif(strpos($item, "genre_id") !== false) {
                if(empty($value)) {
                    $errors[] = "Žanras turi būti parinktas";
                }
            }
        }
    }
    return $errors;
}

