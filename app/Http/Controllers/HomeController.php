<?php

namespace App\Http\Controllers;

use PDO;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class HomeController
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function index()
    {
        $stmt = $this->db->prepare("SELECT *  FROM users");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        return new JsonResponse($stmt->fetchAll());
    }
}