<?php

    class DashboardController
    {
        public function index()
        {
            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader, [
                'cache' => '/path/to/compilation_cache',
                'auto_reload' => true,
            ]);

            $template = $twig->load('dashboard.html');
            $parameters['name_user'] = $_SESSION['usr']['name_user'];
            $parameters['role'] = $_SESSION['usr']['role'];
            
            $artists = json_decode($this->getArtists());
            $nameList = array();
            foreach ($artists as $value) {
                array_push($nameList, $value[0]->name);
            }
            $parameters['artists'] = implode($nameList, "%");
            $album = new Album;
            $parameters['albums'] =  json_encode($album->getAlbums());
            return $template->render($parameters);
        }

        public function logout()
        {
            unset($_SESSION['usr']);
            session_destroy();

            header('Location: http://localhost/Moat');
       }

       public function artists()
       {            
        $loader = new \Twig\Loader\FilesystemLoader('app/view');
        $twig = new \Twig\Environment($loader, [
            'cache' => '/path/to/compilation_cache',
            'auto_reload' => true,
        ]);

        $template = $twig->load('artists.html');
        $parameters['artists'] = $this->getArtists();

        return $template->render($parameters);
       }

       public function insertAlbum() {
            $artists = json_decode($this->getArtists());
            $nameList = array();
            foreach ($artists as $value) {
                array_push($nameList, $value[0]->name);
            }
            if (in_array($_POST['artist'], $nameList)) {
                try{
                    $album = new Album;
                    $album->setArtist($_POST['artist']);
                    $album->setAlbum($_POST['album']);
                    $album->setYear($_POST['year']);
                    $album->insertAlbum();
                    header('Location: http://localhost/Moat/dashboard');
                } catch (\Exception $e) {
                    header('Location: http://localhost/Moat/dashboard');
                }
            } else {
                header('Location: http://localhost/Moat/dashboard');
            }
        }

        public function updateAlbum() {
            $album = new Album;
            $album->setArtist($_POST['artist']);
            $album->setAlbum($_POST['album']);
            $album->setYear($_POST['year']);
            $album->setCd($_POST['cd']);
            $album->updateAlbum();
            header('Location: http://localhost/Moat/dashboard');
        }

        public function deleteAlbum() {
            $album = new Album;
            $album->setCd($_POST['cd']);
            $album->deleteAlbum();
            header('Location: http://localhost/Moat/dashboard');
        }

       public function getArtists() {
        $url = "https://www.moat.ai/api/task/";
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $headers = array(
            'Basic: ZGV2ZWxvcGVyOlpHVjJaV3h2Y0dWeQ=='
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $resp1 = curl_exec($curl);
        $parameters = print_r($resp1,true);
        curl_close($curl);
        return $parameters;
       }
    }
