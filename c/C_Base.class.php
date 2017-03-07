<?php

/**
 * Created by PhpStorm.
 * User: bmonkey
 * Date: 04.03.17
 * Time: 11:16
 */
abstract class C_Base
{
    protected $title;
    protected $errorMessage;
    protected $content;
    protected $mArticles;
    protected $mUsers;

    function __construct()
    {
        $title = '';
        $errorMessage = '';
        $content= null;
        $mArticles = null;
        $mUsers = null;
    }

    public function Execute()
    {
        $this->Computing();
        $this->Output();
    }

    protected function Computing()
    {
        $this->mArticles = new M_Articles();
        $this->mUsers = new M_Users();
        $this->mUsers->ClearSessions();
    }

    protected function Output()
    {
        $variables = array('title' => $this->title, 'error_message' => $this->errorMessage, 'content' => $this->content);
        $page = $this->IncludeView("V_Base.php", $variables);
        echo $page;
    }

    protected function IsPost()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    protected function toInt($data)
    {
        return abs((int)trim($data));
    }

    protected function toStr($data)
    {
        return htmlspecialchars(trim($data));
    }

    protected function IncludeView(string $filepath, array $variables)
    {
        foreach ($variables as $variable => $value)
            $$variable = $value;
        ob_start();
        include "v/" . $filepath;
        return ob_get_clean();
    }

    function __destruct()
    {
    }
}