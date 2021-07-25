<?php

class BikeListing {
    //personal information
    public $name; //string
    public $phone; // string
    public $email; // string
    //bike information
    public $title; //string -> title of listing
    public $serialnumber; // string
    public $type; // string
    public $description; // string 50 characters only
    //bike details
    public $yearofmanufacture; // integer
    public $characteristics; // string (probably might use enum's)
    public $condition; // string (new , used)
    //price of bike
    public $price;

    function __construct(
        $name,
        $phone,
        $email,
        $title,
        $serialnumber,
        $type,
        $description,
        $yearofmanufacture,
        $characteristics,
        $condition,
        $price
    ) {
    $this->name = $name;
    $this->phone = $phone;
    $this->email = $email;
    $this->title = $title;
    $this->serialnumber = $serialnumber;
    $this->type = $type;
    $this->description = $description;
    $this->yearofmanufacture = $yearofmanufacture;
    $this->characteristics = $characteristics;
    $this->condition = $condition;
    $this->price = $price;
    }
    
    public static function initUsingFileLines($line) {
        $lines = explode(",",$line);
        $instance = null;
        try {
            $price = intval($lines[10]);
            $price = number_format($price,2);

            $instance = new self(
            $lines[0],
            $lines[1],
            $lines[2],
            $lines[3],
            $lines[4],
            $lines[5],
            $lines[6],
            $lines[7],
            $lines[8],
            $lines[9],
            $price
            );
        }
        catch (Exception $e) {
            $instance = null;
        }
        return $instance;
    }

    public static function init() {
        $price = intval($lines[10]);
        $price = number_format($price,2);

        $instance = new self(
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        $price
        );
        return $instance;
    }

    //generate serial number saperately instead of initialising on constructor to reduce initialisation timing
    public static function generateSerialNumber($year) {
        //extract the last two string characters using substring
        $year = substr(strval($year), 2, 2);
        //generate random number
        $number = rand(100,999);
        //genernate random characters
        $length = 3;    
        $threeletterchars = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);

        $result = "${year}-${number}-${threeletterchars}";
        return $result;
    }
}

?>