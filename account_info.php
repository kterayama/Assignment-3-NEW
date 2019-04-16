
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

require 'functions.inc';


// if user is not logged in, redirect to login.php
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
}

// prevent user from directly typing in url and redirect user to login if they do so
if (!isset($_SERVER['HTTP_REFERER'])) {
    header('location:./login.php');
    exit;
}

// variable needed to retrieve relevant data from $userDataArrayFile
$userDataArrayFile = './user_data.dat';

$all_user_info_array = arrayfile_to_array($userDataArrayFile);
$all_user_info_array = array_change_key_case($all_user_info_array);

$username = $_SESSION['id'];

?>
<form action ='<?php echo $_SERVER['PHP_SELF']; ?>' method = 'POST'>
    <?php
// retrieve data from $userDataArrayFile and assign data retrieve to corresponding variables
    $email = $all_user_info_array[strtolower($username)]['email'];
    $fullname = $all_user_info_array[strtolower($username)]['fullname'];
    $password = $all_user_info_array[strtolower($username)]['password'];

// Check if the Update Account button has been pressed and values are valid, then overwrite old user's data with new data and store data in $userDataArrayFile
    if (array_key_exists('update_submit', $_POST)) {
        // master error array
        $error = array();
        // use functions created below to validate the users' input
        validate_password($_POST['password']);
        validate_email($_POST['email']);

//Overwrite user's information to $all_user_info_array using $user_registration_info to the file: 'user_data.dat' when $error is empty
        if (empty($error)) {
            // $new_user is an array that contain user's information: username, password, email
            $update_user = array('fullname' => $_POST['fullname'], 'password' => $_POST['password'], 'email' => $_POST['email']);
            // $new_user array is put in master array of $all_user_info_array identify by [$_POST['username']]
            $all_user_info_array[$username] = $update_user;
            // $all_user_info_array writes in $userDataArrayFile 
            array_to_arrayfile($all_user_info_array, $userDataArrayFile);
        }
    }
    ?>
    <?php
    // print out user account information update form
    printf('
    <center>
        <h2>Update Your Account </h2>
        User Name: <input type="text"  disabled  name="username" value=%s>
        <br><br>
        Full Name: <input type="text" required  name="fullname" value=%s> %s
        <br><br>
        Password: <input type="password" name="password" value=%s> %s
        <br><br>
        Re-enter Password: <input type="password" name="reEnterpassword" value=%s> %s
        <br><br>
        Email: <input type="text" name="email" value=%s> %s
        <br><br>
        <input type="submit" name="update_submit" value="Update Account">
    </center>
', $username, $fullname, isset($error['password']) ? '<br>' . implode('<br>', $error['password']) : '', $password, isset($error['password']) ? '<br>' . implode('<br>', $error['password']) : '', $password, isset($error['reEnterpassword']) ? '<br>' . implode('<br>', $error['reEnterpassword']) : '', $email, isset($error['email']) ? '<br>' . implode('<br>', $error['email']) : '');
    ?>
</form>

<?php
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
?>

