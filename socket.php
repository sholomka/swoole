<?php

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_bind($socket, '127.0.0.1', 9090);
socket_listen($socket, 5);

while(1) {
    $conn = socket_accept($socket);
    $msg = "hello\n";
    socket_write($conn, $msg, strlen($msg));
    socket_close($conn);
}


