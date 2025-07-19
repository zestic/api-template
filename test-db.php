<?php

echo "Testing database connection...\n";

try {
    $host     = getenv('DB_HOST') ?: 'postgres';
    $port     = getenv('DB_PORT') ?: 5432;
    $dbname   = getenv('DB_NAME') ?: 'xaddax_api';
    $user     = getenv('DB_USER') ?: 'xaddax';
    $password = getenv('DB_PASSWORD') ?: 'password1';

    $dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s', $host, $port, $dbname);
    $pdo = new PDO($dsn, $user, $password);
    echo "SUCCESS: Database connection established!\n";
    
    // Test a simple query
    $stmt = $pdo->query('SELECT version()');
    $version = $stmt->fetchColumn();
    echo "PostgreSQL version: " . $version . "\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

echo "Testing Weaviate connection...\n";
$weaviateUrl = getenv('WEAVIATE_URL') ?: 'http://weaviate:8080';
echo "Weaviate URL: " . $weaviateUrl . "\n";

// Test if we can reach Weaviate
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $weaviateUrl . '/v1/meta');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($response !== false && $httpCode === 200) {
    echo "SUCCESS: Weaviate is reachable!\n";
    $meta = json_decode($response, true);
    if (isset($meta['version'])) {
        echo "Weaviate version: " . $meta['version'] . "\n";
    }
} else {
    echo "WARNING: Weaviate is not reachable (this is expected if not running)\n";
}

echo "Testing Xdebug...\n";
if (extension_loaded('xdebug')) {
    echo "SUCCESS: Xdebug is loaded!\n";
    echo "Xdebug mode: " . ini_get('xdebug.mode') . "\n";
    echo "Xdebug client host: " . ini_get('xdebug.client_host') . "\n";
    echo "Xdebug client port: " . ini_get('xdebug.client_port') . "\n";
} else {
    echo "ERROR: Xdebug is not loaded!\n";
}
