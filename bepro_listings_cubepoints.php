<?php
//class for charging users to post listings. Requires cubepoints

class BL_Cubepoints{
	function __construct(){
		add_action("plugins_loaded", array($this,'start_up'), 10, 4 );
		add_action( 'bepro_listing_form_before',  array($this,"bl_frontend_form_points_check") );
	}
	
	function start_up(){
		if ( !function_exists( 'cp_ready' ) ) return;
		$data = get_option("bepro_listings");
		//cubepoints check
		if($data["cubepoints"] && ($data["cubepoints"] != 0)){
			add_action( 'cp_logs_description', array($this,'bl_log_descriptions'), 10, 4 );
			add_action('cp_config_form',array($this,'cp_module_bl_config'));
			add_action('cp_config_process',array($this,'cp_module_bl_process'));
			add_action( 'bepro_listings_add_listing', array($this,"bl_frontend_form_submit_check") );
		}
	}
 
    function bl_frontend_form_points_check() {
		$data = get_option("bepro_listings");
		if($data["cubepoints"] && ($data["cubepoints"] != 0)){
			//check if user is logged in
			$uid = get_current_user_id();
			if(!$uid || ($uid == 0)){
				header("Location: ".get_bloginfo("url")."/?p=".$data["redirect_need_funds"]);
			}
			
			//check if in-sufficient funds
			$current_points = cp_getPoints($uid);
			if($current_points < $data["charge_amount"]){
				header("Location: ".get_bloginfo("url")."/?p=".$data["redirect_need_funds"]);
			}
		}
    } 
	
	function bl_frontend_form_submit_check($post) {
		if(isset($post['post_id']) && (is_numeric($post['post_id'])) && ($post['post_id'] != 0)){
			$data = get_option("bepro_listings");
			//check if in-sufficient funds
			$uid = get_current_user_id();
			$current_points = cp_getPoints($uid);
			
			//if insufficient funds then abort listing save altogether
			if($current_points == 0){
				header("Location: ".get_bloginfo("url")."/?p=".$data["redirect_need_funds"]);
			}
			
			//update cubepoint records
			$new_points = $current_points - $data["charge_amount"];
			cp_updatePoints($uid, $new_points);
			cp_log("listing", $uid, -$data["charge_amount"], "Listing payment");

		}
    }
	
	//update cubepoints log
	function bl_log_descriptions($type, $user_id, $points, $msg){
		if ( ("listing" == $type) && ('Listing payment' == $msg) ) {
			echo 'Points used during BePro Listing creation';
		} 
	}
	
	function cp_module_bl_config(){
		$data = get_option("bepro_listings");
	?>
		<br />
		<h3><?php _e('BePro Listings','cp'); ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="redirect_need_funds"><?php _e('Page ID (add funds)', 'bepro-listings'); ?>:</label></th>
				<td valign="middle"><input type="text" id="redirect_need_funds" name="redirect_need_funds" value="<?php echo $data["redirect_need_funds"]; ?>" size="7" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="cp_modules_woocube_max_deduction_percentage"><?php _e('How much to charge?', 'bepro-listings'); ?>:</label></th>
				<td valign="middle"><input type="text" id="charge_amount" name="charge_amount" value="<?php echo $data["charge_amount"]; ?>" size="7" /></td>
			</tr>

		</table>
	<?php
	}

	/* Process and save options */
	function cp_module_bl_process(){
		$data = get_option("bepro_listings");
		//get vars
		$data["redirect_need_funds"] = is_numeric($_POST["redirect_need_funds"])? $_POST["redirect_need_funds"]:$data["redirect_need_funds"];
		$data["charge_amount"] = is_numeric($_POST["charge_amount"])?$_POST["charge_amount"]:$data["charge_amount"];
		
		//check and save vars
		update_option('bepro_listings', $data);
	}

}

$make_some_money = new BL_Cubepoints();

?>
