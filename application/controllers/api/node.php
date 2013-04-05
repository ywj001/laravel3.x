<?php

class Api_Node_Controller extends Controller {  
 

	public function action_save()
	{   

		$this->filter( 'before', 'csrf' );
	 	return formbuilder::save();
	}
	 

}