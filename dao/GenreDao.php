<?php

namespace dao;
use PDO;
use entity\Genre;
use dao\PDOUtil;
class GenreDao{
    public function fetchOneGenre($id){
        $link = PDOUtil::createMySQLConnection();
        $query = "SELECT id,name FROM genre WHERE id = ?";
        $stmt = $link->prepare($query);
        $stmt->bindParam(1,$id);
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $stmt->execute();
        // $genre = $stmt->fetch();
        $results  = $stmt->fetchObject(Genre::class);
        $link =null;
        return $results;
    }
    public function fetchGenreFromDb(): bool | array{        
        $link = PDOUtil::createMySQLConnection();
        $query = "SELECT id,name FROM genre";
        $stmt = $link->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE,'entity\Genre');
        $stmt->execute();
        $result = $stmt->fetchAll();
        $link =null;
        return $result;
    }
    public function addNewGenre(Genre $genre): int{
        $result = 0;
        $link = PDOUtil::createMySQLConnection();
        $link -> beginTransaction();
        $query = 'INSERT INTO genre(name) VALUES (?)';
        $stmt = $link->prepare($query);
        $stmt->bindValue(1,$genre->getName());
        if($stmt->execute()){
            $link -> commit();
            $result = 1;
        }else{
            $link -> rollBack();
        }
        $link =null;
        return $result;
    }
    
    public function updateGenreToDb(Genre $genre){
        $result = 0;
        $link = PDOUtil::createMySQLConnection();
        $link -> beginTransaction();
        $query = 'UPDATE genre SET name = ? WHERE id = ?';
        $stmt = $link->prepare($query);
        $stmt->bindValue(1,$genre -> getName());
        $stmt->bindValue(2,$genre -> getId());
        if($stmt->execute()){
            $link -> commit();
            $result = 1;
        }else{
            $link -> rollBack();
        }
        $link =null;
        return $result;
    }
    public function deleteGenreFromDb($id): int{
        $result = 0;
        $link = PDOUtil::createMySQLConnection();
        $link -> beginTransaction();
        $query = 'DELETE FROM genre WHERE id = ?';
        $stmt = $link->prepare($query);
        $stmt->bindParam(1,$id);
        if($stmt->execute()){
            $link -> commit();
            $result = 1;
        }else{
            $link -> rollBack();
        }
        $link =null;
        return $result;
    }
}


?>