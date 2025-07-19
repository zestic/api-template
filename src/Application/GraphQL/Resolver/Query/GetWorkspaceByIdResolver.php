<?php

declare(strict_types=1);

namespace Application\GraphQL\Resolver\Query;

use GraphQL\Middleware\Contract\ResolverInterface;
use GraphQL\Type\Definition\ResolveInfo;

class GetWorkspaceByIdResolver implements ResolverInterface
{
    public function __construct(
        private readonly WorkspaceRepository $repository,
    ) {}

    public function __invoke($source, array $args, $context, ResolveInfo $info): mixed
    {
        $data = $this->repository->findById();

        return $data;
    }
}
