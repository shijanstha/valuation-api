<?php

class ContactUs
{

    // database connection and table name
    private $conn;
    private $table_name = "contact_us";

    // object properties
    public $id;
    public $name;
    public $email;
    public $contact_no;
    public $message;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function getAllContactUs()
    {
        $query = "SELECT * FROM
                " . $this->table_name . " 
            ORDER BY
                id";
        
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function createContactUs()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET
                    name = :name, 
                    email = :email, 
                    contact_no = :contact_no,
                    message = :message
                    ";

        $stmt = $this->conn->prepare($query);

        //sanitizing for sql injection
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->contact_no = htmlspecialchars(strip_tags($this->contact_no));
        $this->message = htmlspecialchars(strip_tags($this->message));

        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":contact_no", $this->contact_no);
        $stmt->bindParam(":message", $this->message);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function fetchContactUs()
    {
        $query = "SELECT * FROM " . $this->table_name . " 
                        where id = ?
                        LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->name = $row['name'];
        $this->email = $row['email'];
        $this->contact_no = $row['contact_no'];
        $this->message = $row['message'];
        $this->id = $row['id'];
    }

    function update()
    {
        $query = "UPDATE " . $this->table_name . "
                    SET
                        name = :name,
                        email = :email,
                        contact_no = :contact_no,
                        message = :message
                    WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->contact_no = htmlspecialchars(strip_tags($this->contact_no));
        $this->message = htmlspecialchars(strip_tags($this->message));

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':contact_no', $this->contact_no);
        $stmt->bindParam(':message', $this->message);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind id of record to delete
        $stmt->bindParam(1, $this->id);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}

?>