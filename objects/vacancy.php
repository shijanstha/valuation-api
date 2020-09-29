<?php

class Vacancy
{

    // database connection and table name
    private $conn;
    private $table_name = "vacancy";

    // object properties
    public $vacancy_id;
    public $vacancy_title;
    public $city;
    public $opening;
    public $experience;
    public $vacancy_desc;
    public $service_type;
    public $created_dt;
    public $expiry_dt;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function fetchAllVacancies()
    {
        $query = "SELECT * FROM " . $this->table_name . "
                    ORDER BY
                        vacancy_id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }


    function createVacancy()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET
                    vacancy_title= :vacancy_title, city= :city, opening = :opening, experience = :experience, 
                    vacancy_desc = :vacancy_desc, service_type = :service_type, expiry_dt = :expiry_dt";

        $stmt = $this->conn->prepare($query);


        //sanitizing for sql injection
        $this->vacancy_title = htmlspecialchars(strip_tags($this->vacancy_title));
        $this->city = htmlspecialchars(strip_tags($this->city));
        $this->opening = htmlspecialchars(strip_tags($this->opening));
        $this->experience = htmlspecialchars(strip_tags($this->experience));
        $this->vacancy_desc = htmlspecialchars(strip_tags($this->vacancy_desc));
        $this->service_type = htmlspecialchars(strip_tags($this->service_type));
        $this->expiry_dt = htmlspecialchars(strip_tags($this->expiry_dt));

        // bind values
        $stmt->bindParam(":vacancy_title", $this->vacancy_title);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":opening", $this->opening);
        $stmt->bindParam(":experience", $this->experience);
        $stmt->bindParam(":vacancy_desc", $this->vacancy_desc);
        $stmt->bindParam(":service_type", $this->service_type);
        $stmt->bindParam(":expiry_dt", $this->expiry_dt);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function fetchVacancy()
    {
        $query = "SELECT *       
                        FROM " . $this->table_name . " 
                        where vacancy_id = ?
                        LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->vacancy_id);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->vacancy_id = $row['vacancy_id'];
        $this->vacancy_title = $row['vacancy_title'];
        $this->city = $row['city'];
        $this->opening = $row['opening'];
        $this->experience = $row['experience'];
        $this->vacancy_desc = $row['vacancy_desc'];
        $this->service_type = $row['service_type'];
        $this->created_dt = $row['created_dt'];
        $this->expiry_dt = $row['expiry_dt'];
    }

    function update()
    {
        $query = "UPDATE " . $this->table_name . "
                    SET
                    vacancy_title = :vacancy_title,
                    city = :city,
                    opening = :opening,
                    experience = :experience,
                    vacancy_desc = :vacancy_desc,
                    service_type = :service_type,
                    expiry_dt = :expiry_dt
                    WHERE vacancy_id = :vacancy_id";

        $stmt = $this->conn->prepare($query);

        $this->vacancy_title = htmlspecialchars(strip_tags($this->vacancy_title));
        $this->city = htmlspecialchars(strip_tags($this->city));
        $this->opening = htmlspecialchars(strip_tags($this->opening));
        $this->experience = htmlspecialchars(strip_tags($this->experience));
        $this->vacancy_desc = htmlspecialchars(strip_tags($this->vacancy_desc));
        $this->service_type = htmlspecialchars(strip_tags($this->service_type));
        $this->expiry_dt = htmlspecialchars(strip_tags($this->expiry_dt));
        $this->vacancy_id = htmlspecialchars(strip_tags($this->vacancy_id));

        $stmt->bindParam(':vacancy_title', $this->vacancy_title);
        $stmt->bindParam(':city', $this->city);
        $stmt->bindParam(':opening', $this->opening);
        $stmt->bindParam(':experience', $this->experience);
        $stmt->bindParam(':vacancy_desc', $this->vacancy_desc);
        $stmt->bindParam(':service_type', $this->service_type);
        $stmt->bindParam(':expiry_dt', $this->expiry_dt);
        $stmt->bindParam(':vacancy_id', $this->vacancy_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE vacancy_id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->vacancy_id = htmlspecialchars(strip_tags($this->vacancy_id));

        // bind id of record to delete
        $stmt->bindParam(1, $this->vacancy_id);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
