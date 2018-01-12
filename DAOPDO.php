<?php
class DAOPDO
{
    private static $instance;
    private $pdo;

    private function __construct()
    {
        $host = isset($options['host']) ? $options['host'] : 'www.hellobirds.top';
        $dbname = isset($options['dbname']) ? $options['dbname'] : 'wx';
        $user = isset($options['user']) ? $options['user'] : 'root';
        $password = isset($options['password']) ? $options['password'] : 'root';
        $charset = isset($options['charset']) ? $options['charset'] : 'utf8';
        $port = isset($options['port']) ? $options['port'] : '3306';

        $dsn = "mysql:host=$host;dbname=$dbname;port=$port;charset=$charset";
        $this->pdo = new \PDO($dsn, $user, $password);

    }

    private function __clone()
    {

    }

    public static function getSingleTon()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getPDO()
    {
        return $this->pdo;
    }

    //查询一条数据
    public function fetchRow($sql)
    {
        $pdo_statement = $this->pdo->query($sql);
        if ($pdo_statement === false) {
            $error_no = $this->pdo->errorCode();
            $error = $this->pdo->errorInfo();
            $err_str = "SQL语句有误，详细信息如下：<br>" . $error[2];
            echo $err_str;
            return false;
        }
        $result = $pdo_statement->fetch(PDO::FETCH_ASSOC);
        $pdo_statement->closeCursor();
        return $result;
    }

    //查询全部数据
    public function fetchAll($sql)
    {
        $pdo_statement = $this->pdo->query($sql); //失败返回false 成功返回pdostatement
        if ($pdo_statement === false) {
            $error = $this->pdo->errorInfo();
            $err_str = "SQL语句有误，详细信息如下：<br>" . $error[2];
            echo $err_str;
            return false;
        }
        $result = $pdo_statement->fetchAll(PDO::FETCH_ASSOC);
        $pdo_statement->closeCursor();
        return $result;
    }

    //查询一个字段的值
    public function fetchColumn($sql)
    {
        $pdo_statement = $this->pdo->query($sql);
        if ($pdo_statement === false) {
            $error = $this->pdo->errorInfo();
            $err_str = "SQL语句有误，详细信息如下：<br>" . $error[2];
            echo $err_str;
            return false;
        }
        $result = $pdo_statement->fetchColumn();
        $pdo_statement->closeCursor();
        return $result;
    }

    //执行增删改的操作
    public function exec($sql)
    {
        $res = $this->pdo->exec($sql);//返回受影响的行数
        if ($res === false) {
            $error = $this->pdo->errorInfo();
            $err_str = 'SQL语句有误，详细信息如下：<br>' . $error[2];
            echo $err_str;
            return false;
        }
        return $res;
    }

    //引号转义包裹的方法
    //why？
    //$id = "1 or \1=1";
    // $sql = "delete from user where id=1 or 1=1"
    //so 用户输入的数据不可信，需要将用户输入的数据用引号转义：where id='1 or 1=1' \\w
    public function quote($data)
    {
        return $this->pdo->quote($data);
    }

    //查询刚刚插入的这条数据的主键
    public function lastInsertId($key = '')
    {
        return $this->pdo->lastInsertId($key);
    }
}