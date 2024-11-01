<?php
if (!defined('ABSPATH')) {
    die;
}
//postinstall function
function guaven_sqlcharts_load_defaults()
{
    if (get_option("guaven_sqlcharts_already_installed_2") === false) {
        update_option("guaven_sqlcharts_already_installed_2", "1");
        guaven_sqlcharts_install_first_data();

    }
}

function guaven_sqlcharts_install_first_data()
{
    require_once(dirname(__FILE__) . "/initial_data.php");
    gvn_chart_sample_nonxml_data();
}


function guaven_sqlcharts_recommended(){
    if(!class_exists('WooCommerce'))return;
    $uid=(int)get_current_user_id();
    if(isset($_GET["gvnsql_dismiss_recommendation"])){
        update_option('gvnsql_dismiss_recommendation_'.$uid,1);
        return;
    }
    if(get_option('gvnsql_dismiss_recommendation_'.$uid)!='')return;
    return '<table class="gf-alert gf-alert-info" style="margin-top:20px">
            <tbody><tr><td style="width: auto;vertical-align: top;padding: 20px;">
            <h2>WooCommerce Search Engine – INSTANT, RELEVANT AND SMART Search Box</h2>
            <h3>Turn your website search into Smart Search which find products by price, SKU, attributes, meta data, categorys, tags etc. </h3>
            <p>“WooCommerce Search Engine” is a very powerful and easy to use WooCommerce Search Plugin which turns a simple search box of your WooCommerce Store to the powerful multifunctional magic box which helps you to sell more products. The plugin UI is compatible with ALL THEMES.</p>
            <a target="_blank" style="border:0px solid #6200ee;border-radius:0px;color:white;font-weight:bold;background: #6200ee;" class="button button-secondary" 
            href="https://codecanyon.net/item/woocommerce-search-box/15685698">Get the Search Box </a>
            </td><td style="position:relative">
            <a href="'.admin_url().'/edit.php?post_type=gvn_schart&gvnsql_dismiss_recommendation=1'.'" style="position: absolute;right: 0;top: -15px;right: -10px;"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="11" height="14" viewBox="0 0 11 14">
            <path d="M10.141 10.328q0 0.312-0.219 0.531l-1.062 1.062q-0.219 0.219-0.531 0.219t-0.531-0.219l-2.297-2.297-2.297 2.297q-0.219 0.219-0.531 0.219t-0.531-0.219l-1.062-1.062q-0.219-0.219-0.219-0.531t0.219-0.531l2.297-2.297-2.297-2.297q-0.219-0.219-0.219-0.531t0.219-0.531l1.062-1.062q0.219-0.219 0.531-0.219t0.531 0.219l2.297 2.297 2.297-2.297q0.219-0.219 0.531-0.219t0.531 0.219l1.062 1.062q0.219 0.219 0.219 0.531t-0.219 0.531l-2.297 2.297 2.297 2.297q0.219 0.219 0.219 0.531z"></path>
            </svg>
            </a>
            <img src="'.plugin_dir_url( __FILE__ ) . 'asset/img/recommended1.jpg" style="max-width: 430px;"></td></tr>
            </tbody></table>';
}



function guaven_sqlcharts_my_admin_notice()
{
    global $post;


    if( 
        (!empty($_SERVER["REQUEST_URI"]) and strpos($_SERVER["REQUEST_URI"],'post_type=gvn_schart')!==false)
        or 
        (!empty($post) and $post->post_type == 'gvn_schart')
     ){
        echo guaven_sqlcharts_recommended();
     }
    


    if (!empty($post) and $post->post_type == 'gvn_schart'):
        if (!current_user_can('manage_options')) {
            echo '<br><br>
  <div class="updated gf-alert gf-alert-danger">Only administrators can manage this page</div>';
            die();
        }
        echo '<div class="updated gf-alert gf-alert-info">';
        if (empty($_GET["post"]) and strpos($_SERVER["REQUEST_URI"], "post-new") === false):
            $gf_message = 'Use <b>Add new</b> button above to create new sql report. And click on any existing rule names below
          to manage them. ';
        else:
            $gf_message = '
       1. Give any name to your report.<br>
       2. Choose chart type, type sql query, enter field names, labels and then press to Publish/Update<br>
       3. After update you will see the name and the demo of the needed shortcode at the bottom of this admin page. You can use that shortcode anywhere in your website: in pages, posts, widgets etc. <br>
        ';
        endif;
        _e('<div style="float:left;max-width:calc(100% - 345px)">' . $gf_message . '</div>', 'guaven_sqlcharts');
        echo '<div style="float: right;
    margin-top: 0px;
    padding-top: 0px;"><a target="_blank" style="text-align:center;border:0px solid #6200ee;border-radius:0px;color:white;font-weight:bold;background: #6200ee;"
    class="button button-secondary" href="https://guaven.com/contact/solution-request/">Get Premium Support </a>
    <span style="line-height: 30px;padding: 0 5px;">OR</span>    
    <a target="_blank" style="text-align:center;border:0px solid #26b286;border-radius:0px;color:white;font-weight:bold;background: #26b286;"
    class="button button-secondary" href="https://guaven.com/service/small-thankyou-premium-support-service/">Make a Small Donation</a>
    </div> </div>';
    endif;
}
add_action('admin_notices', 'guaven_sqlcharts_my_admin_notice');

