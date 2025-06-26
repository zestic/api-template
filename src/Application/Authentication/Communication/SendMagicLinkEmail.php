<?php

declare(strict_types=1);

namespace Application\Authentication\Communication;

use Communication\Interactor\SendCommunication;
use Zestic\GraphQL\AuthComponent\Communication\SendMagicLinkInterface;
use Zestic\GraphQL\AuthComponent\Entity\MagicLinkToken;

final class SendMagicLinkEmail implements SendMagicLinkInterface
{
    public function __construct(
        private SendCommunication $sendCommunication,
    ) {}

    public function send(MagicLinkToken $magicLinkToken): void
    {
        $communication = [
            'channels' => [
                'email',
            ],
            'definitionId' => 'auth.magic-link',
            'context' => [
                'subject' => [
                    'name' => $context->get('displayName'),
                ],
                'body' => [
                    'name' => $context->get('displayName'),
                    'link' => $token->token,
                ],
                'email' => [
                    'name' => $context->get('displayName'),
                    'link' => $token->token,
                ],
                'sms' => [
                    'name' => $context->get('displayName'),
                    'link' => $token->token,
                    'email' => $context->get('email'),
                ],
            ],
            'recipients' => [
                [
                    'email' => $context->get('email'),
                    'name' => $context->get('displayName'),
                ],
            ],
        ];
        $this->sendCommunication->send($communication);
    }
}
