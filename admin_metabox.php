<?php
if (!defined('ABSPATH')) {
    die;
}

global $post;
wp_nonce_field('meta_box_nonce_action', 'meta_box_nonce_field');


?>
<div style="width:calc(100% - 110px);float:left">

<h3>Required parameters</h3>

<h4 class="gsql_h4">Step 1: Choose a chart type</h4>

<p>
<select name="guaven_sqlcharts_graphtype" id="guaven_sqlcharts_graphtype">
<option value="pie_l" <?php $smfootnote='';
$guaven_sqlcharts_graphtype = get_post_meta($post->ID, 'guaven_sqlcharts_graphtype', true);
echo ($guaven_sqlcharts_graphtype == 'pie_l' ? 'selected' : '');?>>Pie Chart</option>
<option value="line_l" <?php echo ($guaven_sqlcharts_graphtype == 'line_l' ? 'selected' : '');?>>Line Chart</option>
<option value="donut_l" <?php echo ($guaven_sqlcharts_graphtype == 'donut_l' ? 'selected' : '');?>>Donut Chart</option>
<option value="bar_l" <?php echo ($guaven_sqlcharts_graphtype == 'bar_l' ? 'selected' : '');?>>Vertical Bar Chart</option>
<option value="horizontalbar_l" <?php echo ($guaven_sqlcharts_graphtype == 'horizontalbar_l' ? 'selected' : '');?>>Horizontal Bar Chart</option>
<option value="area_l" <?php echo ($guaven_sqlcharts_graphtype == 'area_l' ? 'selected' : '');?>>Area Chart</option>
<option value="polar_l" <?php echo ($guaven_sqlcharts_graphtype == 'polar_l' ? 'selected' : '');?>>Polar Area</option>

<?php
if ($guaven_sqlcharts_graphtype!='' and strpos($guaven_sqlcharts_graphtype,'_l')===false) {
?>
<option value="pie" <?php echo ($guaven_sqlcharts_graphtype == 'pie' ? 'selected' : '');?>>Google Chart - Pie *</option>
<option value="3dpie" <?php echo ($guaven_sqlcharts_graphtype == '3dpie' ? 'selected' : '');?>>Google Chart - 3D Pie *</option>
<option value="column" <?php echo ($guaven_sqlcharts_graphtype == 'column' ? 'selected' : '');?>>Google Chart - Column *</option>
<option value="bar" <?php echo ($guaven_sqlcharts_graphtype == 'bar' ? 'selected' : '');?>>Google Chart - Bar *</option>
<option value="area" <?php echo ($guaven_sqlcharts_graphtype == 'area' ? 'selected' : '');?>>Google Chart - Area *</option>
<?php
$smfootnote='<br><small>
* Google Chart options are deprecated and will be removed since 3.0 version.
Currently those options support single queries only. Use non-Google Chart options above.
</small>';
} ?>
</select>
<?php
echo $smfootnote;
?>
<br>
</p>

<p><label><input type="checkbox" name="guaven_sqlcharts_tablepart" value="1" <?php echo get_post_meta($post->ID, 'guaven_sqlcharts_tablepart', true)!=''?'checked':''; ?>>
  Show table-view data below the graph</lable></p>
</div>
<div style="width:110px;float:left"><img src="<?php echo plugin_dir_url( __FILE__ ) . 'asset/img/pie.png';?>" class="charttype" style="opacity:0.5;margin-top:20px;float:right;width:100px"></div>
<div style="clear:both;display:block"></div>
<hr>




<h4 class="gsql_h4">Step 2: Enter Your SQL Query  </h4>
<p>
<textarea name="guaven_sqlcharts_code" id="guaven_sqlcharts_code" style="width:100%" rows="6"><?php
echo (get_post_meta($post->ID, 'guaven_sqlcharts_code', true) != '' ? get_post_meta($post->ID, 'guaven_sqlcharts_code', true) : '');
?>
</textarea>
<br><small>Separate sql queries with ";" if you would like to use multiple queries to build comparison graphs. <a href="https://www.dropbox.com/s/l9xggkeliqdswo9/mysqlchart_example.png?dl=0"  target="_blank">See example</a>
<br>
<b>Some supported dynamic tags can be used in your query: {current_user_id},{current_user_login},{current_user_email},{current_user_display_name}.</b>
</small>
</p>

<hr>





