<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

require 'vendor/autoload.php';
require_once './dbconnect.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$app = new \Slim\App;
$db = new db();

// To be changed
$jwtSecret = 'your_jwt_secret';

// Sample
$app->get('/', function(){
    echo("Hello from root folder");
});

// Auth
// CHECK CREDENTIALS
$app->post('/login', function ($request, $response, $args) use ($db, $jwtSecret) {
    $conn = $db->connect();

    $input = $request->getParsedBody();

    if (!is_array($input)) {
        return $response->withStatus(400)->withJson(['message' => 'Invalid input']);
    }

    $username = $input['username'] ?? '';
    $password = $input['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM user WHERE username = :username");
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['pwd'])) {
        // Password is correct, generate JWT token
        $payload = [
            'username' => $username,
            'exp' => time() + 3600 // Token expiration time (1 hour)
        ];

        $jwt = JWT::encode($payload, $jwtSecret, 'HS256');

        $data = [
            'token' => $jwt,
            'user' => ['username' => $username]
        ];

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');

    } else {
        $data = ['message' => 'Invalid username or password'];
        $response->getBody()->write(json_encode($data));
        return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
    }
});

// Logout
$app->post('/logout', function ($request, $response, $args) use ($db) {
    session_start();
    session_unset();
    session_destroy();
    
    $conn = $db->connect();

    $headers = $request->getHeader('Authorization');
    $token = '';

    if (!empty($headers)) {
        $token = str_replace('Bearer ', '', $headers[0]);
    }

    if ($token) {
        $stmt = $conn->prepare('INSERT INTO blacklisted_tokens (token) VALUES (:token)');
        $stmt->execute([':token' => $token]);
    }

    $response->getBody()->write(json_encode(['message' => 'Logged out successfully']));
    return $response->withHeader('Content-Type', 'application/json');
});

$checkAuth = require 'middleware.php';

// Routes
$app->group('/Admin', function ($group) {
    $group->get('/Home', function ($request, $response, $args) {
        $response->getBody()->write("Admin Home");
        return $response;
    });

    $group->get('/About', function ($request, $response, $args) {
        $response->getBody()->write("Admin About");
        return $response;
    });

    $group->get('/Manage', function ($request, $response, $args) {
        $response->getBody()->write("Admin Manage");
        return $response;
    });

    $group->get('/Profile', function ($request, $response, $args) {
        $response->getBody()->write("Admin Profile");
        return $response;
    });
})->add($checkAuth);

$app->get('/users', function($request, $response, $args){
    $name = $args['name'];
    echo 'Hello' .$name;
});

// CREATE (ON HOLD)
$app->post('/users', function($request, $response, $args) use ($db){
    $conn = $db->connect();
    $data = $request->getParsedBody();

    try{
        if(isset($data['username']) && isset($data['password'])){
            $fullName = $data['fullName'];
            $email = $data['email'];
            $username = $data['username'];
            $phoneNo = $data['phoneNo'];
            $password = $data['password'];
    
            $sql = 'INSERT INTO user (email, username, pwd, fullName, phoneNo) VALUES (:email, :username, :pwd, :fullName, :phoneNo)';
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':pwd', $password);
            $stmt->bindValue(':fullName', $fullName);
            $stmt->bindValue(':phoneNo', $phoneNo);
    
            $stmt->execute();
    
            return $response->withJson(['message' => 'created successfully']);
        
        } else{
            return $response->withJson(['message' => 'failed']);
            
        }
    }catch(Exception $error){
        return $response->withJson(['message' => 'something went wrong']);
    }
    
});

// READ (To be updated)
$app->get('/profile', function($request, $response, $args) use ($db){
    try{
        $conn = $db->connect();

        $sql = 'SELECT * FROM user WHERE userId = 1';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $profile = $stmt->fetch(PDO::FETCH_ASSOC);

        return $response->withJson(["profile" => $profile]);
    }catch(Exception $e){
        return $response->withJson(["error" => "Error: " . $e->getMessage()]);
    }
});


// Password
// UPDATE
$app->post('/resetPwd', function($request, $response, $args) use ($db){
    $conn = $db->connect();
    $input = $request->getParsedBody();

    $email = $input['email'] ?? '';
    $plainPassword = $input['password'] ?? '';

    // Hash the password
    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

    // Update the database with the hashed password
    $stmt = $conn->prepare("UPDATE user SET pwd = :pwd WHERE email = :email");
    $stmt->execute(['pwd' => $hashedPassword, 'email' => $email]);

    echo 'Password updated successfully.';
});

// Profile
// UPDATE
$app->put('/profile/{id}/update', function($request, $response, $args) use ($db){
    $profileId = $args['id'];

    try {
        $conn = $db->connect();
        $data = $request->getParsedBody();

        $sql = 'UPDATE user SET email=:email, username=:username, fullName=:fullName, phoneNo=:phoneNo  WHERE userId = :userId';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':fullName', $data['fullName']);
        $stmt->bindParam(':phoneNo', $data['phoneNo']);
        $stmt->bindParam(':userId', $profileId, PDO::PARAM_INT);
        $stmt->execute();

        return $response->withJson(['success' => true]);
    } catch(Exception $e) {
        return $response->withJson(["error" => "Error: " . $e->getMessage()], 500);
    }
});

