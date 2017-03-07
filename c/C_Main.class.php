<?php

class C_Main extends C_Base
{
    private $pages;
    private $currentPage;
    private $articles;

    protected function Computing()
    {
        parent::Computing();
        $articles_on_page = 5;
        $this->currentPage = $this->toInt($_GET['main']) ?: 1; // Допилить проверку на переданное значение и сделать класс от которог отнаследуются эти 2
        $articles = $this->mArticles->getAll();
        $this->pages = range(1, ceil(count($articles) / $articles_on_page), 1);
        $this->articles = $this->mArticles->Preview($articles, $this->currentPage - 1, $articles_on_page);
        $this->title = "Обзор записей";
    }

    protected function Output()
    {
        $variables = array('pages' => $this->pages, 'current_page' => $this->currentPage, 'articles' => $this->articles);
        $this->content = $this->IncludeView('V_Main.php', $variables);
        parent::Output();
    }
}