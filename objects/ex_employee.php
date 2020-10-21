<?php

class ExEmployee
{

    // database connection and table name
    private $conn;
    private $table_name = "ex_employee";

    // object properties
    public $id;
    public $name;
    public $address;
    public $current_work;
    public $description;
    public $fb_link;
    public $img_path;


    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function fetchAllExEmployees()
    {
        $query = "SELECT * FROM " . $this->table_name . " 
                    ORDER BY
                        name";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }


    function createExEmployee()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET
                    name= :name, address= :address, current_work = :current_work,
                    description = :description, img_path = :img_path, fb_link = :fb_link";
        $stmt = $this->conn->prepare($query);


        //sanitizing for sql injection
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->current_work = htmlspecialchars(strip_tags($this->current_work));
        $this->fb_link = htmlspecialchars(strip_tags($this->fb_link));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->img_path = htmlspecialchars(strip_tags($this->img_path));

        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":current_work", $this->current_work);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":img_path", $this->img_path);
        $stmt->bindParam(":fb_link", $this->fb_link);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function fetchExEmployee()
    {
        $query = "SELECT *       
                        FROM " . $this->table_name . " id
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
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->address = $row['address'];
        $this->current_work = $row['current_work'];
        $this->description = $row['description'];
        $this->img_path = $row['img_path'];
        $this->fb_link = $row['fb_link'];
    }

    function update()
    {
        $query = "UPDATE " . $this->table_name . "
                    SET
                        name = :name,
                        address = :address,
                        current_work = :current_work,
                        description = :description,
                        fb_link = :fb_link,
                        img_path = :img_path
                    WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->current_work = htmlspecialchars(strip_tags($this->current_work));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->img_path = htmlspecialchars(strip_tags($this->img_path));
        $this->fb_link = htmlspecialchars(strip_tags($this->fb_link));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':current_work', $this->current_work);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':img_path', $this->img_path);
        $stmt->bindParam(':fb_link', $this->fb_link);
        $stmt->bindParam(':id', $this->id);

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
