<?php

namespace core;

class Application
{

    public static $app;
    public $request;
    public $response;
    public $router;
    public $controller = null;
    public $db;

    public function __construct($config = null)
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        self::$app = $this;

        if (!empty($config['dbName'])) {
            $this->db = new DataBase($config);
        }
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}
