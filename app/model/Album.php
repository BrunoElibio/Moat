<?php

    use Bruno\Database\Connection;

    class Album
    {
        private $cd;
        private $artist;
        private $album;
        private $year;

        public function getAlbums()
        {
                $conn = Connection::getConn();
                //selecionar o usuario que tenha o mesmo login do informado
                $sql = 'SELECT * FROM album WHERE 1';
                
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $result = $stmt->fetchAll(MYSQLI_NUM);
                return $result;
        }

        public function insertAlbum()
        {
                $conn = Connection::getConn();
                $sql = "INSERT INTO album(album, artist, year) VALUES(:album, :artist, :year)";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':album', $this->album);
                $stmt->bindValue(':artist', $this->artist);
                $stmt->bindValue(':year', $this->year);
                $stmt->execute();
        }

        public function updateAlbum()
        {
                $conn = Connection::getConn();
                $sql = "UPDATE album SET album=:album, artist=:artist, year=:year WHERE cd=:cd";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':album', $this->album);
                $stmt->bindValue(':artist', $this->artist);
                $stmt->bindValue(':year', $this->year);
                $stmt->bindValue(':cd', $this->cd);
                $stmt->execute();
        }

        public function deleteAlbum()
        {
                $conn = Connection::getConn();
                $sql = "DELETE FROM album WHERE cd=:cd";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':cd', $this->cd);
                $stmt->execute();
        }

        /**
         * Get the value of cd
         */ 
        public function getCd()
        {
                return $this->cd;
        }

        /**
         * Set the value of cd
         *
         * @return  self
         */ 
        public function setCd($cd)
        {
                $this->cd = $cd;

                return $this;
        }

        /**
         * Get the value of artist
         */ 
        public function getArtist()
        {
                return $this->artist;
        }

        /**
         * Set the value of artist
         *
         * @return  self
         */ 
        public function setArtist($artist)
        {
                $this->artist = $artist;

                return $this;
        }

        /**
         * Get the value of album
         */ 
        public function getAlbum()
        {
                return $this->album;
        }

        /**
         * Set the value of album
         *
         * @return  self
         */ 
        public function setAlbum($album)
        {
                $this->album = $album;

                return $this;
        }

        /**
         * Get the value of year
         */ 
        public function getYear()
        {
                return $this->year;
        }

        /**
         * Set the value of year
         *
         * @return  self
         */ 
        public function setYear($year)
        {
                $this->year = $year;

                return $this;
        }
    }
