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

?>
<form action ='<?php echo $_SERVER['PHP_SELF']; ?>' method = 'POST'>
            
    <?php
// Check if the register button has been pressed 
    if (array_key_exists('Register_submit', $_POST)) {
        require 'functions.inc';
        // master error array
        $error = array();
        
        //variables needed for functions to validate user's input
        $userDataArrayFile = './user_data.dat';
        $all_user_info_array = arrayfile_to_array($userDataArrayFile);
        
        // use functions created below to validate the users' input
        validate_username($_POST['username'], $all_user_info_array);
        validate_password($_POST['password']);
        validate_email($_POST['email']);

        //add user's information to $all_user_info_array using $user_registration_info to the file: 'user_data.dat' when $error is empty
        if (empty($error)) {
            // $new_user is an array that contain user's information: username, fullname, password, email
            $new_user = array('username' => $_POST['username'], 'fullname' => $_POST['fullname'], 'password' => $_POST['password'], 'email' => $_POST['email']);
            // $new_user array is put in master array of $all_user_info_array identify by [$_POST['username']]
            $all_user_info_array[$_POST['username']] = $new_user;
            // $all_user_info_array is write in $userDataArrayFile 
            array_to_arrayfile($all_user_info_array, $userDataArrayFile);

            //User's username is $_SESSION['id']
            $_SESSION['id'] = $_POST['username'];
            //redirect
            header('location: ./index.php');
            exit;
        }
    }
    ?>
    <?php
    // print out registration form
    printf('
    <center>
        <h2>Create an Account </h2>
        User Name: <input type="text" name="username" value=%s> %s
        <br><br>
        Full Name: <input type="text" required  name="fullname" value=%s>
        <br><br>
        Password: <input type="password" name="password" value=%s> %s
        <br><br>
        Re-enter Password: <input type="password" name="reEnterpassword" value=%s> %s
        <br><br>
        Email: <input type="text" name="email" value=%s> %s
        <br><br>
        <input type="submit" name="Register_submit" value="Register">
    </center>
', isset($_POST['username']) ? $_POST['username'] : '', isset($error['username']) ? '<br>' . implode('<br>', $error['username']) : '', isset($_POST['fullname']) ? $_POST['fullname'] : '', isset($_POST['password']) ? $_POST['password'] : '', isset($error['password']) ? '<br>' . implode('<br>', $error['password']) : '', isset($_POST['reEnterpassword']) ? $_POST['reEnterpassword'] : '', isset($error['reEnterpassword']) ? '<br>' . implode('<br>', $error['reEnterpassword']) : '', isset($_POST['email']) ? $_POST['email'] : '', isset($error['email']) ? '<br>' . implode('<br>', $error['email']) : '');
    ?>
</form>

<?php
//create function to validate users' input
function validate_username($username, $all_user_info_array) {
    global $error;
    // check if username already exists
    if (array_key_exist_case_ins($username, $all_user_info_array))
        $error['username']['Username'] = 'Sorry, username already exists';
    //if username characters are not in the range of 3-15, return errors
    if ((3 > strlen($username))or ( strlen($username) > 15))
        $error['username']['usernameLength'] = "Please make a username with a length greater than 3 and less than 15 characters";
    //if username contains characters other than letters and numbers
    if (!ctype_alnum($username))
        $error['username']['notLetterNum'] = "Please enter a username contain only letter and/or number";
}

function validate_password($password) {
    global $error;
    //if password's length is less than 5, return errors
    if ((strlen($password) < 5))
        $error['password']['passwordLength'] = "Please make a password with a length greater than 5 characters";
    //if the password does not match with Re-enter Password, return error
    if ($password !== $_POST['reEnterpassword'])
        $error['reEnterpassword']['password_NotMatch_reEnterpassword'] = "Password does not match with Re-enter Password, please re-enter again";
}

function validate_email($email) {
    global $error;
// Email: Format: x@y.z, x=letters, #,_,.  ;  y=only letter&number& "." ; z=domain name ex: edu, tv, com, case insensitive
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $error['email']['emailFormat'] = 'Invalid email format, please make sure to enter a valid email format';
}
