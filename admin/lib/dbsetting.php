<?php
$url =  $_SERVER['REQUEST_URI']; 
$folder ="..".DIRECTORY_SEPARATOR;
$google_url = "";
$saved_url = "";
$col = (int) $_REQUEST['col'];
if (isset($_GET['task'])) {
if ($_GET["task"]=='save'){
savedataDB($col);
header('Location: ' . $_SERVER["HTTP_REFERER"] );
}
}


$xmlfile = '../data/version.xml';
$xmlinfo=simplexml_load_file($xmlfile);
$xmlinfo->asXML($xmlfile);
$languagefile = include('../language/'.$xmlinfo->language.'.php');
define ('_TEXT',$languagefile);
?>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php echo _TEXT['DATA_SOURCE_SETTING'];?></title> 
<script>
		document.getElementById('fileToUpload').required = false;
		$('#fileToUpload').get(0).setCustomValidity('');
		
		document.getElementById('google_url').required = false;
		$('#google_url').get(0).setCustomValidity('');
</script>  


 <!-- Modal -->
 
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="javascript:window.location.href = window.location.href;">&times;</button>
                 <h4 class="modal-title"><?php echo _TEXT['DATA_SOURCE_SETTING'];?></h4>
            </div>			<!-- /modal-header -->
			<?php 
			

			
			$xmlDoc=simplexml_load_file($folder.'data/data.xml');
			if (!isset ($xmlDoc->col[$col]->rdbms)) {
				$xmlDoc->col[$col]->source = $xmlDoc->col[0]->source;
				$xmlDoc->col[$col]->rdbms = $xmlDoc->col[0]->rdbms;
	 			$xmlDoc->col[$col]->servername  = $xmlDoc->col[0]->servername ;
	 			$xmlDoc->col[$col]->ssl = $xmlDoc->col[0]->ssl;
	 			$xmlDoc->col[$col]->username = $xmlDoc->col[0]->username ;
	 			$xmlDoc->col[$col]->password = $xmlDoc->col[0]->password;
	 			$xmlDoc->col[$col]->dbname = $xmlDoc->col[0]->dbname;
				$xmlDoc->col[$col]->dbconnected = $xmlDoc->col[0]->dbconnected ;
				$xmlDoc->col[$col]->file = $xmlDoc->col[0]->file;
			     $xmlDoc->asXML($folder.'data/data.xml');
			}
			
			$rdbms = $xmlDoc->col[$col]->rdbms;
			
			$title = $xmlDoc->col[$col]->title;			
			?>

			<form id="dbsetting" class="form-horizontal" enctype="multipart/form-data" action="dbsetting2.php?task=save&layout=1&col=<?php echo $_POST['col'];?>" method="post" onsubmit="return validateForm();">
			<fieldset>
			 </br>
			
			<div class="modal-body">
			
			<!-- Tab Panel starts -->
			<ul class="nav nav-tabs">
			<?php
			$dbTabActive = "active";
			$xlTabActive = "";
			 if ($xmlDoc->col[$col]->dbconnected== '1'){
				  $dbTabActive = "active";
				  $xlTabActive = "";
				}
		
				if ($xmlDoc->col[$col]->source== 'upload'){
					if (substr($xmlDoc->col[$col]->file,0,6)=="https:" ) {
							$google_url = "checked";
							$dbTabActive = "";
							$xlTabActive = "active";
							$saved_url = $xmlDoc->col[$col]->file;
						} else {
							if (file_exists($xmlDoc->col[$col]->file)) {
								$dbTabActive = "";
								$xlTabActive = "active";
							}
					}
				}
			?>
			  <li class="<?php echo $dbTabActive;?>"><a data-toggle="tab" href="#home" onclick="tabvalue('ADatabase');">&nbsp;&nbsp;&nbsp;&nbsp; <?php echo _TEXT['DATABASE'];?> &nbsp;&nbsp;&nbsp;&nbsp;</a></li>
			  <li class="<?php echo $xlTabActive;?>"><a data-toggle="tab" id="xltabid" href="#menu1" onclick="tabvalue('upload');">   <?php echo _TEXT['FILE'];?></a></li>
			  <input type="hidden" id="source" name="source" value="ADatabase" />
			</ul>

			<div class="tab-content">
			<!-- Tab for Data Source -->
			  <div id="home" class="tab-pane fade in <?php echo $dbTabActive;?>">

			  		<p>&nbsp;</p>
					<div id="Database" >
					<!-- Database connection -->
						<label  class="col-sm-3 control-label"><?php echo _TEXT['DATABASE'];?>:</label>
						  <div class="col-sm-8" >
						  <select class="form-control" id="rdbms" name="rdbms" value="<?php echo $rdbms;?>" onchange="DBSelection()">
							<option value="mysql" <?php if (($rdbms=='mysql') || ($rdbms=='')){?> selected <?php }?>>MySQL</option>
							<option value="sqlite" <?php if ($rdbms=='sqlite'){?> selected <?php }?>>SQLite</option>
						  </select>
						  </div>
						  
						
						<div id="hostID" <?php if ($rdbms=='sqlite'){?> style="display:none;"<?php }?>>  
						<br/><p>&nbsp;</p>
					  	<label class="col-sm-3 control-label"><?php echo _TEXT['HOST'];?>:</label> 
						<div class="col-sm-8">
						   <input type="text" class="form-control" id="host" name="host" value="<?php echo $xmlDoc->col[$col]->servername;?>" placeholder="localhost" size="50" <?php if (!($rdbms=='sqlite')){?> required oninvalid="this.setCustomValidity('<?php echo _TEXT['ENTER_HOST_NAME'];?>')" oninput="setCustomValidity('')" <?php }?>/>    
						</div>
						</div>
						
						
						<div id="userID" <?php if ($rdbms=='sqlite'){?> style="display:none;"<?php }?>>
						<br/><p>&nbsp;</p>
						<label class="col-sm-3 control-label"><?php echo _TEXT['USER'];?>:</label> 
						<div class="col-sm-8">
						   <input type="text" class="form-control" id="user" name="user" value="<?php echo $xmlDoc->col[$col]->username;?>" placeholder="root" size="50" <?php if (!($rdbms=='sqlite')){?> required oninvalid="this.setCustomValidity('<?php echo _TEXT['ENTER_USER_NAME'];?>')" oninput="setCustomValidity('')"  <?php }?>/>    
						</div>
						</div>
						
						<div id="passwordID" <?php if ($rdbms=='sqlite'){?> style="display:none;"<?php }?>>
						<br/><p>&nbsp;</p>
						<label class="col-sm-3 control-label"><?php echo _TEXT['PASSWORD'];?>:</label> 
						<div class="col-sm-8">
						   <input type="password" class="form-control" id="password" name="password" value="<?php echo $xmlDoc->col[$col]->password;?>" size="50"/>    
						</div>
						</div>
						
						<br/><p>&nbsp;</p>
						
						<label class="col-sm-3 control-label"><?php echo _TEXT['DB_NAME'];?>:</label> 
						<div class="col-sm-8">
						   <input type="text" id="dbname" class="form-control" name="dbname" value="<?php echo $xmlDoc->col[$col]->dbname;?>" placeholder="<?php echo _TEXT['TYPE_YOUR_DATABASE_NAME'];?>" size="50" required oninvalid="this.setCustomValidity('<?php echo _TEXT['ENTER_DB_NAME'];?>')" oninput="setCustomValidity('')" />    
						</div>
						<br/><p>&nbsp;</p>
						
						<label class="col-sm-3 control-label"><?php echo _TEXT['SSL_ENABLED'];?>:</label> 
						<div class="col-sm-2">
						   <input type="checkbox" id="ssl" name="ssl" <?php if($xmlDoc->col[$col]->ssl=='on'){ echo 'checked';}?> />   
						</div>
						<br/><p>&nbsp;</p>

					</div>
					
			  </div>
			<!-- Tab Data Source end -->
	
			<!-- Tab for Properties -->  
			  <div id="menu1" class="tab-pane fade in <?php echo $xlTabActive;?>">
				<div class="col-md-12">
				<br/>         
				
				<input type="radio" name="pc_cloud" value="pc" checked id="pc">
				<label> <?php echo _TEXT['UPLOAD_FILE'];?></label>
							<?php if($xlTabActive) {?>
								<div class="label label-success"><?php echo basename($xmlDoc->col[$col]->file);?></div>
							  <?php } ?>
							  
							  <div class="form-group files">

								<input type="file" name="fileToUpload" id="fileToUpload" class="form-control"  title="<?php echo _TEXT['SELECT_XLS_CSV'];?>" oninvalid="this.setCustomValidity('<?php echo _TEXT['SELECT_XLS_CSV'];?>')" oninput="setCustomValidity('')"
								value ="<?php if (file_exists($xmlDoc->col[$col]->file)) {echo $xmlDoc->col[$col]->file;}?>" lang="de-de"/>								
								
								<div class="col-md-8 col-lg-8 col-sm-8">
									<select  id="fileselect" name="filename" class="form-control col-sm-offset-2" size="6" onclick="fileselect_f();">
									   <?php
										 $search = $folder. "data".DIRECTORY_SEPARATOR."*.{csv,xls,xlsx}";
										 
										 $patterns = array();
										 $replacements =  array();
										 foreach (glob($search, GLOB_BRACE) as $filename) {
													$filenamevalue = $filename;
													$patterns[0] = '/...data/';
													$replacements[0] = '';
													$patterns[2] = '/\\\/';
													$replacements[2] = '';

													$filename= preg_replace($patterns, $replacements, $filename);

													echo '<option value="'. $filenamevalue.'">'. $filename .'</option>';
												}

										?>    
										</select>
										<br/>
									</div>								
								
								
							  </div>           
						    
				</div>
				
				<div class="col-md-12"> 
				<br/>
				<input type="radio" name="pc_cloud" value="cloud" id="cloud" <?php echo $google_url;?> onchange="google_url_f();"><label>&nbsp;Google Drive</label>&nbsp;
				<input type="url" name="google_url" id="google_url"
				   placeholder="https://docs.google.com/spreadsheets.."
				   pattern="https://.*" size="55"
				    onfocus="google_url_f();"
					oninvalid="this.setCustomValidity('<?php echo _TEXT['VALID_URL'];?>')" oninput="setCustomValidity('')"
					value ="<?php echo $saved_url;?>"
				   >
				   <p><br/></p>
				</div>
			  </div>
			  <!-- Tab Properties Ends -->
			  
			  
			</div>
			<!-- Tab Panel Ends -->

			<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:window.location.href = window.location.href;"><?php echo _TEXT['CANCEL'];?></button>
                <button type="submit" class="btn btn-primary"><?php echo _TEXT['SAVE_CHANGES'];?></button>
            </div>
			</fieldset>
			</form>
			</div>			<!-- /modal-body -->


