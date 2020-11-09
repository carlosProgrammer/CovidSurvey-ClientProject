<?php 
if (isset($_GET['task'])) {
		if ($_GET["task"]=='open'){
			$newfile = '../data'.DIRECTORY_SEPARATOR.'data.xml';
			$file = '../data'.DIRECTORY_SEPARATOR.'empty'.DIRECTORY_SEPARATOR.'data.xml';
			
			if (!copy($file, $newfile)) {
				echo "failed to copy $file...\n";
			}
			
			$newfile = '../data'.DIRECTORY_SEPARATOR.'layout.xml';
			$file = '../data'.DIRECTORY_SEPARATOR.'empty'.DIRECTORY_SEPARATOR.'layout.xml';
			
			if (!copy($file, $newfile)) {
				echo "failed to copy $file...\n";
			}
			session_start();
			$_SESSION['filename']="";
			session_destroy();
			header('Location: ' . $_SERVER["HTTP_REFERER"] );
			exit();
		}
}
?>


 <!-- Modal -->
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="javascript:window.location.href = window.location.href;">&times;</button>
		 <h4 class="modal-title"><?php echo _TEXT['OPEN_NEW_DASHBOARD'];?></h4>
	</div>			
	<!-- Tab Panel Ends -->
	<form  id="newfile" class="form-horizontal" action="<?php if (isset($_REQUEST['loc'])) {echo $_REQUEST['loc'];}?>new.php?task=open" method="post">
	<br/>
	
	<div class="col-sm-12">
	<h3><?php echo _TEXT['SURE_NEW_DASHBOARD'];?></h3>
		<br/>
	</div><br/><br/><br/><br/><br/>

	
	<div class="modal-footer">
		<button type="button" class="btn btn-primary"  data-dismiss="modal" onclick="javascript:window.location.href = window.location.href;"><?php echo _TEXT['CONFIRM_NO'];?></button>
		<button type="submit" class="btn btn-default"  style="float:right;"><?php echo _TEXT['CONFIRM_YES'];?></button>
	</div>
</form>

