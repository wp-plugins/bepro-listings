<?php
/*
	This file is part of BePro Listings.

    BePro Listings is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    BePro Listings is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with BePro Listings.  If not, see <http://www.gnu.org/licenses/>.
*/	
class bepro_widgets {
  function filter_search_control(){
		if ($_POST['id_base'] == "bepro-listings-search-filter")bepro_widgets::bepro_save_widget();
		$data = get_option('filter_search_widget');
		?>
		  <p><label>Listing Page url<input name="listing_page"
		type="text" value="<?php echo $data['listing_page']; ?>" /></label></p>
		  <p><label>Geo Fields?<input name="geo"
		type="checkbox" value="1" <?php echo (($data['geo'] == 1)? "checked='checked'":'')?>/></label></p>
	  <?php
  }
  function filter_search_widget($args){
	$data = get_option('filter_search_widget');
	$data["echo_this"] = true;
    echo $args['before_widget'];
    echo $args['before_title'] .__("Filter Listings", "bepro-listings"). $args['after_title'];
    Bepro_listings::search_filter_options($data);
    echo $args['after_widget'];
  }
  function bepro_save_widget(){
	  if ($_POST["id_base"] == "bepro-listings-search-filter"){
		$data['listing_page'] = attribute_escape($_POST['listing_page']);
		$data['geo'] = (attribute_escape($_POST['geo']) == 1)? 1:0;
		update_option('filter_search_widget', $data);
		echo 'success';
	  }
	  if ($_POST["id_base"] == "bepro-listings-map"){
		$data['num_results'] = attribute_escape($_POST['num_results']);
		$data['size'] = attribute_escape($_POST['size']);
		update_option('bepro_map_widget', $data);
		echo "success";
	  }
  }
  
  function bepro_map_control(){
	 if ($_POST["id_base"] == "bepro-listings-map")bepro_widgets::bepro_save_widget();
     $data = get_option('bepro_map_widget');
	  ?>
		  <p><label># Results<select name="num_results">
		  <option value="" <?php echo ($data['num_results'] == "")? "selected='selected'":""; ?> >Select One</option>
		  <option value="1" <?php echo ($data['num_results'] == 1)? "selected='selected'":""; ?> >1</option>
		  <option value="2" <?php echo ($data['num_results'] == 2)? "selected='selected'":""; ?>>2</option>
		  <option value="3" <?php echo ($data['num_results'] == 3)? "selected='selected'":""; ?>>3</option>
		  <option value="4" <?php echo ($data['num_results'] == 4)? "selected='selected'":""; ?>>4</option>
		  <option value="5" <?php echo ($data['num_results'] == 5)? "selected='selected'":""; ?>>5</option>
		  <option value="10" <?php echo ($data['num_results'] == 10)? "selected='selected'":""; ?>>10</option>
		  <option value="15" <?php echo ($data['num_results'] == 15)? "selected='selected'":""; ?>>15</option>
		  <option value="20" <?php echo ($data['num_results'] == 20)? "selected='selected'":""; ?>>20</option>
		  <option value="25" <?php echo ($data['num_results'] == 25)? "selected='selected'":""; ?>>25</option>
		  <option value="30" <?php echo ($data['num_results'] == 30)? "selected='selected'":""; ?>>30</option>
		  </select>
		  </label></p>
		  <p><label>Size<select name="size">
		  <option value="" <?php echo ($data['size'] == "")? "selected='selected'":""; ?> >Select One</option>
		  <option value="1" <?php echo ($data['size'] == 1)? "selected='selected'":""; ?> >1</option>
		  <option value="2" <?php echo ($data['size'] == 2)? "selected='selected'":""; ?>>2</option>
		  <option value="3" <?php echo ($data['size'] == 3)? "selected='selected'":""; ?>>3</option>
		  <option value="4" <?php echo ($data['size'] == 4)? "selected='selected'":""; ?>>4</option>
		  </select></label></p>
	  <?php
  }
  function bepro_map_widget($args){
	$data = get_option('filter_search_widget');
	$data["echo_this"] = true;
    echo $args['before_widget'];
    echo $args['before_title'] .__("Listings Map", "bepro-listings"). $args['after_title'];
    generate_map($data);
    echo $args['after_widget'];
  }

  function register(){
    register_sidebar_widget('Bepro Listings Search Filter', array('bepro_widgets', 'filter_search_widget'));
    register_widget_control('Bepro Listings Search Filter', array('bepro_widgets', 'filter_search_control'));
    register_sidebar_widget('Bepro Listings Map', array('bepro_widgets', 'bepro_map_widget'));
    register_widget_control('Bepro Listings Map', array('bepro_widgets', 'bepro_map_control'));
  }
}
?>