<h4 class="gsql_h4">Step 3: Set Arguments and Values for a Chart - See <a href="https://www.dropbox.com/s/5tt0se24x6hfas0/mysqlchart_example-1.png?dl=0" target="_blank">Example 1</a>
  and <a href="https://www.dropbox.com/s/s8ygh1zngo2ajzi/mysqlchart_example-4.png?dl=0" target="_blank">Example 2</a></h4>


<div style="display:inline-block;width:48%;height:90px;vertical-align:text-bottom">
Label for X axis: <br><input type="text" name="guaven_sqlcharts_xarg_l" id="guaven_sqlcharts_xarg_l" value="<?php
echo get_post_meta($post->ID, 'guaven_sqlcharts_xarg_l', true);
?>">
<br>
<small>This is just label text for a query argument, you can type any desired name here.</small>
</div>

<div style="display:inline-block;width:48%;height:90px;vertical-align:text-bottom">
Label for Y axis: <br><input type="text" name="guaven_sqlcharts_yarg_l" id="guaven_sqlcharts_yarg_l" value="<?php
echo get_post_meta($post->ID, 'guaven_sqlcharts_yarg_l', true);
?>">
<br><small>This is just a label text for query's main value, you can type any desired name here.<br>
  Use ";" separated label names if you have more than one query inside SQL CODE field.</small>
</div>

<div style="width:100%;padding:4px"></div>
<div>
<div style="display:inline-block;width:48%;height:90px;vertical-align:text-bottom">
SQL column name of X axis:
<br>
<input type="text" name="guaven_sqlcharts_xarg_s" id="guaven_sqlcharts_xarg_s" value="<?php
echo get_post_meta($post->ID, 'guaven_sqlcharts_xarg_s', true);
?>"><br>
<small>Write corresponding SQL field/column name here. f.e. display_name, post_date</small>
</div>


<div style="display:inline-block;width:48%;height:90px;vertical-align:text-bottom">
SQL column name of Y axis:
<br>
<input type="text" name="guaven_sqlcharts_yarg_s" id="guaven_sqlcharts_yarg_s" value="<?php
echo get_post_meta($post->ID, 'guaven_sqlcharts_yarg_s', true);
?>"><br>
<small>Write corresponding SQL field name here. f.e. post_count) - Use one single output name even if you have multiple queries in SQL CODE field.</small>
</div>
</div>


<hr/>
<h3 id="Optional" id="Optional">Advanced parameters</h3>
<p>  <a href="#Optional" class="btn button dynamicfieldbutton">Show/Hide Advanced Parameters</a></p>

<div class="dynamicfielddiv" style="display:none">

