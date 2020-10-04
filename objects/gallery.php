<?php

class Gallery
{

    // database connection and table name
    private $conn;
    private $table_name = "gallery";

    // object properties
    public $img_id;
    public $img_desc;
    public $img_path;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function fetchAllImages()
    {
        $query = "SELECT * FROM " . $this->table_name . "
            ORDER BY
                img_id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function addImageToGallery()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET
                   img_desc = :img_desc, 
                   img_path = :img_path";

        $stmt = $this->conn->prepare($query);

        //sanitizing for sql injection
        $this->img_desc = htmlspecialchars(strip_tags($this->img_desc));
        $this->img_path = htmlspecialchars(strip_tags($this->img_path));

        // bind values
        $stmt->bindParam(":img_desc", $this->img_desc);
        $stmt->bindParam(":img_path", $this->img_path);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function fetchImage()
    {
        $query = "SELECT * from " . $this->table_name . " 
                        where img_id = ?
                        LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->img_id);

        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->img_desc = $row['img_desc'];
        $this->img_path = $row['img_path'];
        $this->img_id = $row['img_id'];

        return $row;
    }

    function update()
    {
        $query = "UPDATE " . $this->table_name . "
                    SET
                        img_desc = :img_desc,
                        img_path = :img_path
                    WHERE img_id = :img_id";

        $stmt = $this->conn->prepare($query);

        $this->img_desc = htmlspecialchars(strip_tags($this->img_desc));
        $this->img_path = htmlspecialchars(strip_tags($this->img_path));
        $this->img_id = htmlspecialchars(strip_tags($this->img_id));

        $stmt->bindParam(':img_desc', $this->img_desc);
        $stmt->bindParam(':img_path', $this->img_path);
        $stmt->bindParam(':img_id', $this->img_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE img_id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->img_id = htmlspecialchars(strip_tags($this->img_id));

        // bind id of record to delete
        $stmt->bindParam(1, $this->img_id);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
