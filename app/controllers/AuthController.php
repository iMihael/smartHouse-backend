<?php

namespace app\controllers;

use app\collections\User;
use app\forms\Login;
use app\forms\SignUp;

class AuthController extends BaseController
{
    public function signUpAction()
    {
        //TODO: write functional test
        $form = new SignUp();
        $errors = false;

        if ($this->request->isPost()) {
            if($form->isValid($this->request->getPost())) {
                $user = new User();
                if($user->signUp($this->request->getPost())) {
                    $this->response->redirect('index/index');
                } else {
                    $errors = $user->getMessages();
                }
            } else {
                $errors = $form->getMessages();
            }
        }

        $this->view->setVars([
            'form' => $form,
            'errors' => $errors
        ]);
    }

    public function loginAction()
    {
        //TODO: write functional test
        $form = new Login();
        $errors = false;

        if ($this->request->isPost()) {
            if($form->isValid($this->request->getPost())) {

                if($form->loginUser(
                    $this->request->getPost('email'),
                    $this->request->getPost('password'),
                    $this->request->getPost('stayIn')
                    )
                ) {
                    $this->response->redirect('index/index');
                } else {
                    $errors = [
                        'Wrong email or password'
                    ];
                }

            } else {
                $errors = $form->getMessages();
            }
        }

        $this->view->setVars([
            'form' => $form,
            'errors' => $errors
        ]);
    }

    public function logoutAction()
    {
        $this->di->get('user')->logout();
        $this->response->redirect('index/index');
    }
}