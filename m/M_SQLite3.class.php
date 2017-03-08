<?php

class M_SQLite3
{
    const DB_NAME = '../articles.db';
    private $_db;

    /**
     * @param string $name
     * @return null|SQLite3
     * @throws Exception
     */
    function __get(string $name)
    {
        if ($name == "db")
            return $this->_db;
        throw new Exception("Unknown property!");
    }

    function __construct()
    {
        $this->_db = null;
        if (!file_exists(self::DB_NAME)) {
            $this->_db = new SQLite3(self::DB_NAME);
            $sql[] = "CREATE TABLE articles(
	                  id_article INTEGER PRIMARY KEY AUTOINCREMENT,
	                  title TEXT,
	                  content TEXT
	                  )";
            $sql[] = "INSERT INTO articles(title, content)
                        SELECT 'Первая статья' as title, 'Содержимое 1' as content
                  UNION SELECT 'Вторая статья' as title, 'Содержимое 2' as content";
            foreach ($sql as $query)
                $this->_db->exec($query);

        }
        $this->_db = $this->_db instanceof SQLite3 ? $this->_db : new SQLite3(self::DB_NAME);
    }

    /**
     * @param string $data
     * @return string
     */
    public function escape(string $data)
    {
        return SQLite3::escapeString($data);
    }

    /**
     * @param string $table
     * @param array $object
     * @return bool
     * @throws Exception
     */
    public function Insert(string $table, array $object)
    {
        $columns = array();
        $values = array();
        foreach ($object as $key => $value) {
            $columns[] = $this->escape($key . '');
            if ($value === null) {
                $values[] = 'NULL';
            } else {
                $values[] = "'{$this->escape($value . '')}'";
            }
        }
        $columns_s = implode(',', $columns);
        $values_s = implode(',', $values);
        $query = "INSERT INTO $table ($columns_s) VALUES ($values_s)";
        $result = $this->_db->exec($query);
        if (!$result)
            throw new Exception($this->_db->lastErrorCode() . ": " . $this->_db->lastErrorMsg());
        return $result;
    }

    /**
     * @param string $query
     * @return array|bool
     */
    public function Select(string $query)
    {
        $result = $this->_db->query($query);
        if (!$result) return false;
        $array = array();
        while ($row = $result->fetchArray(SQLITE3_ASSOC))
            $array[] = $row;
        return $array;
    }

    /**
     * @param string $query
     * @param bool $mode
     * @return array|string|bool
     * @throws Exception
     */
    public function SelectOne(string $query, bool $mode = true)
    {
        $result = $this->_db->querySingle($query, $mode);
        return $result;
        /*if (is_array($result) && empty($result))
            throw new Exception("No data resolve!");
        if ($result == null)
            throw new Exception("Bad request!");
         $result?: false;*/
    }

    /**
     * @param string $table
     * @param array $object
     * @param string $where
     * @return bool
     * @throws Exception
     */
    public function Update(string $table, array $object, string $where)
    {
        $sets = array();
        foreach ($object as $key => $value) {
            $key = $this->escape($key . '');
            if ($value === null) {
                $sets[] = "$key=NULL";
            } else {
                $value = $this->escape($value . '');
                $sets[] = "$key='$value'";
            }
        }
        $sets_s = implode(',', $sets);
        $query = "UPDATE $table SET $sets_s WHERE $where";
        $result = $this->_db->exec($query);
        if (!$result)
            throw new Exception($this->_db->lastErrorCode() . ": " . $this->_db->lastErrorMsg());
        return $result;
    }

    /**
     * @param string $table
     * @param string $where
     * @return int
     * @throws Exception
     */
    public function Delete(string $table, string $where)
    {
        $query = "DELETE FROM $table WHERE $where";
        if (!$this->_db->exec($query))
            throw new Exception($this->_db->lastErrorCode() . ": " . $this->_db->lastErrorMsg());
        return $this->_db->changes();
    }

    function __destruct()
    {
        unset($this->_db);
    }
}