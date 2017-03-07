<?php

class C_NewArticle extends C_Base
{
    private $articleTitle;
    private $articleContent;

    protected function Computing()
    {
        parent::Computing();
        if ($this->isPost()) {
            $this->articleTitle = $this->toStr($_POST['title']);
            $this->articleContent = $this->toStr($_POST['content']);
            if (empty($this->articleTitle) || empty($this->articleContent)) {
                $this->errorMessage = "Нужно заполнить все поля";
            } else {
                if ($this->mArticles->Add($this->articleTitle, $this->articleContent)) {
                    header("Location: index.php");
                    exit;
                } else
                    $this->errorMessage = "Ошибка при сохранении заметки в базу.";
            }
        }
        $this->title = "Создание новой заметки";
    }

    protected function Output()
    {
        $variables = array('title' => $this->articleTitle, 'content' => $this->articleContent);
        $this->content = $this->IncludeView('V_NewArticle.php', $variables);
        parent::Output();
    }
}