using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Http;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Configuration;

// For more information on enabling Web API for empty projects, visit https://go.microsoft.com/fwlink/?LinkID=397860

namespace sharp_crud
{

    [Route("api/[controller]")]
    public class ValuesController : Controller
    {
        public IConfiguration _configuration;
        public ValuesController(IConfiguration configuration)
        {
            _configuration = configuration;
        }
        public IActionResult Create()
        {
            var name = Request.Form["name"];
            var age = Request.Form["age"];
            var method = Request.Form["method"];

            string status = "";
            string code = "";
            if (method == "create") {
                Crud crud = new(_configuration.GetSection("ConnectionStrings:DefaultConnection").Value);
                string[] x = crud.Create(name,Convert.ToInt32(age)).Split("|");
                status = x[0];
                code = x[1];
            }
            else
            {
                status = "false";
                code = "later enum";
            }
            return Ok(new { status, code = code  });
        }
        public IActionResult Read()
        {
            var method = Request.Form["method"];

            string status = "";
            string code = "";
            if (method == "read")
            {
                Crud crud = new(_configuration.GetSection("ConnectionStrings:DefaultConnection").Value);
                string[] x = crud.Read().Split("|");
                status = x[0];
                code = x[1];
            }
            else
            {
                status = "false";
                code = "later enum";
            }
            return Ok(new { status, code = code });
        }
        public IActionResult Update()
        {
            var name = Request.Form["name"];
            var age = Request.Form["age"];
            var personId = Request.Form["personId"];
            var method = Request.Form["method"];

            string status = "";
            string code = "";
            if (method == "update")
            {
                Crud crud = new(_configuration.GetSection("ConnectionStrings:DefaultConnection").Value);
                string[] x = crud.Update(name, Convert.ToInt32(age),Convert.ToInt32(personId)).Split("|");
                status = x[0];
                code = x[1];
            }
            else
            {
                status = "false";
                code = "later enum";
            }
            return Ok(new { status = status, code = code });
        }
        public IActionResult Delete()
        {
            var personId = Request.Form["personId"];
            var method = Request.Form["method"];

            string status = "";
            string code;
            if (method == "delete")
            {
                Crud crud = new(_configuration.GetSection("ConnectionStrings:DefaultConnection").Value);
                string[] x = crud.Delete(Convert.ToInt32(personId)).Split("|");
                status = x[0];
                code = x[1];
            }
            else
            {
                status = "false";
                code = "later enum";
            }
            return Ok(new { status, code = code });
        }
    }
}
