<?php

class InterestUser {
    public $serialnumber; // string
    public $name; // string
    public $phone; // string
    public $email; // string
    public $price;

    function __construct(
        $serialnumber,
        $name,
        $phone,
        $email,
        $price
    ) {
    $this->serialnumber = $serialnumber;
    $this->name = $name;
    $this->phone = $phone;
    $this->email = $email;
    $this->price = $price;
    }
    
    public static function initUsingFileLines($line) {
        $lines = explode(",",$line);
        $instance = null;
        try {
            $price = intval($lines[4]);
            $price = number_format($price,2);

            $instance = new self(
            $lines[0],
            $lines[1],
            $lines[2],
            $lines[3],
            $price
            );
        }
        catch (Exception $e) {
            $instance = null;
        }
        return $instance;
    }

    public static function init() {
        $price = intval($lines[4]);
        $price = number_format($price,2);

        $instance = new self(
        "",
        "",
        "",
        "",
        $price
        );
        return $instance;
    }

}

?>