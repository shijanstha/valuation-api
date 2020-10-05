<?php

class Estimation
{
    // database connection and table name
    private $conn;
    private $table_name = "estimation";

    // object properties
    public $name;
    public $value;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getBasicEstimationRates()
    {
        $query = "SELECT 
                    MAX(CASE WHEN estimation.name= 'basic_attached_bathroom_rate' THEN estimation.value END) 'basic_attached_bathroom_rate',
                    MAX(CASE WHEN estimation.name= 'basic_bedroom_rate' THEN estimation.value END) 'basic_bedroom_rate',
                    MAX(CASE WHEN estimation.name= 'basic_common_bathroom_rate' THEN estimation.value END) 'basic_common_bathroom_rate',
                    MAX(CASE WHEN estimation.name= 'basic_floor_rate' THEN estimation.value END) 'basic_floor_rate',
                    MAX(CASE WHEN estimation.name= 'basic_kitchen_rate' THEN estimation.value END) 'basic_kitchen_rate',
                    MAX(CASE WHEN estimation.name= 'basic_modular_kitchen_rate' THEN estimation.value END) 'basic_modular_kitchen_rate',
                    MAX(CASE WHEN estimation.name= 'basic_sitting_room_rate' THEN estimation.value END) 'basic_sitting_room_rate'
                    FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $basicRates = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($basicRates);

        return $basicRates;
    }

    public function getDeluxeEstimationRates()
    {
        $query = "SELECT 
                    MAX(CASE WHEN estimation.name= 'deluxe_attached_bathroom_rate' THEN estimation.value END) 'deluxe_attached_bathroom_rate',
                    MAX(CASE WHEN estimation.name= 'deluxe_bedroom_rate' THEN estimation.value END) 'deluxe_bedroom_rate',
                    MAX(CASE WHEN estimation.name= 'deluxe_common_bathroom_rate' THEN estimation.value END) 'deluxe_common_bathroom_rate',
                    MAX(CASE WHEN estimation.name= 'deluxe_floor_rate' THEN estimation.value END) 'deluxe_floor_rate',
                    MAX(CASE WHEN estimation.name= 'deluxe_kitchen_rate' THEN estimation.value END) 'deluxe_kitchen_rate',
                    MAX(CASE WHEN estimation.name= 'deluxe_modular_kitchen_rate' THEN estimation.value END) 'deluxe_modular_kitchen_rate',
                    MAX(CASE WHEN estimation.name= 'deluxe_sitting_room_rate' THEN estimation.value END) 'deluxe_sitting_room_rate' 
                    FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $deluxeRates = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($deluxeRates);

        return $deluxeRates;
    }

    public function getPremiumEstimationRates()
    {
        $query = "SELECT 
                    MAX(CASE WHEN estimation.name= 'premium_attached_bathroom_rate' THEN estimation.value END) 'premium_attached_bathroom_rate',
                    MAX(CASE WHEN estimation.name= 'premium_bedroom_rate' THEN estimation.value END) 'premium_bedroom_rate',
                    MAX(CASE WHEN estimation.name= 'premium_common_bathroom_rate' THEN estimation.value END) 'premium_common_bathroom_rate',
                    MAX(CASE WHEN estimation.name= 'premium_floor_rate' THEN estimation.value END) 'premium_floor_rate',
                    MAX(CASE WHEN estimation.name= 'premium_kitchen_rate' THEN estimation.value END) 'premium_kitchen_rate',
                    MAX(CASE WHEN estimation.name= 'premium_modular_kitchen_rate' THEN estimation.value END) 'premium_modular_kitchen_rate',
                    MAX(CASE WHEN estimation.name= 'premium_sitting_room_rate' THEN estimation.value END) 'premium_sitting_room_rate'
                    FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $premiumRates = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($premiumRates);

        return $premiumRates;
    }

    public function basicCalculation($order)
    {
        $basicRates = $this->getBasicEstimationRates();
        $totalAmount = 0;

        $floorAmount = (!empty($order["area_of_single_floor"]) ? $order["area_of_single_floor"] : 0) * (!empty($order["floor"]) ? $order["floor"] : 0) * $basicRates["basic_floor_rate"];
        $bedroomAmount = (!empty($order["bedroom"]) ? $order["bedroom"] : 0) * $basicRates["basic_bedroom_rate"];
        $kitchenAmount = (!empty($order["kitchen"]) ? $order["kitchen"] : 0) * ((!empty($order["modular_kitchen"]) ? $order["modular_kitchen"] : 0) == "Y" ? $basicRates["basic_modular_kitchen_rate"] : $basicRates["basic_kitchen_rate"]);
        $sittingRoomAmount = (!empty($order["sitting_room"]) ? $order["sitting_room"] : 0) * $basicRates["basic_sitting_room_rate"];
        $commonBathroomAmount = (!empty($order["common_bathroom"]) ? $order["common_bathroom"] : 0) * $basicRates["basic_common_bathroom_rate"];
        $attachedBathroomAmount = (!empty($order["attached_bathroom"]) ? $order["attached_bathroom"] : 0) * $basicRates["basic_attached_bathroom_rate"];
        $totalAmount = $floorAmount + $bedroomAmount + $kitchenAmount + $sittingRoomAmount + $commonBathroomAmount + $attachedBathroomAmount;

        $basicAmounts = array(
            "floorAmount" => $floorAmount,
            "bedroomAmount" => $bedroomAmount,
            "kitchenAmount" => $kitchenAmount,
            "sittingRoomAmount" => $sittingRoomAmount,
            "commonBathroomAmount" => $commonBathroomAmount,
            "attachedBathroomAmount" => $attachedBathroomAmount,
            "totalAmount" => $totalAmount
        );

        return $basicAmounts;
    }

