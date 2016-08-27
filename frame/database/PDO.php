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

    protected $sqlBuilder;

    public function connect($config)
    {
        $dsn = "mysql:host={$config['host']};dbname={$config['db_name']};charset={$config['charset']}";
        $this->pdo = new \PDO($dsn, $config['username'], $config['password']);
    }

    public function query($sql, $binds = [])
    {
        $statement = $this->pre($sql, $binds);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function execute($sql, $binds = [])
    {
        $statement = $this->pre($sql, $binds);
        return $statement->rowCount();
    }

    private function pre($sql, $binds = [])
    {
        $pre = $this->pdo->prepare($sql);
        for ($index = 0; $index < count($binds); $index++) {
            $pre->bindParam($index + 1, $binds[$index]);
        }
        if (false == $pre->execute()) {
            throw new \Exception("SQL ERROR Code:{$pre->errorCode()} Message:" . json_encode($pre->errorInfo()));
        }
        return $pre;
    }

    public function select($fields)
    {
        if ($fields && is_array($fields)) {
            $fields = '`' . implode('`,`', $fields) . '`';
        }
        $this->sqlBuilder['select'] = $fields;
        !isset($this->sqlBuilder['operator']) && $this->sqlBuilder['operator'] = 'select';
        return $this->process();
    }

    public function delete()
    {
        $this->sqlBuilder['operator'] = 'delete';
        return $this->process();
    }

    public function update($condition, $value = null)
    {
        if (is_array($condition)) {
            array_walk($condition, function ($conValue,$conKey) {
                $this->sqlBuilder['update'][] = [
                    'condition' => '`' . $conKey . '`',
                    'value' => $conValue
                ];
            });
        } else {
            $this->sqlBuilder['update'][] = [
                'condition' => '`' . $condition . '`',
                'value' => $value
            ];
        }
        $this->sqlBuilder['operator'] = 'update';
        return $this->process();
    }

    public function insert(array $values)
    {
        array_walk($values, function ($conValue,$conKey) {
            $this->sqlBuilder['insert'][] = [
                'condition' => '`' . $conKey . '`',
                'value' => $conValue
            ];
        });
        $this->sqlBuilder['operator'] = 'insert';
        return $this->process();
    }

    public function where($condition, $operator = null, $value = null)
    {
        if (is_array($condition)) {
            array_walk($condition, function ($conKey, $conValue) {
                $this->sqlBuilder['where'][] = [
                    'condition' => '`' . $conKey . '`',
                    'operator' => '=',
                    'value' => $conValue
                ];
            });
        } else {
            $this->sqlBuilder['where'][] = [
                'condition' => '`' . $condition . '`',
                'operator' => $operator,
                'value' => $value
            ];
        }
        return $this;
    }

    public function orderBy($field, $order = null)
    {
        if($order)
        {
            $this->sqlBuilder['orderBy'] = '`'.$field.'` '.$order;
        }else{
            $this->sqlBuilder['orderBy'] = $field;
        }
        return $this;
    }

    public function groupBy($fields)
    {
        $this->sqlBuilder['groupBy'] = $fields;
        return $this;
    }

    public function having($condition)
    {
        $this->sqlBuilder['having'] = $condition;
        return $this;
    }

    public function limit($offset, $length)
    {
        $this->sqlBuilder['limit'] = "{$offset},{$length}";
        return $this;
    }

    public function table($name)
    {
        $this->sqlBuilder['table'] = $name;
        return $this;
    }

    private function process()
    {
        $sql = '';
        $binds = [];
        switch ($this->sqlBuilder['operator']){
            case 'select':
                $sql.='SELECT '.$this->sqlBuilder['select'].' FROM '.$this->sqlBuilder['table'];
                if(isset($this->sqlBuilder['where'])){
                    $where = '';
                    array_walk($this->sqlBuilder['where'],function($item)use(&$where,&$binds){
                        $where&&$where = 'AND ';
                        $where.= $item['condition'] . ' '.$item['operator'].' ? ';
                        $binds[] = $item['value'];
                    });
                    $sql.=' WHERE '.$where;
                }
                if(isset($this->sqlBuilder['groupBy'])){
                    $sql.=' GROUP BY '.$this->sqlBuilder['groupBy'];
                }
                if(isset($this->sqlBuilder['having'])){
                    $sql.=' HAVING '.$this->sqlBuilder['having'];
                }
                if(isset($this->sqlBuilder['orderBy'])){
                    $sql.=' ORDER BY '.$this->sqlBuilder['orderBy'];
                }
                if(isset($this->sqlBuilder['limit'])){
                    $sql.=' LIMIT '.$this->sqlBuilder['limit'];
                }
                $sql.=' ;';
                $this->sqlBuilder = [];
                return $this->query($sql,$binds);
            case 'update':
                $sql.='UPDATE '.$this->sqlBuilder['table'].' SET ';
                $updateFields = '';
                array_walk($this->sqlBuilder['update'],function($item)use(&$updateFields,&$binds){
                    $updateFields&&$updateFields .=', ';
                    $updateFields.= $item['condition'] . '= ? ';
                    $binds[] = $item['value'];
                });
                $sql.=$updateFields;
                if(isset($this->sqlBuilder['where'])){
                    $where = '';
                    array_walk($this->sqlBuilder['where'],function($item)use(&$where,&$binds){
                        $where&&$where = 'AND ';
                        $where.= $item['condition'] . ' '.$item['operator'].' ? ';
                        $binds[] = $item['value'];
                    });
                    $sql.=' WHERE '.$where;
                }
                $sql.=' ;';
                $this->sqlBuilder = [];
                return $this->execute($sql,$binds);
            case 'delete':
                $sql.='DELETE FROM '.$this->sqlBuilder['table'];
                if(isset($this->sqlBuilder['where'])){
                    $where = '';
                    array_walk($this->sqlBuilder['where'],function($item)use(&$where,&$binds){
                        $where&&$where = 'AND ';
                        $where.= $item['condition'] . ' '.$item['operator'].' ? ';
                        $binds[] = $item['value'];
                    });
                    $sql.=' WHERE '.$where;
                }
                $sql.=' ;';
                $this->sqlBuilder = [];
                return $this->execute($sql,$binds);
            case 'insert':
                $sql.='INSERT INTO '.$this->sqlBuilder['table'].' SET ';
                $insertFields = '';
                array_walk($this->sqlBuilder['insert'],function($item)use(&$insertFields,&$binds){
                    $insertFields&&$insertFields.=',';
                    $insertFields.= $item['condition'] . '= ? ';
                    $binds[] = $item['value'];
                });
                $sql.=$insertFields.' ;';
                $this->sqlBuilder = [];
                return $this->execute($sql,$binds);
        }
        return false;
    }

}