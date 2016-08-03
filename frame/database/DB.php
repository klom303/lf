<?php
/**
 * User: YeJiaLu
 * Date: 2016/3/23
 * Time: 12:51
 */
namespace Frame\Database;

class DB
{
    private static $instance;
    /**
     * @var DBInterface
     */
    private $db;
    protected $config;

    private function __construct()
    {
        $this->config = include __CONFIG__ . '/database.php';

        $this->db = $this->getDevice($this->config['device']);

        $this->db->connect($this->config);
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function getDevice($device)
    {
        $deviceClass = __NAMESPACE__ . '\\' . $device;
        $deviceObj = new $deviceClass();
        if (!$deviceObj instanceof DBInterface) {
            return null;
        }
        return $deviceObj;
    }

    public static function query($sql, $binds = [])
    {
        $instance = self::getInstance();
        return $instance->db->query($sql, $binds);
    }

    public static function execute($sql, $binds = [])
    {
        $instance = self::getInstance();
        return $instance->db->execute($sql, $binds);
    }
}