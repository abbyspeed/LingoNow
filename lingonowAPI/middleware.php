<?php

use Firebase\JWT\JWT;

function checkAuth($request, $response, $next) {
    $headers = $request->getHeader('Authorization');
    $token = '';

    if (!empty($headers)) {
        $token = str_replace('Bearer ', '', $headers[0]);
    }

    try {
        $decoded = JWT::decode($token, 'your_secret_key', ['HS256']);
        // Optionally: Check if the user has admin privileges
        // if ($decoded->role !== 'admin') {
        //     return $response->withStatus(403)->write('Forbidden');
        // }
        return $next($request, $response);
    } catch (Exception $e) {
        return $response->withStatus(401)->write('Unauthorized');
    }
}

return 'checkAuth';