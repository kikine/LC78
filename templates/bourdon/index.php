<?php
//Template by Clement BOURDON
defined( '_VALID_MOS' ) or die( 'Restricted access' );
// needed to seperate the ISO number from the language file constant _ISO
$iso = explode( '=', _ISO );
// xml prolog
echo '<?xml version="1.0" encoding="'. $iso[1] .'"?' .'>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <?php mosShowHead(); ?>
<?php
if ( $my->id ) {
	initEditor();
}
$collspan_offset = ( mosCountModules( 'right' ) + mosCountModules( 'user2' ) ) ? 2 : 1;
//script to determine which div setup for layout to use based on module configuration
$user1 = 0;
$user2 = 0;
$user6 = 0;
$user7 = 0;
$colspan = 0;
$colspan2 = 0;
$right = 0;
// banner combos
//user1 and user2 combos
if ( mosCountModules( 'user1' ) + mosCountModules( 'user2' ) >= 2) {
	$user1 = 2;
	$user2 = 2;
	$colspan = 3;
} elseif ( mosCountModules( 'user1' ) == 1 ) {
	$user1 = 1;
	$colspan = 1;
} elseif ( mosCountModules( 'user2' ) == 1 ) {
	$user2 = 1;
	$colspan = 1;
}
//user6 and user7 combos
if ( mosCountModules( 'user6' ) + mosCountModules( 'user7' ) >= 2) {
	$user6 = 2;
	$user7 = 2;
	$colspan2 = 3;
} elseif ( mosCountModules( 'user6' ) == 1 ) {
	$user6 = 1;
	$colspan2 = 1;
} elseif ( mosCountModules( 'user7' ) == 1 ) {
	$user7 = 1;
	$colspan2 = 1;
}
//right based combos
if ( mosCountModules( 'right' ) and ( empty( $_REQUEST['task'] ) || $_REQUEST['task'] != 'edit' ) ) {
	$right = 1;
}
    ?>
    <meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
    <link rel="Stylesheet" type="text/css" href="<?php echo $mosConfig_live_site;?>/templates/bourdon/css/template_css.css" />
  </head>
  <body style="{margin-top:0px;}">
    <div align="center">
      <table border="0" cellpadding="0" cellspacing="0" width="960">
        <tr>
          <td class="outline">
            <div id="header_outer">
              <div id="header"> &nbsp;
              <h1>My site name or Logo</h1>
              </div>
<!-- TOP Object -->
              <div id="top_outer">
                <div id="top_inner">
		<?php
			if ( mosCountModules( 'top' ) ) {
				mosLoadModules ( 'top', -2 );
			} else {
			?>
			<span class="error">Top Module Empty</span>
		<?php
			}
		?>
                </div>
              </div>
            </div>
            <div id="menu">
<!-- SEARCH Object in USER3-->
	            <div id="search_outer">
	              <div id="search_inner">
	                <?php mosLoadModules ( 'user3', -1 ); ?>
	              </div>
	            </div>
<!-- MENU_TOP Object in USER4 -->
	            <div id="buttons_outer">
	              <div id="buttons_inner">
	                <div id="buttons">
	                  <?php mosLoadModules ( 'user4', -1); ?>
	                </div>
	              </div>
             </div>
            </div>
            <div class="clr">
            </div>
<!-- LEFT Object -->
            <div id="left_outer">
              <div id="left_inner">
                <?php mosLoadModules ( 'left', -2 ); ?>
              </div>
              <!--
              <div id="poweredby_inner">
                  <img src="<?php echo $mosConfig_live_site;?>/templates/bourdon/images/powered_by.png" alt="powered_by.png, 1 kB" title="powered_by" border="0" height="68" width="165" /><br />
              </div>
              -->
            </div>
            <div id="content_outer">
              <div id="content_inner">
<!-- BANNER Object -->
<?php
		if ( mosCountModules ('banner') ) {
?>
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="content_table">
                  <tr>
                    <td>
                      <div id="banner_inner">
                      <!--
                        <img src="<?php echo $mosConfig_live_site;?>/templates/bourdon/images/advertisement.png" alt="advertisement.png, 0 kB" title="advertisement" border="0" height="8" width="468" /><br />
                        -->
                        <?php mosLoadModules( 'banner', -1 ); ?><br />
                      </div>
		   </td>
                  </tr>
                </table>
<?php
		 }
