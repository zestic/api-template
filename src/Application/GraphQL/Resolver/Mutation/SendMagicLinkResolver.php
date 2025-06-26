<?php

declare(strict_types=1);

namespace Application\GraphQL\Resolver\Mutation;

use GraphQL\Middleware\Contract\ResolverInterface;
use GraphQL\Type\Definition\ResolveInfo;
use Zestic\GraphQL\AuthComponent\Interactor\SendMagicLink;

final class SendMagicLinkResolver implements ResolverInterface
{
    public function __construct(
        private readonly SendMagicLink $sendMagicLink,
    ) {}

    public function __invoke($source, array $args, $context, ResolveInfo $info): mixed
    {
        return $this->sendMagicLink->send($args['email']);
    }
}