    public function deluxeCalculation($order)
    {
        $deluxeRates = $this->getDeluxeEstimationRates();
        $totalAmount = 0;

        $floorAmount = (!empty($order["area_of_single_floor"]) ? $order["area_of_single_floor"] : 0) * (!empty($order["floor"]) ? $order["floor"] : 0) * $deluxeRates["deluxe_floor_rate"];
        $bedroomAmount = (!empty($order["bedroom"]) ? $order["bedroom"] : 0) * $deluxeRates["deluxe_bedroom_rate"];
        $kitchenAmount = (!empty($order["kitchen"]) ? $order["kitchen"] : 0) * ((!empty($order["modular_kitchen"]) ? $order["modular_kitchen"] : 0) == "Y" ? $deluxeRates["deluxe_modular_kitchen_rate"] : $deluxeRates["deluxe_kitchen_rate"]);
        $sittingRoomAmount = (!empty($order["sitting_room"]) ? $order["sitting_room"] : 0) * $deluxeRates["deluxe_sitting_room_rate"];
        $commonBathroomAmount = (!empty($order["common_bathroom"]) ? $order["common_bathroom"] : 0) * $deluxeRates["deluxe_common_bathroom_rate"];
        $attachedBathroomAmount = (!empty($order["attached_bathroom"]) ? $order["attached_bathroom"] : 0) * $deluxeRates["deluxe_attached_bathroom_rate"];
        $totalAmount = $floorAmount + $bedroomAmount + $kitchenAmount + $sittingRoomAmount + $commonBathroomAmount + $attachedBathroomAmount;

        $deluxeAmounts = array(
            "floorAmount" => $floorAmount,
            "bedroomAmount" => $bedroomAmount,
            "kitchenAmount" => $kitchenAmount,
            "sittingRoomAmount" => $sittingRoomAmount,
            "commonBathroomAmount" => $commonBathroomAmount,
            "attachedBathroomAmount" => $attachedBathroomAmount,
            "totalAmount" => $totalAmount
        );

        return $deluxeAmounts;
    }

    public function premiumCalculation($order)
    {
        $premiumRates = $this->getPremiumEstimationRates();
        $totalAmount = 0;

        $floorAmount = (!empty($order["area_of_single_floor"]) ? $order["area_of_single_floor"] : 0) * (!empty($order["floor"]) ? $order["floor"] : 0) * $premiumRates["premium_floor_rate"];
        $bedroomAmount = (!empty($order["bedroom"]) ? $order["bedroom"] : 0) * $premiumRates["premium_bedroom_rate"];
        $kitchenAmount = (!empty($order["kitchen"]) ? $order["kitchen"] : 0) * ((!empty($order["modular_kitchen"]) ? $order["modular_kitchen"] : 0) == "Y" ? $premiumRates["premium_modular_kitchen_rate"] : $premiumRates["premium_kitchen_rate"]);
        $sittingRoomAmount = (!empty($order["sitting_room"]) ? $order["sitting_room"] : 0) * $premiumRates["premium_sitting_room_rate"];
        $commonBathroomAmount = (!empty($order["common_bathroom"]) ? $order["common_bathroom"] : 0) * $premiumRates["premium_common_bathroom_rate"];
        $attachedBathroomAmount = (!empty($order["attached_bathroom"]) ? $order["attached_bathroom"] : 0) * $premiumRates["premium_attached_bathroom_rate"];
        $totalAmount = $floorAmount + $bedroomAmount + $kitchenAmount + $sittingRoomAmount + $commonBathroomAmount + $attachedBathroomAmount;

        $premiumAmounts = array(
            "floorAmount" => $floorAmount,
            "bedroomAmount" => $bedroomAmount,
            "kitchenAmount" => $kitchenAmount,
            "sittingRoomAmount" => $sittingRoomAmount,
            "commonBathroomAmount" => $commonBathroomAmount,
            "attachedBathroomAmount" => $attachedBathroomAmount,
            "totalAmount" => $totalAmount
        );

        return $premiumAmounts;
    }
}
