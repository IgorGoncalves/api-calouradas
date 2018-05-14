<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calourada
{
  public $title;
  public $date;
  public $description;
  public $end;
  public $local;

  function __construct($title, $description = "", $date, $end, $local = "") {
      $this->title = $title;
      $this->description = $description;
      $this->date = str_replace("-", "/", $date);
      $this->end = str_replace("-", "/", $end);
      $this->local = $local;
  }
}