<?php
function savedataDB($col) {
	
	 $xmlfile = '../data/data.xml';
	 $xmlDoc=simplexml_load_file($xmlfile);

	 $xmlDoc->col[$col]->source = $_POST['source'];
	 
	 if ($_POST['source']=='ADatabase'){
	 	$xmlDoc->col[$col]->rdbms = $_POST['rdbms'];
	 }
 
	 if (!empty($_POST['host'])){
	 	$xmlDoc->col[$col]->servername = $_POST['host'];
	 }
	 
	 $xmlDoc->col[$col]->ssl = '';
	 if (!empty($_POST['ssl'])){
	 	$xmlDoc->col[$col]->ssl = $_POST['ssl'];
	 }
		
	if (!empty($_POST['user'])){
	 	$xmlDoc->col[$col]->username = $_POST['user'];
		}
		

	 $xmlDoc->col[$col]->password = $_POST['password'];

		
	if (!empty($_POST['dbname'])){
	 	$xmlDoc->col[$col]->dbname = $_POST['dbname'];
		}

		
	 // DB connection start
			if ($_POST['source']=='ADatabase'){
			if (!$xmlDoc->col[$col]->dbname==''){

			$DB_TYPE = $xmlDoc->col[$col]->rdbms; //Type of database<br>
			if (isset($_POST['ssl'])){
				$DB_HOST = 'https://'.$xmlDoc->col[$col]->servername; //Host name<br>
				}
				else
				{
				$DB_HOST = $xmlDoc->col[$col]->servername; //Host name<br>
			}
			$DB_USER = $xmlDoc->col[$col]->username; //Host Username<br>
			$DB_PASS = $xmlDoc->col[$col]->password; //Host Password<br>
			$DB_NAME = $xmlDoc->col[$col]->dbname; //Database name<br><br>
			
			if (!empty(parse_url($DB_HOST, PHP_URL_PORT))) {
				$PORT = 'port='.parse_url($DB_HOST, PHP_URL_PORT).';';
				$DB_HOST=parse_url($DB_HOST, PHP_URL_HOST);
			}
			
			$SERVER='host';
			$DATABASE='dbname';
			$PORT="";
			
			if ($DB_TYPE=='sqlsrv') {
				$SERVER='Server';
				$DATABASE='Database';
			}
				

        $xmlDoc->col[$col]->dbconnected = '1';	

		if ($DB_TYPE=='oci'){
			$DB_HOST = $DB_HOST."/".$DB_NAME;
			$conn = oci_connect($DB_USER, $DB_PASS, $DB_HOST);
			if (!$conn) {
			   $xmlDoc->col[$col]->dbconnected = '0';
			}
		} else {
			try{
				
					if ($DB_TYPE=='sqlite'){
						if (file_exists($DB_NAME)){
								if (filesize($DB_NAME) > 0 ) {
										$conn = new PDO("$DB_TYPE:$DB_NAME");
									}
									else 
									{
										$xmlDoc->col[$col]->dbconnected = '0';
									}
							}
							else {
								$xmlDoc->col[$col]->dbconnected = '0';
							}
					}
					else {
						$conn = new PDO("$DB_TYPE:$SERVER=$DB_HOST;$DATABASE=$DB_NAME; $PORT", $DB_USER, $DB_PASS);
					}
				} catch(PDOException $e){
					$xmlDoc->col[$col]->dbconnected = '0';
					} 
				}
			}
		}


		 if ($_POST['source']=='upload'){
			 if($_POST['pc_cloud']=='cloud'){
				 $xmlDoc->col[$col]->file = $_POST['google_url'];
			 }
			 if (basename($_FILES["fileToUpload"]["name"]) ) {		
				$target_file =  "../data/" . basename($_FILES["fileToUpload"]["name"]);
				move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
				$xmlDoc->col[$col]->file = $target_file;
			 }
			 if(!empty($_POST['filename'])) {
					$xmlDoc->col[$col]->file = $_POST['filename'];
			   }
			}

	 $xmlDoc->asXML($xmlfile);

}
?> 

