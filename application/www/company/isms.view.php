<?php
$mobile_agent = "/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/";

if(preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])){
	echo '<img src="/assets/mobile_templet/mobile_enterprise/img/common/img_isms_m_211102.jpg" width="346" height="490">';
}else{
	echo '<img src="/assets/templet/enterprise/img/common/img_isms_pc_211102.jpg" width="720" height="630">';
}


