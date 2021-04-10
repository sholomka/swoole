<?php

// 0, 1, 1, 2, 3, 5, 8, 13, 21...

function fibonacci($n) {


    if ($n <= 2) {
        return $n - 1;
    }

    echo $n . PHP_EOL;

    return fibonacci($n - 1) + fibonacci($n - 2);
}


echo fibonacci(50) . PHP_EOL;
