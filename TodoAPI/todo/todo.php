<?php
namespace TodoRepository;

class TODO
{

    protected $db = null;

    public function __construct()
    {

        $this->db = new db\Connection();

    }

    public function createtodo($todo, $cat, $desc)
    {
        $con     = $this->db->OpenCon();
        $sql = true;

        $stmt = $con->prepare("INSERT INTO todo(todo, category, description) VALUES (?,?,?)");
        $stmt->bind_param("sss", $todo,$cat,$desc);
        $result = $stmt->execute();
        if (!$result) {
            $sql = $con->error;
        }

        return $sql;
    }

    public function getAllTodo($limit,$offset)
    {
        $con = $this->db->OpenCon();
        $stmt   = "SELECT * FROM todo LIMIT $limit OFFSET $offset";
        if($limit == 0){

            $stmt   = "SELECT * FROM todo";
        }
        $sql    = true;
        $result = $con->query($stmt);
        if (!$result) {

           $sql = $con->error;
        }
        else{
        	$sql = $result;
        }
        $this->db->CloseCon();

        return $sql;

    }

    public function getTodo($id)
    {
        $con = $this->db->OpenCon();

        $todoid   = $con->real_escape_string($id);
        $stmt   = "SELECT * FROM todo WHERE id = $todoid";
        $sql    = true;
        $result = $con->query($stmt);

        if ($result->num_rows == 1) {

            $sql = $result;
        }
        $this->db->CloseCon();

        return $sql;

    }

    public function updateTodo($todos, $cat, $desc, $id)
    {
        $con   = $this->db->OpenCon();
        $sql = true;
        $stmt = $con->prepare("UPDATE todo SET todo=?,category=?,description=? WHERE id=  ?");
        $stmt->bind_param("sssi", $todo,$category,$desc,$todoid);
        $result = $stmt->execute();
        if (!$result) {
            $sql = $con->error;
        }

        return $sql;
    }

    public function delTodo($id)
    {
        $con = $this->db->OpenCon();
        $sql    = true;
        $stmt = $con->prepare("DELETE FROM `todo` WHERE id=  ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        if (!$result) {
            $sql = $con->error;
        }
        $this->db->CloseCon();
        return $sql;

    }
    public function CountTodo()
    {
         
        $con = $this->db->OpenCon();
        $stmt   = "SELECT COUNT(*) as rows FROM `todo`";
        $sql    = true;
        $result = $con->query($stmt);

        if (!$result) {
            $sql = $con->error;
        } else{

            $row = $result->fetch_assoc();
            $sql = $row['rows'];
        }

        $this->db->CloseCon();

        return $sql;
    }

}
?>