function guaven_sqlcharts_onboarding_notice(){
    if((function_exists('wp_doing_ajax') and wp_doing_ajax()) or get_option('guaven_sqlcharts_onboarding_notice_dismissed') == 1)
        return;

    printf('
        <div class="guaven-sqlcharts-notice notice notice-success is-dismissible" data-notice="onboarding_notice">
            <p>Welcome aboard on MySQL Charts!</p>
        </div>'
    );
}
add_action('admin_notices', 'guaven_sqlcharts_onboarding_notice');

function guaven_sqlcharts_onboarding_notice_dismissed(){
    check_ajax_referer('notice_dismissed', 'nonce');
    switch ($_POST['type']){
        case 'onboarding_notice':
            update_option('guaven_sqlcharts_onboarding_notice_dismissed', 1);  
            break;
        }
}
add_action('wp_ajax_guaven_sqlcharts_onboarding_notice_dismissed', 'guaven_sqlcharts_onboarding_notice_dismissed');

function guaven_sqlcharts_enqueue_chart()
{
    wp_enqueue_script('guaven_sqlcharts_chartjs', plugins_url('asset/bundle.min.js', __FILE__),array('jquery'),GVNSQLCHARTS_VERSION);
    wp_localize_script('guaven_sqlcharts_chartjs', 'guaven_sqlcharts_notice_dismissed', array(
        'action' => 'guaven_sqlcharts_onboarding_notice_dismissed',
        'nonce' => wp_create_nonce('notice_dismissed')
    ));

}
add_action('wp_enqueue_scripts', 'guaven_sqlcharts_enqueue_chart');
add_action('admin_enqueue_scripts', 'guaven_sqlcharts_enqueue_chart');

function guaven_sqlcharts_enqueue_main_style()
{
    wp_enqueue_style('guaven_sqlcharts_main_style', plugins_url('asset/guaven_sqlcharts.css', __FILE__),array(),GVNSQLCHARTS_VERSION);
}
add_action('wp_enqueue_scripts', 'guaven_sqlcharts_enqueue_main_style');
add_action('admin_enqueue_scripts', 'guaven_sqlcharts_enqueue_main_style');


