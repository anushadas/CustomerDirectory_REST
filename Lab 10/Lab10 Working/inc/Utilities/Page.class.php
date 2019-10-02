<?php

class Page  {

    public static $title = "Set Title!";

    static function header()    { ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>

            <!-- Basic Page Needs
        –––––––––––––––––––––––––––––––––––––––––––––––––– -->
            <meta charset="utf-8">
            <title><?php echo self::$title; ?></title>
            <meta name="description" content="">
            <meta name="author" content="">

            <!-- Mobile Specific Metas
        –––––––––––––––––––––––––––––––––––––––––––––––––– -->
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <!-- FONT
        –––––––––––––––––––––––––––––––––––––––––––––––––– -->
            <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

            <!-- CSS
        –––––––––––––––––––––––––––––––––––––––––––––––––– -->
            <link rel="stylesheet" href="css/normalize.css">
            <link rel="stylesheet" href="css/skeleton.css">

            <!-- Favicon
        –––––––––––––––––––––––––––––––––––––––––––––––––– -->
            <link rel="icon" type="image/png" href="images/favicon.png">

        </head>

        <body>

            <!-- Primary Page Layout
        –––––––––––––––––––––––––––––––––––––––––––––––––– -->
            <div class="container">
                <div class="row">
                    <div class="one-half column" style="margin-top: 25%">
                        <h4><?php echo self::$title; ?></h4>
    <?php }

    static function footer()    { ?>

            </div>
        </div>
        </div>

        <!-- End Document
        –––––––––––––––––––––––––––––––––––––––––––––––––– -->
        </body>
        </html>

    <?php }

    static function listCustomers($customerData) {
        
        echo '<table class="u-full-width">
        <thead>
          <tr>
            <th>Name</th>
            <th>City</th>
            <th>Address</th>
            <th>Delete</th>
            <th>Edit</th>
          </tr>
        </thead>
        <tbody>';

        foreach ($customerData as $customer)  {
            echo '<TR>';
            echo '<TD>'.$customer->getName().'</TD>';
            echo '<TD>'.$customer->getAddress().'</TD>';
            echo '<TD>'.$customer->getCity().'</TD>';
            echo '<TD><A HREF="'.$_SERVER["PHP_SELF"].'?action=delete&id='.$customer->getCustomerID().'">Delete</A></TD>';
            echo '<TD><A HREF="'.$_SERVER["PHP_SELF"].'?action=edit&id='.$customer->getCustomerID().'">Edit</A></TD>';
            echo '</TR>';
        }
         echo '</tbody>
      </table>';

    }

    static function addCustomer()   { ?>

    <h4>Add Customer</h4>
    <!-- The above form looks like this -->
    <form method="POST" ACTION="<?php echo $_SERVER["PHP_SELF"]; ?>">
    <div class="row">

        <div class="six columns">
        <label for="name">name</label>
        <input class="u-full-width" type="TEXT" placeholder="First Last" id="name" NAME="name">
        </div>

        <div class="six columns">
        <label for="name">address</label>
        <input class="u-full-width" type="TEXT" placeholder="Full Address" id="address" NAME="address">
        </div>
        
        <div class="six columns">
        <label for="name">City</label>
        <input class="u-full-width" type="TEXT" placeholder="City Name" id="city" NAME="city">
        </div>

    </div>
    <input class="button-primary" type="submit" value="Submit">
    </form>

    <?php }

    static function editCustomer($c)    { ?>

    <h4>Edit Customer - <?php echo $c->getCustomerID(); ?></h4>
    <!-- The above form looks like this -->
    <form method="POST" ACTION="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" value="<?php echo $c->getCustomerID(); ?>">


        <div class="row">

            <div class="six columns">
            <label for="name">name</label>
            <input class="u-full-width" type="TEXT" placeholder="First Last" id="name" NAME="name" value="<?php echo $c->getName(); ?>">
            </div>

            <div class="six columns">
            <label for="name">address</label>
            <input class="u-full-width" type="TEXT" placeholder="Full Address" id="address" NAME="address" value="<?php echo $c->getAddress(); ?>">
            </div>
            
            <div class="six columns">
            <label for="name">City</label>
            <input class="u-full-width" type="TEXT" placeholder="City Name" id="city" NAME="city" value="<?php echo $c->getCity(); ?>">
            </div>

        </div>
        <input class="button-primary" type="submit" value="Submit">
        </form>

    <?php }
}