<?php

$socket = socket_create(AF_INET, SOCK_STREAM, 0);
socket_bind($socket, '127.0.0.1', 9090);
socket_listen($socket);
socket_set_nonblock($socket);

$clients = [];

while(1) {
    $readfds = array_merge($clients, array($socket));
    $writefds = null;
    $errorfds = $clients;

    $select = socket_select($readfds, $writefds, $errorfds, 3);

    if ($select > 0) {
        
        if (in_array($socket, $readfds)) {
            $conn = socket_accept($socket);
            $clients[] = $conn;
            $id = sizeof($clients) - 1;
            echo "$conn #[$id] is connected\n";
            $key = array_search($socket, $readfds);
            unset($readfds[$key]);
        }

        foreach ($readfds as $_conn) {
            if ($input = @socket_read($_conn, 512)) {
                $input = trim($input);
                echo "conn #[$id] input: $input\n";
                $ack = "OK\n";
                socket_write($_conn, $ack, strlen($ack));
            }
        }
    }
}

