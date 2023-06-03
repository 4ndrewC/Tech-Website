<?php
/**
* @project ApPHP WebsiteCleaner
* @copyright (c) 2014 ApPHP
* @author ApPHP <info@apphp.com>
* @license http://www.gnu.org/licenses/
*/

// Initialize the session
session_start();

include('../include/settings.inc.php');
include('../include/functions.inc.php');

$file = isset($_POST['file']) ? $_POST['file'] : '';
$action = isset($_POST['action']) ? $_POST['action'] : '';
$malware = isset($_POST['malware']) ? $_POST['malware'] : '';
$check_key = isset($_POST['check_key']) ? $_POST['check_key'] : '';
$post_token = isset($_POST['token']) ? $_POST['token'] : '';
$session_token = isset($_SESSION['token']) ? $_SESSION['token'] : '';
$arr = array();

if($check_key == 'apphpwsc' && $post_token == $session_token){
	
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');   // Date in the past
	header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header('Cache-Control: no-cache, must-revalidate'); // HTTP/1.1
	header('Pragma: no-cache'); // HTTP/1.0
	header('Content-Type: application/json');
	
    $success = false;
	if(_MODE == 'demo'){		
        $arr[] = '"status": "1"';
        $success = true;
    }else if($action == 'delete'){
        if(@unlink('../'.$file)){
            $arr[] = '"status": "1"';
            $success = true;
        }        
    }else if($action == 'clean'){
        $content = file_get_contents('../'.$file);
        if($content !== false){
			
			$singature = wscFindSignature($malware);
			$malwareSingature = isset($singature['signature']) ? $singature['signature'] : '';
			if(preg_match('/'.preg_quote($malwareSingature, '/').'/i', $content)){
                if($fh = fopen('../'.$file, 'w')){
                    $content = str_replace($malwareSingature, '', $content);
                    fwrite($fh, $content);
                    fclose($fh);                    
                    $arr[] = '"status": "1"';
                    $success = true;
                }
            }
        }                
	}
    
    
    if(!$success){
        $arr[] = '"status": "0"';        
        $arr[] = '"error_description": "File '.$file.' '.($action == 'clean' ? 'cleaning' : 'deleting').' error!"';
    }	
	
	echo '{';
	echo implode(',', $arr);
	echo '}';
}else{
	// wrong parameters passed!
	$arr[] = '"status": "0"';
    $arr[] = '"error_description": "Wrong parameters!"';
	echo '{';
	echo implode(',', $arr);
	echo '}';
}    
