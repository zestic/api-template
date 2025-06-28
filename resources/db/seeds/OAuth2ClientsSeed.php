<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class OAuth2ClientsSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        // Create OAuth2 clients for XADDAX ReactNative applications
        $oauthClients = $this->table('oauth_clients');
        
        // Web ReactNative Client (Public Client - no client secret)
        $webClientId = $this->generateUuid();
        $oauthClients->insert([
            'client_id'       => $webClientId,
            'name'            => 'XADDAX Web App (Development)',
            'client_secret'   => null, // Public client for web ReactNative
            'redirect_uri'    => json_encode([
                'http://localhost:3000/auth/callback',
                'http://localhost:3001/auth/callback',
                'http://127.0.0.1:3000/auth/callback',
                'http://127.0.0.1:3001/auth/callback',
            ]),
            'is_confidential' => false, // Public client
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
        ]);

        // Mobile ReactNative Client (Public Client with custom scheme)
        $mobileClientId = $this->generateUuid();
        $oauthClients->insert([
            'client_id'       => $mobileClientId,
            'name'            => 'XADDAX Mobile App (Development)',
            'client_secret'   => null, // Public client for mobile ReactNative
            'redirect_uri'    => json_encode([
                'http://localhost:19006/auth/callback', // Expo development server
                'http://localhost:8081/auth/callback',  // Metro bundler
                'http://127.0.0.1:19006/auth/callback', // Expo development server
                'http://127.0.0.1:8081/auth/callback',  // Metro bundler
                'exp://localhost:19000/--/auth/callback', // Expo development
                'exp://127.0.0.1:19000/--/auth/callback', // Expo development
                'xaddax://auth/callback',               // Custom scheme (for testing)
                'com.xaddax.app://auth/callback',       // Bundle ID scheme (for testing)
            ]),
            'is_confidential' => false, // Public client
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
        ]);

        $oauthClients->save();

        // Output the client IDs for reference
        echo "OAuth2 Development Clients created:\n";
        echo "Web Client ID: {$webClientId}\n";
        echo "Mobile Client ID: {$mobileClientId}\n";
        echo "\nWeb Development Redirect URIs:\n";
        echo "- http://localhost:3000/auth/callback (React dev server)\n";
        echo "- http://localhost:3001/auth/callback (React dev server alt)\n";
        echo "- http://127.0.0.1:3000/auth/callback (React dev server)\n";
        echo "- http://127.0.0.1:3001/auth/callback (React dev server alt)\n";
        echo "\nMobile Development Redirect URIs:\n";
        echo "- http://localhost:19006/auth/callback (Expo dev server)\n";
        echo "- http://localhost:8081/auth/callback (Metro bundler)\n";
        echo "- exp://localhost:19000/--/auth/callback (Expo dev)\n";
        echo "- xaddax://auth/callback (custom scheme for testing)\n";
        echo "- com.xaddax.app://auth/callback (bundle ID scheme for testing)\n";
        echo "\nBoth clients are configured as public clients (no client secret required)\n";
        echo "suitable for ReactNative development with PKCE authentication.\n";
        echo "\nFor production, create separate clients with production redirect URIs.\n";
    }

    /**
     * Generate a UUID v4
     */
    private function generateUuid(): string
    {
        $data    = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // Set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // Set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
