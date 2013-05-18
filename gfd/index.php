<?php
//// 
// GET VARIABLES FROM URL IF NEEDED
$gallerie=$_GET['gallerie'];
$hidemenu=$_GET['hidemenu'];
////
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Photo Gallery</title>
<style type="text/css">
<!--
body,td,th {color: #FFFFFF;}
body {background-color: #ffffff;}
-->
</style>
<!--////
// LET IT IN HEAD TAG TO LOAD THE GALLERY
////-->
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="Scripts/AC_ActiveX.js" type="text/javascript"></script>
<!--/////-->

<script language="JavaScript" type="text/JavaScript"><!--
////
// AUTO RESIZE WINDOW : REMOVE COMMENTS DOUBLE / TO USE THIS 
//if (screen.height>800) {var gtop=(screen.height-750)/2;var gleft=(screen.width-820)/2;
//self.resizeTo(820,750);self.moveTo(gleft,gtop);self.focus();}
//else {self.resizeTo(screen.width,screen.height);self.moveTo(0,0);self.focus();}; 
////
//-->
</script>
</head>
<body>
<div align="center"><table width="90%" height="90%"  border="0" align="center" cellpadding="0" cellspacing="0"><tr><td align="center" valign="middle"><div align="center">
<!--////
// LOAD THE GALLERY 
////-->
<script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0','width','750','height','450','src','banniere','quality','best','pluginspage','http://www.macromedia.com/go/getflashplayer','movie','09<?php $phrase1='?hidemenu='.$hidemenu.'&gallerie='.$gallerie.'&ac_reference='.getenv("HTTP_REFERER").'';print $phrase1;?>','wmode','transparent' ); //end AC code
</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="750" height="450">
  <?php $phrase1='<PARAM NAME=movie VALUE="09.swf?hidemenu='.$hidemenu.'&gallerie='.$gallerie.'&ac_reference='.getenv("HTTP_REFERER").'"/>';print $phrase1;?>
  <param name="quality" value="best" />
  <param name="wmode" value="transparent" />
  <embed <?php $phrase2='src="09.swf?hidemenu='.$hidemenu.'&gallerie='.$gallerie.'&ac_reference='.getenv("HTTP_REFERER").'"';print $phrase2;?> quality="best" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="750" height="450" align="middle" wmode="transparent"></embed>
</object></noscript>
<!--/////-->
</div></td></tr></table></div>
</body>
</html>
