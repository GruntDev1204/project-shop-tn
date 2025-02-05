<?php

return [
    'paths' => ['*'],
    'allowed_methods' => ["GET", 'POST', 'PUT', 'DELETE', 'OPTIONS'],
    'allowed_origins' => ['*'],
    'allowed_headers' => ['Content-Type', 'X-Auth-Token', 'Origin', 'Authorization'],
    'supports_credentials' => false,
];
