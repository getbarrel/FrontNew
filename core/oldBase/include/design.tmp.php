<?php
include(OLDBASE_ROOT."/include/design.onelinebox.php");
include(OLDBASE_ROOT."/include/design.boldlinebox.php");



function colorCirCleBox($color,$width,$text){

	return  "<table cellpadding=0 cellspacing=0 width=$width>
			<tr>
				<td>
					<table cellpadding=0 cellspacing=0 border=0 width=100% align=center>
					  <tr height=1>
					    <td rowspan=3 width=1></td>
					    <td width=1></td>
					    <td width=1></td>
					    <td bgcolor=$color></td>
					    <td width=1></td>
					    <td width=1></td>
					    <td rowspan=3 width=1></td>
					  </tr>
					  <tr height=1>
					    <td colspan=2 bgcolor=$color></td>
					    <td bgcolor=$color></td>
					    <td colspan=2 bgcolor=$color></td>
					  </tr>
					  <tr height=1>
					    <td bgcolor=$color></td>
					    <td colspan=3 bgcolor=$color></td>
					    <td bgcolor=$color></td>
					  </tr>
					</table>
				</td>
			</tr>
			<tr>
				<td bgcolor='$color'>$text</td>
			</tr>
			<tr>
				<td>
				<table cellpadding=0 cellspacing=0 border=0 width=100% align=center>
				  <tr height=1>
				    <td rowspan=3 width=1></td>
				    <td rowspan=2 width=1 bgcolor=$color></td>
				    <td colspan=3 bgcolor=$color></td>
				    <td rowspan=2 width=1 bgcolor=$color></td>
				    <td rowspan=3 width=1></td>
				  </tr>
				  <tr height=1>
				    <td width=1 bgcolor=$color></td>
				    <td bgcolor=$color></td>
				    <td width=1 bgcolor=$color></td>
				  </tr>
				  <tr height=1>
				    <td colspan=2></td>
				    <td bgcolor=$color></td>
				    <td colspan=2></td>
				  </tr>
				</table>
				</td>
			</tr>
		</table>";
}


function top_menu_box($text, $width="240", $css_class="", $line_color="#ffffff", $start_color="#ffffff", $end_color="#D7EBF5"){


return "
<style>.".$css_class." {filter='progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr=$start_color, EndColorStr=$end_color)'; }</style>
<table width=$width border=0 cellspacing=0 cellpadding=0 style='margin-top:0'>
                <tr> 
                  <td height=1 width=1></td>
                  <td width=1></td>
                  <td width=1></td>
                  <td bgcolor='".$line_color."' width=1></td>
                  <td bgcolor='".$line_color."' width=".($width-8)."></td>
                  <td bgcolor='".$line_color."' width=1></td>
                  <td width=1></td>
                  <td width=1></td>
                  <td width=1></td>
                </tr>
                <tr> 
                  <td height=1></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td></td>
                </tr>
                <tr> 
                  <td height=1></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$start_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td></td>
                </tr>
                <tr> 
                  <td bgcolor='".$line_color."' height=1></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$start_color."'></td>
                  <td bgcolor='".$start_color."'></td>
                  <td bgcolor='".$start_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                </tr>
              </table>
              <table width=$width border=0 cellspacing=0 cellpadding=0>
                <tr> 
                  <td width=2 bgcolor='".$line_color."'></td>
                  <td ".($css_class == "" ? "bgcolor='".$bgcolor."'" :"class='".$css_class."'")." style='padding:4 2 2 4' >
                    $text
                  </td>
                  <td width=2 bgcolor='".$line_color."'></td>
                </tr>
              </table>
              <table width=$width border=0 cellspacing=0 cellpadding=0 style='margin-bottom:6'>
                <tr>
                  <td bgcolor='".$line_color."' height=1></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$end_color."'></td>
                  <td bgcolor='".$end_color."'></td>
                  <td bgcolor='".$end_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                </tr>
                <tr> 
                  <td height=1></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$end_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td></td>
                </tr>
                <tr> 
                  <td height=1></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td></td>
                </tr>
                <tr> 
                  <td height=1 width=1></td>
                  <td width=1></td>
                  <td width=1></td>
                  <td bgcolor='".$line_color."' width=1></td>
                  <td bgcolor='".$line_color."' width=".($width-8)."></td>
                  <td bgcolor='".$line_color."' width=1></td>
                  <td width=1></td>
                  <td width=1></td>
                  <td width=1></td>
                </tr>
              </table>";
}



