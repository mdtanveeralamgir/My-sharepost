<?php 
	/*
	* App core class
	* creates URL and loads controller
	* URL format  controller/method/params
	*/

	class Core {

		protected $currentController = "pages";
		protected $currentMethod = "index";
		protected $params = [];
		
		public function __construct(){
			// print_r($this->getUrl());
			$url = $this->getUrl();
			//look into controller for the first value of the url
			if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')){
				//if exists, set as controller
				$this->currentController = ucwords($url[0]);
				// unset 0 index
				unset($url[0]);
			}

			// require the controller
			require_once '../app/controllers/' . $this->currentController . '.php';

			//instantiated controller
			$this->currentController = new $this->currentController;

			//check method exists, 2nd part of the url
			if (isset($url[1])) {
				//check if the method exists in the controller
				if(method_exists($this->currentController, $url[1])){
					$this->currentMethod = $url[1];
					unset($url[1]);
				}
			} 
			
			//get params
			$this->params = $url ? array_values($url) : [];

			//call back to call a method of currentController dynamicaly
			call_user_func_array([$this->currentController, $this->currentMethod], $this->params);	
		}

		// get the url and make array out of it
		public function getUrl(){
			if (isset($_GET["url"])) {
				$url = rtrim($_GET["url"], '/');
				$url = filter_var($url, FILTER_SANITIZE_URL);
				$url = explode('/', $url);
				return $url;
			}
		}




	}
?>