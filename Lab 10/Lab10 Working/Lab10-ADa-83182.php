<?php

//Require configuration
require_once('inc/config.inc.php');

//Require Entities
require_once('inc/Entities/Customer.class.php');

//Require Utilities
require_once('inc/Utilities/RestClient.class.php');
require_once('inc/Utilities/Page.class.php');

//Check if there was get data, perform the action
if (!empty($_GET))    {
    //Perform the Action
    if ($_GET["action"] == "delete")  {
        //Call the rest client with DELETE
        RestClient::call("DELETE",array('id'=>$_GET['id']));
    }

    if ($_GET["action"] == "edit")  {
        //Call the rest client with GET, encode the result
        $jsonString = RestClient::call("GET",array('id'=>$_GET['id']));
        $jc = json_decode($jsonString);

        $c = new Customer();
        $c->setCustomerID($jc->id);
        $c->setName($jc->name);
        $c->setCity($jc->city);
        $c->setAddress($jc->address);

    }

}

//Check for post data
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["action"]) && $_POST["action"] == "edit")    {

        //Assemble the the postData
        $postData = array();
        $postData['ID'] = $_POST['id'];
        $postData['Name'] = $_POST['name'];
        $postData['City'] = $_POST['city'];
        $postData ['Address'] = $_POST['address'];

        //Call the RestClient with PUT
        RestClient::call("PUT",$postData);
        
    //Create
    } 
    else {
        //Assemble the Customer
        $newC = array();
        $newC['Name'] = $_POST['name'];
        $newC['City'] = $_POST['city'];
        $newC ['Address'] = $_POST['address'];
       
        RestClient::Call("POST", $newC);
    }
}

//Get all the customers from the web service via the REST client

$jCustomers = json_decode(RestClient::call("GET",array()));

//Store the customer objects 
$customers = array();

//Iterate through the customers and convert them back to Customer objects
    foreach($jCustomers as $jc)
    {
    $nc = new Customer();
    $nc->setCustomerID($jc->id);
    $nc->setName($jc->name);
    $nc->setCity($jc->city);
    $nc->setAddress($jc->address);

    $customers[] = $nc;
    }


Page::$title = "Lab 10_ADa_83182";
Page::header();
Page::listCustomers($customers);
//Check Get again
    if (!empty($_GET) && $_GET["action"] == "edit") {
    //Page Edit
    Page::editCustomer($c);
    } else {
	//Page Add
    Page::addCustomer();
    }

Page::footer();
