<?php
// 세션시작
session_start();

// 오류코드 정보 수정
// error_reporting(E_ALL & ~E_WARNING);
// ini_set('display_errors', 0);

define('CSS','/css');
define('JS','/js');
define('FRONT','/front');
define('site','yes');

// 현재 서버 주소 
$currentSiteURL = 'http';
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $currentSiteURL .= 's';
}
$currentSiteURL .= '://' . $_SERVER['HTTP_HOST'];

// 현재 서버 주소 URL 정의
define('URL',$currentSiteURL);

// 현재 서버의 CSS주소 URL 정의 
define('CSS_URL',$currentSiteURL.CSS);

// 현재 서버의 JS주소 URL 정의
define('JS_URL',$currentSiteURL.JS);

// Front 폴더의 css주소 url정의
define('FRONT_JS_URL',$currentSiteURL.FRONT.JS);
// Front 폴더의 js주소 url정의
define('FRONT_CSS_URL',$currentSiteURL.FRONT.CSS);
// Front 폴더 url 정의
define('FRONT_URL',$currentSiteURL.FRONT);

echo "Current site URL: $currentSiteURL" ;
echo '<br/>';
echo CSS;

echo '<br/>';
echo CSS_URL;
echo '<br/>';
echo FRONT_JS_URL;

//////////////////////////////////////////////

// @붙이고 하면 오류코드 제거 가능.
@include ('../member/memberController.php')

?>