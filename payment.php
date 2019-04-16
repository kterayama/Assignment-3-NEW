
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
    <center>
    <H2>Welcome to</H2><P><H1>Pandora's Box</H1></P>
    <H3>where every special moment is saved in Pandora's Box<BR></H3>
<?php
session_save_path('.');
session_start();
require 'functions.inc';

//prevent access to the page without logging in and redirect to login.php
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
}

if (!isset($_SERVER['HTTP_REFERER'])) {
    //redirect user to login page if they try to type in the url
    header('location:./login.php');
    exit;
}

// if Confirm Purchase button is clicked, and all inputted data is valid, redirect to invoice.php 
if (array_key_exists('Confirm_purchase', $_POST)) {
    if (!isset($validateCC['invalid'])) {
        if (is_numeric($_POST['CVV'])) {
            $email = $_POST['email'];
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header('location: ./invoice.php');
            }
        }
    }
}
?>
<html>
    <head>
    </head>
    <body>
    <left>
        <h4>Payment and Billing Information</h4>
        <form action='<?php echo $_SERVER['PHP_SELF']; ?>' method="POST">
            <table border="0">
                <tbody>
                    <tr>
                        <!--                        input first name, require field -->
                        <td style="text-align: Left;">First Name</td> 
                        <td style="text-align: left;"><input type=text size=25 maxlength=30 name="FirstName" value="<?php echo @$_POST['FirstName']; ?>" required ></td>
                    </tr>
                    <tr>
                        <!--                        input last name, require field -->
                        <td style="text-align: left;">Last Name</td> 
                        <td style="text-align: left;"><input type=text size=25 maxlength=30 name="LastName" value="<?php echo @$_POST['LastName']; ?>" required></td>
                    </tr>
                    <tr>
                        <!--                     select card type  -->
                        <td style="text-align: left;">Card Type</td> 
                        <td style="text-align: left;">
                            <!--            select credit card type in the dropdown menu  -->
                            <select name="CardType" id="CardType">
                                <option value="Master">Master Card</option>
                                <option value="Visa">Visa</option>
                                <option value="American">American Express</option>
                                <option value="Dinners">Diners Club</option>
                                <option value="Discover">Discover</option>
                                <?php
                                // make the dropdown sticky once a credit card type is selected
                                if (isset($_POST['CardType'])) {
                                    print "<option selected value='{$_POST['CardType']}'>{$_POST['CardType']}</option>";
                                }
                                ?>
                            </select>
                    </tr>
                    <tr>
                        <!--                 input credit card number, required entry  -->
                        <td style="text-align: left;">Card Number</td> 
                        <td style="text-align: left;"><input type=text size=25 maxlength=30 name="Cardnumber" value="<?php echo @$_POST['Cardnumber'] ?>" required></td>
                        <td style="text-align: left;">
                            <?php
                            // validate credit card number and print error message if number is not validate
                            if (array_key_exists('Confirm_purchase', $_POST)) {
                                echo $validateCC['invalid'] = validateCC($_POST['Cardnumber'], $_POST['CardType']);
                            }
                            ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">Expire Date (MM)</td> 
                         <!--            select Month expire in the dropdown menu  -->
                        <td><select name="MM" id="ExpireMonth"> 
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <?php
                                //  make the dropdown sticky once the expire month is selected
                                if (isset($_POST['MM'])) {
                                    print "<option selected value='{$_POST['MM']}'>{$_POST['MM']}</option>";
                                }
                                ?>
                            </select>
                    </tr>
                    <tr>
                        <!--            select expire year in the dropdown menu  -->
                        <td style="text-align: left;">Expire Date (YYYY)</td> 
                        <td><select name="YYYY" id="ExpireYear" >
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                                <?php
                                //  make the dropdown sticky once the expire year is selected
                                if (isset($_POST['YYYY'])) {
                                    print "<option selected value='{$_POST['YYYY']}'>{$_POST['YYYY']}</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    </tr>
                    <tr>
                        <!--            input cvv  -->
                        <td style="text-align: left;">CVV</td> 
                        <td style="text-align: left;"><input type=text size=25 maxlength=3 name="CVV" value="<?php echo @$_POST['CVV']; ?>" required></td>
                        <td style="text-align: left;">
                            <?php
                            // validate inputted cvv, cvv only allow number entry
                            if (array_key_exists('Confirm_purchase', $_POST)) {
                                if (!is_numeric($_POST['CVV']))
                                    echo @$error['notNumeric'] = "Please input numeric value";
                            }
                            ?></td>

                    </tr>
                    <tr>
                        <!--                 input Cardholder Name, required entry  -->
                        <td style="text-align: left;">Cardholder Name</td> 
                        <td style="text-align: left;"><input type=text size=25 maxlength=30 name="Cardholder" value="<?php echo @$_POST['Cardholder']; ?>" required></td>
                    </tr>
                    <tr>
                        <!--                 input address, required entry  -->
                        <td style="text-align: left;">Address</td> 
                        <td style="text-align: left;"><input type=text size=25 maxlength=30 name="address" value="<?php echo @$_POST['address']; ?>" required></td>
                    </tr>
                    <tr>
                        <!--                 input city, required entry  -->
                        <td style="text-align: left;">City</td> 
                        <td style="text-align: left;"><input type=text size=25 maxlength=30 name="city" value="<?php echo @$_POST['city']; ?>" required></td>
                    </tr>
                    <tr>
                        <!--            select State in the dropdown menu  -->
                        <td style="text-align: left;">State</td> 
                        <td style="text-align: left;">
                            <select name="State" id="State">
                                <option value="AL">Alabama</option>
                                <option value="AK">Alaska</option>
                                <option value="AZ">Arizona</option>
                                <option value="AR">Arkansas</option>
                                <option value="CA">California</option>
                                <option value="CO">Colorado</option>
                                <option value="CT">Connecticut</option>
                                <option value="DE">Delaware</option>
                                <option value="DC">District Of Columbia</option>
                                <option value="FL">Florida</option>
                                <option value="GA">Georgia</option>
                                <option value="HI">Hawaii</option>
                                <option value="ID">Idaho</option>
                                <option value="IL">Illinois</option>
                                <option value="IN">Indiana</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="ME">Maine</option>
                                <option value="MD">Maryland</option>
                                <option value="MA">Massachusetts</option>
                                <option value="MI">Michigan</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NV">Nevada</option>
                                <option value="NH">New Hampshire</option>
                                <option value="NJ">New Jersey</option>
                                <option value="NM">New Mexico</option>
                                <option value="NY">New York</option>
                                <option value="NC">North Carolina</option>
                                <option value="ND">North Dakota</option>
                                <option value="OH">Ohio</option>
                                <option value="OK">Oklahoma</option>
                                <option value="OR">Oregon</option>
                                <option value="PA">Pennsylvania</option>
                                <option value="RI">Rhode Island</option>
                                <option value="SC">South Carolina</option>
                                <option value="SD">South Dakota</option>
                                <option value="TN">Tennessee</option>
                                <option value="TX">Texas</option>
                                <option value="UT">Utah</option>
                                <option value="VT">Vermont</option>
                                <option value="VA">Virginia</option>
                                <option value="WA">Washington</option>
                                <option value="WV">West Virginia</option>
                                <option value="WI">Wisconsin</option>
                                <option value="WY">Wyoming</option>
                                <?php
                                //  make the dropdown sticky once the State is selected
                                if (isset($_POST['State'])) {
                                    print "<option selected value='{$_POST['State']}'>{$_POST['State']}</option>";
                                }
                                ?>
                            </select>
                        </td>	

                    </tr>
                    <tr>
                        <!--                 input Postal Code, required entry  -->
                        <td style="text-align: left;">Postal Code</td> 
                        <td style="text-align: left;"><input type=text size=25 maxlength=5 name="PostalCode" value="<?php echo @$_POST['PostalCode']; ?>" required></td>
                    </tr>
                    <tr>
                        <!--                 input email address, required entry  -->
                        <td style="text-align: left;">Email Address</td> 
                        <td style="text-align: left;"><input type=text size=25 maxlength=30 name="email" value="<?php echo @$_POST['email']; ?>" required></td> 
                        <td style="text-align: left;">
                            <?php
                            // validate email address, if email format is invalid, print a message
                            if (array_key_exists('Confirm_purchase', $_POST)) {
                                $email = $_POST['email'];
                                if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                                    echo $error['email']['emailFormat'] = 'Invalid email format, please make sure to enter a valid email format';
                            }
                            ?></td>
                    </tr>

                </tbody>
            </table>
            </body>
            <!--                 create a confirm purchase button  -->
            <input type="submit" name = "Confirm_purchase" value="Complete Purchase">
            </html>

