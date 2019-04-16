
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
        h4{
            font-family: "Courier New", monospace;
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
  
<?php
session_save_path('.');
session_start();
require 'all_products.php';
require 'functions.inc';

//checks if user is logged in, if not, they are directed to login page
if(!isset($_SESSION['id'])) {
  session_destroy();
  header("Location: login.php");
}

// creates page personalization
if(isset($_SESSION['id'])){
    echo "Welcome " . $_SESSION['id'] ;
}

//label specific product name into the $productname
$productname = "Rings";
$products = $allproductsarray[$productname];
//if cart is empty
if (!isset($_SESSION['cartquantity'][$productname])) {
        // start the cart out with zero items
        $cart = array_fill(0, count($products), 0);
        // put the cart into users session
        $_SESSION['cartquantity'][$productname] = $cart;
    }
   
$theErrors = array();
//run the following specific conditions if met when purchase button is clicked
If (isset($_POST["submit_purchase"])) {
    $has_selected_quantity = FALSE;
    for ($i = 0; $i < count($products); $i++) {
        $input_value = $_POST["quantity$i"];
        // if $input_value is not zero then buyer had selected some quantity, that why $has_selected_quantity is TRUE
        if ($input_value != 0) {
            $has_selected_quantity = TRUE;
        }
        //assigning errors found by using function validate_quantity($input_value) to $theErrors[$i]
        $theErrors[$i] = validate_quantity($input_value);
        //if $theErrors[$i] is empty which mean no errors are found, then unset $theErrors[$i]. *If not, $theErrors[$i] will still carrying empty key/array within, which is not "empty"*
        if (empty($theErrors[$i])) {
            unset($theErrors[$i]);
        }
    }
    //if the purchase button is clicked but no quantity is selected, shows the error message "Please select items"
    if (!$has_selected_quantity) {
        $theErrors['notSelection'] = "Please select items";
    }
    //if there are no errors, store the quantity data in session
    if (empty($theErrors)) {
        for ($i = 0; $i < count($products); $i++) {
            $_SESSION['cartquantity'][$productname][$i] = $_POST['quantity' . $i];
        }   
    }
}
?>

<html>
    <head>
        <title>Pandora's Box</title>
    </head>
    <body>
  
        <h4>Rings</h4>
                
        <form action='<?php echo $_SERVER['PHP_SELF']; ?>' method="POST">
            <table border="1">
                <tbody>
                    <tr>
                        <td style="text-align: center;"><b><big>Product</big></b></td> 
                        <td style="text-align: center;"><b><big>Name</big></b></td> 
                        <td style="text-align: center;"><b><big>Price</big></b></td> 
                        <td style="text-align: center;"><b><big>Quantity</big></b></td> 
                    </tr>
                    <?php
                    // printing the data into the table
                    for ($i = 0; $i < count($products); $i++) {
                        printf('
                            <div style="align:center"> 
                <img src= "%s" width=300, height=300><br>
               %s<br>
                $%.2f<br>
               <input type=text size=3 maxlength=3 name=quantity%d value=%d>%s<br>
               </div>
                </tr> ', $products[$i]['image'], $products[$i]['name'], $products[$i]['price'], $i, $_SESSION['cartquantity'][$productname][$i],isset($theErrors[$i]) ? '<br>' . implode('<br>', $theErrors[$i]) : '');
                    }
                    
                    ?>
                    <!-- submit purchase function-->
                    <tr><td colspan="4" style = "text-align: center; border: none"><input type="submit" name = "submit_purchase" value="Add to Cart">
                            <?php
                            //if "notselection" exist in the $theErrors, meaning that the submit button is click when no quantity is selected, print $theErrors['notSelection'] message below the submit button. 
                            if (array_key_exists('notSelection', $theErrors)) {
                                print '<br>' . $theErrors['notSelection'];
                            }
                            ?>
                            <a href="cart.php"><button type="button" class="btn btn-primary">View Cart</button></a>
                            <!-- create button to be able view shopping cart-->
                            <a href="index.php"><button type="button" class="btn btn-primary">Home</button></a>
                            <!-- create button to go back to home page-->
                        </td></tr>
                </tbody>
            </table>
            </body>
            </html>




