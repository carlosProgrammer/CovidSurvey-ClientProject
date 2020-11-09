<?php $xmlinfo=simplexml_load_file($folder."data/version.xml") or die("Error: Cannot create object");;?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Dashboard for Puspa</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="<?php echo $folder;?>favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" href="<?php echo $folder;?>assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $folder;?>css/font-awesome.min.css">
<!-- <link rel="stylesheet" href="<?php //echo $folder;?>css/style_v1.css"> -->
<link rel="stylesheet" href="<?php echo $folder;?>assets/css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo $folder;?>css/layoutsetting.css"> 
<link rel="stylesheet" href="<?php echo $folder;?>assets/css/color-screen.css"> 
<style>
/* Paste this css to your style sheet file or under head tag */
/* This only works with JavaScript, 
if it's not present, don't show loader */
.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-con {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url(<?php echo $folder;?>assets/img/preloader_1.gif) center no-repeat rgba(255, 255, 255, 1);
	 background-size: 150px 150px;
}

.se-pre-modal {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url(<?php echo $folder;?>assets/img/preloader_1.gif) center no-repeat rgba(255, 255, 255, 1);
	 background-size: 150px 150px;
	 display:none;
}
</style>

<script src="<?php echo $folder;?>assets/js/jquery.min.js"></script>
<script src="<?php echo $folder;?>assets/js/jquery-ui.js"></script>
<script src="<?php echo $folder;?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo $folder;?>assets/js/modernizr.js"></script>
<script src="<?php echo $folder;?>assets/js/color-main.js"></script>


<script>
	//paste this code under head tag or in a seperate js file.
	// Wait for window load
	$(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");;
	});
	

function fdropdownmenu(){
	var x = document.getElementById("dropdown-menu");
  if (window.getComputedStyle(x).display === "none") {
    document.getElementById("dropdown-menu").style.display = "block";
  } else {
	 document.getElementById("dropdown-menu").style.display = "none";
  }
};

function LenSelection() {
document.getElementById("lanform").submit(); 
}

</script>

</head>
<?php

$xmlfile = '../data/version.xml';
$xmlinfo=simplexml_load_file($xmlfile);

if (isset($_POST['lanformsubmit'])) {
	$xmlinfo->language = $_POST['language'];
	$xmlinfo->asXML($xmlfile);
}

if (isset($_POST['languagechange'])){
   if ($_POST['languagechange']=="yes") {
		$xmlinfo->language = $_POST['take_tour_language'];
		$xmlinfo->asXML($xmlfile);
	}
}

$xmlinfo->asXML($xmlfile);
$languagefile= include('../language/'.$xmlinfo->language.'.php');
define ('_TEXT',$languagefile);


?>


<body>
<div class="se-pre-con"></div>
<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
					
			
			<button type="button" class="navbar-toggle navbar-toggle-sidebar collapsed">
			<?php echo _TEXT['MENU'];?>
			</button>
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only"><?php echo _TEXT['TOGGLE_NAVIGATION'];?></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#" style="margin-top:-20px;">
				<img src="<?php echo $folder;?>assets/img/dashboardbuilder_logo.png"/>
			</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">  
	
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown ">
					<a href="javascript:void(0);"  class="dropdown-toggle" onclick="fdropdownmenu();" data-toggle="dropdown" role="button" aria-expanded="false">

						<span class="fa fa-question-circle" style="font-size:2em; " ></span>
						<span class="caret"></span></a>
						<ul class="dropdown-menu" id="dropdown-menu" role="menu" style="padding-top:15px;">
						
						<form name="lanform" id="lanform" action="" enctype="multipart/form-data" method="post" >
						<span style="text-align:left;margin-left:20px;">
						 <span class="fa fa-globe" style="font-size:1.3em;" ></span>
						 <select  style="text-align:left;" name="language" value="en-us" onchange="LenSelection();" >
							<option value="de-de" <?php if ($xmlinfo->language=="de-de") {echo "selected";}?>>Deutsche</option>
							<option value="en-us" <?php if ($xmlinfo->language=="en-us") {echo "selected";}?> >English</option>
							<option value="es-es" <?php if ($xmlinfo->language=="es-es") {echo "selected";}?>>Español</option>
							<option value="fr-fr" <?php if ($xmlinfo->language=="fr-fr") {echo "selected";}?>>Français</option>
							<option value="it-it" <?php if ($xmlinfo->language=="it-it") {echo "selected";}?>>Italiano</option>
							<option value="pt-br" <?php if ($xmlinfo->language=="pt-br") {echo "selected";}?>>Português</option>
						 </select>
						 </span>
						 <input type="hidden" name="lanformsubmit" value="true" />
						 </form>
						
							<li><a href="https://dashboardbuilder.net/documentation" target="_blank"><?php echo _TEXT['DOCUMENTAION'];?></a></li>
							<li><a href="#" onclick="changeVideo('v7qde35K6tM')" ><?php echo _TEXT['VIDEO_TUTORIAL'];?></a></li>
							<li><a href="https://dashboardbuilder.net/support" target="_blank"><?php echo _TEXT['SUPPORT'];?></a></li>
							<li><a href="https://dashboardbuilder.net/forum" target="_blank"><?php echo _TEXT['FORUM'];?></a></li>
							<li><a href="https://dashboardbuilder.net" target="_blank"><?php echo _TEXT['VISIT_SITE'];?></a></li>
							<li class="divider"></li>
							<li><a href="#" style="pointer-events: none;"> <?php echo _TEXT['VERSION'].': '.$xmlinfo->version; ?></a></li>
							<li><a href="#" style="pointer-events: none;"> <?php echo _TEXT['LICENSE'].': '.$xmlinfo->type; ?></a></li>
							
							<?php if (!($xmlinfo->type=="FREE") ) {?>
							<li><a href="#" style="pointer-events: none;"><?php echo _TEXT['VALID_TILL'];?>: 
							<?php 
							if (empty($xmlinfo->date)) 
							{
								$xmlinfo->date=date("Ymd");
								if ($xmlinfo->type=="Enterprise") {
									$expirydate = date('M-d-Y',strtotime('+1 year',strtotime($xmlinfo->date)));
								} elseif ($xmlinfo->type=="Standard") {
									$expirydate = date('M-d-Y',strtotime('+3 month',strtotime($xmlinfo->date)));
								} elseif ($xmlinfo->type=="Personal") {
									$expirydate = date('M-d-Y',strtotime('+1 month',strtotime($xmlinfo->date)));
								}
								$xmlinfo->date=date('Ymd',strtotime($expirydate));
								$xmlinfo->asXML($xmlfile);
							} else {
								$expirydate = date('M-d-Y',strtotime($xmlinfo->date));
							}
							echo $expirydate; ?></a></li>
							<?php }?>
							
							<li><a href="https://dashboardbuilder.net/license-upgrade" target="_blank"><?php echo _TEXT['UPGRADE_LICENSE'];?></a></li>
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav> 
