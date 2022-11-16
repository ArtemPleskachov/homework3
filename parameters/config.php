<?php

return [
    'a' => [
        'b' => [
            'c' => 123
        ]
    ],
    'dbFile' => __DIR__ . '/../storage/db.json',
    'monolog' => [
        'chanel' => 'general',
        'level' => [
            'error' => __DIR__ . '/../logs/error.log',
            'info' => __DIR__ . '/../logs/info.log',
        ]
    ],
    'urlConverter' => [
        'codeLength' => 10,
    ],

];