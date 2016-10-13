<?php

class Request
{
    public $get = array();
    public $post = array();
    public $cookie = array();
    public $files = array();
    public $server = array();
    public $isAjax = false;
    public $isPost = false;

    public function __construct()
    {
        $this->get = $this->clean($_GET);
        $this->post = $this->clean($_POST);
        $this->request = $this->clean($_REQUEST);
        $this->cookie = $this->clean($_COOKIE);
        $this->files = $this->clean($_FILES);
        $this->server = $this->clean($_SERVER);
        if (strtolower(filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest') {
            $this->isAjax = true;
        } else
            $this->isAjax = false;

        if (isset($_POST) && count($_POST)>0)
            $this->isPost = true;
        else
            $this->isPost = false;
    }

    /**
     * Clean data comes from get, post, request, cookie, files and server
     * @param type $data
     * @return type
     */
    public function clean($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                unset($data[$key]);
                $data[$this->clean($key)] = $this->clean($value);
            }
        } else {
            $data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
        }

        return $data;
    }
}