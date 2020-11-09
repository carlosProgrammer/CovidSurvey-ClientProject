<?php
// PDO Connection

// Database Variables

$username = "cprogrammr"; // Use your own database username => root
$password = "K4m1s4m4$."; // Use your own database password => ''
$db_name = "survey_db";
$db_server_name = "localhost";



// Create the connection

try {
    $pdo = new PDO ("mysql:host=$db_server_name;dbname=$db_name", $username, $password);

    // Set PDO's error mode to exception

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // echo"Connected successfully";

}

catch (PDOException $err) {
    echo "Connection Failed: " . $err->getMessage();

}

// Select statements
$age = "SELECT option_content FROM options WHERE question_id = '1'";
$gender ="SELECT option_content FROM options WHERE question_id = '2'";
$county ="SELECT option_content FROM options WHERE question_id = '4'";
$role = "SELECT option_content FROM options WHERE question_id = '5'";
$affected = "SELECT option_content FROM options WHERE question_id = '6'";
$effect = "SELECT option_content FROM options WHERE question_id = '7'";
$measure = "SELECT option_content FROM options WHERE question_id = '8'";
$test = "SELECT option_content FROM options WHERE question_id = '9'";
$condition = "SELECT option_content FROM options WHERE question_id = '11'";


// Prepare the select statements
$age_stmt = $pdo->prepare($age);
$gender_stmt = $pdo->prepare($gender);
$county_stmt = $pdo->prepare($county);
$role_stmt = $pdo->prepare($role);
$affected_stmt = $pdo->prepare($affected);
$effect_stmt = $pdo->prepare($effect);
$measure_stmt = $pdo->prepare($measure);
$test_stmt = $pdo->prepare($test);
$condition_stmt = $pdo->prepare($condition);

// Execute the stmts
$age_stmt->execute();
$gender_stmt->execute();
$county_stmt->execute();
$role_stmt->execute();
$affected_stmt->execute();
$effect_stmt->execute();
$measure_stmt->execute();
$test_stmt->execute();
$condition_stmt->execute();


// Retrieve the rows using fetchAll

$ages = $age_stmt->fetchAll();
$genders = $gender_stmt->fetchAll();
$counties =$county_stmt ->fetchAll();
$roles = $role_stmt->fetchAll();
$affecteds = $affected_stmt->fetchAll();
$effects = $effect_stmt->fetchAll();
$measures = $measure_stmt->fetchAll();
$tests = $test_stmt->fetchAll();
$conditions = $condition_stmt->fetchAll();

?>