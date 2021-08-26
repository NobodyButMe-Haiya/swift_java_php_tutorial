using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Http;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Configuration;

// For more information on enabling Web API for empty projects, visit https://go.microsoft.com/fwlink/?LinkID=397860

namespace YoutubeCrud.Controllers
{
    [Route("api/[controller]")]
    public class ValuesController : Controller
    {
        public IConfiguration _configuration;
        public ValuesController(IConfiguration configuration)
        {
            _configuration = configuration;
        }

        // GET: api/values
        //https://localhost:5001/api/values?mode=hack&joke=takkira
        // tutorial said mvc cannot be use old QueryString And Form.. not .. We do our own way :p
        [HttpGet]
        public ActionResult Get()
        {
            bool status = false;
            List<PersonModel> data = new();

            string mode = Request.Query["mode_get"];
            string code;
            if (mode == "read")
            {
                try
                {
                    Crud crud = new(_configuration.GetSection("ConnectionStrings:DefaultConnection").Value);
                    data = crud.Read();
                    code = ReturnCode.READ_SUCCESS.ToString();
                    status = true;
                }
                catch (Exception ex)
                {
                    code = ex.Message;
                }
            }
            else
            {
                code = ReturnCode.QUERY_FAILURE.ToString();
                status = false;
            }
            // it will return json charp enum bugs
            int code_return = Convert.ToInt32(code);
            return Ok(new { status, code = code_return, data = data });
        }

        // POST: api/values
        //https://localhost:5001/api/values

        [HttpPost]
        public ActionResult Post()
        {

            bool status = false;
            List<PersonModel> data = new();

            string mode = Request.Form["mode"];

            var name = Request.Form["name"];
            var age = Request.Form["age"];
            var personId = Request.Form["personId"];

            string code;
            Crud crud = new(_configuration.GetSection("ConnectionStrings:DefaultConnection").Value);

            switch (mode)
            {
                case "create":
                    try
                    {
                        crud.Create(name, Convert.ToInt32(age));
                        // if direct it will output string lol
                        code = ((int)ReturnCode.CREATE_SUCCESS).ToString();
                        status = true;
                    }
                    catch (Exception ex)
                    {
                        code = ex.Message;
                    }
                    break;
                case "read":
                    try
                    {
                        data = crud.Read();
                        code = ((int)ReturnCode.READ_SUCCESS).ToString();
                        status = true;
                    }
                    catch (Exception ex)
                    {
                        code = ex.Message;
                    }
                    break;
                case "update":
                    try
                    {
                        crud.Update(name, Convert.ToInt32(age), Convert.ToInt32(personId));
                        code = ((int)ReturnCode.UPDATE_SUCCESS).ToString();
                        status = true;
                    }
                    catch (Exception ex)
                    {
                        code = ex.Message;
                    }
                    break;
                case "delete":
                    try
                    {
                        crud.Delete(Convert.ToInt32(personId));
                        code = ((int)ReturnCode.DELETE_SUCCESS).ToString();
                        status = true;
                    }
                    catch (Exception ex)
                    {
                        code = ex.Message;
                    }
                    break;
                default:
                    code = ((int)ReturnCode.ACCESS_DENIED_NO_MODE).ToString();
                    status = false;
                    break;
            }
            int code_return;
            bool success = int.TryParse(code, out code_return);
            if (!success)
            {
                // server error
                code_return = 500;
            }
            return Ok(new { status, code = code_return, data = data });
        }
    }
}
