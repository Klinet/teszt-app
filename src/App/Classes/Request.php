<?php

namespace App\Classes;
class Request
{
   public $method;
   public $uri;
   public $postData;
   public $getData;

   public function __construct()
   {
       $this->method = $_SERVER['REQUEST_METHOD'];
       $this->uri = $_SERVER['REQUEST_URI'];
       $this->postData = $_POST;
       $this->getData = $_GET;
   }
}