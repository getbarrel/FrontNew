<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$view = getForbizView(true);



$id = $view->input->post('id');
if ($id) {
    setProductId($id);
}else{
    $result['result'] = 'fail';
    $result['data'] = 'not Product Id';
    echo json_encode($result);
}
        


