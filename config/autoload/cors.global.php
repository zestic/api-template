<?php

declare(strict_types=1);

return [
    'mezzio-cors' => [
        'allowed_origins' => ['*'], // Adjust based on your needs
        'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
        'allowed_headers' => ['*'],
        'allowed_max_age' => '86400',
        'credentials_allowed' => true,
        'exposed_headers' => ['*'],
    ],
];
