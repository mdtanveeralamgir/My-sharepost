<?php

	class Pages extends Controller {

		public function __construct(){
			
		}

		//default method index
		public function index() {
			if(isLoggedIn()){
				redirect('posts');
			}
			$data = [ 'title' => 'SharePosts',
					  'description' => 'A simple social network to practice PHP MVC framework'
				];
			$this->view('pages/index', $data);
		}

		public function about() {
			$data = ['title' => 'About',
					 'description' => 'An app to share posts'
		];
			$this->view('pages/about', $data);
		}
	}

?>