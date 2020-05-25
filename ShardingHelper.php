<?php

Class User {
  public $id;
  public $username;
  public $email;

  public function __construct($id, $username, $email) {
    $this->id = $id;
    $this->username = $username;
    $this->email = $email;
  }
}

Class DB {
  private $shard_first;
  private $shard_second;

  private function __construct() {
    $this->shard_first = new PDO('mysql:host=127.0.0.1;port=3306;dbname=db_onlineshop', 'user', 'pass');
    $this->shard_second = new PDO('mysql:host=127.0.0.1;port=3307;dbname=db_onlineshop', 'user', 'pass');
  }

  public function getConnection(User $user) {
    return $user->id <= 500 ? $this->shard_first : $this->shard_second;
  }
}
