<?php
include_once("$DOCUMENT_ROOT/class/database.class");
if (!class_exists('forbizDatabase')){ // 클래스선언이 없으면...

	class forbizDatabase extends Database{

	}


} // 클래스를 선언하고 종료한다...

if (!class_exists('CommerceDatabase'))
{ // 클래스선언이 없으면...
	class CommerceDatabase extends Database{

	}

} // 클래스를 선언하고 종료한다...