function guaven_sqlcharts_isJson($string)
{
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

add_action('init', 'guaven_sqlcharts_register_post');
function guaven_sqlcharts_register_post()
{
    //register_taxonomy('guaven_update_push_tag', 'termin');
    register_post_type('gvn_schart', array(
        'labels' => array(
            'name' => __('My SQL Charts'),
            'singular_name' => __('My SQL chart')
        ),

        'public' => true,
        //'taxonomies' => array('guaven_update_push_tag'),
        'supports' => array(
            'title',
            'postmeta'
        ),
        'register_meta_box_cb' => 'guaven_sqlcharts_metabox_area'
    ));

    guaven_sqlcharts_load_defaults();
}

add_action('admin_footer', 'guaven_sqlcharts_admin_front');


function guaven_sqlcharts_admin_front()
{
    global $post;
    if (!empty($post) and $post->post_type == 'gvn_schart') {
?>
<style type="text/css">#normal-sortables{display: none}</style>
  <?php
    }
}

// metabox for editor
function guaven_sqlcharts_metabox_area()
{
    add_meta_box('guaven_sqlcharts_metabox', 'Configure your graph chart', 'guaven_sqlcharts_metabox', 'gvn_schart', 'advanced', 'default');
}

function guaven_sqlcharts_metabox()
{
    require_once(dirname(__FILE__) . "/admin_metabox.php");
}

function guaven_gutenberg_wrapper($atts){
    if(isset($atts['sqlcharts_inserted_script'])){
        global $sqlcharts_inserted_script;
        $sqlcharts_inserted_script = $atts['sqlcharts_inserted_script'];
    }
    
    // if( isset($_GET["post_id"],$_GET["context"]) and $_GET["context"]=='edit' 
    // and strpos($_SERVER["REQUEST_URI"],'block-renderer/guaven-sqlcharts/gvn-chart-gutenberg')!==false
    // ){
    //     $atts['chart_id']=$_GET["post_id"];
    // }
    $post = get_post($atts['chart_id']);
    if( ! isset($atts['chart_id']) or !isset($post) or $post->post_type != 'gvn_schart'){
        
        return "Invalid id";
    }
    
    return guaven_sqlcharts_local_shortcode(array('id' => $atts['chart_id'])); // temporary explicit value
}
function guaven_register_gutenberg_blocks()
{
    wp_register_script(
		'gvn_gutenberg_charts',
		plugins_url( 'asset/guaven_gutenberg_charts.js', __FILE__ ),
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-server-side-render' ),
		GVNSQLCHARTS_VERSION.'_'.filemtime( plugin_dir_path( __FILE__ ) . 'asset/guaven_gutenberg_charts.js' )
    );
    wp_localize_script('gvn_gutenberg_charts', 'guaven', array(
        'description' => 'Add My SQL Chart to your post',
    ));
    
	register_block_type( 'guaven-sqlcharts/gvn-chart-gutenberg', array(
        'editor_script' => 'gvn_gutenberg_charts',
        'render_callback' => 'guaven_gutenberg_wrapper',
        'attributes' => array(
            'chart_id' => array(
                'type' => 'string',
                'default' => null
            ),
            'sqlcharts_inserted_script' => array(
                'type' => 'number',
                'default' => null
            )
        )
    ));
}
add_action('init', 'guaven_register_gutenberg_blocks');



function guaven_sqlcharts_save_metabox_area($post_id, $post)
{
    if (!isset($_POST['meta_box_nonce_field']) or !wp_verify_nonce($_POST['meta_box_nonce_field'], 'meta_box_nonce_action')) {
        return $post->ID;
    }
    $fields = array(
        "guaven_sqlcharts_chartheight",
        "guaven_sqlcharts_chartwidth",
        "guaven_sqlcharts_graphtype",
        "guaven_sqlcharts_xarg_s",
        "guaven_sqlcharts_xarg_l",
        "guaven_sqlcharts_yarg_s",
        "guaven_sqlcharts_yarg_l",
        "guaven_sqlcharts_tablepart",
        "guaven_sqlcharts_variables",
        "guaven_sqlcharts_formpartrole",
        "guaven_sqlcharts_formpartbutton",
        "guaven_sqlcharts_dbhost",
        "guaven_sqlcharts_dblogin",
        "guaven_sqlcharts_dbname",
        "guaven_sqlcharts_colors",
        "guaven_sqlcharts_begin_with_0_x",
        "guaven_sqlcharts_begin_with_0_y",
        "guaven_sqlcharts_round_y_values",
        "guaven_sqlcharts_legend_position",
        "guaven_sqlcharts_nostacked",
        "guaven_sqlcharts_forcetooltips"
    );
    foreach ($fields as $key => $value) {
        if(isset($_POST[$value]))$newval=esc_attr($_POST[$value]);
        else $newval='';

        update_post_meta($post->ID, $value, $newval);
    }
    if(!empty($_POST["guaven_sqlcharts_dbpass"])){
        $encpass=guaven_sqlcharts_encrypt_decrypt('encrypt',$_POST["guaven_sqlcharts_dbpass"]);
        update_post_meta($post->ID, 'guaven_sqlcharts_dbpass', ['encrypted',$encpass]);
    }
    update_post_meta($post->ID, 'guaven_sqlcharts_code', esc_attr(str_replace("'",'"',stripslashes($_POST['guaven_sqlcharts_code']))) );
}
add_action('save_post', 'guaven_sqlcharts_save_metabox_area', 1, 2);
// save the custom fields



function gvn_chart_check_sql_query($sql)
{
    $blacklister   = array(
        "delete",
        "update",
        "insert",
        "drop",
        "truncate",
        "alter"
    ); //add all
    $blacklister_f = 0;
    foreach ($blacklister as $key => $value) {
        if (strpos($sql, $value) !== false)
            $blacklister_f = 1;
    }
    return $blacklister_f;
}

function guaven_get_labels_and_values($id, $fvs)
{
    $values   = array();
    $labels   = array();
    $xarg_s   = get_post_meta($id, 'guaven_sqlcharts_xarg_s', true);
    $xarg_l   = get_post_meta($id, 'guaven_sqlcharts_xarg_l', true);
    $yarg_s   = get_post_meta($id, 'guaven_sqlcharts_yarg_s', true);
    $yarg_l   = get_post_meta($id, 'guaven_sqlcharts_yarg_l', true);
    $chartype = array(
        'line_l' => 'Line',
        'pie_l' => 'Pie',
        'donut_l' => 'Pie',
        'bar_l' => 'Bar',
        'horizontalbar_l' => 'Horizontal Bar',
        'area_l' => 'Line'
    );
    foreach ($fvs as $key => $value) {
        $values[$value->$xarg_s] = $value->$yarg_s;
        $labels[$value->$xarg_s] = '"' . $value->$xarg_s . '"';
    }
    return array(
        $labels,
        $values,
        explode(";", $yarg_l),
        explode(";", $xarg_l)
    );
}

function guaven_sqlcharts_print_chart_js($print_data)
{
    extract($print_data);

    if ($tip_g == 'line_l') {
        guaven_sqlcharts_linedata($title, $labels, $values, $ylabel, 'false', $pid);
    }
    if ($tip_g == 'area_l') {
        guaven_sqlcharts_linedata($title, $labels, $values, $ylabel, 'true', $pid);
    } elseif ($tip_g == 'pie_l') {
        guaven_sqlcharts_piedata($title, $labels, $values, $ylabel, $pid);
    } elseif ($tip_g == 'donut_l') {
        guaven_sqlcharts_piedata($title, $labels, $values, $ylabel, $pid, 'doughnut');
    } elseif ($tip_g == 'bar_l') {
        guaven_sqlcharts_bardata($title, $labels, $values, $ylabel, 'bar', $pid);
    } elseif ($tip_g == 'horizontalbar_l') {
        guaven_sqlcharts_bardata($title, $labels, $values, $ylabel, 'horizontalBar', $pid);
    }
    elseif($tip_g == 'custom'){
        guaven_sqlcharts_custom($title, $labels, $values, $ylabel, $pid);
    }
    elseif ($tip_g == 'polar_l') {
        guaven_sqlcharts_piedata($title, $labels, $values, $ylabel, $pid, 'polarArea');
    }
}

function guaven_sqlcharts_custom($title, $labels, $values, $ylabel, $pid){
    do_action('guaven_sqlcharts_custom',$title, $labels, $values, $ylabel, $pid);
}

function gvn_chart_put_variables($sql,$pid){
  $sql_initial=$sql;


  $default_tag_keys=['{current_user_id}','{current_user_login}','{current_user_email}','{current_user_display_name}'];
  if(is_user_logged_in(  )){
    $currentuser=wp_get_current_user();
    $default_tag_values=[$currentuser->ID,$currentuser->user_login,$currentuser->user_email,$currentuser->user_display_name];
  }
  else {
    $default_tag_values='';
  }
  $sql_initial=str_replace($default_tag_keys,$default_tag_values,$sql_initial);

  $variables_raw=get_post_meta($pid,'guaven_sqlcharts_variables',true);
  $variables_arr=explode("|",$variables_raw);
  foreach($variables_arr as $varfield){
    $varfield_arr=explode("~",$varfield);
    if (count($varfield_arr)<3) continue;
    $varfield_arr=array_map("trim",$varfield_arr);
    if (!empty($_GET[$varfield_arr[0]])) $varreplacement=$_GET[$varfield_arr[0]]; else $varreplacement=$varfield_arr[1];
    if (!is_numeric($varreplacement) and strpos($varreplacement,'()')===false) $varreplacement='"'.$varreplacement.'"';

    $sql_initial=str_replace('{'.$varfield_arr[0].'}',$varreplacement,$sql_initial);
  }
  return $sql_initial;
}

function gvn_chart_top_form($atts){
  if (get_post_meta($atts["id"],'guaven_sqlcharts_formpartrole',true)!='' and !is_user_logged_in()) return;
  $topform='';$dateexists=false;
  $variables_raw=get_post_meta($atts['id'],'guaven_sqlcharts_variables',true);
  $variables_raw=explode("|",$variables_raw);
  foreach ($variables_raw as $vrow){
    $vrow_arr=explode("~",$vrow);
    $vrow_arr=array_map("trim",$vrow_arr);
    if (empty($vrow_arr[3])) continue;
    $gvalue=!empty($_GET[$vrow_arr[0]])?esc_attr(urldecode($_GET[$vrow_arr[0]])):'';
    $dvalue=(strpos($vrow_arr[1],'()')===false)?esc_attr($vrow_arr[1]):'';
    if ($vrow_arr[3]=='date') {
      $dateexists=true;
      $topform.= $vrow_arr[2].' <input autocomplete="off" style="max-width:210px" type="text"
      value="'.$gvalue.'"
      data-toggle="datepicker" name="'.$vrow_arr[0].'" placeholder="'.$dvalue.'">
      ';}
    else {
      $topform.= $vrow_arr[2].' <input autocomplete="off" style="max-width:210px;'.($vrow_arr[3]=='number'?'width:100px;':'').'"
      type="'.$vrow_arr[3].'"
      value="'.$gvalue.'"    name="'.$vrow_arr[0].'" placeholder="'.$dvalue.'">
      ';
    }
  }
  if (!empty($topform)) {
    $topform='<form method="get" action="" class="guaven_sqlcharts_form">'.$topform.'
    <input type="submit"
    value="'.(get_post_meta($atts['id'], 'guaven_sqlcharts_formpartbutton', true)!=''?esc_attr(get_post_meta($atts['id'], 'guaven_sqlcharts_formpartbutton', true)):'OK').'"></form>';
    if ($dateexists) $topform.='<script>setTimeout(function(){jQuery(\'[data-toggle="datepicker"]\').datepicker({format: \'yyyy-mm-dd\'});
},300);</script>';
    return $topform ;
  }
  return;
}


