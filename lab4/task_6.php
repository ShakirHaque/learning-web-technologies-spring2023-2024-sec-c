<?php

$data = array(25,67,98,60,55,787,637637,771,876,2123,536536);

$search = 60;

$found = false;
for ($i = 0; $i < count($data); $i++) {
    if ($data[$i] == $search) {
        $found = true;
        break;
    }
}

if ($found) {
    echo "Element found ";
} else {
    echo "Element not found ";
}
?>
