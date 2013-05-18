<?php
//	edited by mic (www.mgfi.info) 2005.09.08 - 14:21

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/* HTML class for all JooMap administration output */
class HTML_joomap {
	/* Show the configuration options and menu ordering */
	function show ( $menus, $pageNav, &$lists ) {
		global $joomap_cfg, $option;
		?>
		<script language="javascript" type="text/javascript">
		function menu_listItemTask( id, task, option ) {
			var f = document.adminForm;
			cb = eval( 'f.' + id );
			if (cb) {
				cb.checked = true;
				submitbutton(task);
			}
			return false;
		}

		function changeDisplayImage() {
			if (document.adminForm.imageurl.value !='') {
				document.adminForm.imagelib.src='../components/com_joomap/images/' + document.adminForm.imageurl.value;
			} else {
				document.adminForm.imagelib.src='images/blank.png';
			}
		}
		</script>

		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th class="menus"><?php echo _JOOMAP_CFG_COM_TITLE; ?></th>
		</tr>
		</table>
		<span style="font-weight:bold;"><?php echo _JOOMAP_CFG_OPTIONS; ?></span>:<br />
		<table class="adminlist" style="table-layout: auto; white-space:nowrap;">
		<tr>
			<td style="width:1%"><?php echo _JOOMAP_CFG_TITLE; ?>: </td>
			<td style="width:32%"><input type="text" name="title" value="<?php echo @$joomap_cfg->title; ?>" /></td>
		    <td style="width:1%"><?php echo _JOOMAP_CFG_CSS_CLASSNAME; ?>: </td>
		    <td style="width:32%"><input type="text" name="classname" value="<?php echo @$joomap_cfg->classname; ?>"/></td>
		    <td style="width:1%"><?php echo _JOOMAP_EX_LINK; ?>: </td>
		    <td style="width:33%"><input type="checkbox" name="exlinks" value="1" <?php echo @$joomap_cfg->exlinks ? 'checked ':'';?> />
		    &nbsp;
		    <?php echo $lists['imageurl']; ?>
		    </td>
		</tr>
		<tr>
			<td><?php echo _JOOMAP_CFG_EXPAND_CATEGORIES; ?>: </td>
			<td><input type="checkbox" name="expand_category" value="1" <?php echo @$joomap_cfg->expand_category ? 'checked ':'';?> /></td>
		    <td><?php echo _JOOMAP_CFG_EXPAND_SECTIONS; ?>: </td>
		    <td><input type="checkbox" name="expand_section" value="1" <?php echo @$joomap_cfg->expand_section ? 'checked ':'';?> /></td>
		    <td align="right"><?php echo _JOOMAP_PREVIEW; ?>:</td>
		    <td valign="top" align="center">
			<?php
                if( eregi( 'gif|jpg|jpeg|png', $joomap_cfg->ext_image )) { ?>
                    <img src="<?php echo $GLOBALS['mosConfig_live_site']; ?>/components/com_joomap/images/<?php echo $joomap_cfg->ext_image; ?>" name="imagelib" />
                    <?php
                } else { ?>
                    <img src="images/blank.png" name="imagelib" />
                    <?php
                } ?>
			</td>
		</tr>
		<tr>
			<td><?php echo _JOOMAP_CFG_EXPAND_PHPSHOP; ?>: </td>
			<td colspan="5">
				<input type="checkbox" name="expand_pshop" value="1"<?php echo @$joomap_cfg->expand_pshop ? ' checked ':'';?> />
			</td>
		</tr>
		<tr>
			<td><?php echo _JOOMAP_CFG_SHOW_MENU_TITLES; ?>: </td>
			<td><input type="checkbox" name="show_menutitle" value="1" <?php echo @$joomap_cfg->show_menutitle ? 'checked ':'';?> /></td>
			<td><?php echo _JOOMAP_CFG_NUMBER_COLUMNS; ?>: </td>
			<td><input type="text" name="columns" value="<?php echo @$joomap_cfg->columns;?>" /></td>
			<td colspan="2">&nbsp;</td>
		</tr>
		</table>
		<span style="font-weight:bold;"><?php echo _JOOMAP_CFG_SET_ORDER; ?>:</span><br />
		<table class="adminlist">
		<tr style="white-space:nowrap">
			<th width="20">#</th>
			<th width="1"><input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $menus ); ?>);" /></th>
			<th width="1"><?php echo _JOOMAP_CFG_MENU_SHOW; ?></th>
			<th width="1"><?php echo _JOOMAP_CFG_MENU_REORDER; ?></th>
			<th width="1"><?php echo _JOOMAP_CFG_MENU_ORDER; ?></th>
			<th class="title"><?php echo _JOOMAP_CFG_MENU_NAME; ?></th>
		</tr>
		<?php
		$k = 0;
		$i = 0;
		$start = 0;
		if ($pageNav->limitstart)
			$start = $pageNav->limitstart;
		$count = count($menus)-$start;
		if ($pageNav->limit)
			if ($count > $pageNav->limit)
				$count = $pageNav->limit;
		for ($i=0, $n=count( $menus ); $i < $n; ++$i) {
			$menu = $menus[$i];
			$checked = mosCommonHTML::CheckedOutProcessing( $menu, $i );
			if ( $menu->show ) {
				$img = 'tick.png';
				$alt = _JOOMAP_SHOW;
				$title = _JOOMAP_CFG_DISABLE;
			} else {
				$img = 'publish_x.png';
				$alt = _JOOMAP_NO_SHOW;
				$title = _JOOMAP_CFG_ENABLE;
			}
			?>
			<tr class="<?php echo 'row'. $k; ?>">
				<td align="center" width="30px">
					<?php echo $pageNav->rowNumber( $i ); ?>
				</td>
				<td>
					<?php echo $checked; ?>
				</td>
				<td align="center">
					<a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>','<?php echo $menu->show ? 'unpublish' : 'publish';?>')">
					<img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>"/>
					</a>
				</td>
				<td align="center">
					<?php echo $pageNav->orderUpIcon( $i, true ); ?>
					<?php echo $pageNav->orderDownIcon( $i, $n, true ); ?>
				</td>
				<td align="center">
					<input type="text" name="order[<?php echo $menu->id; ?>]" size="5" value="<?php echo $menu->ordering; ?>" class="text_area" style="text-align:center" />
				</td>
				<td>
					<?php echo $menu->type; ?>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		</table>
		<?php echo $pageNav->getListFooter(); ?>

		<input type="hidden" name="option" value="com_joomap" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		</form>
		<?php
	}
}
?>
