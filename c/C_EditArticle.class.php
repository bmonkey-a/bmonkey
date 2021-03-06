<?php

class C_EditArticle extends C_Base
{
    private $article;

    protected function Computing()
    {
        parent::Computing(); // TODO: Change the autogenerated stub
        if ($this->isPost()) {
            $this->article['id_article'] = $this->toInt($_POST['id_article']); // Добавить проверку на права редактирования
            $this->article['title'] = $this->toStr($_POST['title']);
            $this->article['content'] = $this->toStr($_POST['content']);
            if (empty($this->article['id_article']) || empty($this->article['title']) || empty($this->article['content'])) {
                $this->errorMessage = "Все поля должны быть заполнены";
            }
            else {
                if ($this->mArticles->Edit($this->article['id_article'], $this->article['title'], $this->article['content'])) {
                    header("Location: index.php?moderate");
                    exit;
                } else
                    $this->errorMessage = "Ошибка при обращении к базе!";
            }
        } else {
            $id_article = $this->toInt($_GET['edit_article']) ?: 0;
            if ($id_article)
                $this->article = $this->mArticles->getById($id_article);
            else {
                header("Location: index.php?moderate");
                exit;
            }

        }
        $this->title = "Редактирование заметки";
    }

    protected function Output()
    {
        $variables = array('article' => $this->article);
        $this->content = $this->IncludeView('V_EditArticle.php', $variables);
        parent::Output(); // TODO: Change the autogenerated stub
    }
}