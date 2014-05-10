<?php
/*
License:
 Released under the GPL license
  http://www.gnu.org/copyleft/gpl.html

  Copyright 2009 
  - Unmastered Affiliate (email : contact@unmasteredaffiliate.com) 
  - Paradigm Advertising (email : contact@paradigmadvertising.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

	You may not remove this license message from the source code
*/

// Replace "YOURACCESSKEYID" with your ShrinkTheWeb Access Key ID.
define('ACCESS_KEY', 'YOURACCESSKEYID');
		
if (!empty($_POST['siteurl'])) {
	$url='http://www.shrinktheweb.com/xino.php?stwembed=1&stwaccesskeyid='.ACCESS_KEY.'&stwxmax=200&stwurl='.$_POST['siteurl'];
	echo '<img src="',$url,'" />';
}



else{
?>
<script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.3.2.min.js"></script>
<script type="text/javascript">
function send(){

		var data = 'siteurl=' + $("#siteurl").val(); 

			$.ajax({
					url: "form.php", 
					type: "post",
					data:  data,
					cache: false,

					success: function (html) {                
						$("#imageContainer").html(html);
					}  // success:      

			}); 
}

</script>
<input type="text" name="siteurl" id="siteurl"/>
<input type="submit" value="Submit" onclick="send()"/>
<? } ?>
<div id="imageContainer"></div>