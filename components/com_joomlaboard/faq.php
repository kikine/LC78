<?php
/**
* faq.php joomlaboard faq
* @package com_joomlaboard
* @copyright (C) 2000 - 2007 TSMF / Jan de Graaff / All Rights Reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author TSMF
* Joomla! is Free Software
**/

// Dont allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
?>
         <h3 class="contentheading"><a name="boardcode"></a> What is boardcode?</h3>
         <p>Boardcode are special tags that will allow you to format your messages.  Currently, Joomlaboard supports links, bold, italic, bold, "quoted" text, img, size, list and colored text.  <br />
         The tags are used as follows:</p>
		<table width="90%">
		 <tr><th class="sectiontableheader">Code</th><th class="sectiontableheader">Result</th></tr>
		 <tr><td  class="sectiontableentry2">[b]Bold[/b]</td><td  class="sectiontableentry2"><b>Bold</b></td></tr>
         <tr><td class="sectiontableentry1">[i]Italic[/i]</td><td class="sectiontableentry1"><i>Italic</i></td></tr>
         <tr class="sectiontableentry2"><td>[u]Underline[/u]</td><td><u>Underline</u></td></tr>
	     <tr class="sectiontableentry1"><td>[size=4]Size[/size]</td><td><font size="4">Size</font></td></tr>
	     <tr class="sectiontableentry2"><td>[color=#FF0000]Red[/color]</td><td><font color="red">Red</font></td></tr>
	     <tr class="sectiontableentry1"><td>[img=150]link to image[/img]</td><td>will produce a image with a width off 150 pixels.<br />
	    <u>Please remember you can go to a maximum width of 499 pixels.</u></td></tr>
		<tr class="sectiontableentry2"><td>[ul]<br />[li]item 1[/li]<br />
		        [li]item 2[/li]<br />
	    	    [li]item 3[/li]<br />[/ul]<br /></td>
	        
		<td>
	        <ul><li>item 1</li>
	            <li>item 2</li>
		        <li>item 3</li></ul>
		</td></tr>

		<tr class="sectiontableentry1"><td>
		    [ol]<br />[li]item 1[/li]<br />
		    [li]item 2[/li]<br />
		    [li]item 3[/li]<br />[/ol]<br />
		</td>
		<td>   <ol><li>item 1</li>
		    <li>item 2</li>
	    	<li>item 3</li></ol>
		</td></tr>
		<tr class="sectiontableentry2"><td>[url]http://www.yahoo.com[/url]</td><td><a href="http://www.yahoo.com">http://www.yahoo.com</a></td></tr>
        <tr class="sectiontableentry1"><td>[url=http://www.yahoo.com]Yahoo![/url]</td><td><a href="http://www.yahoo.com">Yahoo!</a></td></tr>
        <tr class="sectiontableentry2"><td>[quote]Quote[/quote]</td><td><div class="sb_quote">Quote</div></td></tr>
        <tr class="sectiontableentry1"><td>[code]<br />&lt;?<br /> //Some code here <br />while ($adversary=='Neo'){ fork(agent_Smith);} ?&gt;<br />[/code]<br /></td>
        <td>
        	<table width="90%" border="0" align="center">
        	<tr><td><b>Code:</b></td></tr>
        		<tr><td><pre>
<?php
highlight_string('<?php'."\n".'//Some code here'."\n".'while ($adversary==\'Neo\')'.'{ fork(agent_Smith);}'."\n".'?>');
?>
        	</pre></td></tr>
         </table></td></tr></table>
         <h3 class="contentheading">About the Forum Component</h3>
         <p>This forum is based on the Simpleboard Forum originally written by Josh Levine.<br />
         It has been extended, enhanced and integrated as a Joomla component by Jan de Graaff.<br />
         Please visit the home of the Forum Component at the <a href="http://www.tsmf.net" target="_blank">Two Shoes M-Factory</a> website.<br /></p>
         
         <h3 class="contentheading">The TSMF Team</h3>
         <p>The Joomlaboard development team consists of:<br />
         Jan de Graaff (also Project Admin), Tomislav Ribicic, Arno Zijlstra, Niels Vandekeybus, Iosif Chatzimichail, Jon Langevin, Kathy Strickland and Thomas Despoix.
         </p>
          
         <h3 class="contentheading">Special Thanks:</h3>
         <table style="border-size:0px;">
         <tr><td><a href="http://www.tmjg-marketing.com" target="_blank">Toni Brännlund</a></td><td>::</td><td>For helping me out with the <a href="http://www.tsmf.net" target="_blank">Two Shoes Module Factory website</a>.</td></tr>
         <tr><td><a href="http://www.phil-taylor.com" target="_blank">Phil Taylor</a></td><td>::</td><td>For helping me out with some of the basics of component writing.</td></tr>
         <tr><td>Andrew Eddie</td><td>::</td><td>For giving me a jumpstart on rewriting the Admin Area as a MOS compliant backend.</td></tr>
         <tr><td><a href="http://www.smarterdocuments.com" target="_blank">Andrew Fletcher</a></td><td>::</td><td>For helping me out with the Review code and the Language Support.</td></tr>
         <tr><td>Dave McDonnell</td><td>::</td><td>For helping us out with the Safe Mode problems we had.</td></tr>
         <tr><td>Jick</td><td>::</td><td>For giving a great start on the Discuss Mosbot.</td></tr>
         </table>