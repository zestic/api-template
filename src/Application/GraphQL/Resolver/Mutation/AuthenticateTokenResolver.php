<?php

declare(strict_types=1);

namespace Application\GraphQL\Resolver\Mutation;

use Application\Authentication\Interactor\AuthenticateToken;
use GraphQL\Middleware\Contract\ResolverInterface;
use GraphQL\Type\Definition\ResolveInfo;

final class AuthenticateTokenResolver implements ResolverInterface
{
    public function __construct(
        private readonly AuthenticateToken $authenticateToken,
    ) {}

    public function __invoke($source, array $args, $context, ResolveInfo $info): mixed
    {
        return $this->authenticateToken->authenticate($args['token']);
    }
}
