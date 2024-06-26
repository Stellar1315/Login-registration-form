<?php
session_start();

function connectToDatabase() //connecting to database
{
    $hostname = "localhost"; //change these to connect to your own database
    $username = "root";
    $password = "";
    $database = "login/register";

    $connection = null;
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    try {
        $connection = mysqli_connect($hostname, $username, $password, $database);
        mysqli_set_charset($connection, 'latin1');
        $databaseAvailable = true;
    } catch (mysqli_sql_exception $e) {
        $databaseAvailable = false;
    }
    if (!$databaseAvailable) {
        ?><h2>Database not found</h2><?php
        die();
    }
    return $connection;
}
function checkEmailAvailability($email, $database) //checking if email is unique
{
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($database, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    $stmt->execute();
    $result = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (! empty($result)){
        return false;
    }
    else{
        return true;
    }
}
function checkUsernameAvailability($username, $database) // checking if username is unique
{
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($database, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    $stmt->execute();
    $result = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (! empty($result)){
        return false;
    }
    else{
        return true;
    }
}
function getUserByID($id, $database) //get info of the user with unique id
{
    $sql = sprintf("SELECT * FROM users WHERE user_id = $id");
    $result = $database->query($sql);
    $userinfo = $result->fetch_assoc();
    return $userinfo;
}
?>
