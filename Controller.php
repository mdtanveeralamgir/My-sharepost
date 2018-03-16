<?php
/* 

	> base controller
	> load model and view

*/

class Controller {

	//load model
	public function model($model) {
		require_once '../app/models/' . $model . '.php';

		//instantiate model
		return new $model();
	}

	//load view
	public function view($view, $data = []) {
		
		//check if the file is in the view folder
		if(file_exists('../app/views/' . $view . '.php')){
			require_once '../app/views/' . $view . '.php';
		} else {
			die('view does not exists');
		}
	}
}	

?>