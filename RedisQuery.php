<?php

require_once "RedisService.php";

$request = $_GET;
$id = intval($request["id"]);
$redisService = new RedisService();
$start = microtime();

$result = [];

if ($cache = $redisService->get('product_' . $id)) {
  $result = $cache;
  $result['data']['from'] = 'cache';
} else {
  $product = MySqlDB::getInstance()
    ->query("SELECT * FROM books WHERE id = :id", [":id" => $id]);

  if ($product) {
    $result = reset($product);
    $redisService->set('book-' . $id, $result);
    $result['data']['from'] = 'db';
  }
}
$result['data']['time'] = microtime() - $start;

echo json_encode($result, JSON_UNESCAPED_UNICODE);
