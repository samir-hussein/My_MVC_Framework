<?php

namespace App;

use App\Database\Schema;
use App\Database\DataBase;
use App\Database_Tables\Migrations;

class Application
{

    public static $app;
    public $request;
    public $response;
    public $route;
    private $db;
    private $session;
    private $visits;
    private $paymob;
    private $TwoCheckOut;
    private $mail;

    public function __construct($config = null)
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->route = new Route($this->request, $this->response);
        self::$app = $this;
        $this->session = new Session;
        $this->mail = new Mail($config['Mail']);

        if (!empty($config['MySql']['dbName'])) {
            $this->db = new DataBase($config['MySql']);
            new Schema();
            new Migrations();
            $this->visits = new Visitors();
        }

        if (!empty($config['PayMob']['PayMob_User_Name'])) {
            $this->paymob = new PayMob($config['PayMob']);
        }

        if (!empty($config['2checkout']['merchantCode'])) {
            $this->TwoCheckOut = new TwoCheckOut($config['2checkout']);
        }
    }

    public function run()
    {
        return $this->route->resolve();
    }
}
