<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Load Forbiz View
$view = getForbizView(true);

if ($view->input->get('status') == 'PAY_APPROVED') {
    ?>
    <script>
        opener.location.href = '/payment/toss/result?<?=http_build_query($view->input->get());?>';
        self.close();
    </script>
    <?php
} else {
    ?>
    <script>
        alert('결제 오류 : <?=$view->input->get('status');?>');
        self.close();
    </script>
    <?php
}