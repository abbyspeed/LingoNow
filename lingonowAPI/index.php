<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

require 'vendor/autoload.php';
require_once './dbconnect.php';

$app = new \Slim\App;
$db = new db();

$app->get('/', function(){
    echo("Hello from root folder");
});

$app->get('/users', function($request, $response, $args){
    $name = $args['name'];
    echo 'Hello' .$name;
});

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

$app->get('/Categories', function($request, $response, $args) use ($db){
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

$app->get('/Slangs', function($request, $response, $args) use ($db){
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

$app->get('/category', function($request, $response, $args) use ($db){
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

$app->post('/Create', function($request, $response, $args) use ($db){
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

$app->run();