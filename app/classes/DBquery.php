<?php

namespace classes;
/**
 * Работа с БД
 * // Выборка набора записей
 * $users = $db->queryRows('SELECT * FROM users WHERE name LIKE ?', array('%username%'));
 *
 * // Выборка одной записи
 * $user = $db->queryRow('SELECT * FROM users WHERE id=:id', array(':id' => 123));
 *
 * // Добавление записи (INSERT) и получение значения поля AUTO_INCREMENT
 * $newUserId = $db->insert('users', array('name' => 'NewUserName', 'password' => 'zzxxcc'));
 */
class DBquery
{
    private $db;

    function __construct($user = 'root', $pass = 'fktiby123')
    {

        $db = new \PDO('mysql:host=db;dbname=circle;charset=utf8', $user, $pass);
        $this->db = $db;
    }

    /**
     * Добавление записи в таблицу
     * @param  [string] $table        [Название таблицы]
     * @param  [array] $fields       [description]
     * @param  [type] $insertParams [description]
     * @return [type]               [description]
     */
    public function insert($table, $fields, $insertParams = null)
    {
        try {
            $result = null;
            $names = '';
            $vals = '';
            foreach ($fields as $name => $val) {
                if (isset($names[0])) {
                    $names .= ', ';
                    $vals .= ', ';
                }
                $names .= $name;
                $vals .= ':' . $name;
            }
            $ignore = isset($insertParams['ignore']) && $insertParams['ignore'] ? 'IGNORE' : '';
            $sql = "INSERT $ignore INTO " . $table . ' (' . $names . ') VALUES (' . $vals . ')';
            $rs = $this->db->prepare($sql);
            foreach ($fields as $name => $val) {
                $rs->bindValue(':' . $name, $val);
            }
            if ($rs->execute()) {
                $result = $this->db->lastInsertId(null);
            }
            return $result;
        } catch (Exception $e) {
            $this->report($e);
        }
    }

    public function queryRow($query, $params = null, $fetchStyle = \PDO::FETCH_ASSOC, $classname = null)
    {
        $rows = $this->queryRowOrRows(true, $query, $params, $fetchStyle, $classname);
        return $rows;
    }

    public function queryRows($query, $params = null, $fetchStyle = \PDO::FETCH_ASSOC, $classname = null)
    {
        $rows = $this->queryRowOrRows(false, $query, $params, $fetchStyle, $classname);
        return $rows;
    }

    private function queryRowOrRows($singleRow, $query, $params = null, $fetchStyle = \PDO::FETCH_ASSOC, $classname = null)
    {
        try {
            $result = null;
            $stmt = $this->db->prepare($query);
            if ($classname) {
                $stmt->setFetchMode($fetchStyle, $classname);
            } else {
                $stmt->setFetchMode($fetchStyle);
            }
            if ($stmt->execute($params)) {
                $result = $singleRow ? $stmt->fetch() : $stmt->fetchAll();
                $stmt->closeCursor();
            }
            return $result;
        } catch (Exception $e) {
            $this->report($e);
        }
    }

    private function report($e)
    {
        throw $e;
    }

    public function deleteSql($sql, $params = [])
    {
        $sth = $this->db->prepare($sql);
        return $sth->execute($params);
    }

}