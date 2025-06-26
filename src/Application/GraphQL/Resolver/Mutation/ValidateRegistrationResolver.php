<?php

declare(strict_types=1);

namespace Application\GraphQL\Resolver\Mutation;

use GraphQL\Middleware\Contract\ResolverInterface;
use GraphQL\Type\Definition\ResolveInfo;
use Zestic\GraphQL\AuthComponent\Interactor\ValidateRegistration;

final class ValidateRegistrationResolver implements ResolverInterface
{
    public function __construct(
        private readonly ValidateRegistration $validateRegistration,
    ) {}

    public function __invoke($source, array $args, $context, ResolveInfo $info): mixed
    {
        return $this->validateRegistration->validate($args['token']);
    }
}
