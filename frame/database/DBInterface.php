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
}