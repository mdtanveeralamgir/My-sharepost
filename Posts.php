<?php
class Posts extends Controller{

	public function __construct(){
		if (!isLoggedIn()) {
			redirect('users/login');
		}

		$this->postModel = $this->model('Post');
		$this->userModel = $this->model('User');
	}

	public function index(){
		$posts = $this->postModel->getPosts();
		$data = [
			'posts' => $posts
		];
		$this->view('posts/index', $data);
	}

	public function add(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			//sanitize post
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$data = [
			'title' => trim($_POST['title']),
			'body' => trim($_POST['body']),
			'user_id' => $_SESSION['user_id'],
			'title_err' => '',
			'body_err' => ''
		];

		//vaidate title
		if(empty($data['title'])){
			$data['title_err'] = 'Please fill out the title';
		}

		//vaidate body
		if(empty($data['body'])){
			$data['body_err'] = 'Please fill out the body';
		}

		//make sure there is no error
		if(empty($data['title_err']) && empty($data['body_err'])){
			//Validated
			if($this->postModel->addPost($data)){
				flash('post_message', 'post added successfully');
				redirect('posts');
			}else{

				die('Something is wrong');
			}

		}else{
			//Load view with error
			$this->view('posts/add', $data);
		}

		}else{
			$data = [
			'title' => '',
			'body' => ''
		];
		$this->view('posts/add', $data);
		}
		
	}

	//Show details of posts
	public function show($id){

		$post = $this->postModel->getPostById($id);
		$user = $this->userModel->getUserById($post->user_id);

		$data = [
			'post' => $post,
			'user' => $user
		];
		$this->view('posts/show', $data);
	}

		public function edit($id){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			//sanitize post
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$data = [
			'id' => $id,	
			'title' => trim($_POST['title']),
			'body' => trim($_POST['body']),
			'user_id' => $_SESSION['user_id'],
			'title_err' => '',
			'body_err' => ''
		];

		//vaidate title
		if(empty($data['title'])){
			$data['title_err'] = 'Please fill out the title';
		}

		//vaidate body
		if(empty($data['body'])){
			$data['body_err'] = 'Please fill out the body';
		}

		//make sure there is no error
		if(empty($data['title_err']) && empty($data['body_err'])){
			//Validated
			if($this->postModel->updatePost($data)){
				flash('post_message', 'post updated successfully');
				redirect('posts');
			}else{

				die('Something is wrong');
			}

		}else{
			//Load view with error
			$this->view('posts/edit', $data);
		}

		}else{
			// Get Existing post from model
			$post = $this->postModel->getPostById($id);
			//Check for owner
			if ($post->user_id != $_SESSION['user_id']) {
				redirect('posts');
			}
			$data = [
			'id' => $id,	
			'title' => $post->title,
			'body' => $post->body
		];
		$this->view('posts/edit', $data);
		}
		
	}

	public function delete($id){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			// Get Existing post from model
			$post = $this->postModel->getPostById($id);
			//Check for owner
			if ($post->user_id != $_SESSION['user_id']) {
				redirect('posts');
			}
			if ($this->postModel->deletePost($id)) {
				flash('post_message', 'Message deleted');
				redirect('posts');
			}else{
				die('Something went wrong');
			}

		}else{
			redirect('posts');
		}
	}

}

?>