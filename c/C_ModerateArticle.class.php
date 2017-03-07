<?php

class C_ModerateArticle extends C_Base
{
    private $pages;
    private $currentPage;
    private $articles;

    protected function Computing()
    {
        parent::Computing();
        $articles_on_page = 2;
        $articles = $this->mArticles->getAll();
        $this->pages = range(1, ceil(count($articles) / $articles_on_page), 1);
        $this->currentPage = abs((int)($_GET['moderate'])) ?: 1; // Допилить проверку на переданное значение
        $this->articles = array_reverse($this->mArticles->Preview($articles, $this->currentPage - 1, $articles_on_page));
        $this->title = "Управление записями";
    }

    protected function Output()
    {
        $variables = array('pages' => $this->pages, 'current_page' => $this->currentPage, 'articles' => $this->articles);
        $this->content = $this->IncludeView('V_ModerateArticle.php', $variables);
        parent::Output();
    }
}