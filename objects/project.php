<?php

class Project
{

    // database connection and table name
    private $conn;
    private $table_name = "project";

    // object properties
    public $project_id;
    public $project_title;
    public $client;
    public $address;
    public $project_desc;
    public $project_cost;
    public $img_path;
    public $completed;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function getAllProjects()
    {
        $query = "SELECT * FROM 
                " . $this->table_name . " 
            ORDER BY
                project_id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function createProject()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET
                    project_title = :project_title, 
                    client = :client,
                    address = :address,
                    project_desc = :project_desc, 
                    project_cost = :project_cost, 
                    img_path = :img_path,
                    completed = :completed
                    ";

        $stmt = $this->conn->prepare($query);

        //sanitizing for sql injection
        $this->project_title = htmlspecialchars(strip_tags($this->project_title));
        $this->client = htmlspecialchars(strip_tags($this->client));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->project_desc = htmlspecialchars(strip_tags($this->project_desc));
        $this->project_cost = htmlspecialchars(strip_tags($this->project_cost));
        $this->img_path = htmlspecialchars(strip_tags($this->img_path));
        $this->completed = htmlspecialchars(strip_tags($this->completed));

        // bind values
        $stmt->bindParam(":project_title", $this->project_title);
        $stmt->bindParam(":client", $this->client);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":project_desc", $this->project_desc);
        $stmt->bindParam(":project_cost", $this->project_cost);
        $stmt->bindParam(":img_path", $this->img_path);
        $stmt->bindParam(":completed", $this->completed);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function fetchProject()
    {
        $query = "SELECT * FROM " . $this->table_name . " 
                        where project_id = ?
                        LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->project_id);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->project_id = $row['project_id'];
        $this->project_title = $row['project_title'];
        $this->client = $row['client'];
        $this->address = $row['address'];
        $this->project_cost = $row['project_cost'];
        $this->project_desc = $row['project_desc'];
        $this->img_path = $row['img_path'];
        $this->completed = $row['completed'];
    }

    function update()
    {
        $query = "UPDATE " . $this->table_name . "
                    SET
                        project_title = :project_title,
                        project_desc = :project_desc,
                        img_path = :img_path,
                        client = :client,
                        address = :address,
                        project_cost = :project_cost,
                        completed = :completed

                    WHERE project_id = :project_id";

        $stmt = $this->conn->prepare($query);

        $this->project_id = htmlspecialchars(strip_tags($this->project_id));
        $this->project_title = htmlspecialchars(strip_tags($this->project_title));
        $this->client = htmlspecialchars(strip_tags($this->client));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->project_cost = htmlspecialchars(strip_tags($this->project_cost));
        $this->project_desc = htmlspecialchars(strip_tags($this->project_desc));
        $this->img_path = htmlspecialchars(strip_tags($this->img_path));
        $this->completed = htmlspecialchars(strip_tags($this->completed));

        $stmt->bindParam(':project_id', $this->project_id);
        $stmt->bindParam(':project_title', $this->project_title);
        $stmt->bindParam(':client', $this->client);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':project_cost', $this->project_cost);
        $stmt->bindParam(':project_desc', $this->project_desc);
        $stmt->bindParam(':img_path', $this->img_path);
        $stmt->bindParam(':completed', $this->completed);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE project_id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->project_id = htmlspecialchars(strip_tags($this->project_id));

        // bind id of record to delete
        $stmt->bindParam(1, $this->project_id);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
