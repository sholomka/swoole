<?php

$socket = socket_create(AF_INET, SOCK_STREAM, 0);
socket_bind($socket, '127.0.0.1', 9090);
socket_listen($socket);
socket_set_nonblock($socket);

$clients = [];
$seconds = 0;

while(1) {
    if ($conn = socket_accept($socket)) {
        echo is_resource($conn);

        if (is_resource($conn)) {
            socket_set_nonblock($conn);
            $clients[] = $conn;
            $id = sizeof($clients) - 1;
            echo "$conn #[$id] is connected\n";
        }
    }


    if (count($clients)) {
        foreach ($clients as $id => $conn) {


            if ($input = socket_read($conn, 512)) {

                echo $input;

                $input = trim($input);
                echo "conn #[$id] input: $input\n";
                $ack = "OK\n";
                socket_write($conn, $ack, strlen($ack));
                if ($input == 'quit') {
                    socket_close($conn);
                    unset($clients[$id]);
                    echo "conn #[$id] is disconnected\n";
                }
            }
        }
    }
}

socket_close($socket);
