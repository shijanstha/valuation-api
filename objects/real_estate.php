<?php

class RealEstate
{

    // database connection and table name
    private $conn;
    private $table_name = "real_estate";

    // object properties
    public $re_id;
    public $re_name;
    public $address;
    public $cost;
    public $contact_no;
    public $img_path;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function getAllRealEstate()
    {
        $query = "SELECT * FROM 
                " . $this->table_name . " 
            ORDER BY
                re_id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function createRealEstate()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET
                    re_name = :re_name,
                    address = :address,
                    cost = :cost,
                    contact_no = :contact_no,
                    img_path = :img_path
                    ";

        $stmt = $this->conn->prepare($query);

        //sanitizing for sql injection
        $this->re_name = htmlspecialchars(strip_tags($this->re_name));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->cost = htmlspecialchars(strip_tags($this->cost));
        $this->contact_no = htmlspecialchars(strip_tags($this->contact_no));
        $this->img_path = htmlspecialchars(strip_tags($this->img_path));

        // bind values
        $stmt->bindParam(":re_name", $this->re_name);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":cost", $this->cost);
        $stmt->bindParam(":contact_no", $this->contact_no);
        $stmt->bindParam(":img_path", $this->img_path);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function fetchRealEstate()
    {
        $query = "SELECT * FROM " . $this->table_name . " 
                        where re_id = ?
                        LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->re_id);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->re_id = $row['re_id'];
        $this->re_name = $row['re_name'];
        $this->address = $row['address'];
        $this->cost = $row['cost'];
        $this->contact_no = $row['contact_no'];
        $this->img_path = $row['img_path'];
    }

    function update()
    {
        $query = "UPDATE " . $this->table_name . "
                    SET
                        re_name = :re_name,
                        address = :address,
                        cost = :cost,
                        contact_no = :contact_no,
                        img_path = :img_path

                    WHERE re_id = :re_id";

        $stmt = $this->conn->prepare($query);

        $this->re_id = htmlspecialchars(strip_tags($this->re_id));
        $this->re_name = htmlspecialchars(strip_tags($this->re_name));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->cost = htmlspecialchars(strip_tags($this->cost));
        $this->contact_no = htmlspecialchars(strip_tags($this->contact_no));
        $this->img_path = htmlspecialchars(strip_tags($this->img_path));

        $stmt->bindParam(':re_id', $this->re_id);
        $stmt->bindParam(':re_name', $this->re_name);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':cost', $this->cost);
        $stmt->bindParam(':contact_no', $this->contact_no);
        $stmt->bindParam(':img_path', $this->img_path);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE re_id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->re_id = htmlspecialchars(strip_tags($this->re_id));

        // bind id of record to delete
        $stmt->bindParam(1, $this->re_id);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
