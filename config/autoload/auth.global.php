<?php

declare(strict_types=1);

use Application\Authentication\Communication\SendMagicLinkEmail;
use Application\Authentication\Communication\SendVerificationEmail;
use Domain\User\Interactor\UserRegistration;
use Zestic\GraphQL\AuthComponent\Communication\SendMagicLinkInterface;
use Zestic\GraphQL\AuthComponent\Communication\SendVerificationLinkInterface;
use Zestic\GraphQL\AuthComponent\Contract\UserCreatedHookInterface;

return [
    'dependencies'   => [
        'aliases'    => [
            SendMagicLinkInterface::class => SendMagicLinkEmail::class,
            SendVerificationLinkInterface::class => SendVerificationEmail::class,
            UserCreatedHookInterface::class => UserRegistration::class,
        ],
    ],
];
