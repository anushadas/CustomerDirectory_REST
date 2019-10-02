<?php

class CustomerDAO    {

    private static $db;

    static function initialize()    {

        //Initialize the database connection
        self::$db = new PDOAgent('Customer');
    
    }

    //CREATE a single Customer
    static function createCustomer(Customer $newCustomer): int   {
         
        $sqlInsert = "INSERT INTO Customers (Name, Address, City) VALUES (:name, :address, :city);";
        //Q
        self::$db->query($sqlInsert);
        //B
        self::$db->bind(':name',$newCustomer->getName());
        self::$db->bind(':address', $newCustomer->getAddress());
        self::$db->bind(':city', $newCustomer->getCity());
        //E
        self::$db->execute();
        //R
        return  self::$db->lastInsertId();

    }

    //READ a single Customer
    static function getCustomer(int $id) : Customer   {

        $singleSelect = "SELECT * FROM Customers WHERE CustomerID = :customerid";

        //Q
        self::$db->query($singleSelect);
        //B
        self::$db->bind(':customerid', $id);
        //E
        self::$db->execute();
        //R
        return self::$db->singleResult();

    }

    //READ a list of Customers
    static function getCustomers(): Array   {

        $selectAll = "SELECT * FROM Customers;";
        //Q
        self::$db->query($selectAll);

        //E
        self::$db->execute();

        //R
        return self::$db->resultset();
     
    }

    //UPDATE 
    static function updateCustomer(Customer $updatedCustomer): int   {
       try {
            
            $updateQuery = "UPDATE Customers SET Name = :name, City = :city, Address = :address WHERE CustomerId = :id;";

            //Q
            self::$db->query($updateQuery);

            //B
            self::$db->bind(':id', $updatedCustomer->getCustomerID());
            self::$db->bind(':city', $updatedCustomer->getCity());
            self::$db->bind(':name', $updatedCustomer->getName());
            self::$db->bind(':address', $updatedCustomer->getAddress());
            
            //E
            self::$db->execute();

            //Checking for appropriate updates
            if (self::$db->rowCount() !=1)    {
                throw new Exception("There was an error updating the database!");
            }
        } 
        catch (Exception $ex) {
            echo $ex->getMessage();
            self::$db->debugDumpParams();
        }    

        //R
        return self::$db->rowCount();
    }

    //DELETE
    static function deleteCustomer(int $id): bool {

        try {

            $deleteQuery = "DELETE FROM Customers WHERE CustomerId = :customerid";

            //Q
            self::$db->query($deleteQuery);

            //B
            self::$db->bind(':customerid', $id);

            //E
            self::$db->execute();

            if (self::$db->rowCount() != 1) {
                throw new Exception("There was an error deleting customer $id");
            } 
        
        } catch (Exception $ex) {

            echo $ex->getMessage();
            self::$db->debugDumpParams();
            return false;
        
        }

        //R
        return true;
    }

}

?>
