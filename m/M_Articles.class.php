<?php

/**
 * Created by PhpStorm.
 * User: bmonkey
 * Date: 04.03.17
 * Time: 11:55
 */
class M_Articles
{
    private $sqlite;

    function __construct()
    {
        $this->sqlite = new M_SQLite3();
    }

    /**
     * @param string $title
     * @param string $content
     * @return bool
     */
    public function Add(string $title, string $content)
    {
        $obj = array('title' => $title, 'content' => $content);
        return $this->sqlite->Insert('articles', $obj);
    }

    /**
     * @return array|bool
     */
    public function getAll()
    {
        $query = "SELECT * FROM articles ORDER BY id_article DESC";
        return $this->sqlite->Select($query);
    }

    /**
     * @param int $id_article
     * @return array|bool
     */
    public function getById(int $id_article)
    {
        $query = "SELECT * FROM articles WHERE id_article = '$id_article'";
        return $this->sqlite->SelectOne($query);
    }

    /**
     * @param int $id_article
     * @param string $title
     * @param string $content
     * @return bool
     */
    public function Edit(int $id_article, string $title, string $content)
    {   $obj = array('title' => $title, 'content' => $content);

        return $this->sqlite->Update('articles', $obj, "id_article = '$id_article'");
    }

    /**
     * @param int $id_article
     * @return int
     */
    public function Delete(int $id_article)
    {
        return $this->sqlite->Delete('articles', "id_article = '$id_article'");
    }

    /**
     * @param array $articles
     * @param int $position
     * @param int $count
     * @param int $size
     * @return array
     */
    public function Preview(array $articles, int $position, int $count, int $size = 300)
    {
        $result = array();
        foreach (array_slice($articles, $position * $count, $count) as $article) {
            $article['content'] = mb_strlen($article['content']) >= $size ? mb_substr($article['content'], 0, $size) . "..." : $article['content'];
            $result[] = $article;
        }
        return $result;
    }
}