<script>
function DBSelection() {

	var x = document.getElementById("rdbms").value;

	if(x === 'sqlite'){ //Check if SQLite is selected
            document.getElementById('hostID').style.display="none";
			document.getElementById('host').required = false;
			document.getElementById('userID').style.display="none";
			document.getElementById('user').required = false;
			document.getElementById('passwordID').style.display="none";
			$('#host').get(0).setCustomValidity('');
			$('#user').get(0).setCustomValidity('');
			}
			else {
			document.getElementById('hostID').style.display="block";
			document.getElementById('host').required = true;
			document.getElementById('userID').style.display="block";
			document.getElementById('user').required = true;   
			document.getElementById('passwordID').style.display="block"; 
			 }
}
</script>

<script type="text/javascript">
function tabvalue(tabvalue) {

	document.getElementById("source").value = tabvalue;

	if (tabvalue=='upload'){
		document.getElementById('host').required = false;
		document.getElementById('user').required = false;
		document.getElementById('dbname').required = false;
		$('#host').get(0).setCustomValidity('');
		$('#user').get(0).setCustomValidity('');
		$('#dbname').get(0).setCustomValidity('');
		
		//var e = document.getElementById("fileselect");
       // var strUser = e.options[e.selectedIndex].value;
		
		if ($('#fileselect').val() != null) {
			
			document.getElementById('pc').checked = true;
			document.getElementById('fileToUpload').required = false;
			document.getElementById('google_url').required = false;
			$('#fileToUpload').get(0).setCustomValidity('');
			$('#google_url').get(0).setCustomValidity('');
			
		} else if(document.getElementById('cloud').checked == true) {
			document.getElementById('fileToUpload').required = false;
			$('#fileToUpload').get(0).setCustomValidity('');
			document.getElementById('google_url').required = true;
		} else {
			<?php if (file_exists($xmlDoc->col[$col]->file)) { ?>
			document.getElementById('fileToUpload').required = false;
			$('#fileToUpload').get(0).setCustomValidity('');
			<?php } else { ?>
			document.getElementById('fileToUpload').required = true;
			<?php } ?>
			document.getElementById('google_url').required = false;
			$('#google_url').get(0).setCustomValidity('');
		}
		
	}
	
	if (tabvalue=='ADatabase'){
		document.getElementById('host').required = true;
		document.getElementById('user').required = true;
		document.getElementById('dbname').required = true;
		document.getElementById('fileToUpload').required = false;
		$('#fileToUpload').get(0).setCustomValidity('');
		DBSelection();
	}
}


