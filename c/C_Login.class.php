<?php

class C_Login extends C_Base
{
    private $login;
    private $remember;

    function __construct()
    {
        parent::__construct();
        $this->login = '';
        $this->remember = false;
    }

    protected function Computing()
    {
        parent::Computing();
        $this->mUsers->Logout();
        if ($this->IsPost() && !empty($_POST['login']) && !empty($_POST['password'])) {
            $this->login = $this->toStr($_POST['login']);
            $this->remember = isset($_POST['remember']) ?: '';
            if ($this->mUsers->Login($this->login, $_POST['password'], $this->remember)){
                header('Location: index.php');
                exit();
            }
        }
        $this->title = "Редактирование заметки";
    }

    protected function Output()
    {
        $variables = array('login' => $this->login, 'remember' => $this->remember);
        $this->content = $this->IncludeView('V_Login.php', $variables);
        parent::Output();
    }
}