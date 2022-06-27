<?php

    use Bruno\Database\Connection;

    class User
    {
        private $cd;
        private $name;
        private $login;
        private $password;
        private $role;

        public function validateLogin()
        {
            $conn = Connection::getConn();
            //selecionar o usuario que tenha o mesmo login do informado
            $sql = 'SELECT * FROM muser WHERE login = :login';
            
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':login', $this->login);
            $stmt->execute();

            if ($stmt->rowCount()) {
                $result = $stmt->fetch();

                if ($result['password'] === $this->password) {
                    $_SESSION['usr'] = array(
                        'id_user'   => $result['cduser'], 
                        'name_user' => $result['name'],
                        'role'      => $result['admin'] // 1 == admin, 0 == user
                    );

                    return true;
                }
            }

            throw new \Exception('Login Inválido');
        }

        public function insertUser()
        {
            $conn = Connection::getConn();
            $sql = "INSERT INTO muser(name, login, password, admin) VALUES(:name, :login, :password, :admin)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':name', $this->name);
            $stmt->bindValue(':login', $this->login);
            $stmt->bindValue(':password', $this->password);
            $stmt->bindValue(':admin', $this->role);
            $stmt->execute();
        }

        public function setLogin($login)
        {
            $this->login = $login;
        }

        public function setName($name)
        {
            $this->name = $name;
        }

        public function setPassword($password)
        {
            $this->password = $password;
        }

        public function getName()
        {
            return $this->name;
        }

        public function getLogin()
        {
            return $this->login;
        }

        public function getPassword()
        {
            return $this->password;
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
         * Get the value of role
         */ 
        public function getRole()
        {
                return $this->role;
        }

        /**
         * Set the value of role
         *
         * @return  self
         */ 
        public function setRole($role)
        {
                $this->role = $role;

                return $this;
        }
    }
