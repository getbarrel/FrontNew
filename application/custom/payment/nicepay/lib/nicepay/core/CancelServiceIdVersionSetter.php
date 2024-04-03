<?php
require_once dirname(__FILE__).'/MessageIdVersionSetter.php';

/**
 * 
 * @author crimson
 *
 */
class CancelServiceIdVersionSetter implements MessageIdVersionSetter{
	
	/**
	 * Default constructor
	 */
	public function __construct(){
		
	}

	/**
	 * 
	 * @see MessageIdVersionSetter::fillIdAndVersion()
	 */
	public function fillIdAndVersion($webMessageDTO) {
		$webMessageDTO->setParameter(VERSION, "NPG01");
		$webMessageDTO->setParameter(ID, "IPGC1");
	}
}
?>