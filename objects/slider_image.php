<?php

class SliderImage
{

    // database connection and table name
    private $conn;
    private $table_name = "slider_image";

    // object properties
    public $slider_id;
    public $slider_desc;
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
                slider_id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function addImageToSlider()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET
                   slider_desc = :slider_desc, img_path = :img_path";

        $stmt = $this->conn->prepare($query);

        //sanitizing for sql injection
        $this->slider_desc = htmlspecialchars(strip_tags($this->slider_desc));
        $this->img_path = htmlspecialchars(strip_tags($this->img_path));

        // bind values
        $stmt->bindParam(":slider_desc", $this->slider_desc);
        $stmt->bindParam(":img_path", $this->img_path);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function fetchImage()
    {
        $query = "SELECT * from " . $this->table_name . " 
                        where slider_id = ?
                        LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->slider_id);

        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->slider_desc = $row['slider_desc'];
        $this->img_path = $row['img_path'];
        $this->slider_id = $row['slider_id'];

        return $row;
    }

    function update()
    {
        $query = "UPDATE " . $this->table_name . "
                    SET
                        slider_desc = :slider_desc,
                        img_path = :img_path
                    WHERE slider_id = :slider_id";

        $stmt = $this->conn->prepare($query);

        $this->slider_desc = htmlspecialchars(strip_tags($this->slider_desc));
        $this->img_path = htmlspecialchars(strip_tags($this->img_path));
        $this->slider_id = htmlspecialchars(strip_tags($this->slider_id));

        $stmt->bindParam(':slider_desc', $this->slider_desc);
        $stmt->bindParam(':img_path', $this->img_path);
        $stmt->bindParam(':slider_id', $this->slider_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE slider_id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->slider_id = htmlspecialchars(strip_tags($this->slider_id));

        // bind id of record to delete
        $stmt->bindParam(1, $this->slider_id);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