?>
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="content_table">
                  <tr valign="top">
                    <td width="99%">
<!-- USER1 and USER2 Objects -->
<?php
			if ($colspan > 0) {
                        ?>
                      <table border="0" cellpadding="0" cellspacing="0" width="100%" class="content_table">
                        <tr valign="top">
<?php
			if ( $user1 > 0 ) {
                          ?>
                          <td width="50%">
                            <div class="user1_inner">
                              <?php mosLoadModules ( 'user1', -2 ); ?>
                            </div>
                          </td>
<?php
			}
			if ( $colspan == 3) {
                          ?>
                          <td width="2">
                            <img src="<?php echo $mosConfig_live_site;?>/templates/bourdon/images/spacer.png" alt="" title="spacer" border="0" height="10" width="2" />
                          </td>
<?php
			}
			if ( $user2 > 0 ) {
                          ?>
                          <td width="50%">
                            <div class="user2_inner">
                              <?php mosLoadModules ( 'user2', -2 ); ?>
                            </div>
                          </td>
<?php
			}
                          ?>
                        </tr>
                        <tr>
                          <td colspan="<?php echo $colspan; ?>">
                            <img src="<?php echo $mosConfig_live_site;?>/templates/bourdon/images/spacer.png" alt="" title="spacer" border="0" height="2" width="100" /><br />
                          </td>
                        </tr>
                      </table>
<?php
			}
                        ?>
<!-- PATHWAY and BODY Objects -->
                      <table border="0" cellpadding="0" cellspacing="0" width="100%" class="content_table">
                        <tr valign="top">
                          <td>
                            <div id="pathway_text">
                              <?php mosPathWay(); ?>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td class="body_outer">
                            <?php mosMainBody(); ?>
                          </td>
                        </tr>
                      </table>
<!-- USER5 Object -->
                      <table border="0" cellpadding="0" cellspacing="0" width="100%" class="content_table">
                        <tr valign="top">
                          <td class="user5_inner">
                            <?php mosLoadModules ( 'user5', 0 ); ?>
                          </td>
                        </tr>
                      </table>
<!-- USER6 and USER7 Objects -->
<?php
			if ($colspan2 > 0) {
                        ?>
                      <table border="0" cellpadding="0" cellspacing="0" width="100%" class="content_table">
                        <tr valign="top">
<?php
			if ( $user6 > 0 ) {
                          ?>
                          <td width="50%">
                            <div class="user6_inner">
                              <?php mosLoadModules ( 'user6', -2 ); ?>
                            </div>
                          </td>
<?php
			}
			if ( $colspan2 == 3) {
                          ?>
                          <td width="2">
                            <img src="<?php echo $mosConfig_live_site;?>/templates/bourdon/images/spacer.png" alt="" title="spacer" border="0" height="10" width="2" />
                          </td>
<?php
			}
			if ( $user7 > 0 ) {
                          ?>
                          <td width="50%">
                            <div class="user7_inner">
                              <?php mosLoadModules ( 'user7', -2 ); ?>
                            </div>
                          </td>
<?php
			}
                          ?>
                        </tr>
                        <tr>
                          <td colspan="<?php echo $colspan; ?>">
                            <img src="<?php echo $mosConfig_live_site;?>/templates/bourdon/images/spacer.png" alt="" title="spacer" border="0" height="2" width="100" /><br />
                          </td>
                        </tr>
                      </table>
<?php
			}
                        ?>
                    </td>
<!-- RIGHT Object -->
<?php
		if ( $right > 0 ) {
                    ?>
                    <td>
                      <div id="right_outer">
                        <div id="right_inner">
                          <?php mosLoadModules ( 'right', -2 ); ?>
                        </div>
                      </div>
                    </td>
<?php
		  }
                    ?>
                  </tr>
                </table>
              </div>
            </div>
          </td>
        </tr>
      </table>
    </div>
    <?php include_once( $GLOBALS['mosConfig_absolute_path'] . '/includes/footer.php' ); ?>
    <?php mosLoadModules( 'debug', -1 );?>
  </body>
</html>