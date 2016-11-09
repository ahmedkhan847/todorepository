<?php
namespace TodoRepository\db;

include 'config.php';
class Connection
{

    protected $conn = null;
  
    public function OpenCon()
    {

        $this->conn = new \mysqli(servername, username, password, dbname);

        return $this->conn;

    }

    public function CloseCon()
    {

        $this->conn->close();

    }

}
?>