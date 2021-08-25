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
    public enum ReturnCode
    {
        CONNECTION_ERROR = 100,
        ACCESS_DENIED_NO_MODE = 404,
        ACCESS_DENIED = 500,
        CREATE_SUCCESS = 101,
        READ_SUCCESS = 201,
        UPDATE_SUCCESS = 301,
        DELETE_SUCCESS = 401,
        QUERY_FAILURE = 601
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
        /// <summary>
        /// Create
        /// </summary>
        /// <param name="name"></param>
        /// <param name="age"></param>
        public void Create(String name, int age)
        {
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
                }catch(MySqlException ex)
                {
                    System.Diagnostics.Debug.WriteLine(ex.Message);
                    throw new Exception(ReturnCode.QUERY_FAILURE.ToString());
                }
            }
        }
        /// <summary>
        /// Read
        /// </summary>
        /// <returns></returns>
        public List<PersonModel> Read()
        {
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
                    }
                }
                catch (MySqlException ex)
                {
                    System.Diagnostics.Debug.WriteLine(ex.Message);
                    throw new Exception(ReturnCode.QUERY_FAILURE.ToString());
                }
            }
            return personModels;
        }
        /// <summary>
        /// Update
        /// </summary>
        /// <param name="name"></param>
        /// <param name="age"></param>
        /// <param name="personId"></param>
        public void Update(string name, int age,int personId)
        {
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
                }
                catch (MySqlException ex)
                {
                    System.Diagnostics.Debug.WriteLine(ex.Message);
                    throw new Exception(ReturnCode.QUERY_FAILURE.ToString());
                }
            }
        }
        /// <summary>
        ///  Delete
        /// </summary>
        /// <param name="personId"></param>
        public void Delete(int personId)
        {
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
                }
                catch (MySqlException ex)
                {
                    System.Diagnostics.Debug.WriteLine(ex.Message);
                    throw new Exception(ReturnCode.QUERY_FAILURE.ToString());
                }
            }
        }
    }
}
