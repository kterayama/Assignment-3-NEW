
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
require 'functions.inc';
//starts session

$error = array();
// Checks if the login button has been pressed, if it has, checks for user information in 'user_data.dat'
if (array_key_exists('login_submit', $_POST)) {
    $userDataArrayFile = './user_data.dat';
 
    //retrieve user's information from variable userDataArrayFile and put it in as a value in $all_user_info_array
    $all_user_info_array = arrayfile_to_array($userDataArrayFile);
    //convert $all_user_info_array into lower case
    $all_user_info_array = array_change_key_case($all_user_info_array);
    
    //if username exists, get the password and check if the password enter is the same
    if (array_key_exists(strtolower($_POST['username']), $all_user_info_array)) {
        //password match?
        if ($_POST['password'] == $all_user_info_array[strtolower($_POST['username'])]['password']) {
            //session id is user's username
            $_SESSION['id'] = $_POST['username'];
            //if password matches, redirect to index.php
            header('location: ./index.php');
            exit;
        } else {
            //if password does not match, generate password error
            $error['password']['incorrect'] = 'Password incorrect';
        }
    } else {
        //if username is not found, generate username error
        $error['username']['incorrect'] = 'Username not found';
    }
}

//redirect to registration.php when New User button is pressed
if (array_key_exists('NewUser_submit', $_POST)) {
    header('location: ./registration.php');
}
?>
        
<form action ='<?php echo $_SERVER['PHP_SELF']; ?>' method = 'POST'>
    <?php
    // display login form
    printf('
    <center>
       
        <br> 
        <h2>Please Login Below </h2>    
        User Name: <input type="text" name="username" value=%s> %s
        <br><br>
        Password: <input type="password" name="password" value=%s> %s
        <br><br>
        <input type="submit" name="login_submit" value="Login">
        <br><br>
        <input type="submit" name="NewUser_submit" value="New User">
    </center>
    ', isset($_POST['username']) ? $_POST['username'] : '', isset($error['username']) ? '<br>' . implode('<br>', $error['username']) : '', isset($_POST['password']) ? $_POST['password'] : '', isset($error['password']) ? '<br>' . implode('<br>', $error['password']) : '');
    ?>
</form>

