<?php

namespace app\core;

use app\lib\DataBase;

class Model
{
    protected static $table;
    protected        $data = [];

    public function __get($key)
    {
        return $this->data[$key];
    }

    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function __isset($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * Вернуть все записи из таблицы
     *
     * @return object
     */
    public static function findAll()
    {
        $db = new DataBase();
        $db->setClassName(get_called_class());

        $sql = 'SELECT * FROM ' . static::$table . ' ORDER BY id DESC';

        return $db->query($sql);
    }

    /**
     * Вернуть записи из таблицы значение колонки $column в которых равно $value
     *
     * @param $column
     * @param $value
     *
     * @return bool или object
     */
    public static function findByColumn($column, $value)
    {
        $db = new DataBase();
        $db->setClassName(get_called_class());

        $sql = 'SELECT * FROM ' . static::$table . ' WHERE ' . $column . ' = :value';
        $res = $db->query($sql, [':value' => $value]);

        if(!empty($res))
        {
            return $res;
        }

        return false;
    }

    /**
     * Удалить запись из таблицы по ID
     *
     * @param $id
     *
     * @return bool
     */
    public static function delete($id)
    {
        $db = new DataBase();

        $sql = 'DELETE FROM ' . static::$table . ' WHERE id = :id';

        return $db->execute($sql, [':id' => $id]);
    }

    /**
     * добавить новую запись в БД
     *
     * @return bool
     */
    public function insert()
    {
        $db          = new DataBase();
        $cols        = array_keys($this->data);    //формируем массив cols заполненный ключами массива data
        $colsPrepare = array_map(function ($col_name){return ':' . $col_name;}, $cols);  //перед каждым элементом массива cols добавляем ":"
        $dataExec    = [];
        foreach($this->data as $key => $value)
        {
            $dataExec[':' . $key] = $value;
        }
        $sql    = 'INSERT INTO ' . static::$table . ' (' . implode(', ', $cols) . ') VALUES (' . implode(', ', $colsPrepare) . ') ';
        $result = $db->execute($sql, $dataExec);

        /*if(true == $result)
        {
            $this->id = $db->lastInsertId();
        }*/

        return $result;
    }

    /**
     * обновить запись в БД
     *
     * @return bool
     */
    protected function update()
    {
        $db = new DataBase();
        $data = [];
        $dataExec = [];
        foreach ($this->data as $key=>$value) {
            $dataExec[':' . $key] = $value;
            if ($key == 'id') {
                continue;
            }
            $data[] = $key . ' = :' . $key;
        }
        $sql = 'UPDATE ' . static::$table . ' SET ' . implode(', ', $data) . ' WHERE id=:id';
        return  $db->execute($sql, $dataExec);
    }

    public function save()
    {
        if (isset($this->id)) {
            return $this->update();
        } else {
            return $this->insert();
        }
    }
}