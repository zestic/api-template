<?php

declare(strict_types=1);

namespace Infrastructure\Profile;

use Domain\Profile\Entity\Profile;
use Infrastructure\DB\Hydration\CarbonImmutableHydration;

final class ProfileHydration
{
    public function __construct(
        private readonly CarbonImmutableHydration $carbonHydration
    ) {
    }

    public function dehydrate(Profile $profile): array
    {
        return [
            'id'   => $profile->getId(),
            'name' => $profile->getName(),
        ];
    }

    public function hydrate(array $data): Profile
    {
        $profile = new Profile();
        $this->update($profile, $data);

        return $profile;
    }

    public function update(Profile $profile, array $data): void
    {
        if (isset($data['created_at'])) {
            $profile->setCreatedAt($this->carbonHydration->hydrate($data['created_at']));
        }
        if (isset($data['id'])) {
            $profile->setId($data['id']);
        }
        if (isset($data['name'])) {
            $profile->setName($data['name']);
        }
        if (isset($data['updated_at'])) {
            $profile->setUpdatedAt($this->carbonHydration->hydrate($data['updated_at']));
        }
        if (isset($data['deleted_at'])) {
            $profile->setDeletedAt($this->carbonHydration->hydrate($data['deleted_at']));
        }
    }
}
