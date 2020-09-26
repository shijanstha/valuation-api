<?php

class Employee
{

    // database connection and table name
    private $conn;
    private $table_name = "employee";

    // object properties
    public $employee_id;
    public $employee_name;
    public $position;
    public $contact_no;
    public $email;
    public $type;
    public $img_path;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function fetchAllEmployees()
    {
        $query = "SELECT * FROM " . $this->table_name . "
                    ORDER BY
                        employee_name";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }


    function createEmployee()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET
                    employee_name= :employee_name, position= :position, type = :type,
                    contact_no = :contact_no, email = :email, img_path = :img_path";

        $stmt = $this->conn->prepare($query);


        //sanitizing for sql injection
        $this->employee_name = htmlspecialchars(strip_tags($this->employee_name));
        $this->position = htmlspecialchars(strip_tags($this->position));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->contact_no = htmlspecialchars(strip_tags($this->contact_no));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->img_path = htmlspecialchars(strip_tags($this->img_path));

        // bind values
        $stmt->bindParam(":employee_name", $this->employee_name);
        $stmt->bindParam(":position", $this->position);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":contact_no", $this->contact_no);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":img_path", $this->img_path);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function fetchEmployee()
    {
        $query = "SELECT *       
                        FROM " . $this->table_name . " 
                        where employee_id = ?
                        LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->employee_id);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->employee_id = $row['employee_id'];
        $this->employee_name = $row['employee_name'];
        $this->position = $row['position'];
        $this->type = $row['type'];
        $this->contact_no = $row['contact_no'];
        $this->email = $row['email'];
        $this->img_path = $row['img_path'];
    }

    function update()
    {
        $query = "UPDATE " . $this->table_name . "
                    SET
                        employee_name = :employee_name,
                        position = :position,
                        type = :type,
                        contact_no = :contact_no,
                        email = :email,
                        img_path = :img_path
                    WHERE employee_id = :employee_id";

        $stmt = $this->conn->prepare($query);

        $this->employee_name = htmlspecialchars(strip_tags($this->employee_name));
        $this->position = htmlspecialchars(strip_tags($this->position));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->contact_no = htmlspecialchars(strip_tags($this->contact_no));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->img_path = htmlspecialchars(strip_tags($this->img_path));
        $this->employee_id = htmlspecialchars(strip_tags($this->employee_id));

        $stmt->bindParam(':employee_name', $this->employee_name);
        $stmt->bindParam(':position', $this->position);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':contact_no', $this->contact_no);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':img_path', $this->img_path);
        $stmt->bindParam(':employee_id', $this->employee_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE employee_id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->employee_id = htmlspecialchars(strip_tags($this->employee_id));

        // bind id of record to delete
        $stmt->bindParam(1, $this->employee_id);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}

?>