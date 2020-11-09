<style>
.takeatour {color:red;font-size:22px;padding:10px;}
.takeatour2 {color:red;font-size:14px;padding:10px;line-height:238%;text-align:left;margin-left:0px;font-size: 0.90vw;}
</style>
<?php 

	


?>
<form  id="takeatourform" name="takeatourform" class="form-horizontal" action="" method="post">
<div class="modal-header" style="background:#34b4eb;">
	<button type="submit" class="close" style="color:#fff;" >&times;</button>
	 <h4 class="modal-title" style="color:#fff;text-weight:bold;"><?php echo strtoupper(_TEXT['TAKE_A_TOUR']);?></h4>
</div>

  <div class="modal-body" id="questions">
  
	<div id="q0" >
	  <h4 style="color:#34b4eb;"><?php echo _TEXT['SELECT_LANGUAGE']?></h4>
	  <center>
	  <div style="margin-top:50px; margin-bottom: 180px;">
	  <span >
		 <span class="fa fa-globe" style="font-size:2.0em;" ></span>
		 <select  style="text-align:left;font-size:1.5em;" name="take_tour_language" value="en-us" onchange="javascript:document.getElementById('languagechange').value = 'yes';document.getElementById('takeatourform').submit();" >
			<option value="de-de" <?php if ($xmlinfo->language=="de-de") {echo "selected";}?>>Deutsche</option>
			<option value="en-us" <?php if ($xmlinfo->language=="en-us") {echo "selected";}?> >English</option>
			<option value="es-es" <?php if ($xmlinfo->language=="es-es") {echo "selected";}?>>Español</option>
			<option value="fr-fr" <?php if ($xmlinfo->language=="fr-fr") {echo "selected";}?>>Français</option>
			<option value="it-it" <?php if ($xmlinfo->language=="it-it") {echo "selected";}?>>Italiano</option>
			<option value="pt-br" <?php if ($xmlinfo->language=="pt-br") {echo "selected";}?>>Português</option>
		 </select>
		 </span>
		 </div>
	  </center>
	</div>
  
	<div id="q1" style="display: none">
	  <h4 style="color:#34b4eb;"><?php echo _TEXT['STEP']." 1 ". _TEXT['OF']." 5";?></h4>
	  
	  <h3 style="font-weight:bold;"><?php echo _TEXT['CONNECT_YOUR_DATA']?></h3><br/>
		<img src="../assets/img/take_tour_step1.png" style="width:100%;height:auto;"/>
		<div class="takeatour" style="position:absolute;top: 50%; right:36px;"><?php echo _TEXT['HOW_CONNECT_YOUR_DATA']?></div>
	</div>

	<div id="q2" style="display: none">
		<h4 style="color:#34b4eb;"><?php echo _TEXT['STEP']." 2 ". _TEXT['OF']." 5";?></h4>
		<h3 style="font-weight:bold;"><?php echo strtoupper(_TEXT['DATABASE_SETTINGS']);?></h3></br>
		<center>
		<img src="../assets/img/take_tour_step2a.png" style="width:45%;height:auto;display:block;margin-left:auto;margin-right:auto; box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"/>
		<div class="takeatour2" style="position:relative;margin-top: -30%; left:40%;margin-bottom:5%;"><?php echo _TEXT['CHOOSE_DATABASE']?><br/><?php echo _TEXT['ENTER_DBSERVER']?><br/><?php echo _TEXT['ENTER_DBUSER']?><br/><?php echo _TEXT['ENTER_DBPASSWORD']?><br/><?php echo _TEXT['ENTER_DBNAME']?><br/>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo _TEXT['CHECK_SSL']?></div>
		</center>
		<br/>
		<ul>
		<li><?php echo _TEXT['YOU_CAN_CONNECT']?></li>
		<li><?php echo _TEXT['YOUR_DATABASE_ICON']?> <span style="font-size:16px; "><sub><div class="fa fa-check" style="color:#009933;" ></div></sub><div class="fa fa-database"></div></span> <?php echo _TEXT['YOU_ARE_CONNECTED']?></li>
		</ul>
	</div>

	<div id="q3" style="display: none">
		<h4 style="color:#34b4eb;"><?php echo _TEXT['OR'];?></h4>
		<h3 style="font-weight:bold;"><?php echo _TEXT['RETRIEVE_DATA'];?></h3><br/>
		<center>
		<img src="../assets/img/take_tour_step2b.png" style="width:45%;height:auto;display:block;margin-left:auto;margin-right:auto; box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"/>
		<div class="takeatour2" style="position:relative;margin-top: -31%; left:29%;"><?php echo _TEXT['UPLOAD_NEW_FILE']?></div>
		<div class="takeatour2" style="position:relative;margin-top: 0%; left:45%;line-height:1.3em;"><?php echo _TEXT['CHOOSE_A_FILE']?></div>
		<div class="takeatour2" style="position:relative;margin-top: 5%; left:29%;margin-bottom:7%;"><?php echo _TEXT['GOOGLE_SHEET']?></div>
		</center>
	
		<ul>
		<li><?php echo _TEXT['RETRIEVE_DATA_XLS'];?></li>
		<li><?php echo _TEXT['FILE_ICON'];?> <span style="font-size:16px;color:#669933;" class="fa fa-file-excel-o"></span> <?php echo _TEXT['FILE_UPLOADED']?></li>
		</ul>
	</div>
		
	<div id="q4" style="display: none">
		<h4 style="color:#34b4eb;"><?php echo _TEXT['STEP']." 3 ". _TEXT['OF']." 5";?></h4>
		<h3 style="font-weight:bold;"><?php echo _TEXT['CHART_SETTINGS'];?></h3><br/>
		<center>
		<img src="../assets/img/take_tour_step3.png" style="width:100%;height:auto;"/>
		<div class="takeatour" style="position:absolute;top: 50%; left:36px;"><?php echo _TEXT['CLICK_FOR_CHART_SETTINGS']?></div>
		</center>
	</div>
	
	<div id="q5" style="display: none">
		<h4 style="color:#34b4eb;"><?php echo _TEXT['STEP']." 4 ". _TEXT['OF']." 5";?></h4>
		<h3 style="font-weight:bold;"><?php echo _TEXT['SQL_QUERY'];?></h3><br/>
		<center>
		<img src="../assets/img/take_tour_step4.png" style="width:100%;height:auto;height:auto;display:block;margin-left:auto;margin-right:auto; box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"/>
		<div class="takeatour2" style="position:relative;margin-top: -34%; left:40%;"><?php echo _TEXT['ENTER_YOUR_QUERY']?></div>
		<div class="takeatour2" style="position:relative;margin-top: -1.5%; left:35%;"><?php echo _TEXT['HIT_RUN_QUERY']?></div>
		<div class="takeatour2" style="position:relative;margin-top: -2%; text-align:right;margin-bottom:20%;line-height:1em;"><?php echo _TEXT['CLICK_TABLE']?></div>
		</center>
	</div>
	
	<div id="q6" style="display: none">
		<h4 style="color:#34b4eb;"><?php echo _TEXT['STEP']." 5 ". _TEXT['OF']." 5";?></h4>
		<h3 style="font-weight:bold;"><?php echo _TEXT['SELECT_X_Y'];?></h3><br/>
		<center>
		<img src="../assets/img/take_tour_step5.png" style="width:100%;height:auto;height:auto;display:block;margin-left:auto;margin-right:auto; box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"/>
		<div class="takeatour2" style="position:relative;margin-top: -55%; left:21%;line-height:1.6em;"><?php echo _TEXT['SELECT_CHART_TYPE']?></div>
		<div class="takeatour2" style="position:relative;margin-top: 26%; left:50%;"><?php echo _TEXT['SQL_RESULT']?></div>
		<div class="takeatour2" style="position:relative;margin-top: 3%; text-align:right;margin-bottom:2%;"><?php echo _TEXT['CLICK_SAVE_CHANGES']?></div>
		</center>
	</div>
	
	
   </div>

  <div class="modal-footer">
  <button type="button" class="btn btn-default" id="prev" style="float:left;"><?php echo _TEXT['PREVIOUS'];?></button>
  <!--<span style="text-align:center;"><input type="checkbox" id="takeatour_checkbox" name="takeatour_checkbox" >&nbsp;Don't show this tour again&nbsp;</span>-->
  <button type="button" class="btn btn-primary" id="next" style="background-color:#34b4eb;"><?php echo _TEXT['NEXT'];?></button>
  </div>
  <input type="hidden" id="languagechange" name="languagechange" value="no"/>
  <input type="hidden" id="takeatourtask" name="takeatourtask" value="submit"/>
  </form>
  
<script>
$(function() {
    $('#next').on('click', function() {
        $('#questions>div').each(function() {
            var id = $(this).index();
            if ($(this).is(':visible')) {
                $(this).hide();
                if (id == $('#questions>div').length - 1) {
				  $('#questions>div').eq(id).show();
                } else {
					$('#questions>div').eq(id +1).fadeIn(1000);
                }
                return false;
            }
        });
    });
	
	$('#prev').on('click', function() {
        $('#questions>div').each(function() {
            var id = $(this).index();
            if ($(this).is(':visible')) {
                $(this).hide();
                if (id == 0) {
				   $('#questions>div').eq(0).show();
                } else {
				   $('#questions>div').eq(id - 1).fadeIn(1000);
                }
                return false;
            }
        });
    });
});
</script>