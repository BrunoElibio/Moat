<?php

    class RegisterController
    {
        public function index()
        {
            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader, [
                'cache' => '/path/to/compilation_cache',
                'auto_reload' => true,
            ]);

            $template = $twig->load('register.html');
            $parameters['name_user'] = $_SESSION['usr']['name_user'];

            return $template->render($parameters);
        }

        public function register()
        {
            try{
                $user = new User;
                $user->setLogin($_POST['username']);
                $user->setPassword($_POST['password']);
                $user->setRole($_POST['password']);
                $user->setName($_POST['fullname']);
                $user->setRole($_POST['role'] == 'on' ? 1 : 0);
                $user->insertUser();
                
                header('Location: http://localhost/Moat/dashboard');
            } catch (\Exception $e) {
                $_SESSION['msg_error'] = array('msg' => $e->getMessage(), 'count' => 0);

                header('Location: http://localhost/Moat/dashboard/register');
            }
        }

    }