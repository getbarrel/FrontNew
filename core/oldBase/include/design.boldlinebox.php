<?php

function BoldLineBox($text, $width="240", $css_class="", $line_color="#ffffff", $bgcolor="#D7EBF5"){

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
                  <td height=2></td>
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
                  <td height=2></td>
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
                  <td width=10 bgcolor='".$line_color."'></td>
                  <td ".($css_class == "" ? "bgcolor='".$bgcolor."'" :$css_class)." ><!--style='padding:4 2 2 4' -->
                    $text
                  </td>
                  <td width=10 bgcolor='".$line_color."'></td>
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
?>