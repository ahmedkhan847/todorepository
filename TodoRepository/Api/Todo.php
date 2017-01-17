<?php
namespace TodoRepository\Api;

class Todo
{
   protected $db = NULL;

   public function __construct(Db\Connection $db) {
      $this->db = $db;
   }

   public function createTodo($todo, $cat, $desc) {
      try {
         $con = $this->db->conn();
         $stmt = $con->prepare(
            "INSERT INTO todo(todo, category, description) 
            VALUES (?,?,?)"
         );
         $stmt->bind_param("sss", $todo, $cat, $desc);
         $result = $stmt->execute();
         if (!$result) {
            $sql = $con->error;
            throw new \Exception($sql);
         }
         $this->db->close();
         return true;
      } catch (\Exception $e) {
         return $this->ErrorHandling($e);
      }
   }

   public function getAllTodo() {
      $result = $this->db->conn()
              ->query("SELECT * FROM todo");

      if (!$result) {
         $error = $this->db->error;
         throw new \Exception($error);
      }
      $this->db->close();
      return $result;
   }

   public function getTodo($id) {
      try {
         $con = $this->db->conn();
         $stmt = $con->prepare(
            "SELECT * FROM todo WHERE id = ?"
         );
         $stmt->bind_param("i", $id);
         $result = $stmt->execute();
         if (!$result) {
            throw new \Exception($con->error);
         }

         $result = $stmt->get_result();
         $item = $result->fetch_assoc();
         $this->db->close();
         return $item;
      } catch (\Exception $e) {
         return $this->ErrorHandling($e);
      }
   }

   public function updateTodo($todo, $cat, $desc, $id) {
      try {
         $con = $this->db->conn();
         $stmt = $con->prepare(
            "UPDATE todo SET todo=?,category=?,description=? 
             WHERE id=  ?");
         $stmt->bind_param("sssi", $todo, $cat, $desc, $id);
         $result = $stmt->execute();
         if (!$result) {
            throw new \Exception($con->error);
         }
         return $result;
      } catch (\Exception $e) {
         return $this->ErrorHandling($e);
      }
   }

   public function delTodo($id) {
      try {
         $con  = $this->db->open();
         $stmt = $con->prepare(
            "DELETE FROM `todo` WHERE id=?"
         );
         $stmt->bind_param("i", $id);
         $result = $stmt->execute();
         if (!$result) {
            throw new \Exception($con->error);
         }
         $this->db->close();
         return $result;
      } catch (\Exception $e) {
         return $this->ErrorHandling($e);
      }
   }

   function ErrorHandling($e) {
      $this->db->close();
      $sql = $e->getMessage();
      return $sql;
   }
}