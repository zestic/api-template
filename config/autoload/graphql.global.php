<?php

declare(strict_types=1);

return [
    'graphql' => [
        'middleware' => [
            'allowedHeaders' => [
                'application/graphql',
                'application/json',
            ],
        ],
        'schema' => [
            'isCacheEnabled' => true,
            'cacheDirectory' => __DIR__ . '/../../data/cache/graphql',
            'schemaDirectories' => [
                __DIR__ . '/../../resources/graphql',
                __DIR__ . '/../../vendor/zestic/graphql-auth-component/resources/graphql',
            ],
            'parserOptions' => [],
        ],
        'server' => [
            'errorsHandler' => function (array $errors, callable $formatter) {
                foreach ($errors as $error) {
                    // Sentry\captureException($error);
                }

                return array_map($formatter, $errors);
            },
            // 'context' => function ($request) {
            //     $token = $request->getHeaderLine('Authorization');
            //     if (!empty($token)) {
            //         return new \Zestic\GraphQL\Context\TokenContext($token);
            //     }
            //     return null;
            // },
        ],
    ],
];
