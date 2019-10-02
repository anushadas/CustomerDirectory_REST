<?php


//Require configuration
require_once('inc/config.inc.php');

//Require Entities
require_once('inc/Entities/Customer.class.php');

//Require Utillity Classes
require_once('inc/Utilities/PDOAgent.class.php');
require_once('inc/Utilities/CustomerDAO.class.php');

/*
Create  - INSERT - POST
Read    - SELECT - GET
Update  - UPDATE - PUT
DELETE  - DELETE - DELETE
*/

//Instantiate a new Customer Mapper
CustomerDAO::initialize();


//Pull the request data
parse_str(file_get_contents('php://input'), $requestData);

//Do something based on the request
switch ($_SERVER["REQUEST_METHOD"])   {

    case "POST":    //Picked up a POST, Its Insert time!
    //YARC Id=6&Name=Sally Hill&City=Vancouver&Address=66 Royal Ave

    //New Customer
    $nc = new Customer();
    $nc->setName($requestData["Name"]);
    $nc->setAddress($requestData["Address"]);
    $nc->setCity($requestData["City"]);

    $result = CustomerDAO::createCustomer($nc);
    //Return the results
    echo json_encode($result);

    break;

    //If there was a request with an id return that customer, if not return all of them!
    case "GET":

        if (isset($requestData['id']))    {

            //Return the customer object
            $sc = CustomerDAO::getCustomer($requestData['id']);
            
            //Get a serializable version
            $ssc = $sc->jsonSerialize();

            //Set the header
            header('Content-Type: application/json');
            //Barf out the JSON version
            echo json_encode($sc->jsonSerialize());

        } else {
            //All the customers!
            $customers = CustomerDAO::getCustomers();
        
            //Walk the customers and add them to a serialized array to return.
            $serializedCustomers = array();

            foreach ($customers as $customer)    {
                $serializedCustomers[] = $customer->jsonSerialize();
            }
            //Return the results

            //Set the header
            header('Content-Type: application/json');
            //Return the entire array
            echo json_encode($serializedCustomers);            
        }
    break;
   
    case "PUT":
       //Updated Customer
        $uc = new Customer();
        $uc->setCustomerID($requestData["ID"]);
        $uc->setName($requestData["Name"]);
        $uc->setAddress($requestData["Address"]);
        $uc->setCity($requestData["City"]);
        
        $result = CustomerDAO::updateCustomer($uc);
        //Return the results
        echo json_encode($result);
    break;

    case "DELETE":
    CustomerDAO::deleteCustomer($requestData['id']);
    break; 

    default:
        echo json_encode(array("message"=> "Você fala HTTP?"));
    break;
}


?>
