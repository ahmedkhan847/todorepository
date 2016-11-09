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
        try{
            $con     = $this->db->OpenCon();
            $sql = true;
            $this->Validation($todo, $cat, $desc);
            $stmt = $con->prepare("INSERT INTO todo(todo, category, description) VALUES (?,?,?)");
            $stmt->bind_param("sss", $todo,$cat,$desc);
            $result = $stmt->execute();
            if (!$result) {
                $sql = $con->error;
                throw new \Exception($sql);
            }
            $this->db->CloseCon();
            return $sql;

        } 
        catch(\Exception $e){
            return $this->ErrorHandling($e);
        }
        
    }

    public function getAllTodo()
    {
        try{
            $con = $this->db->OpenCon();
            $stmt   = "SELECT * FROM todo";
            
            $sql    = true;
            $result = $con->query($stmt);
            if (!$result) {

            $sql = $con->error;
            throw new \Exception($sql);
            }
            $sql = $result;
            
            $this->db->CloseCon();

            return $sql;
        }
        catch(\Exception $e){
            return $this->ErrorHandling($e);
        }
        

    }

    public function getTodo($id)
    {
        try{
            $con = $this->db->OpenCon();

            $todoid   = $con->real_escape_string($id);
            $stmt   = "SELECT * FROM todo WHERE id = $todoid";
            $sql    = true;
            $result = $con->query($stmt);
            if(!$result){
                $sql = $con->error;
                throw new \Exception($sql);
            }
            $sql = $result;
            $this->db->CloseCon();

            return $sql;
        }
        catch(\Exception $e){
            return $this->ErrorHandling($e);
            }
        

    }

    public function updateTodo($todo, $cat, $desc, $id)
    {
        try{
            $con   = $this->db->OpenCon();
            $sql = true;
            $this->Validation($todo, $cat, $desc);
            $stmt = $con->prepare("UPDATE todo SET todo=?,category=?,description=? WHERE id=  ?");
            $stmt->bind_param("sssi", $todo,$category,$desc,$id);
            $result = $stmt->execute();
            if (!$result) {
                $sql = $con->error;
                throw new \Exception($sql);
            }

            return $sql;
        }
        catch(\Exception $e){
            return $this->ErrorHandling($e);
            }
        
    }

    public function delTodo($id)
    {
        try{
            $con = $this->db->OpenCon();
            $sql    = true;
            $stmt = $con->prepare("DELETE FROM `todo` WHERE id=  ?");
            $stmt->bind_param("i", $id);
            $result = $stmt->execute();
            if (!$result) {
                $sql = $con->error;
                throw new \Exception($sql);
            }
            $this->db->CloseCon();
            return $sql;
        }
        catch(\Exception $e){
                return $this->ErrorHandling($e);
            }
        

    }
    function ErrorHandling($e){
            $this->db->CloseCon();
            $sql = $e->getMessage();
            return $sql;
    }

    function Validation($todo, $cat, $desc){
        if(preg_match("/^(\s*|[\"]+)$/",$todo) || preg_match("/^(\s*|[\"]+)$/",$cat) || preg_match("/^(\s*|[\"]+)$/",$desc) ){
            throw new \Exception('Fields Must Contain Proper Values');
        }
    }

}
?>