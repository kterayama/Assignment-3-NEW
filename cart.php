
<center>
<style>
        body{
            background-image: url(soft.jpg);
            background-size: cover;
        }
        h1 {
            font-family: "Snell Roundhand", cursive;
            font-size: 60px;
            font-variant: small-caps;
            line-height: 10px;
            color: #DCB414;
        }
        h2 {
            font-family: "Snell Roundhand", cursive;
            font-size: 30px;
            line-height: 10px;
        }
        h3 {
            font-family: "Snell Roundhand", cursive;
            font-size: 20px;
            line-height: 10px;
        }
        img {
            width: 300px;
            display: block;
        }
        table, td {
            border: 1.5px solid black;
            font-family: "Courier New", monospace;
            border-collapse: collapse;
            text-align: center;
        }
        tr:hover {
            background-color: #EAF5FE;
        }
        th {
            background-color: black;
            color: white;
        }
    </style>
    <H2>Welcome to</H2><P><H1>Pandora's Box</H1></P>
    <H3>where every special moment is saved in Pandora's Box<BR></H3>
<?php
session_save_path('.');
session_start();
require 'all_products.php';
require 'functions.inc';


// create page personalization
if (isset($_SESSION['id'])) {
    echo "Hi " . $_SESSION['id'];
}

//if the cart is empty
if (empty($_SESSION['cartquantity'])) {
    // start the cart out with zero items
    foreach ($allproductsarray as $productname => $productarrray) {
        $cart = array_fill(0, count($productarrray), 0);
        // put the cart in user session
        $_SESSION['cartquantity'][$productname] = $cart;
    }
    // print message if cart is empty
    print " Your cart is currently empty ";
}

// if update quantity button is clicked
if (array_key_exists('Update_Quantity', $_POST)) {
    foreach ($_SESSION['cartquantity'] as $productname => $productquantity) {
        foreach ($productquantity as $i => $quantity) {
            // if the updated quantity is valid, then replace the quantity in the session
            //Validate inputted quantities, number only, no negative, no decimals
            if (isset($_POST['quantity'][$productname][$i])) {
                $input_value = $_POST['quantity'][$productname][$i];
                $theErrors[$productname][$i] = validate_quantity($input_value);
                // if no error, then delete all data in $theErrors[$productname][$i]
                if (empty($theErrors[$productname][$i])) {
                    unset($theErrors[$productname][$i]);
                }
                // if no error, then replace the new quantities over the old quantity that store in session
                if (empty($theErrors[$productname])) {
                    $_SESSION['cartquantity'][$productname][$i] = $_POST['quantity'][$productname][$i];
                }
            }
        }
    }
}

// if Proceed to check out button is clicked, direct user to payment.php 
if (array_key_exists('check_out', $_POST)) {
    header('location: ./payment.php');
}

?>
<html>
   
    <body>
    <left>
        <h3>Shopping Cart</h3>
                
        <form action='<?php echo $_SERVER['PHP_SELF']; ?>' method="POST">
            <table border="1">
                <tbody>
                    <tr>
                        <!--                    table's column label -->
                        <td style="text-align: center;"><b><big>Product</big></b></td> 
                        <td style="text-align: center;"><b><big>Name</big></b></td> 
                        <td style="text-align: center;"><b><big>Price</big></b></td> 
                        <td style="text-align: center;"><b><big>Quantity</big></b></td> 
                        <td style="text-align: center;"><b><big>Extended Price</big></b></td> 
                    </tr>
                    <?php
                    //being subtotal is zero
                    $subtotal = 0;
                    foreach ($_SESSION['cartquantity'] as $productname => $productquantity) {
                        foreach ($productquantity as $i => $quantity) {
                            if ($productquantity[$i] > 0) {
                                // calculate the extended price
                                $extended_price = $allproductsarray[$productname][$i]['price'] * $productquantity[$i];
                                // calculate subtotal
                                $subtotal = $subtotal + $extended_price;

                                printf('
                <tr>
                <td><img src=./images/%s width=300, height=300></td>
                <td style = "text-align: center;">%s</td>
                <td style = "text-align: center;">$%.2f</td>
                <td style = "text-align: center;"><input type=text size=3 maxlength=3 name=quantity[%s][%d] value=%d>
                <br><input type="submit" name="Update_Quantity" value="Update Quantity">%s</td> 
                <td style = "text-align: center;">$%.2f</td> 
                </tr> ', $allproductsarray[$productname][$i]['image'], $allproductsarray[$productname][$i]['name'], $allproductsarray[$productname][$i]['price'], $productname, $i, $productquantity[$i], isset($theErrors[$productname][$i]) ? '<br>' . implode('<br>', $theErrors[$productname][$i]) : '', $extended_price);
                            }
                        }
                    }

// shipping cost information/calculate shipping cost
                    //if subtotal is less than $75 then shipping costs is $5
                    if ($subtotal < 75) {
                        $shipping = 5.00;
                        //if subtotal is less than $150 then shipping costs is $10
                    } elseif ($subtotal < 150) {
                        $shipping = 10.00;
                        //if subtotal is more than $150 then shipping is free
                    } else {
                        $shipping = 0;
                    }
//calculate tax 
                    $tax_rate = 0.045; // tax rate @ 4.5%
                    $tax = $tax_rate * $subtotal;
//calculate total check out
                    $total = $subtotal + $tax + $shipping;
                    ?>

                    <!--print out subtotal, tax rate, shipping fee, and total check out in 4 rows-->
                    <tr>
                        <td colspan = "4" width = "67%">
                            Sub-total
                        </td>
                        <td style = "text-align: center;" width = "54%">
                            $ <?php printf('%.2f', $subtotal);
                    ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" width="67%">

                            <font face="arial">
                            Tax rate @ 4.5%
                            </font>
                        </td>
                        <td style="text-align: center;" width="54%">
                            $ <?php printf('%.2f', $tax); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" width="67%">

                            <font face="arial">
                            Shipping fee
                            </font>
                        </td>
                        <td style="text-align: center;" width="54%">
                            $ <?php printf('%.2f', $shipping); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" width="67%">
                            <b>
                                Total
                            </b>
                        </td>
                        <td style="text-align: center;" width="54%">
                            <b>
                                $<?php printf('%.2f', $total); ?>
                            </b>
                        </td>
                    </tr>
            </table>
            </body>
            
<!--           Create Proceed to check out button-->
            <input type="submit" name="check_out" value="Check Out">

