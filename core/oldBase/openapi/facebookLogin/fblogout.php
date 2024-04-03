<?
/**
 * facebook 로그아웃 처리페이지 샘플
 * 
 * - 쿠키삭제
 * - 메인페이지로 이동
 * 
 * @author bgh
 * @date 2013.07.15
 * 
 */
 
$past = time() - 3600;
foreach ( $_COOKIE as $key => $value )
{
    setcookie( $key, $value, $past, '/' );
}

echo "<script>document.location.href = 'http://".$_SERVER["HTTP_HOST"]."';</script>";
