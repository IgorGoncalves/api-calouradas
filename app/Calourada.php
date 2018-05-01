<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calourada
{
  public $title;
  public $date;
  public $local;

  function __construct($title, $date, $local = "") {
      $this->title = $title;
      $this->date = str_replace("-", "/", $date);
      $this->local = $local;
  }
}