function guaven_sqlcharts_encrypt_decrypt($action, $string) 
{
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'GWSCHARTPL2022.2016.';
    $secret_iv = 'GWSCHARTPL2016.2022';
    $key = hash('sha256', $secret_key);    
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if( $action == 'decrypt' ) {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

function guaven_sqlcharts_local_shortcode($atts) {
    if(empty($atts['id']))return 'ID is missing.';
    $remote_host=get_post_meta($atts['id'], 'guaven_sqlcharts_dbhost', true);
    if ($remote_host!=''){
      $remote_db=get_post_meta($atts['id'], 'guaven_sqlcharts_dbname', true);
      $remote_login=get_post_meta($atts['id'], 'guaven_sqlcharts_dblogin', true);
      $remote_pass=get_post_meta($atts['id'], 'guaven_sqlcharts_dbpass', true);
      if(is_array($remote_pass)){
        $remote_pass=guaven_sqlcharts_encrypt_decrypt('decrypt',$remote_pass[1]);
      }
      $wpdb=new wpdb($remote_login,$remote_pass,$remote_db,$remote_host);
    }
    else {
      global $wpdb;
    }

    $GLOBALS["guaven_sqlcharts_atts"]=$atts;

    $sql           = html_entity_decode(get_post_meta($atts['id'], 'guaven_sqlcharts_code', true));
    if(empty($sql))return 'SQL query is missing.';
    $sql=gvn_chart_put_variables($sql,$atts['id']);


    $sql=apply_filters('guaven_sqlcharts_rendered_sql',$sql,$atts);

    $blacklister_f = gvn_chart_check_sql_query($sql);
    if ($blacklister_f == 1)return 'You given SQL code contains forbidden commands. Remember that you should only use SELECT queries';
    $tip_g = get_post_meta($atts['id'], 'guaven_sqlcharts_graphtype', true);

    for($i=1;$i<20;$i++){ $replacearg=!empty($atts["arg".$i])?$atts["arg".$i]:0;
        $sql=str_replace("{arg".$i."}",esc_sql($replacearg),$sql);}
    $sql_split         = explode(';', $sql);
    $labels_and_values = array();
    $post_g            = get_post($atts['id']);

    global $sqlcharts_inserted_script;
    for ($i = 0; $i < count($sql_split); $i++) {
        if (!empty($sql_split[$i])) {

            $fvs = $wpdb->get_results($sql_split[$i]);
            if (strpos($_SERVER["REQUEST_URI"],'wp-admin')!==false){
              $wpdb->show_errors();
              ob_start();
              $wpdb->print_error();
              $printerror = ob_get_clean();
              if ($printerror != '' and strpos($printerror, "[]") === false)
                  return $printerror;
              elseif (empty($fvs))
                  return 'Your SQL returnes empty data, please recheck your SQL query above';
            }

            ob_start();

            if (empty($sqlcharts_inserted_script))
                $sqlcharts_inserted_script = 1;
                $labels_and_values[$i] = guaven_get_labels_and_values($atts['id'], $fvs);
                $labels[$i]            = $labels_and_values[$i][0];
                $values[$i]            = $labels_and_values[$i][1];
                $ylabel[$i]            = !empty($labels_and_values[$i][2][$i]) ? $labels_and_values[$i][2][$i] : '';
                $xlabel[$i]            = !empty($labels_and_values[$i][3][$i]) ? $labels_and_values[$i][3][$i] : '';
        }
    }

    echo gvn_chart_top_form($atts);
    ?>
    <canvas 
        id="ct-chart_<?php echo $sqlcharts_inserted_script; ?>" 
        class="guaven_chart_canvas"
        style="width: <?php echo get_post_meta($atts['id'], 'guaven_sqlcharts_chartwidth', true); ?>px !important; height: <?php echo get_post_meta($atts['id'], 'guaven_sqlcharts_chartheight', true); ?>px !important;"
    ></canvas>

     <script type="text/javascript" class="gvn_charts_script" async>
     var ctx = jQuery("#ct-chart_<?php
    echo $sqlcharts_inserted_script;
    ?>");

    <?php
        $print_data=apply_filters('guaven_sqlcharts_pre_print_vars',['tip_g'=>$tip_g, 'title'=>$post_g->post_title, 
        'labels'=>$labels, 'values'=>$values, 'ylabel'=>$ylabel, 'pid'=>$atts['id']]);
        guaven_sqlcharts_print_chart_js($print_data);
    ?>
    </script>

    <?php
    if (!empty($atts["table"])) echo guaven_sqlcharts_tablepart($post_g->post_title, $labels, $values, $ylabel,$xlabel);
    $sqlcharts_inserted_script++;
    return ob_get_clean();
}

add_shortcode('gvn_schart_2', 'guaven_sqlcharts_local_shortcode');

add_shortcode("gvn_schart_2_cached",function($atts){
	if(empty($atts["id"]))return;
    $expire=!empty($atts["expire"])?intval($atts["expire"]):3600;
	$cached=get_transient('cached_sql_charts_'.$atts["id"]);
	if(!empty($cached) and !isset($_GET["force_sql_cache_reload"])  )return $cached;
	$tobecached=do_shortcode('[gvn_schart_2 id="'.$atts["id"].'"]');
	set_transient('cached_sql_charts_'.$atts["id"], $tobecached,$expire);//you can change 3600 yourself
	return $tobecached;
});

function guaven_sqlcharts_colors($index, $pid = null){
  if(!isset($pid)) {
    global $post;
    $pid = $post->ID;
  }
  $colors=get_post_meta($pid,'guaven_sqlcharts_colors',true);
  $colors=explode(",",$colors);
  //var_dump($colors,$index,$colors[$index]);
  if (!empty($colors[$index])) return $colors[$index];
  return rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255);
}

function guaven_sqlcharts_toshowlegend($pid){
    $guaven_sqlcharts_legend_position=get_post_meta($pid, 'guaven_sqlcharts_legend_position', true);
    if(in_array($guaven_sqlcharts_legend_position,['top','bottom','left','right'])){
        $display='true';$position=$guaven_sqlcharts_legend_position;
    }
    else {
        $display='false';$position='top';
    }
    return "legend: {display: ".$display.",position:'".$position."'},";
}

function guaven_sqlcharts_bardata($title, $labels, $values, $ylabel, $type = 'bar', $pid = null)
{
?>
    var data = {
    labels: [<?php
    echo implode(",", guaven_sqlcharts_merge_labeldata($labels) );
?>],
    datasets: [
    <?php
    $values_new=guaven_sqlcharts_key_normalizer($values,$labels,$ylabel)[0];
    $i=-1;
    foreach ($values_new as $key_ak=>$value_ak) {
    $i++;
?>
        {
            <?php 
            if(!empty($GLOBALS["guaven_sqlcharts_atts"]["params"])){
                //passing chartJS params via the shortcode
                echo esc_js($GLOBALS["guaven_sqlcharts_atts"]["params"]);
            } 
            ?>
            label: "<?php
        echo esc_attr($ylabel[$key_ak]);
?>",
            backgroundColor: [
                <?php
        echo guaven_sqlcharts_colorgenerator(count($values_new[$key_ak]), 0, 0, guaven_sqlcharts_colors($i, $pid));
?>
            ],
            borderColor: [
                <?php
        echo guaven_sqlcharts_colorgenerator(count($values_new[$key_ak]), 0, 0.2, guaven_sqlcharts_colors($i, $pid));
?>
            ],
            borderWidth: 1,
            data: [<?php
        echo implode(",", $values_new[$key_ak]);
?>],
        },
        <?php
    }
?>
    ]
};
var options={
    <?php echo guaven_sqlcharts_toshowlegend($pid);?>
    responsive: true,
    scales: {
        xAxes: [{
            <?php echo (get_post_meta($pid, 'guaven_sqlcharts_nostacked', true) == 1) ? '':'stacked: true,';?>
            ticks: {
                beginAtZero: <?php echo (get_post_meta($pid, 'guaven_sqlcharts_begin_with_0_x', true) == 1) ? 'true':'false'; ?>
            }
        }],
        yAxes: [{
            <?php echo (get_post_meta($pid, 'guaven_sqlcharts_nostacked', true) == 1) ? '':'stacked: true,';?>
            ticks: {
                <?php if(get_post_meta($pid, 'guaven_sqlcharts_round_y_values', true) == 1) echo 'precision: 0,'; ?>
                beginAtZero: <?php echo (get_post_meta($pid, 'guaven_sqlcharts_begin_with_0_y', true) == 1) ? 'true':'false'; ?>
            }
        }]
    }
};
var myBarChart = new Chart(ctx, {
    type: '<?php
    echo $type;
?>',
    data: data,
    options: options
});
    <?php
}

function guaven_sqlcharts_merge_labeldata($labels){
    if(count($labels)==1)return $labels[0];
    $merged=[];
    foreach($labels as $label){
        $merged=array_merge($merged,$label);
    }
    return array_unique($merged);
}

function guaven_sqlcharts_linedata($title, $labels, $values, $ylabel, $type = 'false', $pid = null)
{
?>
var data = {
    labels: [<?php
    echo implode(",", guaven_sqlcharts_merge_labeldata($labels));
?>],
    datasets: [
    <?php    
    $values_new=guaven_sqlcharts_key_normalizer($values,$labels,$ylabel)[0];
    $i=-1;
    foreach ($values_new as $key_ak=>$value_ak) {
        $i++;
?>
        {
            <?php 
            if(!empty($GLOBALS["guaven_sqlcharts_atts"]["params"])){
                //passing chartJS params via the shortcode
                echo esc_js($GLOBALS["guaven_sqlcharts_atts"]["params"]);
            } 
            ?>
            label: "<?php
        echo esc_attr($ylabel[$key_ak]);
?>",
            fill: <?php echo $type=="false"?$type:($i==0?'"+1"':'"origin"');
?>,
            lineTension: 0.1,
            backgroundColor:  <?php
        echo guaven_sqlcharts_colorgenerator(1, 1, 0.2, guaven_sqlcharts_colors($i, $pid));
?>
            borderColor:  <?php
        echo guaven_sqlcharts_colorgenerator(1, 1, 0.2, guaven_sqlcharts_colors($i, $pid));
?>
            pointBorderColor: <?php
        echo guaven_sqlcharts_colorgenerator(1, 1, 0.2, guaven_sqlcharts_colors($i, $pid));
?>
            pointHoverBackgroundColor: <?php
        echo guaven_sqlcharts_colorgenerator(1, 1, 0.2, guaven_sqlcharts_colors($i, $pid));
?>
            pointHoverBorderColor:  <?php
        echo guaven_sqlcharts_colorgenerator(1, 1, 0.2, guaven_sqlcharts_colors($i, $pid));
?>
            data: [<?php
        echo implode(",", $values_new[$key_ak]);
?>],
            spanGaps: false,
        },
        <?php
    }
?>
    ]
};
var myLineChart = new Chart(ctx, {
    type: 'line',
    data: data,
   options: {
        <?php echo guaven_sqlcharts_toshowlegend($pid);?>
        responsive: true,
        scales: {
            xAxes: [{
                display: true,
                ticks: {
                   beginAtZero: <?php echo (get_post_meta($pid, 'guaven_sqlcharts_begin_with_0_x', true) == 1) ? 'true':'false'; ?>
                }
            }],
            yAxes: [{
                ticks: {
                   <?php if(get_post_meta($pid, 'guaven_sqlcharts_round_y_values', true) == 1) echo 'precision: 0,'; ?>
                   beginAtZero: <?php echo (get_post_meta($pid, 'guaven_sqlcharts_begin_with_0_y', true) == 1) ? 'true':'false'; ?>
                }
            }]
        }
    }
});
    <?php
}


function guaven_sqlcharts_piedata($title, $labels, $values, $ylabel, $pid, $type = 'pie')
{
    if(get_post_meta($pid,'guaven_sqlcharts_forcetooltips',true)!=''){
        echo 'guaven_sqlcharts_show_pie_labels();'.PHP_EOL;
    }
?>
    var options={
        showAllTooltips: true,
        <?php echo guaven_sqlcharts_toshowlegend($pid);?>
        responsive: true,
    };
    var data = {
    labels: [ <?php echo implode(",", guaven_sqlcharts_merge_labeldata($labels));?>],
    datasets: [
    <?php
    for ($i = 0; $i < count($values); $i++) {
?>
        {
            <?php 
            if(!empty($GLOBALS["guaven_sqlcharts_atts"]["params"])){
                //passing chartJS params via the shortcode
                echo esc_js($GLOBALS["guaven_sqlcharts_atts"]["params"]);
            } 
            ?>
            data: [<?php
        echo implode(",", $values[$i]);
?>],
            backgroundColor: [
                <?php
                $ii=0;
                foreach($values[$i] as $vci=>$valuecolor){
                    echo guaven_sqlcharts_colorgenerator(1, 0, -0.1, guaven_sqlcharts_colors($ii, $pid));
                    $ii++;
                }       
?>
            ],
            hoverBackgroundColor: [
               <?php
               $ii=0;
               foreach($values[$i] as $vci=>$valuecolor){
                echo guaven_sqlcharts_colorgenerator(1, 0, 0.2, guaven_sqlcharts_colors($ii, $pid));
                $ii++;
            } 
?>
            ]
        },
<?php
    }
?>
        ]
};
var myPieChart = new Chart(ctx,{
    type: '<?php
    echo $type;
?>',
    data: data,
    options: options
});
    <?php
}




function guaven_sqlcharts_colorgenerator($count, $indic, $darkness = 0, $initcolor = '255,0,0')
{
  if (strpos($initcolor,'#')===0) {
    $split = str_split(substr($initcolor,1), 2);
    $r = hexdec($split[0]);
    $g = hexdec($split[1]);
    $b = hexdec($split[2]);
    $ret='';
    for ($i = 0; $i < $count; $i++) {
        $ret .= "'rgba(" . $r . ", " . $g . ", " . $b . ",".($darkness + 0.8 - $indic * $i * 0.8 / ($count)).")',
        ";
      }
      return $ret;
  }
    $initial_colors = array(
        'linebg' => 'red',
        'linebr' => 'yellow',
        'linebc' => 'green',
        'linehbg' => 'white',
        'linehbc' => 'black'
    );
    if (!empty($initial_colors[$count]))
        return '"' . $initial_colors[$count] . '",
        ';
    $ret = '';
    for ($i = 0; $i < $count; $i++) {
        $ret .= "'rgba(" . $initcolor . "," . ($darkness + 0.8 - $indic * $i * 0.8 / ($count)) . ")',
        ";
    }
    return $ret;
}

function guaven_sqlcharts_tablepart($title, $labels, $values, $ylabel,$xlabel){
  $tabledata='';
  $fcol=[];$scol=[];
  $empty_cell=apply_filters( 'guaven_sqlcharts_table_empty_cell','<td></td>');
  $tablein='';
  foreach($values as $row=>$valuerow){
    foreach ($valuerow as $key => $value) {
      $putval=$labels[$row][$key]??'';
      $fcol[$key]='<td>'.str_replace('"',"",$putval).'</td>';
      $scol[$key][$row]='<td>'.$value.'</td>';
    } 
    foreach($scol as $scolkey=>$scolvalue){
        for($i=0;$i<count($values);$i++){
            //echo $i;
            if(!isset($scolvalue[$i]))$scol[$scolkey][$i]=$empty_cell;;
        }
        ksort($scol[$scolkey]);
      }
  }  
  
  foreach($fcol as $key=>$value){
    $tablein.='<tr>'.$value.implode(" ",$scol[$key]).'</tr>'.PHP_EOL;
  }
  $tabledata.='<table><tr><th>'.$xlabel[0].'</th><th>'.implode("</th><th>",$ylabel).'</th></tr>
  '.$tablein.'</table><br>';
  return $tabledata;

}

function guaven_sqlcharts_graphtype($post){
    if (strpos(get_post_meta($post->ID, 'guaven_sqlcharts_graphtype', true), "_l") !== false)
        $postfix = '_2';
    else $postfix = '';
    return $postfix;
}

add_filter('the_content',function($content){
    if(!is_singular('gvn_schart'))return $content;
    global $post;
    $postfix=guaven_sqlcharts_graphtype($post);
    return '[gvn_schart'.$postfix.' id="'.$post->ID.'"'.
    (get_post_meta($post->ID,'guaven_sqlcharts_tablepart',true)!=''?' table="1"':'')
    .']';
});

function guaven_sqlcharts_key_normalizer($values,$labels,$ylabel){
    $normalize_keys=[];
    $empty_value=apply_filters( 'guaven_sqlcharts_table_empty_value','');
    foreach ($values as $key_ak=>$value_ak) {
        $normalize_keys=array_merge($normalize_keys,array_keys($values[$key_ak]));
    }
    $values_normalized=[];$labels_normalized=[];$ylabel_normalized=[];
    foreach($normalize_keys as $normalized_key){
        foreach ($values as $key_ak=>$value_ak) {
            $values_normalized[$key_ak][$normalized_key]=isset( $values[$key_ak][$normalized_key])? $values[$key_ak][$normalized_key]:"'".$empty_value."'";
            $labels_normalized[$key_ak][$normalized_key]=isset( $labels[$key_ak][$normalized_key])? $labels[$key_ak][$normalized_key]:"''";
            $ylabel_normalized[$key_ak][$normalized_key]=isset( $ylabel[$key_ak][$normalized_key])? $ylabel[$key_ak][$normalized_key]:"";
        }
    }
    return [$values_normalized,$labels_normalized,$ylabel_normalized];
}


add_filter('guaven_sqlcharts_table_empty_cell',function($str){return '<td>#</td>';});
add_filter('guaven_sqlcharts_table_empty_value',function($str){return 'N/A';});