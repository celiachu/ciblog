<?php
	class Posts extends CI_Controller{
		public function index($offset = 0){	
			// 分页类配置
			$config['base_url'] = base_url() . 'posts/index/';
			$config['total_rows'] = $this->db->count_all('posts');
			$config['per_page'] = 3;
			$config['uri_segment'] = 3;
			$config['attributes'] = array('class' => 'pagination-link');

			// 初始化分页类
			$this->pagination->initialize($config);

			$data['title'] = '最新博文';

			$data['posts'] = $this->post_model->get_posts(FALSE, $config['per_page'], $offset);

			$this->load->view('templates/header');
			$this->load->view('posts/index', $data);
			$this->load->view('templates/footer');
		}

		public function view($slug = NULL){
            $slug = urldecode($slug);
			$data['post'] = $this->post_model->get_posts($slug);
			$post_id = $data['post']['id'];
			$data['comments'] = $this->comment_model->get_comments($post_id);

			if(empty($data['post'])){
				show_404();
			}

			$data['title'] = $data['post']['title'];

			$this->load->view('templates/header');
			$this->load->view('posts/view', $data);
			$this->load->view('templates/footer');
		}

		public function create(){
			$data['title'] = 'Create Post';

			$data['categories'] = $this->post_model->get_categories();

			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('body', 'Body', 'required');

			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('posts/create', $data);
				$this->load->view('templates/footer');
			} else {
				// 上传图片
				$config['upload_path'] = './assets/images/posts';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size'] = '2048';
				$config['max_width'] = '2000';
				$config['max_height'] = '2000';

				$this->load->library('upload', $config);

				if(!$this->upload->do_upload()){
					$errors = array('error' => $this->upload->display_errors());
					$post_image = 'noimage.jpg';
				} else {
					$data = array('upload_data' => $this->upload->data());
					$post_image = $_FILES['userfile']['name'];
				}

				$this->post_model->create_post($post_image);

				// 设置消息
				$this->session->set_flashdata('post_created', '创建博文成功');

				redirect('posts');
			}
		}

		public function delete($id){
			$this->post_model->delete_post($id);

			// 设置消息
			$this->session->set_flashdata('post_deleted', '删除博文成功');

			redirect('posts');
		}

		public function edit($slug){
            $slug = urldecode($slug);
			$data['post'] = $this->post_model->get_posts($slug);

			// 检查登录
			$user = $this->session->userdata('user');
			if($user["id"] != $this->post_model->get_posts($slug)['user_id']){
				redirect('posts');
			}

			$data['categories'] = $this->post_model->get_categories();

			if(empty($data['post'])){
				show_404();
			}

			$data['title'] = 'Edit Post';

			$this->load->view('templates/header');
			$this->load->view('posts/edit', $data);
			$this->load->view('templates/footer');
		}

		public function update(){
			// TODO 鉴权

			$this->post_model->update_post();

			// 通知
			$this->session->set_flashdata('post_updated', '博文已更新');

			redirect('posts');
		}
	}