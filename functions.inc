
<!-- Author: Thomas Norton 
The Surfboard Shack is a website designed to cater to all ages: keiki to kane and wahine. We sell surfboards. 
This page is in an extension page to house the various functions needed through the webpages being presented. This is a convenient way to 
-->
<?php

function arrayfile_to_array($filepath) {
// This function reads the file at $filepath and returns an array
// It is assumed that the file being read is a serialized array (created using array_to_arrayfile)
    $fsize = @filesize($filepath);
    if ($fsize > 0) {
        $fp = fopen($filepath, "r");
        $encoded = fread($fp, $fsize);
        fclose($fp);
        return unserialize($encoded);
    } else
        return array();
}

function array_to_arrayfile($theArray, $filepath) {
// This function serializes an array in $theArray and saves it in the file at $filepath. 
// The file may then be converted back into an array using the arrayfile_to_array() function

    if ($fp = fopen($filepath, "w+")) {
        $encoded = serialize($theArray);
        fwrite($fp, $encoded);
        fclose($fp);
    } else
        echo "Unable to write array to $filepath";
}

// This function make input into lower case
function array_key_exist_case_ins($needle, $hay) {
    return in_array(strtolower($needle), array_map('strtolower', array_keys($hay)));
}

// create a function validate_quantity to check if there are any errors in the $input_value. Where $input_value = $_POST["quantity$i"]
function validate_quantity($input_value) {
    $error = array();
    // if the $input_value (buyer input) is not numeric, $error['notNumeric']which contain the message "Please input numeric value" will be adding to the $error = array().
    if (!is_numeric($input_value))
        $error['notNumeric'] = "Please input numeric value";
    // if the $input_value (buyer input) is less than zero (negative), $error["cannotBeNegative"] which contain the message "Please input a positive value" will be adding to the $error = array().
    if ($input_value < 0)
        $error["cannotBeNegative"] = "Please input a positive value";
    // if the $input_value (buyer input)contain decimal, $error["float"] which contain the message "Please enter a whole integer" will be adding to the $error = array().
    if (strpos($input_value, '.') != FALSE)
        $error["float"] = "Please enter a whole integer";
    return $error;
}

// A method to check credit 
function validateCC($cc_num, $type) {
    if ($type == "American") {$pattern = "/^([34|37]{2})([0-9]{13})$/";if (preg_match($pattern, $cc_num)) {$verified = true;} else {$verified = false;}} elseif ($type == "Dinners") {$pattern = "/^([30|36|38]{2})([0-9]{12})$/";if (preg_match($pattern, $cc_num)) {$verified = true;} else {$verified = false;}} elseif ($type == "Discover") {$pattern = "/^([6011]{4})([0-9]{12})$/";if (preg_match($pattern, $cc_num)) {$verified = true;} else {$verified = false;}} elseif ($type == "Master") {$pattern = "/^([51|52|53|54|55]{2})([0-9]{14})$/";if (preg_match($pattern, $cc_num)) {$verified = true;} else {$verified = false;}} elseif ($type == "Visa") {$pattern = "/^([4]{1})([0-9]{12,15})$/"; if (preg_match($pattern, $cc_num)) {$verified = true;} else {$verified = false;}}

    if($verified == false) {
    //if validation fail, print a message
    echo "Credit card invalid. Please make sure that you entered a valid credit card ";
    } 
}

?>


