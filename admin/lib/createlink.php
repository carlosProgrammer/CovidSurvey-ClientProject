<?php if(!isset($_SESSION['filename'])) {?>
<div class="modal-header">
<div class="col-sm-12">

<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="javascript:window.location.href = window.location.href;">&times;</button>
<h4 class="modal-title"><?php echo _TEXT['FILE_SHARE'];?></h4>
</div>
<hr>
<br/>
<div class="alert alert-danger alert-dismissable">
	<p><?php echo _TEXT['NO_FILE_NAME'];?></p>
</div>
	<br/><br/>
	<div style="text-align:right;">
		<button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:window.location.href = window.location.href;"><?php echo _TEXT['CANCEL'];?></button>
    </div>


<?php return; } ?>
<?php // get the URL
$sharelink = preg_replace('|/lib|', '',$_SERVER['HTTP_REFERER']);
?>
 
		<div class="modal-header">
		<div class="col-sm-12">

		<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="javascript:window.location.href = window.location.href;">&times;</button>
		<h4 class="modal-title"><?php echo _TEXT['FILE_SHARE'];?></h4>
		</div>
		<hr>

		<br/>
		 <textarea class="form-control" rows="1" id="sharelink"><?php echo  $sharelink.'?share='.$_SESSION['filename'];?></textarea>
		 
		<div style="text-align:right;">
		<br/>
		<button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:window.location.href = window.location.href;"><?php echo _TEXT['CLOSE'];?></button>&nbsp;
		<button type="button" class="btn btn-primary" onClick="copypast('hiddencode')" ><?php echo _TEXT['COPY'];?>&nbsp;<span class="fa fa-copy"></span></button>
	    </div>			<!-- /modal-header -->

	
<script>
function copypast(id){
	document.getElementById('sharelink').select();
    document.execCommand('copy');
};
</script>	


