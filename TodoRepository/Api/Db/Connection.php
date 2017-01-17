<?php
namespace TodoRepository\Api\Db;

class Connection
{
   protected $conn = NULL;


   public function __construct($value) {
      $this->conn =
         new \mysqli($value['servername'], $value['username'], $value['password'],
            $value['dbname']);

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