
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

// prevent users to access to invoice.php + redirect users to login.php if they try to access invoice.php directly
if (!isset($_SESSION['id'])) {
    header("Location: ./login.php");
}

//redirect user to login page if they try to direct access invoice.php by typing the url
if (!isset($_SERVER['HTTP_REFERER'])) {
    header('location:./login.php');
    exit;
}

require 'functions.inc';
require 'products.php';
$userDataArrayFile = './user_data.dat';
//retrieve user name information from $all_user_info_array
$all_user_info_array = arrayfile_to_array($userDataArrayFile);
$all_user_info_array = array_change_key_case($all_user_info_array);
// retrieve email data from $all_user_info_array
$email = $all_user_info_array[strtolower($_SESSION['id'])]['email'];

// use ob_start() and ob_get_flush() to contain invoice information
ob_start();
?>

<html>
    <head>
        <title>Nike Store</title>
        
    </head>
    <body>
    <center>
        <h1>Hi, <?php echo $_SESSION['id']; ?> here is your invoice.</h1>

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

                // printing the data onto the table only if quantity is greater than zero
                foreach ($_SESSION['cartquantity'] as $productname => $productquantity) {
                    for ($i = 0; $i < count($productquantity); $i++) {
                        if ($productquantity[$i] > 0) {
                            // calculate the extended price
                            $extended_price = $allsurfboardsarray[$productname][$i]['price'] * $productquantity[$i];
                            // calculate subtotal
                            $subtotal = $subtotal + $extended_price;

                            printf('
                <tr>
                <td><img src=./images/%s width=300, height=300></td>
                <td style = "text-align: center;">%s</td>
                <td style = "text-align: center;">$%.2f</td>
                <td style = "text-align: center;">%d</td> 
                <td style = "text-align: center;">$%.2f</td> 
                </tr> ', $allsurfboardsarray[$productname][$i]['image'], $allsurfboardsarray[$productname][$i]['name'], $allsurfboardsarray[$productname][$i]['price'], $productquantity[$i], $extended_price);
                        }
                    }
                }

                // shipping costs information & calculate shipping cost
                //if subtotal is less than $75 then shipping costs is $5
                if ($subtotal < 75) {
                    $shipping = 5.00;
                    //if subtotal is less than $150 then shipping costs is $10
                } elseif ($subtotal < 200) {
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

                <?php
                $invoice = ob_get_flush();

                //tells PHP what mail server to use
                $mail_server = "mail.hawaii.edu";
                ini_set("SMTP", $mail_server);

                //provides a 'from' address so spam filters don't complain
                $from_address = "jmomoki@hawaii.edu";
                ini_set("sendmail_from", $from_address);

                $recipient = $email;
                $subject = "Order confirmation";

                // Try to send the email
                if (mail($recipient, $subject, $invoice)) {
                    echo "Thank you for your order {$_SESSION['id']}! a copy of this invoice has been emailed to you";
                } else {
                    echo "Invoice failed to send to $email";
                }

                //delete session once transaction is completed.
                session_destroy();
                ?>

