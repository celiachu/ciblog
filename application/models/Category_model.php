<?php
	class Category_model extends CI_Model{
		// 构造函数
		public function __construct(){
			$this->load->database();
		}

		// 拿到所有类别
		public function get_categories(){
			$this->db->order_by('name');
			$query = $this->db->get('categories');
			return $query->result_array();
		}

		// 创建类别
		public function create_category(){
            $user = $this->session->userdata('user');
			$data = array(
				'name' => $this->input->post('name'),
				'user_id' => $user['id']
			);

			return $this->db->insert('categories', $data);
		}

		// 通过id获取单个类别
		public function get_category($id){
			$query = $this->db->get_where('categories', array('id' => $id));
			return $query->row();
		}
		
		// 删除类别
		public function delete_category($id){
			$this->db->where('id', $id);
			$this->db->delete('categories');
			return true;
		}
	}