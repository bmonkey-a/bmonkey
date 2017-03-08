<?php

class C_Registration extends C_Base
{
    private $udata;

    function __construct()
    {
        parent::__construct();
        $this->udata = null;
    }

    protected function Computing()
    {
        parent::Computing();
        $this->mUsers->Logout();
        if ($this->IsPost()) {
            $this->udata['name'] = $this->toStr($_POST['name']);
            $this->udata['login'] = $this->toStr($_POST['email']);
            $this->udata['password'] = $this->toStr($_POST['password']);
            // На клиентской части добавить проверку правильности ввода данных
            if (in_array(null, $this->udata))
                $this->errorMessage = "Нужно заполнить все поля";
            else {
                $check = '';
                if ($this->mUsers->Register($this->udata, $check)) {
                    header("Refresh:5; url=index.php?main");
                    $this->errorMessage = "Регистрация прошла успешно, вы будете перемещены на Главную страницу через 3 секунды";
                } else {
                    if (!empty($check))
                        $this->errorMessage = "Пользователь с адресом $check уже зарегистрирован. Забыли пароль?";
                    else
                        $this->errorMessage = "Произошла ошибка при регистрации пользователя. Пожалуйста обратитесь через форму Обратной связи для решения проблемы.";
                }
            }
        }
        $this->title = "Регистрация";
    }

    protected function Output()
    {
        $variables = array('title' => $this->title, 'name' => $this->udata['name'], 'email' => $this->udata['login'], 'message' => $this->errorMessage);
        $this->content = $this->IncludeView('V_Registration.php', $variables);
        parent::Output();
    }

}