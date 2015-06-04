<?php

class bepro_listings_api{
	function __construct(){
	
	}
	
	function answer($requests){
		$response = "";
		foreach($requests->listing as $request){
			switch($request->action){
				case "update":
					$response .= $this->update($request->listing);
					break;
				case "delete":
					$response .= $this->delete($request->listing);
					break;
				default:
					$response .= "<response><error>5</error></response>";
			}
		}
		echo $response;
	}
	
	function update($listing){
		if(!$listing->item_name) return "<response><error>3</error></response>";
		$data = get_option("bepro_listings");
		$_POST["bepro_post_id"] = @$listing->id;
		$_POST["item_name"] = @$listing->item_name;
		$_POST["content"] = @$listing->content;
		$_POST["categories"] = @$listing->categories;
		
		if(@$data["show_cost"]){
			$_POST["cost"] = @$listing->cost;
		}
		
		if(@$data["show_con"]){
			$_POST["first_name"] = @$listing->first_name;
			$_POST["last_name"] = @$listing->last_name;
			$_POST["email"] = @$listing->email;
			$_POST["phone"] = @$listing->phone;
			$_POST["website"] = @$listing->website;
		}
		
		if(@$data["show_geo"]){
			$_POST["address_line1"] = @$listing->address_line1;
			$_POST["city"] = @$listing->city;
			$_POST["postcode"] = @$listing->postcode;
			$_POST["state"] = @$listing->state;
			$_POST["country"] = @$listing->country;
			$_POST["lat"] = @$listing->lat;
			$_POST["lon"] = @$listing->lon;
		}
		
		if(@$data["show_img"]){
			$_POST["photo"] = @$listing->item_name;
		}
		$result = bepro_listings_save(false, true);
		if(is_numeric($result))
			return "<response><error>0</error><listing><id>".$result."</id></listing></response>";
			
		return "<response><error>6</error><listing><id>".@$listing->id."</id><item_name>".@$listing->item_name."</item_name></listing></response>";
	}
	
	function delete($listing){
		if(!$listing->id) return "<response><error>4</error></response>";
		if(@bepro_delete_post($listing->id)){
			return "<response><error>0</error><listing><id>".$listing->id."</id></listing></response>";
		}else{
			return "<response><error>6</error><listing><id>".$listing->id."</id></listing></response>";
		}
	}
}
?>