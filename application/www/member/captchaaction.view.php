<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


$view = getForbizView(true);
$igData = $view->input->get();

	if($igData["captcha_text"] != "") {
		if($_SESSION["ig_capt"] == $igData["captcha_text"]) {
			echo "IG_OK";
			//	ig_로그인 성공시 처리
				if(trim($igData["uid"]) != "") {
						$view->qb
							->set('fail_count', '0', false)
							->where('id', $igData["uid"])
							->update(TBL_COMMON_USER)
							->exec();

				}
			//	ig_로그인 성공시 처리
			exit;
		} else {
			echo "IG_NO";
			exit;
		}
	} else {
			exit;
	}
exit;