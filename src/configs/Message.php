<?php

abstract class Message {
  protected $db;

  public function __construct($db)
  {
    $this->db = $db;
  }
}
