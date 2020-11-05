<?php

class ClientDetail
{

    // database connection and table name
    private $conn;
    private $table_name = "client_detail";

    // object properties
    public $id;
    public $name;
    public $email;
    public $contact_no;
    public $address;
    public $area_of_single_floor;
    public $floor;
    public $bedroom;
    public $kitchen;
    public $modular_kitchen;
    public $sitting_room;
    public $common_bathroom;
    public $attached_bathroom;
    public $basic_total;
    public $deluxe_total;
    public $premium_total;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function getAllClientDetail()
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

    function createClientDetail($basic, $deluxe, $premium)
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET
                    name = :name, 
                    email = :email, 
                    contact_no = :contact_no,
                    address = :address,
                    area_of_single_floor = :area_of_single_floor,
                    floor = :floor,
                    bedroom = :bedroom,
                    kitchen = :kitchen,
                    modular_kitchen = :modular_kitchen,
                    sitting_room = :sitting_room,
                    common_bathroom = :common_bathroom,
                    attached_bathroom = :attached_bathroom,
                    basic_total = :basic_total,
                    deluxe_total = :deluxe_total,
                    premium_total = :premium_total
                    ";

        $stmt = $this->conn->prepare($query);

        //sanitizing for sql injection
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->contact_no = htmlspecialchars(strip_tags($this->contact_no));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->area_of_single_floor = htmlspecialchars(strip_tags($this->area_of_single_floor));
        $this->floor = htmlspecialchars(strip_tags($this->floor));
        $this->bedroom = htmlspecialchars(strip_tags($this->bedroom));
        $this->kitchen = htmlspecialchars(strip_tags($this->kitchen));
        $this->modular_kitchen = htmlspecialchars(strip_tags($this->modular_kitchen));
        $this->sitting_room = htmlspecialchars(strip_tags($this->sitting_room));
        $this->common_bathroom = htmlspecialchars(strip_tags($this->common_bathroom));
        $this->attached_bathroom = htmlspecialchars(strip_tags($this->attached_bathroom));
        $this->basic_total = htmlspecialchars(strip_tags($basic));
        $this->deluxe_total = htmlspecialchars(strip_tags($deluxe));
        $this->premium_total = htmlspecialchars(strip_tags($premium));

        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":contact_no", $this->contact_no);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":area_of_single_floor", $this->area_of_single_floor);
        $stmt->bindParam(":floor", $this->floor);
        $stmt->bindParam(":bedroom", $this->bedroom);
        $stmt->bindParam(":kitchen", $this->kitchen);
        $stmt->bindParam(":modular_kitchen", $this->modular_kitchen);
        $stmt->bindParam(":sitting_room", $this->sitting_room);
        $stmt->bindParam(":common_bathroom", $this->common_bathroom);
        $stmt->bindParam(":attached_bathroom", $this->attached_bathroom);
        $stmt->bindParam(":basic_total", $this->basic_total);
        $stmt->bindParam(":deluxe_total", $this->deluxe_total);
        $stmt->bindParam(":premium_total", $this->premium_total);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function fetchClientDetail()
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
        $this->address = $row['address'];
        $this->area_of_single_floor = $row['area_of_single_floor'];
        $this->floor = $row['floor'];
        $this->bedroom = $row['bedroom'];
        $this->kitchen = $row['kitchen'];
        $this->modular_kitchen = $row['modular_kitchen'];
        $this->sitting_room = $row['sitting_room'];
        $this->common_bathroom = $row['common_bathroom'];
        $this->attached_bathroom = $row['attached_bathroom'];
        $this->basic_total = $row['basic_total'];
        $this->deluxe_total = $row['deluxe_total'];
        $this->premium_total = $row['premium_total'];
        $this->id = $row['id'];
    }

    function update()
    {
        $query = "UPDATE " . $this->table_name . "
                    SET
                        name = :name,
                        email = :email,
                        contact_no = :contact_no,
                        address = :address
                    WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->contact_no = htmlspecialchars(strip_tags($this->contact_no));
        $this->address = htmlspecialchars(strip_tags($this->address));

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':contact_no', $this->contact_no);
        $stmt->bindParam(':address', $this->address);

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