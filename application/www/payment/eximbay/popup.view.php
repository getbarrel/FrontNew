<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Load Forbiz View
$view = getForbizView(true);
//
$url = $view->input->get('url');
$data = $view->input->post();
?>
<form name="regForm" method="post" action="<?=$url?>">
    <?php foreach ($data as $key => $val) { ?>
        <input type="hidden" name="<?=$key?>" value="<?=$val?>"/>
    <?php } ?>
</form>
<script>
    var frm = document.regForm;
    frm.submit();
</script>