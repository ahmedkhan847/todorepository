<?php
namespace TodoRepository\Api\Db;

class Connection
{
   protected $conn = NULL;


   public function __construct($servername, $username,
                        $password, $dbname) {
      $this->conn =
         new \mysqli($servername, $username, $password,
            $dbname);

      if ($this->conn->connect_error) {
         throw new \Exception($this->conn->connect_error);
      }
   }

   public function conn() {
      return $this->conn;
   }

   public function close() {
      $this->conn->close();
   }
}