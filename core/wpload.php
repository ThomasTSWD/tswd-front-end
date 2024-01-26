<?php 

/*------------ FindWPConfig - searching for a root of wp - php--------- */
function FindWPConfig($dirrectory){
global $confroot;
foreach(glob($dirrectory."/*") as $f){
if (basename($f) == 'wp-config.php' ){
$confroot = str_replace("\\", "/", dirname($f));
return true;
}
if (is_dir($f)){
$newdir = dirname(dirname($f));
}
}
if (isset($newdir) && $newdir != $dirrectory){
if (FindWPConfig($newdir)){
return false;
}	
}
return false;
}
if (!isset($table_prefix)){
global $confroot;
FindWPConfig(dirname(dirname(__FILE__)));
/*------------------------Inclure wp-load en php ------------------*/
/*include_once $confroot."/wp-config.php";*/
include_once $confroot."/wp-load.php";
}



?>