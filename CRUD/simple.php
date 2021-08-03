<?php
/**
 * Simple CRUD - create read update delete
 * next simple_optimize will shorter all code this all first
 * @description
 *
 */
header('Content-Type: application/json');
$mode = filter_input(INPUT_POST, "mode", FILTER_SANITIZE_STRING);

switch ((string)$mode) {
    case "create":
        // everybody talking about sql injection but reality
        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
        $age = filter_input(INPUT_POST, "age", FILTER_SANITIZE_NUMBER_INT);

        // Are the name is pure string result ?
        $passTestName = 0;
        $passTestAge = 0;
        if (is_string($name)) {
            echo "Yes i'm a string";
            $passTestName = 1;
        }
        // Are the age variable are pure string result ?
        if (is_numeric($age)) {
            echo "Yes i'm numeric";
            $passTestAge = 1;
        }
        if ($passTestName == 1 && $passTestAge == 1) {
            // are we need to cast string before or after (String)  or (Age) ?
            // lets check it via  var dump
            var_dump($name);

            var_dump($age);

            // if we scare we can just cast it

            $name = (string)$name;
            $age = (int)$age;

            // now we connect to our database  and insert record

            $servername = "localhost";
            $username = "username";
            $password = "password";
            $database = "database";

            $connection = mysqli_connect($servername, $username, $password);
            // since it was simple not oop so we catch the error manually
            if (!$connection) {
                echo json_encode(
                    [
                        "success" => false,
                        "message" => "Server got connection issue"
                    ]
                );
            } else {
                // now we have connection , we select the database
                $database = mysqli_select_db($connection, $database);

                // but wait are we want insert record before everything insert
                mysqli_begin_transaction($connection);
                if (!$database) {
                    echo json_encode(
                        [
                            "success" => false,
                            "message" => "Server got database issue"
                        ]
                    );
                    // we don't need amy buffer more . clear em all .
                } else {
                    // now we gain access to connection and database. We make query  to insert to database
                    /// but somebody still scare if the value is not correct
                    $statement = mysqli_prepare($connection, "INSERT INTO person VALUES (?, ?,?)");
                    // s -> string, i -> integer , d -  double , b - blob
                    mysqli_stmt_bind_param($statement, 'si', $name, $age);
                    $statement_result = mysqli_stmt_execute($statement);
                    if (!$statement_result) {
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
                }
            }
            exit();
        } else{
            json_encode(
                [
                    "success"=>false,
                    "message"=>"Access Denied"
                ]
            );
        }

        break;
    case "read":

        $servername = "localhost";
        $username = "username";
        $password = "password";
        $database = "database";

        $connection = mysqli_connect($servername, $username, $password);
        // since it was simple not oop so we catch the error manually
        if (!$connection) {
            echo json_encode(
                [
                    "success" => false,
                    "message" => "Server got connection issue"
                ]
            );
        } else {
            // now we have connection , we select the database
            $database = mysqli_select_db($connection, $database);

            // but wait are we want insert record before everything insert
            if (!$database) {
                echo json_encode(
                    [
                        "success" => false,
                        "message" => "Server got database issue"
                    ]
                );
                // we don't need amy buffer more . clear em all .
            } else {
                // now we gain access to connection and database

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
        }
        break;
    case "update":
        // everybody talking about sql injection but reality
        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
        $age = filter_input(INPUT_POST, "age", FILTER_SANITIZE_NUMBER_INT);
        $personId = filter_input(INPUT_POST, "personId", FILTER_SANITIZE_NUMBER_INT);

        // Are the name is pure string result ?
        $passTestName = 0;
        $passTestAge = 0;
        $passTestId = 0;

        if (is_string($name)) {
            echo "Yes i'm a string";
            $passTestName = 1;
        }
        // Are the age variable are pure int result ?
        if (is_numeric($age)) {
            echo "Yes i'm numeric";
            $passTestAge = 1;
        }

        // Are the id variable are pure int result ?
        if (is_numeric($age)) {
            echo "Yes i'm numeric";
            $passTestAge = 1;
        }

        if ($passTestName == 1 && $passTestAge == 1 && $passTestId == 1) {
            // are we need to cast string before or after (String)  or (Age) ?
            // lets check it via  var dump
            var_dump($name);

            var_dump($age);

            var_dump($personId);

            // if we scare we can just cast it

            $name = (string)$name;
            $age = (int)$age;
            $personId = (int)$personId;

            // now we connect to our database  and insert record

            $servername = "localhost";
            $username = "username";
            $password = "password";
            $database = "database";

            $connection = mysqli_connect($servername, $username, $password);
            // since it was simple not oop so we catch the error manually
            if (!$connection) {
                echo json_encode(
                    [
                        "success" => false,
                        "message" => "Server got connection issue"
                    ]
                );
            } else {
                // now we have connection , we select the database
                $database = mysqli_select_db($connection, $database);

                // but wait are we want insert record before everything insert
                mysqli_begin_transaction($connection);
                if (!$database) {
                    echo json_encode(
                        [
                            "success" => false,
                            "message" => "Server got database issue"
                        ]
                    );
                    // we don't need amy buffer more . clear em all .
                } else {
                    // now we gain access to connection and database. We make query  to insert to database
                    /// but somebody still scare if the value is not correct
                    $statement = mysqli_prepare($connection, "UPDATE person SET name=?,age=? WHERE  personId = ?");
                    // s -> string, i -> integer , d -  double , b - blob
                    mysqli_stmt_bind_param($statement, 'si', $name, $age);
                    $statement_result = mysqli_stmt_execute($statement);
                    if (!$statement_result) {
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
                }
            }
            exit();
        } else{
            json_encode(
                [
                    "success"=>false,
                    "message"=>"Access Denied"
                ]
            );
        }
        break;
    case "delete":
        // everybody talking about sql injection but reality
        $personId = filter_input(INPUT_POST, "personId", FILTER_SANITIZE_NUMBER_INT);

        // Are the id variable are pure numeric result ?
        $passTestId = 0;
        if (is_numeric($personId)) {
            echo "Yes i'm numeric";
            $passTestId = 1;

        }
        if ($passTestId == 1) {
            // are we need to cast string before or after (int) ?
            // lets check it via  var dump
            var_dump($personId);

            // if we scare we can just cast it

            $personId = (int)$personId;

            // now we connect to our database  and insert record

            $servername = "localhost";
            $username = "username";
            $password = "password";
            $database = "database";

            $connection = mysqli_connect($servername, $username, $password);
            // since it was simple not oop so we catch the error manually
            if (!$connection) {
                echo json_encode(
                    [
                        "success" => false,
                        "message" => "Server got connection issue"
                    ]
                );
            } else {
                // now we have connection , we select the database
                $database = mysqli_select_db($connection, $database);

                // but wait are we want insert record before everything insert
                mysqli_begin_transaction($connection);
                if (!$database) {
                    echo json_encode(
                        [
                            "success" => false,
                            "message" => "Server got database issue"
                        ]
                    );
                    // we don't need amy buffer more . clear em all .
                } else {
                    // now we gain access to connection and database. We make query  to insert to database
                    /// but somebody still scare if the value is not correct
                    $statement = mysqli_prepare($connection, "DELETE FROM person WHERE personId = ? ");
                    // s -> string, i -> integer , d -  double , b - blob
                    mysqli_stmt_bind_param($statement, 'i', $personId);
                    $statement_result = mysqli_stmt_execute($statement);
                    if (!$statement_result) {
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
                }
            }
            exit();
        } else{
            json_encode(
                [
                    "success"=>false,
                    "message"=>"Access Denied"
                ]
            );
        }
        break;
    default:
        echo json_encode([
            "success" => false,
            "message" => "Cannot identified mode"
        ]);
        break;
}

