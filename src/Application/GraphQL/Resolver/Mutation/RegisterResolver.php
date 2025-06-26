<?php

declare(strict_types=1);

namespace Application\GraphQL\Resolver\Mutation;

use GraphQL\Middleware\Contract\ResolverInterface;
use GraphQL\Type\Definition\ResolveInfo;
use Zestic\GraphQL\AuthComponent\Context\RegistrationContext;
use Zestic\GraphQL\AuthComponent\Interactor\RegisterUser;

class RegisterResolver implements ResolverInterface
{
    public function __construct(
        private readonly RegisterUser $registerUser,
    ) {}

    public function __invoke($source, array $args, $context, ResolveInfo $info): mixed
    {
        // update context to have request info
        $input = $args['input'];
        $registrationContext = new RegistrationContext($input['email'], $input['additionalData']);

        return $this->registerUser->register($registrationContext);
    }
}
