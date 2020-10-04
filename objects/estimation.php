<?php

class Estimation
{
    // database connection and table name
    private $conn;
    private $table_name = "estimation";

    // object properties
    public $key;
    public $value;

    //
    public $mappings = [
        'basic_attached_bathroom_rate' => '',
        'basic_bedroom_rate' => '',
        'basic_common_bathroom_rate' => '',
        'basic_floor_rate' => '',
        'basic_kitchen_rate' => '',
        'basic_modular_kitchen_rate' => '',
        'basic_sitting_room_rate' => '',
        'deluxe_attached_bathroom_rate' => '',
        'deluxe_bedroom_rate' => '',
        'deluxe_common_bathroom_rate' => '',
        'deluxe_floor_rate' => '',
        'deluxe_kitchen_rate' => '',
        'deluxe_modular_kitchen_rate' => '',
        'deluxe_sitting_room_rate' => '',
        'premium_attached_bathroom_rate' => '',
        'premium_bedroom_rate' => '',
        'premium_common_bathroom_rate' => '',
        'premium_floor_rate' => '',
        'premium_kitchen_rate' => '',
        'premium_modular_kitchen_rate' => '',
        'premium_sitting_room_rate' => ''
    ];

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getBasicEstimationRates()
    {
        $con = mysqli_connect("localhost", "root", "root", "valuation");

        $query = "SELECT * FROM " . $this->table_name . " where name like 'basic_%'";

        $result = mysqli_query($con, $query);

        // Fetch all
        $rs = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Free result set
        $rsf = mysqli_free_result($result);

        mysqli_close($con);

        return $rsf;
    }

    public function getDeluxeEstimationRates()
    {
        $query = "SELECT * FROM " . $this->table_name . " 
                    where name like  'deluxe_%'";

        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    public function getPremiumEstimationRates()
    {
        $query = "SELECT * FROM " . $this->table_name . " 
                    where name like  'premium_%'";

        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    public function basicCalculation()
    {
    }

    public function deluxeCalculation()
    {
    }

    public function premiumCalculation()
    {
    }
}
