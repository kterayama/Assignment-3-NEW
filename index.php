<!DOCTYPE html>
<!--
Author: Benjamin Liang & Laila Abella
Class: ITM 352
Project: Assignment 2
In case, if the register is not working.
Testing username:itm352
testing password:grader
Description: Create a website for products with a login, registration, and invoice and use persistent data
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Assignment2</title>
    </head>
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
    <body>
    <center>
<?php
session_save_path('.');
session_start();
//starts the session

if(!isset($_SESSION['id'])) {
  session_destroy();
  header("Location: login.php");
} //makes sure that the user is logged in before being able to view the store

?>
        <H2>Welcome to</H2><P><H1>Pandora's Box</H1></P>
    <H3>where every special moment is saved in Pandora's Box<BR></H3>

    <table>
        <tr><th><font face="Courier New">Necklaces</font><br></th></tr>
        <tr><th><a href="Necklaces.php"><img name="arrow" align="left" src="1 Arrow.jpg" border=0 height="300x" width="400px" alt=""></a>
            </th></tr>
        <tr><th>
                <font face="Courier New">Earrings</font><br>
                <a href="Earrings.php"><img name="earring"  align="center" src="1 Earring.jpg" border=0 height="300px" width="400x" alt=""></a>
            </th></tr>

        <tr><th>    
                <font face="Courier New">Rings</font><br>
                <a href="Rings.php"><img name="ring"  align="left" src="1 Ring.jpg" border=0 height="300px" width="400px" alt=""></a>
            </th></tr>
        </p>
        <br>
        <a href="cart.php"><button type="button" align="left" class="btn btn-primary">View Cart</button></a><br>
        <!-- create button to be able view shopping cart-->
        <a href="account_info.php"><button type="button" align="left" class="btn btn-primary">Update Account Information</button></a>
        <!-- create button to be able to update account info-->
    </table>        
</body>
</html>

