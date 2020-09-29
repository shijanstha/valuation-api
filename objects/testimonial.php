<?php

class Testimonial
{

    // database connection and table name
    private $conn;
    private $table_name = "testimonial";

    // object properties
    public $tes_id;
    public $name;
    public $address;
    public $paragraph;
    public $img_path;
    public $status;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function getAllTestimonial()
    {
        $query = "SELECT * FROM
                " . $this->table_name . " 
            ORDER BY
                tes_id";
        
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function getApprovedTestimonials()
    {
        $query = "SELECT * FROM
                " . $this->table_name . " 
            WHERE 
                status = 'AP'
            ORDER BY
                tes_id";
        
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function getPendingTestimonials()
    {
        $query = "SELECT * FROM
                " . $this->table_name . " 
            WHERE 
                status = 'P'
            ORDER BY
                tes_id";
        
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function getRejectedTestimonials()
    {
        $query = "SELECT * FROM
                " . $this->table_name . " 
            WHERE 
                status = 'R'
            ORDER BY
                tes_id";
        
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function createTestimonial()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET
                    name = :name, 
                    address = :address, 
                    paragraph = :paragraph,
                    img_path = :img_path,
                    status = 'P'
                    ";

        $stmt = $this->conn->prepare($query);

        //sanitizing for sql injection
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->paragraph = htmlspecialchars(strip_tags($this->paragraph));
        $this->img_path = htmlspecialchars(strip_tags($this->img_path));

        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":paragraph", $this->paragraph);
        $stmt->bindParam(":img_path", $this->img_path);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function fetchTestimonial()
    {
        $query = "SELECT * FROM " . $this->table_name . " 
                        where tes_id = ?
                        LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->tes_id);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->name = $row['name'];
        $this->address = $row['address'];
        $this->paragraph = $row['paragraph'];
        $this->img_path = $row['img_path'];
        $this->status = $row['status'];
        $this->tes_id = $row['tes_id'];
    }

    function update()
    {
        $query = "UPDATE " . $this->table_name . "
                    SET
                        name = :name,
                        address = :address,
                        paragraph = :paragraph,
                        img_path = :img_path,
                        status = :status
                    WHERE tes_id = :tes_id";

        $stmt = $this->conn->prepare($query);

        $this->tes_id = htmlspecialchars(strip_tags($this->tes_id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->paragraph = htmlspecialchars(strip_tags($this->paragraph));
        $this->img_path = htmlspecialchars(strip_tags($this->img_path));
        $this->status = htmlspecialchars(strip_tags($this->status));

        $stmt->bindParam(':tes_id', $this->tes_id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':paragraph', $this->paragraph);
        $stmt->bindParam(':img_path', $this->img_path);
        $stmt->bindParam(':status', $this->status);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE tes_id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->tes_id = htmlspecialchars(strip_tags($this->tes_id));

        // bind id of record to delete
        $stmt->bindParam(1, $this->tes_id);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}

?>