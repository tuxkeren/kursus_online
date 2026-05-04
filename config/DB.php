<?php

class DB
{
    private string $host;
    private string $dbname;
    private string $username;
    private string $password;
    private ?PDO $pdo = null;

    public function __construct(
        string $host = 'localhost',
        string $dbname = 'kursus_online',
        string $username = 'root',
        string $password = ''
    ) {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
        $this->connect();
    }

    private function connect(): void
    {
        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $this->host, $this->dbname);
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            throw new RuntimeException('Database connection failed: ' . $e->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        if ($this->pdo === null) {
            $this->connect();
        }

        return $this->pdo;
    }

    public static function make(
        string $host = 'localhost',
        string $dbname = 'kursus_online',
        string $username = 'root',
        string $password = ''
    ): PDO {
        return (new self($host, $dbname, $username, $password))->getConnection();
    }
}
