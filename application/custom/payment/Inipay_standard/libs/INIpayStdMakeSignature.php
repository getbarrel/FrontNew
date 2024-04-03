<?php

//E:\project\sejoing_front_dev\application\custom\payment\Inipay_standard\libs
require_once('INIStdPayUtil.php');

$SignatureUtil = new INIStdPayUtil();

$input = "oid=" . $_REQUEST["oid"] . "&price=" . $_REQUEST["price"] . "&timestamp=" . $_REQUEST["timestamp"];

$output['signature'] = array(
    ///'signature' => $SignatureUtil->makeHash($input, "sha256")
    'signature' => hash("sha256", $input)
);

echo json_encode($output);
?>
