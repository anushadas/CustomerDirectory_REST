<?php
class Customer
{
    //Attributes
    private $CustomerID;
    private $Name;
    private $Address;
    private $City;

    //Getters
    function getName(): String {
        return $this->Name;
    }

    function getAddress(): String {
        return $this->Address;
    }

    function getCity(): String  {
        return $this->City;
    }

    function getCustomerID(): int   {
        return $this->CustomerID;
    }

    //Setters
    function setName(String $newName)    {
    $this->Name = $newName;  
    }

    function setCity(String $newCity)   {
        $this->City = $newCity;
    }

    function setAddress(String $newAddress) {
        $this->Address = $newAddress;
    }

    function setCustomerID(int $CustomerID) {
        $this->CustomerID = $CustomerID;
    }

    function jsonSerialize() : stdClass 
    {

        $obj = new stdClass();
        $obj->id = $this->getCustomerID();
        $obj->name = $this->getName();
        $obj->address = $this->getAddress();
        $obj->city = $this->getCity();

        return $obj;
    }

}
