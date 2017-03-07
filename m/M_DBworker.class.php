<?php

/**
 * Created by PhpStorm.
 * User: bmonkey
 * Date: 07.03.17
 * Time: 9:40
 */
abstract class M_DBworker
{
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
}