function doubleline_box($text, $width="240", $css_class="", $line_color="#ffffff", $bgcolor="#D7EBF5"){

return "
<style>.color1 {filter='progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr=$line_color, EndColorStr=#D7EBF5)'; }</style>
<table width=$width border=0 cellspacing=0 cellpadding=0 style='margin-top:0'>
                <tr> 
                  <td height=1 width=1></td>
                  <td width=1></td>
                  <td width=1></td>
                  <td bgcolor='".$line_color."' width=1></td>
                  <td bgcolor='".$line_color."' width=".($width-8)."></td>
                  <td bgcolor='".$line_color."' width=1></td>
                  <td width=1></td>
                  <td width=1></td>
                  <td width=1></td>
                </tr>
                <tr> 
                  <td height=1></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td></td>
                </tr>
                <tr> 
                  <td height=1></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$bgcolor."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td></td>
                </tr>
                <tr> 
                  <td bgcolor='".$line_color."' height=1></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$bgcolor."'></td>
                  <td bgcolor='".$bgcolor."'></td>
                  <td bgcolor='".$bgcolor."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                </tr>
              </table>
              <table width=$width border=0 cellspacing=0 cellpadding=0>
                <tr> 
                  <td width=2 bgcolor='".$line_color."'></td>
                  <td ".($css_class == "" ? "bgcolor='".$bgcolor."'" :$css_class)." ><!--style='padding:4 2 2 4' -->
                    $text
                  </td>
                  <td width=2 bgcolor='".$line_color."'></td>
                </tr>
              </table>
              <table width=$width border=0 cellspacing=0 cellpadding=0 style='margin-bottom:6'>
                <tr>
                  <td bgcolor='".$line_color."' height=1></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$bgcolor."'></td>
                  <td bgcolor='".$bgcolor."'></td>
                  <td bgcolor='".$bgcolor."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                </tr>
                <tr> 
                  <td height=1></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$bgcolor."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td></td>
                </tr>
                <tr> 
                  <td height=1></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td bgcolor='".$line_color."'></td>
                  <td></td>
                </tr>
                <tr> 
                  <td height=1 width=1></td>
                  <td width=1></td>
                  <td width=1></td>
                  <td bgcolor='".$line_color."' width=1></td>
                  <td bgcolor='".$line_color."' width=".($width-8)."></td>
                  <td bgcolor='".$line_color."' width=1></td>
                  <td width=1></td>
                  <td width=1></td>
                  <td width=1></td>
                </tr>
              </table>";
}

function text_button($text, $width="156", $outcolor='#ffffff', $innercolor='#D7EBF5'){

return "
<table width=$width border=0 cellspacing=0 cellpadding=0 style='margin-top:7'>
                <tr> 
                  <td height=1 width=1></td>
                  <td width=1></td>
                  <td width=1></td>
                  <td bgcolor=$outcolor width=1></td>
                  <td bgcolor=$outcolor width=".($width-8)."></td>
                  <td bgcolor=$outcolor width=1></td>
                  <td width=1></td>
                  <td width=1></td>
                  <td width=1></td>
                </tr>
                <tr> 
                  <td height=1></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                  <td></td>
                </tr>
                <tr> 
                  <td height=1></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$innercolor></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                  <td></td>
                </tr>
                <tr> 
                  <td bgcolor=$outcolor height=1></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$innercolor></td>
                  <td bgcolor=$innercolor></td>
                  <td bgcolor=$innercolor></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                </tr>
              </table>
              <table width=$width border=0 cellspacing=0 cellpadding=0>
                <tr> 
                  <td width=2 bgcolor=$outcolor></td>
                  <td bgcolor=$innercolor style='padding:4 2 2 9'><!--img src='/forbiz/img/squ_blue01.gif' width=11 height=11 style='margin:0 1 3 0' border=0 align=absbottom--> 
                    $text
                  </td>
                  <td width=2 bgcolor=$outcolor></td>
                </tr>
              </table>
              <table width=$width border=0 cellspacing=0 cellpadding=0 style='margin-bottom:6'>
                <tr> 
                  <td bgcolor=$outcolor height=1></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$innercolor></td>
                  <td bgcolor=$innercolor></td>
                  <td bgcolor=$innercolor></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                </tr>
                <tr> 
                  <td height=1></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$innercolor></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                  <td></td>
                </tr>
                <tr> 
                  <td height=1></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                  <td bgcolor=$outcolor></td>
                  <td></td>
                </tr>
                <tr> 
                  <td height=1 width=1></td>
                  <td width=1></td>
                  <td width=1></td>
                  <td bgcolor=$outcolor width=1></td>
                  <td bgcolor=$outcolor width=".($width-8)."></td>
                  <td bgcolor=$outcolor width=1></td>
                  <td width=1></td>
                  <td width=1></td>
                  <td width=1></td>
                </tr>
              </table>";
}