// Categories
// READ
$app->get('/categories', function($request, $response, $args) use ($db){
    try{
        $conn = $db->connect();

        // Fetch categories
        $sqlCategories = 'SELECT * FROM category';
        $stmtCategories = $conn->prepare($sqlCategories);
        $stmtCategories->execute();
        $categories = $stmtCategories->fetchAll(PDO::FETCH_ASSOC);

        // Fetch slangs
        $sqlSlangs = 'SELECT * FROM slang';
        $stmtSlangs = $conn->prepare($sqlSlangs);
        $stmtSlangs->execute();
        $slangs = $stmtSlangs->fetchAll(PDO::FETCH_ASSOC);

        // Group slangs by categoryId
        $result = [];
        foreach ($categories as $category) {
            $categoryId = $category['categoryId'];
            $result[] = [
                'categoryId' => $categoryId,
                'title' => $category['title'],
                'slangTerms' => array_filter($slangs, function($slang) use ($categoryId) {
                    return $slang['categoryId'] == $categoryId;
                })
            ];
        }

        return $response->withJson($result);
    }catch(Exception $e){
        return $response->withJson(["error" => "Error: " . $e->getMessage()]);
    }
});

// Slangs
// READ
$app->get('/slangs', function($request, $response, $args) use ($db){
    try{
        $conn = $db->connect();

        $sqlSlangs = 'SELECT * FROM slang';
        $stmtSlangs = $conn->prepare($sqlSlangs);
        $stmtSlangs->execute();
        $slangs = $stmtSlangs->fetchAll(PDO::FETCH_ASSOC);

        return $response->withJson(["slangs" => $slangs]);
    }catch(Exception $e){
        return $response->withJson(["error" => "Error: " . $e->getMessage()]);
    }
});

$app->get('/slangs/category', function($request, $response, $args) use ($db){
    try{
        $conn = $db->connect();

        $sqlCategories = 'SELECT * FROM category';
        $stmtCategories = $conn->prepare($sqlCategories);
        $stmtCategories->execute();
        $categories = $stmtCategories->fetchAll(PDO::FETCH_ASSOC);

        return $response->withJson(["categories" => $categories]);
    }catch(Exception $e){
        return $response->withJson(["error" => "Error: " . $e->getMessage()]);
    }
});

// CREATE
$app->post('/slangs/create', function($request, $response, $args) use ($db){
    try {
        $conn = $db->connect();
        $data = $request->getParsedBody();

        $sql = 'INSERT INTO slang (word, meaning, example, lastUpdated, categoryId) VALUES (:word, :meaning, :example, :lastUpdated, :categoryId)';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':word', $data['word']);
        $stmt->bindParam(':meaning', $data['meaning']);
        $stmt->bindParam(':example', $data['example']);
        $stmt->bindParam(':lastUpdated', $data['lastUpdated']);
        $stmt->bindParam(':categoryId', $data['categoryId']);
        $stmt->execute();

        return $response->withJson(['success' => true]);
    } catch(Exception $e) {
        return $response->withJson(["error" => "Error: " . $e->getMessage()], 500);
    }
});

// UPDATE
$app->get('/slangs/{id}', function($request, $response, $args) use ($db) {
    $slangId = $args['id'];

    try {
        $conn = $db->connect();

        $sqlSlang = 'SELECT * FROM slang WHERE slangId = :slangId';
        $stmtSlang = $conn->prepare($sqlSlang);
        $stmtSlang->bindParam(':slangId', $slangId, PDO::PARAM_INT);
        $stmtSlang->execute();
        $slang = $stmtSlang->fetch(PDO::FETCH_ASSOC);

        if ($slang) {
            return $response->withJson($slang);
        } else {
            return $response->withJson(["error" => "Slang not found"], 404);
        }
    } catch(Exception $e) {
        return $response->withJson(["error" => "Error: " . $e->getMessage()]);
    }
});

$app->put('/slangs/{id}/update', function($request, $response, $args) use ($db){
    $slangId = $args['id'];

    try {
        $conn = $db->connect();
        $data = $request->getParsedBody();

        $sql = 'UPDATE slang SET word=:word, meaning=:meaning, example=:example, lastUpdated=:lastUpdated, categoryId=:categoryId WHERE slangId=:slangId';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':word', $data['word']);
        $stmt->bindParam(':meaning', $data['meaning']);
        $stmt->bindParam(':example', $data['example']);
        $stmt->bindParam(':lastUpdated', $data['lastUpdated']);
        $stmt->bindParam(':categoryId', $data['categoryId']);
        $stmt->bindParam(':slangId', $slangId, PDO::PARAM_INT);

        $stmt->execute();

        return $response->withJson(['success' => true]);
    } catch(Exception $e) {
        return $response->withJson(["error" => "Error: " . $e->getMessage()], 500);
    }
});

// DELETE
$app->delete('/slangs/{id}/delete', function($request, $response, $args) use ($db) {
    $slangId = $args['id'];

    try {
        $conn = $db->connect();
 
        $sql = 'DELETE FROM slang WHERE slangId = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $slangId, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            return $response->withJson(['message' => 'Slang deleted successfully'], 200);
        } else {
            return $response->withJson(['message' => 'No slang found with that ID'], 404);
        }
    } catch (Exception $e) {
        return $response->withJson(['error' => 'Error: ' . $e->getMessage()], 500);
    }
});

$app->run();