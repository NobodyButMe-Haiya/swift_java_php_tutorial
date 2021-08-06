<?php


class personTable
{
    // you can separate the value and call
    /**
     * @var int
     */
    private $personId;
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $age;

    /**
     * @return int
     */
    public function getPersonId(): int
    {
        return $this->personId;
    }

    /**
     * @param int $personId
     * @return personTable
     */
    public function setPersonId(int $personId): personTable
    {
        $this->personId = $personId;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return personTable
     */
    public function setName(string $name): personTable
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     * @return personTable
     */
    public function setAge(int $age): personTable
    {
        $this->age = $age;
        return $this;
    }

}

// somebody will start thinking . what if we can extend personTable and database configuration same time . C ++ allowed it  but
// not php not java  not c sharp. sometimes people will use interface and do injection .
class SimpleOop extends personTable
{
    private $serverName;
    private $userName;
    private $password;
    private $database;
    /**
     * @var mysqli
     */
    private $connection;

    /**
     * SimpleOop constructor.
     */
    function __construct()
    {
        // init value , this may diff with your setup. the proper is to create a file outside from the www folder so outsider
        // cannot get access to the file .
        $this->serverName = "localhost";
        $this->userName = "youtuber";
        $this->password = "123456";
        $this->database = "youtuber";
        $this->connect();

        // since the scalar is really strict
        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
        $age = filter_input(INPUT_POST, "age", FILTER_SANITIZE_NUMBER_INT);
        $personId = filter_input(INPUT_POST, "personId", FILTER_SANITIZE_NUMBER_INT);

        if ($name && strlen($name) > 0) {
            $this->setName($name);
        }
        if ($age && is_numeric($age)) {
            $this->setAge($age);
        }
        if ($personId && is_numeric($personId)) {
            $this->setPersonId($personId);
        }
    }

    /**
     * Connection to the database
     */
    function connect()
    {
        $this->connection = new mysqli($this->serverName, $this->userName, $this->password, $this->database);
    }

    /**
     * @throws Exception
     */
    function create()
    {
        $this->connection->autocommit(false);

        // bind parameter required parameter not object value kinda weird
        $var1 = $this->getName();
        $var2 = $this->getAge();

        if (strlen($var1) > 0 && $var2 > 0) {
            /// but somebody still scares if the value is not correct or idiom sql injection
            $statement = $this->connection->prepare("INSERT INTO person VALUES (null,?, ?)");
            // s -> string, i -> integer , d -  double , b - blob
            $statement->bind_param("si", $var1, $var2);
            try {
                $statement->execute();
            } catch (Exception $exception) {
                throw new Exception("Query Record Failed");
            }

            $this->connection->commit();
            echo json_encode(
                [
                    "success" => true,
                    "message" => "Query Record work !"
                ]
            );

        } else {
            throw new Exception("Access Denied");
        }
    }

    /**
     * @throws Exception
     */
    function read()
    {
        // you don't need to commit work here ya !
        try {
            $result = $this->connection->query("SELECT * FROM person");
            $data = [];
            while (($row = $result->fetch_assoc()) == TRUE) {
                $data[] = $row;
            }
            echo json_encode(
                [
                    "success" => true,
                    "message" => "Read",
                    "data" => $data
                ]
            );
        }catch (Exception $exception){
            throw new Exception("Cannot read query");
        }
    }

    /**
     * @throws Exception
     */
    function update()
    {
        $this->connection->autocommit(false);

        // bind parameter required parameter not object value kinda weird
        $var1 = $this->getName();
        $var2 = $this->getAge();
        $var3 = $this->getPersonId();

        if (strlen($var1) > 0 && $var2 > 0 && $var3 > 0) {
            /// but somebody still scares if the value is not correct or idiom sql injection
            $statement = $this->connection->prepare("UPDATE person SET name=?,age=? WHERE  personId = ?");
            // s -> string, i -> integer , d -  double , b - blob
            $statement->bind_param("sii", $var1, $var2, $var3);
            try {
                $statement->execute();
            } catch (Exception $exception) {
                throw new Exception("Query Record Failed");
            }

            $this->connection->commit();
            echo json_encode(
                [
                    "success" => true,
                    "message" => "Query Update work !"
                ]
            );

        } else {
            throw new Exception("Access Denied");
        }
    }

    /**
     * @throws Exception
     */
    function delete()
    {
        $this->connection->autocommit(false);

        // bind parameter required parameter not object value kinda weird
        $var1 = $this->getPersonId();

        if ($var1 > 0) {
            /// but somebody still scares if the value is not correct or idiom sql injection
            /// the proper is not delete the record but flag it
            $statement = $this->connection->prepare("DELETE FROM person WHERE personId = ? ");
            // s -> string, i -> integer , d -  double , b - blob
            $statement->bind_param("i", $var1);
            try {
                $statement->execute();
            } catch (Exception $exception) {
                throw new Exception("Query Record Failed");
            }

            $this->connection->commit();
            echo json_encode(
                [
                    "success" => true,
                    "message" => "Query Delete work !"
                ]
            );

        } else {
            throw new Exception("Access Denied");
        }
    }
}

header('Content-Type: application/json');

$mode = filter_input(INPUT_POST, "mode", FILTER_SANITIZE_STRING);

$simpleOop = new SimpleOop();
try {
    switch ($mode) {
        case  "create":
            $simpleOop->create();
            break;
        case  "read":
            $simpleOop->read();
            break;
        case  "update":
            $simpleOop->update();
            break;
        case  "delete":
            $simpleOop->delete();
            break;
        default:
            throw new Exception("Cannot identified mode");
    }
} catch (Exception $exception) {
    echo json_encode([
        "success" => false,
        "message" => $exception->getMessage()
    ]);
}