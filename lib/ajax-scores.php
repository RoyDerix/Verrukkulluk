<?php

if (isset($_POST['rating'])) {
    $score = $_POST['rating'];
    echo json_encode(array(
        'rating'=> $score
    ));
}
