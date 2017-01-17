<?php
namespace TodoRepository\Db;


class Connection
{

    protected $conn = null;
  
    public function __construct($value)
    {

        $this->conn =
         new \mysqli($value['servername'], $value['username'], $value['password'],
            $value['dbname']);

      if ($this->conn->connect_error) {
         throw new \Exception($this->conn->connect_error);
      }

    }
    public function OpenCon()
    {

        

        return $this->conn;

    }

    public function CloseCon()
    {

        $this->conn->close();

    }

}
?>