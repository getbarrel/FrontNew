<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Load Forbiz View
$view = getForbizView(true);

if ($view->input->get('code') == '0') {
    ?>
    <script>
        opener.location.href = '/payment/payco/result?<?=http_build_query($view->input->get());?>';
        self.close();
    </script>
    <?php
} else if ($view->input->get('code') == '2222') {
    ?>
    <script>
        self.close();
    </script>
    <?php
} else {
    ?>
    <script>
        alert('결제 오류 : <?=$view->input->get('code');?>');
        self.close();
    </script>
    <?php
}