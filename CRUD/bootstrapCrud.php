<?php
$serverName = "localhost";
$userName = "youtuber";
$password = "123456";
$database = "youtuber";

$connection = new mysqli($serverName, $userName, $password, $database);
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <title>Hello, world!</title>
</head>
<body class="container-fluid">
<h1> Bootstrap 5.0 to Web API ? </h1>
<br/>
<?php $value = filter_input(INPUT_GET, "notification");
$string = "";
switch ($value) {
    case "createSuccess":
        $string = "You have create a record";
        break;
    case "updateSuccess":
        $string = "You have updated a record";
        break;
    case "deleteSuccess":
        $string = "You have delete a record";
        break;
}
if (strlen($string) > 0) {
    ?>
    <div class="alert alert-primary" role="alert">
        <?php echo $string; ?>
    </div>
<?php } ?>
<table class="table table-striped">
    <thead class="table-light">
    <tr>
        <th>#</th>
        <td>
            <input class="form-control" id="name" type="text"/>
        </td>
        <td>
            <input style="text-align: right" class="form-control" id="age" type="text"/>
        </td>
        <td>
            <button type="button" class="btn btn-success" onclick="createRecord()">
                <i class="bi bi-plus-circle"></i>
                NEW
            </button>
        </td>
    </tr>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">NAME</th>
        <th scope="col">AGE</th>
        <th scope="col">ACTION</th>
    </tr>
    </thead>
    <tbody>

    <?php $SQL = "SELECT * FROM person";
    $result = $connection->query($SQL);
    while (($row = $result->fetch_assoc()) == TRUE) { ?>
        <tr>
            <th scope="row">
                <?php echo $row["personId"]; ?>
            </th>
            <td>
                <input class="form-control" id="<?php echo $row["personId"]; ?>_name" type="text"
                       value="<?php echo $row["name"]; ?>"/>
            </td>
            <td>
                <input style="text-align: right" class="form-control" id="<?php echo $row["personId"]; ?>_age"
                       type="text" value="<?php echo $row["age"]; ?>"/>
            </td>
            <td>
                <div class="btn-group" role="group" aria-label="Form Button"
                     onclick="updateRecord(<?php echo $row["personId"]; ?>)">
                    <button type="button" class="btn btn-warning">
                        <i class="bi bi-file-earmark-text"></i>
                        UPDATE
                    </button>
                    <button type="button" class="btn btn-danger"
                            onclick="deleteRecord(<?php echo $row["personId"]; ?>)">
                        <i class="bi bi-trash"></i>
                        DELETE
                    </button>
                </div
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script>
    // at here we try to be native as possible and you can use url to ease change the which one you prefer
    let url = "simple_oop_proper.php";

    function createRecord() {
        const xmlHttpRequest = new XMLHttpRequest();
        xmlHttpRequest.open("POST", url);
        xmlHttpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlHttpRequest.onreadystatechange = function () {
            if (xmlHttpRequest.readyState === 4) {
                if (xmlHttpRequest.status === 200) {
                    console.log("Request 200 : " + xmlHttpRequest.responseText)
                    const obj = JSON.parse(xmlHttpRequest.responseText);
                    if (obj.code === 101) {
                        console.log("Create Success")
                          window.location.href = "<?php echo $_SERVER["PHP_SELF"]; ?>?notification=createSuccess";
                    } else {
                        // popup saying error
                        console.log("error message : " + obj.message + "Error Code : " + obj.code)
                    }
                } else {
                    console.log("Error", xmlHttpRequest.statusText);
                }
            }
        }
        xmlHttpRequest.send("&mode=create&name=" + document.getElementById("name").value + "&age=" + document.getElementById("age").value);

    }

    function updateRecord(personId) {
        const xmlHttpRequest = new XMLHttpRequest();
        xmlHttpRequest.open("POST", url);
        xmlHttpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlHttpRequest.onreadystatechange = function () {
            if (xmlHttpRequest.readyState === 4) {
                if (xmlHttpRequest.status === 200) {
                    console.log("Request 200 : " + xmlHttpRequest.responseText)
                    const obj = JSON.parse(xmlHttpRequest.responseText);
                    if (obj.code === 301) {
                        console.log("Update Success")
                        window.location.href = "<?php echo $_SERVER["PHP_SELF"]; ?>?notification=updateSuccess";
                    } else {
                        // popup saying error
                        console.log("error message : " + obj.message + "Error Code : " + obj.code)
                    }

                } else {
                    console.log("Error", xmlHttpRequest.statusText);
                }
            }
        }
        xmlHttpRequest.send("&mode=update&&personId=" + personId + "&name=" + document.getElementById(personId + "_name").value + "&age=" + document.getElementById(personId + "_age").value);

    }

    function deleteRecord(personId) {
        const xmlHttpRequest = new XMLHttpRequest();
        xmlHttpRequest.open("POST", url);
        xmlHttpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlHttpRequest.onreadystatechange = function () {
            if (xmlHttpRequest.readyState === 4) {
                if (xmlHttpRequest.status === 200) {
                    console.log("Request 200 : " + xmlHttpRequest.responseText)
                    const obj = JSON.parse(xmlHttpRequest.responseText);
                    if (obj.code === 401) {
                        console.log("Delete Success")
                        window.location.href = "<?php echo $_SERVER["PHP_SELF"]; ?>?notification=deleteSuccess";
                    } else {
                        // popup saying error
                        console.log("error message : " + obj.message + "Error Code : " + obj.code)
                    }
                } else {
                    console.log("Error", xmlHttpRequest.statusText);
                }
            }
        }
        xmlHttpRequest.send("&mode=delete&personId=" + personId);

    }
</script>
</body>
</html>