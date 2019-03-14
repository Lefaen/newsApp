<?php

class sqlNews
{
    static private $host = 'localhost';
    static private $user ='root';
    static private $pass ='';
    static private $db = 'test';
    static private $charset = 'utf8';

    private static function connectSql()
    {
        $dsn = 'mysql:host=' . self::$host . ';dbname=' . self::$db . ';charset=' . self::$charset;
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO($dsn, self::$user, self::$pass, $opt);
        return $pdo;

    }

    public static function getNews($page, $quantity)
    {
        $pdo = self::connectSql();
        $res = $pdo->prepare("SELECT `id`, FROM_UNIXTIME(`idate`, '%d-%m-%Y') as idate, `title`, `announce`
                                            FROM `news`
                                            ORDER BY idate DESC
                                            LIMIT :quantity OFFSET :offset");
        $values[':quantity'] = $quantity;

        $offset = $quantity * ($page - 1);
        $values[':offset'] = $offset;

        $res->execute($values);
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getDetailNews($id)
    {
        $pdo = self::connectSql();
        $res = $pdo->prepare('SELECT `title`, `content` from `news` WHERE `id` = :id');
        $values[':id'] = $id;
        $res->execute($values);
        return $res->fetch();

    }

    public static function getQuantityStrings()
    {
        $pdo = self::connectSql();
        $res = $pdo->query('SELECT count(*) as count FROM `news`');
        $count = $res->fetch();
        return $count['count'];
    }
}

class modelAppNews
{
    private $data = null;
    private $numOfPages = null;
    private $quantityOnPage = 5;

    public function getData()
    {
        return $this->data;
    }

    public function getNumOfPages()
    {
        return $this->numOfPages;
    }

    function getNewsFromSql($page = 1)
    {
        $this->data['news'] = sqlNews::getNews($page, $this->quantityOnPage);
        $this->data['numOfPages'] = $this->getNumOfPages();
        return $this->data;
    }

    function getDetailNews($id)
    {
        $this->data = sqlNews::getDetailNews($id);
    }

    public function __construct()
    {
        $quantity = sqlNews::getQuantityStrings();
        $numOfPages = $quantity / $this->quantityOnPage;
        if ($quantity % $this->quantityOnPage != 0) {
            $numOfPages++;
        }
        $this->numOfPages = (int) $numOfPages;
    }
}