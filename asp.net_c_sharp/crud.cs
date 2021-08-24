using System;
using System.Collections.Generic;
using MySql.Data.MySqlClient;
using Newtonsoft.Json;

namespace sharp_crud
{
    // kinda lazy to create new file
    public class PersonModel
    {
        public string name { get; set; }
        public string age { get; set; }
        public string personId { get; set; }
    }
    public class Crud
    {
        private string _connectionString { get; set; }
        public Crud(String connectionString)
        {
            _connectionString = connectionString;
        }
        private MySqlConnection GetConnection()
        {
            return new MySqlConnection(_connectionString);
        }
        public string Create(String name, int age)
        {
            String json = "";
            MySqlTransaction transaction = null;
            using(MySqlConnection connection = GetConnection())
            {
                try
                {
                    connection.Open();
                    transaction = connection.BeginTransaction();
                    MySqlCommand command = new MySqlCommand("INSERT INTO person VALUES (null,@name, @age)");
                    command.Parameters.AddWithValue("@name", name);
                    command.Parameters.AddWithValue("@age", age);
                    command.ExecuteNonQuery();
                    transaction.Commit();
                    command.Dispose();
                    json = "Record Inserted";
                }catch(MySqlException ex)
                {
                    json = "success|"+ex.Message;
                }
            }
            return "success|"+json;
        }
        public string Read()
        {
            String json = "";
            List<PersonModel> personModels = new List<PersonModel>();
            using (MySqlConnection connection = GetConnection())
            {
                try
                {
                    connection.Open();

                    MySqlCommand command = new MySqlCommand("select * from person");

                    using (var reader = command.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            personModels.Add(new PersonModel()
                            {
                                name = reader["name"].ToString(),
                                age = reader["age"].ToString(),
                                personId = reader["personId"].ToString()
                            });
                        }

                        // so we convert the object to json string;
                        json = JsonConvert.SerializeObject(personModels);
                    }
                }
                catch (MySqlException ex)
                {
                    json = "success|" + ex.Message;
                }
            }
            return "success|" + json;
        }
        public string Update(string name, int age,int personId)
        {
            String json = "";
            MySqlTransaction transaction = null;
            using (MySqlConnection connection = GetConnection())
            {
                try
                {
                    connection.Open();
                    transaction = connection.BeginTransaction();
                    MySqlCommand command = new MySqlCommand("UPDATE person SET name = ?,age = ? WHERE  personId = ?");

                    command.Parameters.AddWithValue("@name", name);
                    command.Parameters.AddWithValue("@age", age);
                    command.Parameters.AddWithValue("@personId", personId);
                    command.ExecuteNonQuery();
                    transaction.Commit();
                    command.Dispose();
                    json = "Record Updated";
                }
                catch (MySqlException ex)
                {
                    json = "success|" + ex.Message;
                }
            }
            return "success|" + json;
        }
        public string Delete(int personId)
        {
            String json = "";
            MySqlTransaction transaction = null;
            using (MySqlConnection connection = GetConnection())
            {
                try
                {
                    connection.Open();
                    transaction = connection.BeginTransaction();
                    MySqlCommand command = new MySqlCommand("DELETE FROM person WHERE personId = ?");
                    command.Parameters.AddWithValue("@personId", personId);
                    command.ExecuteNonQuery();
                    transaction.Commit();
                    command.Dispose();
                    json = "Record Deleted";
                }
                catch (MySqlException ex)
                {
                    json = "success|" + ex.Message;
                }
            }
            return "success|" + json;
        }
    }
}
