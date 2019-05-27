<?php

class ApiErrors  
{
  function notAllowed(){
      header("HTTP/1.0 405 Method Not Allowed");
  }

  function notFound(){
      header("HTTP/1.0 404 Not Found");
  }

  function serverError(){
      header("HTTP/1.0 500 Server error");
  }   
}
