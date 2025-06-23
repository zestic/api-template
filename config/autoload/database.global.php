<?php

declare(strict_types=1);

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

return [
    'dependencies' => [
        'factories' => [
            Connection::class => function () {
                return DriverManager::getConnection([
                    'driver'   => 'pdo_pgsql',
                    'host'     => getenv('DB_HOST') ?: 'postgres',
                    'port'     => getenv('DB_PORT') ?: 5432,
                    'dbname'   => getenv('DB_NAME') ?: 'xaddax_api',
                    'user'     => getenv('DB_USER') ?: 'xaddax',
                    'password' => getenv('DB_PASSWORD') ?: 'password1',
                    'charset'  => 'utf8',
                ]);
            },
            Infrastructure\User\Repository\DbalUserRepository::class => function ($container) {
                return new Infrastructure\User\Repository\DbalUserRepository(
                    $container->get(Connection::class)
                );
            },
        ],
        'aliases' => [
            Domain\User\Repository\UserRepositoryInterface::class => Infrastructure\User\Repository\DbalUserRepository::class,
        ],
    ],
];