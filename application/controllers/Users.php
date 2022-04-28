<?php
	class Users extends CI_Controller{
		// Register user
		public function register(){
			$data['title'] = 'Sign Up';

			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('username', 'Username', 'required|callback_check_username_exists');
			$this->form_validation->set_rules('email', 'Email', 'required|callback_check_email_exists');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('password2', 'Confirm Password', 'matches[password]');

			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('users/register', $data);
				$this->load->view('templates/footer');
			} else {
				// Encrypt password
				$enc_password = md5($this->input->post('password'));

				$this->user_model->register($enc_password);

				// 设置消息
				$this->session->set_flashdata('user_registered', '注册成功，可以用当前账号登录了');

				redirect('posts');
			}
		}

		// Log in user
		public function login(){
			$data['title'] = 'Sign In';

			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('users/login', $data);
				$this->load->view('templates/footer');
			} else {
				$username = $this->input->post('username');
				$password = md5($this->input->post('password'));

				$user_id = $this->user_model->login($username, $password);

				if($user_id){
					// 创建session
					$role = 'guest';
					$user_data = array(
                        "user" =>array(
						'id' => $user_id,
						'name' => $username,
						'email' => $this->user_model->get_user_email($user_id),
						"role"=> $role,
						)
					);

					$this->session->set_userdata($user_data);

					// 设置消息
					$this->session->set_flashdata('user_loggedin', '登录成功');

					redirect('posts');
				} else {
					// 设置消息
					$this->session->set_flashdata('login_failed', '无效登录');

					redirect('users/login');
				}		
			}
		}

		// 登出
		public function logout(){
			// 数据清一下
			$this->session->unset_userdata('user');


			// 设置消息
			$this->session->set_flashdata('user_loggedout', '登出成功');

			// 重定向一下
			redirect('users/login');
		}

		// 用户名是否已存在
		public function check_username_exists($username){
			$this->form_validation->set_message('check_username_exists', '用户名已经存在');
			if($this->user_model->check_username_exists($username)){
				return true;
			} else {
				return false;
			}
		}

		// 邮箱是否已存在
		public function check_email_exists($email){
			$this->form_validation->set_message('check_email_exists', '邮箱已存在');
			if($this->user_model->check_email_exists($email)){
				return true;
			} else {
				return false;
			}
		}
	}