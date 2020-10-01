<?php

class RealEstate
{

    // database connection and table name
    private $conn;
    private $table_name = "real_estate";

    // object properties
    public $re_id;
    public $address;
    public $cost;
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
                    address = :address,
                    cost = :cost,
                    img_path = :img_path
                    ";

        $stmt = $this->conn->prepare($query);

        //sanitizing for sql injection
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->cost = htmlspecialchars(strip_tags($this->cost));
        $this->img_path = htmlspecialchars(strip_tags($this->img_path));

        // bind values
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":cost", $this->cost);
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
        $this->address = $row['address'];
        $this->cost = $row['cost'];
        $this->img_path = $row['img_path'];
    }

    function update()
    {
        $query = "UPDATE " . $this->table_name . "
                    SET
                        address = :address,
                        cost = :cost,
                        img_path = :img_path

                    WHERE re_id = :re_id";

        $stmt = $this->conn->prepare($query);

        $this->re_id = htmlspecialchars(strip_tags($this->re_id));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->cost = htmlspecialchars(strip_tags($this->cost));
        $this->img_path = htmlspecialchars(strip_tags($this->img_path));

        $stmt->bindParam(':re_id', $this->re_id);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':cost', $this->cost);
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
