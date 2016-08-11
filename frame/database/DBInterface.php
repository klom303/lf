<?php
/**
 * User: YeJiaLu
 * Date: 2016/3/23
 * Time: 10:18
 */
namespace Frame\Database;

interface DBInterface
{
    public function connect($config);

    public function query($sql, $binds = []);

    public function execute($sql, $binds = []);

    public function table($name);

    public function select($fields);

    public function delete();

    public function update($condition, $value = null);

    public function insert(array $values);

    public function where($condition, $operator = null, $value = null);

    public function orderBy($field, $order=null);

    public function groupBy($fields);

    public function having($condition);

    public function limit($offset, $length);
}