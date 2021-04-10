<?php

$table = new Swoole\Table(1024, 1);
$table->column('id', Swoole\Table::TYPE_INT);
$table->column('from_id', Swoole\Table::TYPE_INT);
$table->column('data', Swoole\Table::TYPE_STRING, 64);
$table->create();

$server = new Swoole\Server('127.0.0.1', 9501);
$server->table = $table;
$server->on('receive', function ($server, $fd, $from_id, $data) {
    $server->table->set($fd, ['id' => $fd, 'from_id' => $from_id, 'data' => $data]);

    var_dump($server->table->get($fd));

});

$server->start();