<?php
	class Categories extends CI_Controller{
		public function index(){
			$data['title'] = 'Categories';

			$data['categories'] = $this->category_model->get_categories();

			$this->load->view('templates/header');
			$this->load->view('categories/index', $data);
			$this->load->view('templates/footer');
		}

		public function create(){
			$data['title'] = 'Create Category';

			$this->form_validation->set_rules('name', 'Name', 'required');

			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('categories/create', $data);
				$this->load->view('templates/footer');
			} else {
				$this->category_model->create_category();

				// 设置消息
				$this->session->set_flashdata('category_created', '创建成功');

				redirect('categories');
			}
		}

		public function posts($id){
			$data['title'] = $this->category_model->get_category($id)->name;

			$data['posts'] = $this->post_model->get_posts_by_category($id);

			$this->load->view('templates/header');
			$this->load->view('posts/index', $data);
			$this->load->view('templates/footer');
		}

		public function delete($id){
			// TODO 鉴权

			$this->category_model->delete_category($id);

			// 设置消息
			$this->session->set_flashdata('category_deleted', '删除类别成功');

			redirect('categories');
		}
	}