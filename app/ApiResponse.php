<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiResponse
{
  public $data;
  public $errors;

  function __construct($data = [], $errors = []) {
      $this->data =  $data;
      $this->errors =  $errors;
  }
}
