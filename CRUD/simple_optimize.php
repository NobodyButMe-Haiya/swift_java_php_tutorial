<?php
/**
 * Simple CRUD - create read update delete
 * next simple_oop will be structured oop
 * @description
 *
 */

header('Content-Type: application/json');

// parameter database

$serverName = "localhost";
$userName = "youtuber";
$password = "123456";
$database = "youtuber";

$connection = mysqli_connect($serverName, $userName, $password);
$database = mysqli_select_db($connection, $database);

// parameter from outside

$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
$age = filter_input(INPUT_POST, "age", FILTER_SANITIZE_NUMBER_INT);
$personId = filter_input(INPUT_POST, "personId", FILTER_SANITIZE_NUMBER_INT);
$mode = filter_input(INPUT_POST, "mode", FILTER_SANITIZE_STRING);

function access()
{
    global $connection;
    global $database;

    if (!$connection) {
        echo json_encode(
            [
                "success" => false,
                "message" => "Server got connection issue"
            ]
        );
    }
    if (!$database) {
        echo json_encode(
            [
                "success" => false,
                "message" => "Server got database issue"
            ]
        );
    }
    exit();
}

function create()
{
    access();
    global $connection;
    global $name;
    global $age;

    mysqli_autocommit($this->connection,false);
    $passTestName = 0;
    $passTestAge = 0;

    if (is_string($name)) {
        $passTestName = 1;
    }
    // Are the age variable are pure string result ?
    if (is_numeric($age)) {
        $passTestAge = 1;
    }
    if ($passTestName == 1 && $passTestAge == 1) {
        // now we gain access to connection and database. We make query  to insert to database
        /// but somebody still scares if the value is not correct
        $statement = mysqli_prepare($connection, "INSERT INTO person VALUES (?, ?,?)");
        // s -> string, i -> integer , d -  double , b - blob
        mysqli_stmt_bind_param($statement, 'si', $name, $age);
        $statement_result = mysqli_stmt_execute($statement);
        if (!$statement_result) {
            mysqli_commit($this->connection);
            echo json_encode(
                [
                    "success" => false,
                    "message" => "Query Record failed"
                ]
            );
        } else {
            echo json_encode(
                [
                    "success" => true,
                    "message" => "Query Record work !"
                ]
            );
        }
    } else {
        json_encode(
            [
                "success" => false,
                "message" => "Access Denied"
            ]
        );
    }
}

function read()
{
    access();
    global $connection;

    $data = [];
    $sql = "SELECT * FROM person";
    $result = mysqli_query($connection, $sql);
    if (!$result) {
        // something wrong to the query
        echo json_encode(
            [
                "success" => false,
                "message" => "Seem Query Error here"
            ]
        );
    } else {
        // now we generate code for read
        while (($row = mysqli_fetch_array($result)) == TRUE) {
            $data[] = $row;
        }
        echo json_encode(
            [
                "success" => true,
                "message" => "Read",
                "data" => $data
            ]
        );
    }
}

function update()
{
    access();
    global $connection;
    global $name;
    global $age;
    global $personId;

    mysqli_autocommit($this->connection,false);

    $passTestName = 0;
    $passTestAge = 0;

    if (is_string($name)) {
        $passTestName = 1;
    }
    // Are the age variable are pure string result ?
    if (is_numeric($age)) {
        $passTestAge = 1;
    }
    $passTestId = 0;
    if (is_numeric($personId)) {
        $passTestId = 1;
    }
    if ($passTestName == 1 && $passTestAge == 1 && $passTestId == 1) {
        $statement = mysqli_prepare($connection, "UPDATE person SET name=?,age=? WHERE  personId = ?");
        // s -> string, i -> integer , d -  double , b - blob
        mysqli_stmt_bind_param($statement, 'sii', $name, $age,$personId);
        $statement_result = mysqli_stmt_execute($statement);
        if (!$statement_result) {
            mysqli_commit($connection);
            echo json_encode(
                [
                    "success" => false,
                    "message" => "Query Update failed"
                ]
            );
        } else {
            echo json_encode(
                [
                    "success" => true,
                    "message" => "Query Update work !"
                ]
            );
        }
    } else {
        json_encode(
            [
                "success" => false,
                "message" => "Access Denied"
            ]
        );
    }
}

function delete()
{
    access();
    global $connection;
    global $personId;
    // Are the id variable are pure numeric result ?
    $passTestId = 0;
    if (is_numeric($personId)) {
        $passTestId = 1;
    }
    if ($passTestId == 1) {
        // now we gain access to connection and database. We make query  to insert to database
        /// but somebody still scares if the value is not correct
        $statement = mysqli_prepare($connection, "DELETE FROM person WHERE personId = ? ");
        // s -> string, i -> integer , d -  double , b - blob
        mysqli_stmt_bind_param($statement, 'i', $personId);
        $statement_result = mysqli_stmt_execute($statement);
        if (!$statement_result) {
            mysqli_commit($connection);
            echo json_encode(
                [
                    "success" => false,
                    "message" => "Query Delete failed"
                ]
            );
        } else {
            echo json_encode(
                [
                    "success" => true,
                    "message" => "Query Delete work !"
                ]
            );
        }
    } else {
        json_encode(
            [
                "success" => false,
                "message" => "Access Denied"
            ]
        );
    }
}

switch ($mode) {
    case  "create":
        create();
        break;
    case  "read":
        read();
        break;
    case  "update":
        update();
        break;
    case  "delete":
        delete();
        break;
    default:
        echo json_encode([
            "success" => false,
            "message" => "Cannot identified mode"
        ]);

        break;

}