function GrayCirCleBoxStart($vwidth,$vheight){

	return  "<table cellpadding=0 cellspacing=0 width='$vwidth' style='background-repeat:no-repeat;background-position: 70% 0%'>
			<tr height=19>
				<td align=left width=19> <img src='/tmp/images/frame_topleft.gif'></td><td  style='border-top:1px solid #CBCBCB'>&nbsp;</td><td align=right width=19> <img src='/tmp/images/frame_topright.gif'></td>
			</tr>
			<tr height=$vheight valign=top>
				<td style='border-left:1px solid #CBCBCB'>&nbsp;</td>
				<td>";
				

}

function GrayCirCleBoxEnd(){
				
	return	"		</td>
				<td style='border-right:1px solid #CBCBCB'>&nbsp;</td>
			</tr>
			<tr height=19>
				<td align=left width=19> <img src='/tmp/images/frame_bottomleft.gif'></td><td  style='border-bottom:1px solid #CBCBCB'>&nbsp;</td><td align=right width=19><img src='/tmp/images/frame_bottomright.gif'></td>
			</tr>
		</table>";

}

function ShadowCirCleBoxStart($vwidth,$vheight){

	 return "	<table cellpadding=0 cellspacing=0 width='$vwidth'>
				<tr height=18>
					<td align=left width=19> <img src='/tmp/images/shadow_topleft.gif'></td><td  style='border-top:1px solid #CBCBCB'>&nbsp;</td><td align=right width=19> <img src='/tmp/images/shadow_topright.gif'></td>
				</tr>
				<tr height=$vheight valign=top>
					<td style='border-left:1px solid #CBCBCB'>&nbsp;</td>
					<td>";	

}

function ShadowCirCleBoxEnd(){

				
	return	"			</td>
					<td background='/tmp/images/shadow_right.gif'></td>
				</tr>
				<tr height=19>
					<td align=left width=19> <img src='/tmp/images/shadow_bottomleft.gif'></td><td  background='/tmp/images/shadow_bottom.gif'>&nbsp;</td><td align=right width=19><img src='/tmp/images/shadow_bottomright.gif'></td>
				</tr>
			</table>";

}

function ShadowHalfBoxStart($vwidth,$vheight){

	return  "	<table cellpadding=0 cellspacing=0 width=$vwidth>
				<tr height=18>
					<td  style='border-top:1px solid #CBCBCB'>&nbsp;</td><td align=right width=19> <img src='/tmp/images/shadow_topright.gif'></td>
				</tr>
				<tr height=$vheight valign=top>
					<td>";
			

}

function ShadowHalfBoxEnd(){

				
	return	"			</td>
					<td background='/tmp/images/shadow_right.gif'></td>
				</tr>
				<tr height=19>
					<td  background='/tmp/images/shadow_bottom.gif'>&nbsp;</td><td align=right width=19><img src='/tmp/images/shadow_bottomright.gif'></td>
				</tr>
			</table>";

}

function colorCirCleBoxStart($color,$width){

	return  "<table cellpadding=0 cellspacing=0 width=$width>
			<tr>
				<td>
					<table cellpadding=0 cellspacing=0 border=0 width=100% align=center>
					  <tr height=1>
					    <td rowspan=3 width=1></td>
					    <td width=1></td>
					    <td width=1></td>
					    <td bgcolor=$color></td>
					    <td width=1></td>
					    <td width=1></td>
					    <td rowspan=3 width=1></td>
					  </tr>
					  <tr height=1>
					    <td colspan=2 bgcolor=$color></td>
					    <td bgcolor=$color></td>
					    <td colspan=2 bgcolor=$color></td>
					  </tr>
					  <tr height=1>
					    <td bgcolor=$color></td>
					    <td colspan=3 bgcolor=$color></td>
					    <td bgcolor=$color></td>
					  </tr>
					</table>
				</td>
			</tr>
			<tr>
				<td bgcolor='$color'>";
				

}

function colorCirCleBoxEnd($color){
	return 	"		</td>
			</tr>
			<tr>
				<td>
				<table cellpadding=0 cellspacing=0 border=0 width=100% align=center>
				  <tr height=1>
				    <td rowspan=3 width=1></td>
				    <td rowspan=2 width=1 bgcolor=$color></td>
				    <td colspan=3 bgcolor=$color></td>
				    <td rowspan=2 width=1 bgcolor=$color></td>
				    <td rowspan=3 width=1></td>
				  </tr>
				  <tr height=1>
				    <td width=1 bgcolor=$color></td>
				    <td bgcolor=$color></td>
				    <td width=1 bgcolor=$color></td>
				  </tr>
				  <tr height=1>
				    <td colspan=2></td>
				    <td bgcolor=$color></td>
				    <td colspan=2></td>
				  </tr>
				</table>
				</td>
			</tr>
		</table>";
}


