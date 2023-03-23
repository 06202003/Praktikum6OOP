<?php

namespace entity;
use entity\Genre;
class Book{
    private string $ISBN;
    private string $title;
    private string $author;
    private string $publisher;
    private int $publish_year;
    private string $short_description;
    private string $cover;
    private Genre $genre;

   

    /**
     * Get the value of ISBN
     */ 
    public function getISBN()
    {
        return $this->ISBN;
    }

    /**
     * Set the value of ISBN
     *
     * @return  self
     */ 
    public function setISBN($ISBN)
    {
        $this->ISBN = $ISBN;

        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of author
     */ 
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set the value of author
     *
     * @return  self
     */ 
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get the value of publisher
     */ 
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * Set the value of publisher
     *
     * @return  self
     */ 
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * Get the value of publish_year
     */ 
    public function getPublish_year()
    {
        return $this->publish_year;
    }

    /**
     * Set the value of publish_year
     *
     * @return  self
     */ 
    public function setPublish_year($publish_year)
    {
        $this->publish_year = $publish_year;

        return $this;
    }

    /**
     * Get the value of short_description
     */ 
    public function getShort_description()
    {
        return $this->short_description;
    }

    /**
     * Set the value of short_description
     *
     * @return  self
     */ 
    public function setShort_description($short_description)
    {
        $this->short_description = $short_description;

        return $this;
    }

    /**
     * Get the value of cover
     */ 
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Set the value of cover
     *
     * @return  self
     */ 
    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get the value of genre
     */ 
    public function getGenre()
    {
        if(!isset($this -> genre)){
            $this->genre = new Genre();
        }
        return $this->genre;
    }

    /**
     * Set the value of genre
     *
     * @return  self
     */ 
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }
    public function __set($name,$value): void{
        if(!isset($this -> genre)){
            $this->genre = new Genre();
        }
        switch ($name){
            case 'name':
                $this->genre->setName($value);
                break;
        }
     }
}



?>