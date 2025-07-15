<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use Zestic\GraphQL\AuthComponent\Entity\PkceDTO;

final class PkceDTOTest extends TestCase
{
    public function testConstructorWithAllParameters(): void
    {
        $pkce = new PkceDTO(
            clientId: 'test-client-id',
            codeChallenge: 'test-code-challenge',
            codeChallengeMethod: 'S256',
            codeVerifier: 'test-code-verifier',
            redirectUri: 'http://localhost:8081/auth/callback',
            scope: 'read write',
            state: 'test-state'
        );

        self::assertEquals('test-client-id', $pkce->clientId);
        self::assertEquals('test-code-challenge', $pkce->codeChallenge);
        self::assertEquals('S256', $pkce->codeChallengeMethod);
        self::assertEquals('test-code-verifier', $pkce->codeVerifier);
        self::assertEquals('http://localhost:8081/auth/callback', $pkce->redirectUri);
        self::assertEquals('read write', $pkce->scope);
        self::assertEquals('test-state', $pkce->state);
    }

    public function testFromArrayWithAllParameters(): void
    {
        $data = [
            'client_id' => 'test-client-id',
            'code_challenge' => 'test-code-challenge',
            'code_challenge_method' => 'S256',
            'code_verifier' => 'test-code-verifier',
            'redirect_uri' => 'http://localhost:8081/auth/callback',
            'scope' => 'read write',
            'state' => 'test-state',
        ];

        $pkce = PkceDTO::fromArray($data);

        self::assertEquals('test-client-id', $pkce->clientId);
        self::assertEquals('test-code-challenge', $pkce->codeChallenge);
        self::assertEquals('S256', $pkce->codeChallengeMethod);
        self::assertEquals('test-code-verifier', $pkce->codeVerifier);
        self::assertEquals('http://localhost:8081/auth/callback', $pkce->redirectUri);
        self::assertEquals('read write', $pkce->scope);
        self::assertEquals('test-state', $pkce->state);
    }

    public function testToArrayIncludesCodeVerifier(): void
    {
        $pkce = new PkceDTO(
            clientId: 'test-client-id',
            codeChallenge: 'test-code-challenge',
            codeChallengeMethod: 'S256',
            codeVerifier: 'test-code-verifier',
            redirectUri: 'http://localhost:8081/auth/callback',
            scope: 'read write',
            state: 'test-state'
        );

        $array = $pkce->toArray();

        self::assertArrayHasKey('code_verifier', $array);
        self::assertEquals('test-code-verifier', $array['code_verifier']);
        self::assertEquals('test-client-id', $array['client_id']);
        self::assertEquals('test-code-challenge', $array['code_challenge']);
        self::assertEquals('S256', $array['code_challenge_method']);
        self::assertEquals('http://localhost:8081/auth/callback', $array['redirect_uri']);
        self::assertEquals('read write', $array['scope']);
        self::assertEquals('test-state', $array['state']);
    }

    public function testFromArrayThrowsExceptionWhenCodeVerifierMissing(): void
    {
        $data = [
            'client_id' => 'test-client-id',
            'code_challenge' => 'test-code-challenge',
            'code_challenge_method' => 'S256',
            'redirect_uri' => 'http://localhost:8081/auth/callback',
            // Missing code_verifier
        ];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('code_verifier is required');

        PkceDTO::fromArray($data);
    }

    public function testIsValidReturnsTrueWithValidData(): void
    {
        $pkce = new PkceDTO(
            clientId: 'test-client-id',
            codeChallenge: 'test-code-challenge',
            codeChallengeMethod: 'S256',
            codeVerifier: 'test-code-verifier',
            redirectUri: 'http://localhost:8081/auth/callback'
        );

        self::assertTrue($pkce->isValid());
    }

    public function testUsesSecureMethodReturnsTrueForS256(): void
    {
        $pkce = new PkceDTO(
            clientId: 'test-client-id',
            codeChallenge: 'test-code-challenge',
            codeChallengeMethod: 'S256',
            codeVerifier: 'test-code-verifier',
            redirectUri: 'http://localhost:8081/auth/callback'
        );

        self::assertTrue($pkce->usesSecureMethod());
    }

    public function testUsesSecureMethodReturnsFalseForPlain(): void
    {
        $pkce = new PkceDTO(
            clientId: 'test-client-id',
            codeChallenge: 'test-code-challenge',
            codeChallengeMethod: 'plain',
            codeVerifier: 'test-code-verifier',
            redirectUri: 'http://localhost:8081/auth/callback'
        );

        self::assertFalse($pkce->usesSecureMethod());
    }
}
