<?php


// Design for results prompt still to be made.
    $title = 'Success';

    require_once 'includes/header.php';
    require_once 'includes/navbar.php';
    require_once 'db/db_config.php';

    try {
        $age =  $_POST['age'];
        $gender = $_POST['gender'];
        $race = $_POST['race'];
        $county = $_POST['county'];
        $role = $_POST['roles'];
        $affected = $_POST['affected'];
        $effect = $_POST['effects'];
        $measures = $_POST['measures'];
        $test = $_POST['test'];
        $howMany = $_POST['howMany'];
        $condition = $_POST['condition'];
        $comments = $_POST['comments'];

        $sql = "INSERT INTO answers (age, gender, race, county, roles, affected, effect, measure, test, howMany, user_condition, comments) 
                VALUES ('$age','$gender','$race','$county','$roles','$affected','$effects','$measures','$test','$howMany','$condition','$comments')";

        $pdo->exec($sql);

        echo "New Record created successfully";   

    }
    catch(PDOException $err) {
        echo "Connection Failed: " . $err->getMessage();
    }



?>


<?php require_once 'includes/footer.php' ?>