function MenuCirCleBoxStart($color,$width){

	return  "<table cellpadding=0 cellspacing=0 width=$width>
			<tr>
				<td>
					<table cellpadding=0 cellspacing=0 border=0 width=100% align=center>
					  <tr height=1>
					    <td rowspan=3 width=1></td>
					    <td width=1></td>
					    <td width=1></td>
					    <td bgcolor=$color></td>
					    <td width=1></td>
					    <td width=1></td>
					    <td rowspan=3 width=1></td>
					  </tr>
					  <tr height=1>
					    <td colspan=2 bgcolor=$color></td>
					    <td bgcolor=$color></td>
					    <td colspan=2 bgcolor=$color></td>
					  </tr>
					  <tr height=1>
					    <td bgcolor=$color></td>
					    <td colspan=3 bgcolor=$color></td>
					    <td bgcolor=$color></td>
					  </tr>
					</table>
				</td>
			</tr>
			<tr>
				<td bgcolor='$color' align=center style='color:#ffffff;font-weight:bold;padding-left:5px;padding-right:5px;' nowrap>";
				

}

function MenuCirCleBoxEnd($color){
	return 	"		</td>
			</tr>
			<tr>
				<td>
				<table cellpadding=0 cellspacing=0 border=0 width=100% align=center>
				  <tr height=1>
				    <td rowspan=3 width=1></td>
				    <td rowspan=2 width=1 bgcolor=$color></td>
				    <td colspan=3 bgcolor=$color></td>
				    <td rowspan=2 width=1 bgcolor=$color></td>
				    <td rowspan=3 width=1></td>
				  </tr>
				  <tr height=1>
				    <td width=1 bgcolor=$color></td>
				    <td bgcolor=$color></td>
				    <td width=1 bgcolor=$color></td>
				  </tr>
				  <tr height=1>
				    <td colspan=2></td>
				    <td bgcolor=$color></td>
				    <td colspan=2></td>
				  </tr>
				</table>
				</td>
			</tr>
		</table>";
}


function ContentsBox($vtitle,$vContents,$linecolor, $titleBgcolor, $ContentsBgcolor, $vwidth,$vheight){

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
			      <td width='".($vwidth-10)."' height=1 bgcolor='$titleBgcolor'></td>
			      <td width=2 height=1 bgcolor=$linecolor></td>
			      <td width=3 height=1></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=2 height=1></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=3 height=1 bgcolor=$titleBgcolor></td>
			      <td width='".($vwidth-12)."' height=1 bgcolor=$titleBgcolor></td>
			      <td width=3 height=1 bgcolor=$titleBgcolor></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=2 height=1></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=1 height=1></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=2 height=1 bgcolor=$titleBgcolor></td>
			      <td width='".($vwidth-8)."' height=1 bgcolor=$titleBgcolor></td>
			      <td width=2 height=1 bgcolor=$titleBgcolor></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=1 height=1></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=1 height=1></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=1 height=1 bgcolor=$titleBgcolor></td>
			      <td width='".($vwidth-6)."' height=1 bgcolor=$titleBgcolor></td>
			      <td width=1 height=1 bgcolor=$titleBgcolor></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=1 height=1></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=2 height=1 bgcolor=$titleBgcolor></td>
			      <td width='".($vwidth-6)."' height=1 bgcolor=$titleBgcolor></td>
			      <td width=2 height=1 bgcolor=$titleBgcolor></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=1>
			    <tr>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			      <td width=1 height=1 bgcolor=$titleBgcolor></td>
			      <td width='".($vwidth-4)."' height=1 bgcolor=$titleBgcolor></td>
			      <td width=1 height=1 bgcolor=$titleBgcolor></td>
			      <td width=1 height=1 bgcolor=$linecolor></td>
			    </tr>
			    </table>
			    <table border=0 cellpadding=0 cellspacing=0 width=$vwidth height=22 style='TABLE-LAYOUT: fixed'>
			    <tr>
			      <td width=1 height=22 bgcolor=$linecolor></td>
			      <td width=1 height=22 bgcolor=$titleBgcolor></td>
			      <td width=8 height=22 bgcolor=$titleBgcolor></td>
			      <td width='".($vwidth-12)."' height=22 bgcolor=$titleBgcolor>
			         $vtitle 
			      <td width=1 height=22 bgcolor=$titleBgcolor></td>
			      <td width=1 height=22 bgcolor=$linecolor></td>
			    </tr>
			    <tr>
			      <td width=1 bgcolor=$linecolor></td>
			      <td width=1 bgcolor=$ContentsBgcolor></td>
			      <td width=8 bgcolor=$ContentsBgcolor></td>
			      <td width='".($vwidth-12)."' height=$vheight bgcolor=$ContentsBgcolor valign=top style='PADDING-RIGHT: 10px; PADDING-LEFT: 2px; PADDING-BOTTOM: 10px; PADDING-TOP: 10px'>
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