<?php

class Journal
{

    // database connection and table name
    private $conn;
    private $table_name = "journal";

    // object properties
    public $journal_id;
    public $title;
    public $summary;
    public $description;
    public $img_path;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function getAllJournals()
    {
        $query = "SELECT * FROM
                " . $this->table_name . " 
            ORDER BY
                journal_id";
        
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function createJournal()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET
                    title = :title, 
                    summary = :summary, 
                    description = :description,
                    img_path = :img_path
                    ";

        $stmt = $this->conn->prepare($query);

        //sanitizing for sql injection
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->summary = htmlspecialchars(strip_tags($this->summary));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->img_path = htmlspecialchars(strip_tags($this->img_path));

        // bind values
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":summary", $this->summary);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":img_path", $this->img_path);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function fetchJournal()
    {
        $query = "SELECT * FROM " . $this->table_name . " 
                        where journal_id = ?
                        LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->journal_id);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->title = $row['title'];
        $this->summary = $row['summary'];
        $this->description = $row['description'];
        $this->img_path = $row['img_path'];
        $this->journal_id = $row['journal_id'];
    }

    function update()
    {
        $query = "UPDATE " . $this->table_name . "
                    SET
                        title = :title,
                        summary = :summary,
                        description = :description,
                        img_path = :img_path
                    WHERE journal_id = :journal_id";

        $stmt = $this->conn->prepare($query);

        $this->journal_id = htmlspecialchars(strip_tags($this->journal_id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->summary = htmlspecialchars(strip_tags($this->summary));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->img_path = htmlspecialchars(strip_tags($this->img_path));

        $stmt->bindParam(':journal_id', $this->journal_id);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':summary', $this->summary);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':img_path', $this->img_path);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE journal_id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->journal_id = htmlspecialchars(strip_tags($this->journal_id));

        // bind id of record to delete
        $stmt->bindParam(1, $this->journal_id);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}

?>