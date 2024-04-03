<?php

function OneLineBox($vContents,$linecolor,  $ContentsBgcolor, $vwidth,$vheight){

	 return "	<table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=5 height=1></td>
			      <td width='".($vwidth-10)."' height=1 bgcolor=$linecolor></td>
			      <td width=5 height=1></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=3 height=1></td>
			      <td width=2 height=1 bgcolor='$linecolor'></td>
			      <td width='".($vwidth-10)."' height=1 bgcolor='$ContentsBgcolor'></td>
			      <td width=2 height=1 bgcolor=$linecolor></td>
			      <td width=3 height=1></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=2 height=1></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=3 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width='".($vwidth-12)."' height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=3 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=2 height=1></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=1 height=1></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=2 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width='".($vwidth-8)."' height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=2 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=1 height=1></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=1 height=1></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=1 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width='".($vwidth-6)."' height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=1 height=1></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=2 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width='".($vwidth-6)."' height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=2 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=1 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width='".($vwidth-4)."' height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=22 style='TABLE-LAYOUT: fixed'>			    
			    <tr>
			      <td width=1 bgcolor=$linecolor></td>
			      <td width=1 bgcolor=$ContentsBgcolor></td>
			      <td width=8 bgcolor=$ContentsBgcolor></td>
			      <td width='".($vwidth-12)."' height=$vheight bgcolor=$ContentsBgcolor valign=top style='PADDING-RIGHT: 10px; PADDING-LEFT: 2px; PADDING-BOTTOM: 10px; PADDING-TOP: 5px'>
					$vContents 
			      </td>
			      <td width=1 bgcolor='$ContentsBgcolor'></td>
			      <td width=1 bgcolor='$linecolor'></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=1 height=2></td>
			      <td width=1 height=2 bgcolor=$linecolor></td>
			      <td width='".($vwidth-4)."' height=2 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=2 bgcolor=$linecolor></td>
			      <td width=1 height=2></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=2 height=1></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width='".($vwidth-6)."' height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=2 height=1></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=3 height=1></td>
			      <td width=2 height=1 bgcolor=$linecolor></td>
			      <td width='".($vwidth-10)."' height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=2 height=1 bgcolor=$linecolor></td>
			      <td width=3 height=1></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=5 height=1></td>
			      <td width='".($vwidth-10)."' height=1 bgcolor=$linecolor></td>
			      <td width=5 height=1></td>
			    </tr>
			    </table>";
  
}


function OneLineBoxStart($linecolor,  $ContentsBgcolor, $vwidth,$vheight){

	 return "	<table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=5 height=1></td>
			      <td width='".($vwidth-10)."' height=1 bgcolor=$linecolor></td>
			      <td width=5 height=1></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=3 height=1></td>
			      <td width=2 height=1 bgcolor='$linecolor'></td>
			      <td width='".($vwidth-10)."' height=1 bgcolor='$ContentsBgcolor'></td>
			      <td width=2 height=1 bgcolor=$linecolor></td>
			      <td width=3 height=1></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=2 height=1></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=3 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width='".($vwidth-12)."' height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=3 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=2 height=1></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=1 height=1></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=2 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width='".($vwidth-8)."' height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=2 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=1 height=1></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=1 height=1></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=1 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width='".($vwidth-6)."' height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=1 height=1></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=2 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width='".($vwidth-6)."' height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=2 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=1 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width='".($vwidth-4)."' height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=22 style='TABLE-LAYOUT: fixed'>			    
			    <tr>
			      <td width=1 bgcolor=$linecolor></td>
			      <td width=1 bgcolor=$ContentsBgcolor></td>
			      <td width=8 bgcolor=$ContentsBgcolor></td>
			      <td width='".($vwidth-12)."' height=$vheight bgcolor=$ContentsBgcolor valign=top style='PADDING-RIGHT: 10px; PADDING-LEFT: 2px; PADDING-BOTTOM: 10px; PADDING-TOP: 5px'>";
					
			   
  
}



function OneLineBoxEnd($linecolor,  $ContentsBgcolor, $vwidth,$vheight){

	 return "	
			      </td>
			      <td width=1 bgcolor='$ContentsBgcolor'></td>
			      <td width=1 bgcolor='$linecolor'></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=1 height=2></td>
			      <td width=1 height=2 bgcolor=$linecolor></td>
			      <td width='".($vwidth-4)."' height=2 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=2 bgcolor=$linecolor></td>
			      <td width=1 height=2></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=2 height=1></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width='".($vwidth-6)."' height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=2 height=1></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=3 height=1></td>
			      <td width=2 height=1 bgcolor=$linecolor></td>
			      <td width='".($vwidth-10)."' height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=2 height=1 bgcolor=$linecolor></td>
			      <td width=3 height=1></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=5 height=1></td>
			      <td width='".($vwidth-10)."' height=1 bgcolor=$linecolor></td>
			      <td width=5 height=1></td>
			    </tr>
			    </table>";
  
}



function OneLineBoxNoPadding($vContents,$linecolor,  $ContentsBgcolor, $vwidth,$vheight){

	 return "	<table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=5 height=1></td>
			      <td width='".($vwidth-10)."' height=1 bgcolor=$linecolor></td>
			      <td width=5 height=1></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=3 height=1></td>
			      <td width=2 height=1 bgcolor='$linecolor'></td>
			      <td width='".($vwidth-10)."' height=1 bgcolor='$ContentsBgcolor'></td>
			      <td width=2 height=1 bgcolor=$linecolor></td>
			      <td width=3 height=1></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=2 height=1></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=3 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width='".($vwidth-12)."' height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=3 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=2 height=1></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=1 height=1></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=2 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width='".($vwidth-8)."' height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=2 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=1 height=1></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=1 height=1></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=1 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width='".($vwidth-6)."' height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=1 height=1></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=2 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width='".($vwidth-6)."' height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=2 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=1 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width='".($vwidth-4)."' height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=22 style='TABLE-LAYOUT: fixed'>			    
			    <tr>
			      <td width=1 bgcolor=$linecolor></td>
			      <td width=1 bgcolor=$ContentsBgcolor></td>
			      <td width=8 bgcolor=$ContentsBgcolor></td>
			      <td width='".($vwidth-12)."' height=$vheight bgcolor=$ContentsBgcolor valign=top style='PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px'>
					$vContents 
			      </td>
			      <td width=1 bgcolor='$ContentsBgcolor'></td>
			      <td width=1 bgcolor='$linecolor'></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=1 height=2></td>
			      <td width=1 height=2 bgcolor=$linecolor></td>
			      <td width='".($vwidth-4)."' height=2 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=2 bgcolor=$linecolor></td>
			      <td width=1 height=2></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=2 height=1></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width='".($vwidth-6)."' height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=2 height=1></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=3 height=1></td>
			      <td width=2 height=1 bgcolor=$linecolor></td>
			      <td width='".($vwidth-10)."' height=1 bgcolor=$ContentsBgcolor></td>
			      <td width=2 height=1 bgcolor=$linecolor></td>
			      <td width=3 height=1></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=5 height=1></td>
			      <td width='".($vwidth-10)."' height=1 bgcolor=$linecolor></td>
			      <td width=5 height=1></td>
			    </tr>
			    </table>";
  
}
?>