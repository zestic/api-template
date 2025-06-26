<?php

declare(strict_types=1);

namespace Domain\User\Interactor;

use Domain\Profile\DTO\CreateProfileDTO;
use Domain\Profile\Factory\ProfileFactory;
use Zestic\GraphQL\AuthComponent\Context\RegistrationContext;
use Zestic\GraphQL\AuthComponent\Contract\UserCreatedHookInterface;
use Zestic\GraphQL\AuthComponent\Repository\UserRepositoryInterface;

final class UserRegistration implements UserCreatedHookInterface
{
    public function __construct(
        private readonly ProfileFactory $profileFactory,
        // private readonly WorkspaceFactory $workspaceFactory,
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function execute(RegistrationContext $context, int|string $userId): void
    {
        $profile = $this->profileFactory->create(new CreateProfileDTO($context->get('displayName')));
        $user = $this->userRepository->findUserById($userId);
        $user->setSystemId($profile->getId());

        $this->userRepository->update($user);
    }
}
