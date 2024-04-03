<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Load Forbiz View
$view = getForbizView(true);

$data = $view->input->post();
log_message('error', 'eximbayResult : '.json_encode($data));
if ($view->input->post('rescode') == '0000') {
    ?>
    <form name="regForm" method="post" action="/payment/eximbay/result">
        <?php foreach ($data as $key => $val) { ?>
            <input type="hidden" name="<?=$key?>" value="<?=$val?>"/>
        <?php } ?>
    </form>
    <script>
        opener.name = 'eximbayResult';
        var frm = document.regForm;
        frm.target = opener.name;
        frm.submit();
        self.close();
    </script>
    <?php
} else if ($view->input->post('rescode') == 'XXXX') {
    ?>
    <script>
        self.close();
    </script>
    <?php
} else {
    ?>
    <script>
        alert('<?=$view->input->post('resmsg');?>');
        self.close();
    </script>
    <?php
}