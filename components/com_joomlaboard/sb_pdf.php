<?php
/**
* sb_pdf.php joomlaboard pdf generation
* @package com_joomlaboard
* @copyright (C) 2000 - 2007 TSMF / Jan de Graaff / All Rights Reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author TSMF & Phil Taylor
* @version $Id: sb_pdf.php,v 1.1 2005/07/27 10:09:40 jigsjdg Exp $
* Joomla! is Free Software
* Created by Phil Taylor me@phil-taylor.com
* Support file to display PDF Text Only using class from - http://www.ros.co.nz/pdf/readme.pdf
* HTMLDoc is available from: http://www.easysw.com/htmldoc and needs installing on the server for better HTML to PDF conversion
**/
/**

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $mosConfig_offset, $mosConfig_hideAuthor, $mosConfig_hideModifyDate, $mosConfig_hideCreateDate, $mosConfig_live_site;

function dofreePDF (&$database,$obj_sb_cat,$id) {
	global $aro_group,$mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate, $sbConfig;
		$catid = intval( mosGetParam( $_REQUEST, 'catid', 2 ) );
		include( JB_JABSPATH.'/includes/class.ezpdf.php' );
		//first get the thread id for the current post to later on determine the parent post
		$database->setQuery("SELECT `thread` FROM #__sb_messages WHERE id='$id' AND catid='".$obj_sb_cat->getId()."'");
		$threadid=$database->loadResult();

		//load topic post and details
		$database->setQuery("SELECT a.*, b.message FROM #__sb_messages AS a, #__sb_messages_text AS b WHERE a.thread = '$threadid' AND a.catid='".$obj_sb_cat->getId()."' AND a.parent=0 AND a.id=b.mesid");	
		$row=$database->loadObjectList();
	
		$mes_text = $row[0]->message;
		// Ugly but needed to get rid of all the stuff the PDF class cant handle
		$mes_text 	= str_replace( '<p>', "\n\n" , $mes_text );
		$mes_text 	= str_replace( '<P>', "\n\n" , $mes_text );
		$mes_text 	= str_replace( '<br />', "\n" , $mes_text );
		$mes_text 	= str_replace( '<br>', "\n" , $mes_text );
		$mes_text 	= str_replace( '<BR />', "\n" , $mes_text );
		$mes_text 	= str_replace( '<BR>', "\n" , $mes_text );
		$mes_text 	= str_replace( '<li>', "\n - " , $mes_text );
		$mes_text 	= str_replace( '<LI>', "\n - " , $mes_text );
		$mes_text 	= strip_tags( $mes_text );
		$mes_text 	= str_replace( '{mosimage}', '', $mes_text );
		$mes_text 	= str_replace( '{mospagebreak}', '', $mes_text );
	   // bbcode
	   $mes_text = preg_replace("/\[(.*?)\]/si","",$mes_text);	
		$mes_text 	= decodeHTML( $mes_text );
	
		$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
		$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
		$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	
		$all = $pdf->openObject();
		$pdf->saveState();
		$pdf->setStrokeColor( 0, 0, 0, 1 );
	
		// footer
		$pdf->line( 10, 40, 578, 40 );
		$pdf->line( 10, 822, 578, 822 );
		$pdf->addText( 30, 34, 6, $sbConfig['board_title'] .' - '. $mosConfig_sitename );
		$pdf->addText( 250, 34, 6, 'Joomlaboard Forum Component version: '.$sbConfig['version'] );
		$pdf->addText( 450, 34, 6, 'Generated: '. date( 'j F, Y, H:i', time() + $mosConfig_offset*60*60 ) );
	
		$pdf->restoreState();
		$pdf->closeObject();
		$pdf->addObject( $all, 'all' );
		$pdf->ezSetDy( 30 );
		
	
		$txt0 = $row[0]->subject;
		$pdf->ezText( $txt0, 14 );
		$pdf->ezText( _VIEW_POSTED ." ". $row[0]->name ." - ". date(_DATETIME , $row[0]->time), 8 );
		$pdf->ezText( "_____________________________________", 8 );
		//$pdf->line( 10, 780, 578, 780 );
		
		$txt3  = "\n";
		$txt3 .= stripslashes($mes_text);
		$pdf->ezText( $txt3, 10 );
		$pdf->ezText( "\n============================================================================\n\n", 8 );
		//now let's try to see if there's more...
		$database->setQuery("SELECT a.*, b.message FROM #__sb_messages AS a, #__sb_messages_text AS b WHERE a.catid=$catid AND a.thread=$threadid AND a.id=b.mesid AND a.parent != 0 ORDER BY a.time ASC");
		$replies=$database->loadObjectList();
		$countReplies= count ($replies);
		
		if ($countReplies > 0 ) {
			foreach ($replies as $reply) {
				$mes_text = $reply->message;
				// Ugly but needed to get rid of all the stuff the PDF class cant handle
				$mes_text 	= str_replace( '<p>', "\n\n" , $mes_text );
				$mes_text 	= str_replace( '<P>', "\n\n" , $mes_text );
				$mes_text 	= str_replace( '<br />', "\n" , $mes_text );
				$mes_text 	= str_replace( '<br>', "\n" , $mes_text );
				$mes_text 	= str_replace( '<BR />', "\n" , $mes_text );
				$mes_text 	= str_replace( '<BR>', "\n" , $mes_text );
				$mes_text 	= str_replace( '<li>', "\n - " , $mes_text );
				$mes_text 	= str_replace( '<LI>', "\n - " , $mes_text );
				$mes_text 	= strip_tags( $mes_text );
				$mes_text 	= str_replace( '{mosimage}', '', $mes_text );
				$mes_text 	= str_replace( '{mospagebreak}', '', $mes_text );
			   // bbcode
			   $mes_text = preg_replace("/\[(.*?)\]/si","",$mes_text);	
				$mes_text 	= decodeHTML( $mes_text );
	
				$txt0 = $reply->subject;
				$pdf->ezText( $txt0, 14 );
				$pdf->ezText( _VIEW_POSTED ." ". $reply->name ." - ". date(_DATETIME , $reply->time), 8 );
				$pdf->ezText( "_____________________________________", 8 );
				$txt3  = "\n";
				$txt3 .= stripslashes($mes_text);
				$pdf->ezText( $txt3, 10 );
				$pdf->ezText( "\n============================================================================\n\n", 8 );
			}
		}	
			
	$pdf->ezStream();
}//function dofreepdf

function decodeHTML( $string ) {
	$string = strtr( $string, array_flip(get_html_translation_table( HTML_ENTITIES ) ) );
	$string = preg_replace( "/&#([0-9]+);/me", "chr('\\1')", $string );
	return $string;
}

function get_php_setting ($val ) {
	$r = ( ini_get( $val ) == '1' ? 1 : 0 );
	return $r ? 'ON' : 'OFF';
}

dofreePDF($database,$thisCat,$id);
?>
