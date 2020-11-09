<?php 
session_start();
if(isset($_REQUEST['share'])) {
	header('Location: lib/dashboard.php?file='.$_REQUEST['share']);
	exit();
} else {
header('Location: lib');
exit();
}
?>