$(document).ready(function () {

<?php if ($xmlDoc->col[$col]->source== 'upload') {?>
tabvalue('upload');
<?php }?>

$('input[type=file]').change(function () {
	var val = $(this).val().toLowerCase();
	var regex = new RegExp("(.*?)\.(csv|xlsx|xls)$");
	document.getElementById('pc').checked = true;
	document.getElementById('google_url').required = false;
	 if(!(regex.test(val))) {
		$(this).val('');
		document.getElementById("fileToUpload").setCustomValidity("<?php echo _TEXT['SELECT_XLS_CSV'];?>");
		} 
		tabvalue('upload');
	});
});

function google_url_f() {	
	document.getElementById('cloud').checked = true;
	document.getElementById("google_url").setCustomValidity("<?php echo _TEXT['VALID_URL'];?>");
	document.getElementById('fileToUpload').required = false;
	$('#fileToUpload').get(0).setCustomValidity('');
	$('#fileselect').prop('selectedIndex', -1); //reset if file select
	tabvalue('upload');
}

function fileselect_f() {
document.getElementById('pc').checked = true;
document.getElementById('fileToUpload').required = false;
document.getElementById('google_url').required = false;
$('#fileToUpload').get(0).setCustomValidity('');
$('#google_url').get(0).setCustomValidity('');
tabvalue('upload');
}

</script>
