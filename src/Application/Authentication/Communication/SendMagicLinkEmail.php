<?php

declare(strict_types=1);

namespace Application\Authentication\Communication;

use Communication\Interactor\SendCommunication;
use Domain\Profile\Repository\ProfileRepositoryInterface;
use Zestic\GraphQL\AuthComponent\Communication\SendMagicLinkInterface;
use Zestic\GraphQL\AuthComponent\Entity\MagicLinkConfig;
use Zestic\GraphQL\AuthComponent\Entity\MagicLinkToken;
use Zestic\GraphQL\AuthComponent\Repository\UserRepositoryInterface;

final class SendMagicLinkEmail implements SendMagicLinkInterface
{
    public function __construct(
        private SendCommunication $sendCommunication,
        private ProfileRepositoryInterface $profileRepository,
        private UserRepositoryInterface $userRepository,
        private MagicLinkConfig $magicLinkConfig,
    ) {
    }

    public function send(MagicLinkToken $magicLinkToken): void
    {
        $user    = $this->userRepository->findUserById($magicLinkToken->userId);
        $profile = $this->profileRepository->findById($user->getSystemId());

        // Generate the magic link verification URL
        // This should point to the /magic-link/verify endpoint with the token parameter
        $verificationUrl = $this->magicLinkConfig->buildRedirectUrl(
            'http://localhost:8088/magic-link/verify',
            ['token' => $magicLinkToken->token]
        );

        $communication = [
            'channels'     => [
                'email',
            ],
            'definitionId' => 'auth.magic-link',
            'context'      => [
                'subject' => [
                    'name' => $profile->getName(),
                ],
                'body'    => [
                    'name' => $profile->getName(),
                    'link' => $verificationUrl,
                ],
                'email'   => [
                    'name' => $profile->getName(),
                    'link' => $verificationUrl,
                ],
                'sms'     => [
                    'name'  => $profile->getName(),
                    'link'  => $verificationUrl,
                    'email' => $user->getEmail(),
                ],
            ],
            'recipients'   => [
                [
                    'email' => $user->getEmail(),
                    'name'  => $profile->getName(),
                ],
            ],
        ];
        $this->sendCommunication->send($communication);
    }
}