<hr/>
<h4 class="gsql_h4">Width and height (with px. don't type px itself, just numbers)</h4>
<p>

<input type="number" name="guaven_sqlcharts_chartwidth" id="guaven_sqlcharts_chartwidth" value="<?php
echo get_post_meta($post->ID, 'guaven_sqlcharts_chartwidth', true);
?>">

<input type="number" name="guaven_sqlcharts_chartheight" id="guaven_sqlcharts_chartheight" value="<?php
echo get_post_meta($post->ID, 'guaven_sqlcharts_chartheight', true);
?>">
</p>

<p>
Color scheme (comma separated #RGB colors. f.e.  <i>#FF0000</i>  or <i>#00FF00,#BBCC00</i> ).
<br>
<input type="text" name="guaven_sqlcharts_colors" id="guaven_sqlcharts_colors" value="<?php
echo get_post_meta($post->ID, 'guaven_sqlcharts_colors', true);
?>" style="width:500px">
<br><small>Leave empty if you want random colors</small>
</p>

<p>
Mouse-over tooltips</p>
<p>
<label for="guaven_sqlcharts_forcetooltips">
  <input type="checkbox" name="guaven_sqlcharts_forcetooltips" id="guaven_sqlcharts_forcetooltips" value="1" <?php echo get_post_meta($post->ID, 'guaven_sqlcharts_forcetooltips', true)!=''?'checked':''; ?>>
  Force tooltips to be shown by default(not only after mouse-over)
</label>
</p>

<p>
Legend block
<br>
<?php $guaven_sqlcharts_legend_position=get_post_meta($post->ID, 'guaven_sqlcharts_legend_position', true);?>
<select name="guaven_sqlcharts_legend_position" id="guaven_sqlcharts_legend_position">
  <option value="default">Default</option>
  <option value="top" <?php echo $guaven_sqlcharts_legend_position=='top'?"selected":''; ?>>Shop at the top</option>
  <option value="bottom" <?php echo $guaven_sqlcharts_legend_position=='bottom'?"selected":''; ?>>Shop at the bottom</option>
  <option value="left" <?php echo $guaven_sqlcharts_legend_position=='left'?"selected":''; ?>>Shop at the left</option>
  <option value="right" <?php echo $guaven_sqlcharts_legend_position=='right'?"selected":''; ?>>Shop at the right</option>
  <option value="hide" <?php echo $guaven_sqlcharts_legend_position=='hide'?"selected":''; ?>>Hide legend</option>
</select>
<br><small>Legend in a chart is Y values which usually appears at the top/right part of the graph</small>
</p>

<hr/>
<h4 class="gsql_h4">X and Y Axis Ticks (for Line and Bar charts)</h4>
<p>
<label for="guaven_sqlcharts_begin_with_0_x">
  <input type="checkbox" name="guaven_sqlcharts_begin_with_0_x" id="guaven_sqlcharts_begin_with_0_x" value="1" <?php echo get_post_meta($post->ID, 'guaven_sqlcharts_begin_with_0_x', true)!=''?'checked':''; ?>>
  Force start X axes at 0
</label>

<label for="guaven_sqlcharts_begin_with_0_y">
  <input type="checkbox" name="guaven_sqlcharts_begin_with_0_y" id="guaven_sqlcharts_begin_with_0_y" value="1" <?php echo get_post_meta($post->ID, 'guaven_sqlcharts_begin_with_0_y', true)!=''?'checked':''; ?>>
  Force start X axes at 0
</label>
</p>

<p>
<label for="guaven_sqlcharts_round_y_values">
  <input type="checkbox" name="guaven_sqlcharts_round_y_values" id="guaven_sqlcharts_round_y_values" value="1" <?php echo get_post_meta($post->ID, 'guaven_sqlcharts_round_y_values', true)!=''?'checked':''; ?>>
  Show only round numbers in Y axis ticks 
</label>


 <label for="guaven_sqlcharts_nostacked">
<input type="checkbox" name="guaven_sqlcharts_nostacked" id="guaven_sqlcharts_nostacked" value="1" <?php echo get_post_meta($post->ID, 'guaven_sqlcharts_nostacked', true)!=''?'checked':''; ?>
>Disable "stackedness" for datasets
</label>

</p>


<hr/>
<h4 class="gsql_h4">Remote MySQL Database Access Details</h4>

Leave empty if you are connecting to local DB.<p>
<input type="text" name="guaven_sqlcharts_dbhost" id="guaven_sqlcharts_dbhost" value="<?php
echo get_post_meta($post->ID, 'guaven_sqlcharts_dbhost', true);
?>" placeholder="database host">

<input type="text" name="guaven_sqlcharts_dbname" id="guaven_sqlcharts_dbname" value="<?php
echo get_post_meta($post->ID, 'guaven_sqlcharts_dbname', true);
?>" placeholder="database name">

<input type="text" name="guaven_sqlcharts_dblogin" id="guaven_sqlcharts_dblogin" value="<?php
echo get_post_meta($post->ID, 'guaven_sqlcharts_dblogin', true);
?>" placeholder="database username">

<?php 
$dbpass=get_post_meta($post->ID, 'guaven_sqlcharts_dbpass', true);
if(is_array($dbpass)){
  $dbpass=guaven_sqlcharts_encrypt_decrypt('decrypt',$dbpass[1]);
}

?>
<input type="password" name="guaven_sqlcharts_dbpass" id="guaven_sqlcharts_dbpass" value="<?php
echo $dbpass;
?>" placeholder="database password">

</p>
<p>
<small>Note: WordPress supports MySQL only Databases, to use non-MySQL databases some custom PHP code&driver would be needed. 
To discuss how to build that you can <a target="_blank" href="https://guaven.com/contact/solution-request/">contact us</a>.

</small><br>
</p>


<hr/>
<h4 class="gsql_h4" >Dynamic filters - See <a href="https://www.dropbox.com/s/6xa6gk7uc75b8me/mysqlchart_example-2.png?dl=0" target="_blank">Example Settings</a>
  and <a href="https://www.dropbox.com/s/fq1gnqcqdbj65ch/mysqlchart_example-3.png?dl=0" target="_blank">Example Demo</a>
 </h4>

<div >
<p style="font-weight:bold">Enter dynamic filter variables using the format described below:</p>
<textarea name="guaven_sqlcharts_variables" id="guaven_sqlcharts_variables" style="width:100%" rows="2"><?php
echo (get_post_meta($post->ID, 'guaven_sqlcharts_variables', true) != '' ? get_post_meta($post->ID, 'guaven_sqlcharts_variables', true) : '');
?>
</textarea>
<br><p>Use this format: <i>variable_name~default_value~variable_label~variable_type | variable_name~default_value~variable_label~variable_type</i> etc.<br>
  <ul style="padding-left:20px"><li>variable_name - any single name you want.</li><li>
  default_value - default value when no any variable chosen by a user</li><li>
  variable_label - Label which would be visible at a form above the chart</li><li>
  variable_type - number, text or date</li><li>
  ~ is a separator between variable elements.</li><li>
    | is a separator between variables</li></ul>

  For example if to put <b>limit_tag~10~Count~number | post_date_tag~2010-07-05 17:25:18~Date Published~date</b> here,
  then you can use this SQL code <b>select * from wp_posts where post_date<{post_date_tag} limit {limit_tag}</b> in SQL CODE field.
  {post_date_tag} and {limit_tag} would be replaced with dynamic variables.
  So, the plugin will automatically recognize it and put corresponding selectboxes above the chart.  <br></p>
<p><label><input type="checkbox" name="guaven_sqlcharts_formpartrole" value="1"
  <?php echo get_post_meta($post->ID, 'guaven_sqlcharts_formpartrole', true)!=''?'checked':''; ?>>
  Hide dynamic filters form from not-loggedin users at frontend. </label></p>

  <p><label>Submit button text (default is "OK") <input type="text" name="guaven_sqlcharts_formpartbutton" value="<?php
  echo esc_attr(get_post_meta($post->ID, 'guaven_sqlcharts_formpartbutton', true) ); ?>" placeholder="Submit button text"></label></p>

</div>


</div>
<hr>

<style>
.gsql_h4{color:#4693dd;margin-top:5px;margin-bottom:5px}
.wpdberror{color:white;background: red;padding:10px;}
#guaven_sqlcharts_begin_with_0_y{margin-left:24px;}
</style>
<script>
if (jQuery("#post").attr("action").indexOf("#")==-1){
  jQuery("#post").attr("action",jQuery("#post").attr("action")+"#sqldemo");
}
</script>
<?php
$postfix=guaven_sqlcharts_graphtype($post);
if ($postfix != '') {
    
?>
<div class="gf-alert-success gf-alert">
<h4>
Text shortcode: [gvn_schart<?php
    echo $postfix;
?> id="<?php
    echo $post->ID;
?>"<?php echo get_post_meta($post->ID,'guaven_sqlcharts_tablepart',true)!=''?' table="1"':''; ?>]
<br>
<br>
PHP shorcode: &lt;?php echo do_shortcode(' [gvn_schart<?php
    echo $postfix;
?> id="<?php
    echo $post->ID;
?>"<?php echo get_post_meta($post->ID,'guaven_sqlcharts_tablepart',true)!=''?' table="1"':''; ?>]'); ?&gt;
</h4>
<p>Note: Shortcodes supports width and height attributes. F.e. [gvn_schart<?php
    echo $postfix;
?> id="1" width="500" height="400"]. If no attributes, default width, height (which you enter in this page above) will be used.
</div>
<hr>
<h3 id="sqldemo" name="sqldemo">Save Changes and See Live Demo</h3>
<?php
    echo do_shortcode(' [gvn_schart' . $postfix . ' id="' . $post->ID . '" '.(get_post_meta($post->ID,'guaven_sqlcharts_tablepart',true)!=''?' table="1"':'').']');

}
?>
<script>
jQuery(".dynamicfieldbutton").click(function(){jQuery(".dynamicfielddiv").fadeToggle("slow")});
plugindirurl='<?php  echo plugin_dir_url( __FILE__ ) . 'asset/img/'; ?>';
jQuery("#guaven_sqlcharts_graphtype").change(function(){
  jQuery(".charttype").attr("src",plugindirurl+jQuery(this).val().replace("_l","").replace("column","bar")+'.png');
});
jQuery("#guaven_sqlcharts_graphtype").trigger('change');

</script>
<?php 