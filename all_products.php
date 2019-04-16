
<?php

//Create an array to store product images
$image = array(
    "<img src='1 Arrow.jpg'>",
    "<img src='2 Key.jpg'>",
    "<img src='3 Bow.jpg'>",
    "<img src='1 Ring.jpg'>",
    "<img src='2 Ring.jpg'>",
    "<img src='3 Ring.jpg'>",
    "<img src='1 Earring.jpg'>",
    "<img src='2 Earring.jpg'>",
    "<img src='3 Earring.jpg'>",
);

$product0 = array(
    'name' => 'Sparkling Arrow Necklace, <BR> Clear CZ',
    'price' => 75,
    'image' => $image[0]);
$product1 = array(
    'name' => 'Regal Key Necklace, <BR> Sterling Silver',
    'price' => 100,
    'image' => $image[1]);
$product2 = array(
    'name' => 'Brilliant Bow Necklace, <BR> Clear CZ',
    'price' => 100,
    'image' => $image[2]);
$product3 = array(
    'name' => 'Bedazzling Bufferfly Ring',
    'price' => 125,
    'image' => $image[3]);
$product4 = array(
    'name' => 'Flower Crown Ring',
    'price' => 100,
    'image' => $image[4]);
$product5 = array(
    'name' => 'Shining Wash Ring',
    'price' => 55,
    'image' => $image[5]);
$product6 = array(
    'name' => 'Matte Heart Earring',
    'price' => 55,
    'image' => $image[6]);
$product7 = array(
    'name' => 'Butterfly Outline Earring',
    'price' => 65,
    'image' => $image[7]);
$product8 = array(
    'name' => 'Bedazzling Butterfly Earring',
    'price' => 90,
    'image' => $image[8]);


// multidimentional array to store all prod info
$allproductsarray = array(
    'Necklaces' => array($product0, $product1, $product2),
    'Earrings' => array($product3, $product4, $product5),
    'Rings' => array($product6, $product7, $product8),
);
?>
