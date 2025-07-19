<?php

declare(strict_types=1);

namespace Application\GraphQL\Resolver\Query;

interface WorkspaceRepository
{
    /**
     * Find workspace by ID
     *
     * @return array<string, mixed>|null
     */
    public function findById(): ?array;
}
