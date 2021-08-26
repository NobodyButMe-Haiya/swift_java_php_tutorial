@page
@inject Microsoft.Extensions.Configuration.IConfiguration config
@{
    //prevent cache problem
    Random random = new Random();
    int num = random.Next(1000);
    // if everything can be access here awesome.. old days suck
    //Server=localhost;Database=youtuber;Uid=youtuber;Pwd=123456;SSL Mode=None
    var connection = config.GetSection("ConnectionStrings:DefaultConnection").Value;
    List<PersonModel> data = new();
    try
    {
        Crud crud = new(connection);
        data = crud.Read();

    }
    catch (Exception ex)
    {
        System.Diagnostics.Debug.WriteLine(ex.Message);
    }
    var notification = "";

    if (ViewBag.notification != null)
    {
        if (ViewBag.notification.Length > 0)
        {
            notification = ViewBag.notification;
        }
    }
    var stringNotification = "";
    switch (notification)
    {
        case "createSuccess":
            stringNotification = "You have create a record";
            break;
        case "updateSuccess":
            stringNotification = "You have updated a record";
            break;
        case "deleteSuccess":
            stringNotification = "You have delete a record";
            break;
    }
}
@if (stringNotification.Length > 0)
{
    <div class="alert alert-primary" role="alert">
        @stringNotification
    </div>
}

<table class="table table-striped">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <td>
                <input class="form-control" id="name" type="text" />
            </td>
            <td>
                <input style="text-align: right" class="form-control" id="age" type="text" />
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


        @foreach (var item in data)
        {
            <tr>
                <th scope="row">
                    <?php echo $row["personId"]; ?>
                </th>
                <td>
                    <input class="form-control" id="@item.personId-name" type="text"
                           value="@item.name" />
                </td>
                <td>
                    <input style="text-align: right" class="form-control" id="@item.personId-age"
                           type="text" value="@item.age" />
                </td>
                <td>
                    <div class="btn-group" role="group" aria-label="Form Button"
                         >
                        <button type="button" class="btn btn-warning" onclick="updateRecord(@item.personId)">
                            <i class="bi bi-file-earmark-text"></i>
                            UPDATE
                        </button>
                        <button type="button" class="btn btn-danger"
                                onclick="deleteRecord(@item.personId)">
                            <i class="bi bi-trash"></i>
                            DELETE
                        </button>
                    </div>
                </td>
            </tr>
        }
    </tbody>
</table>
<script>// at here we try to be native as possible and you can use url to ease change the which one you prefer
    let url = "https://localhost:5001/api/values"; // api url
    let home = "@Url.RouteUrl(ViewContext.RouteData.Values)";
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
                        location.assign(home + "?notification=createSuccess&rand=@num")
                        return false;
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
                        location.assign(home + "?notification=updateSuccess&rand=@num&date=" + new Date().getTime())
                        return false;
                    } else {
                        // popup saying error
                        console.log("error message : " + obj.message + "Error Code : " + obj.code)
                    }

                } else {
                    console.log("Error", xmlHttpRequest.statusText);
                }
            }
        }
        xmlHttpRequest.send("&mode=update&&personId=" + personId + "&name=" + document.getElementById(personId + "-name").value + "&age=" + document.getElementById(personId + "-age").value);

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
                        location.assign(home + "?miau=1&notification=deleteSuccess&rand=@num")
                        return false;
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

    }</script>