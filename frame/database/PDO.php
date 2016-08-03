<?php
/**
 * User: YeJiaLu
 * Date: 2016/3/23
 * Time: 10:20
 */
namespace Frame\Database;

class PDO implements DBInterface
{
    /**
     * @var \PDO
     */
    protected $pdo;

    public function connect($config)
    {
        $dsn = "mysql:host={$config['host']};dbname={$config['db_name']};charset={$config['charset']}";
        $this->pdo = new \PDO($dsn, $config['username'], $config['password']);
    }

    public function query($sql, $binds = [])
    {
        $statement = $this->pre($sql,$binds);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function execute($sql, $binds = [])
    {
        $statement = $this->pre($sql,$binds);
        return $statement->rowCount();
    }

    private function pre($sql, $binds = [])
    {
        $pre = $this->pdo->prepare($sql);
        for ($index = 0; $index < count($binds); $index++) {
            $pre->bindParam($index + 1, $binds[$index]);
        }
        if(false==$pre->execute())
        {
            throw new \Exception("SQL ERROR Code:{$pre->errorCode()} Message:".serialize($pre->errorInfo()));
        }
        return $pre;
    }

}