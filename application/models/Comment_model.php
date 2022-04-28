<?php
	class Comment_model extends CI_Model{

		// 构造函数
		public function __construct(){
			$this->load->database();
		}

		// 创建评论
		public function create_comment($post_id){
            $user = $this->session->userdata('user');
			$data = array(
				'post_id' => $post_id,
				'name' => $user['name'],
				'email' => $user['email'],
				'body' => $this->input->post('body')
			);

			return $this->db->insert('comments', $data);
		}

		//  获取评论
		public function get_comments($post_id){
			$query = $this->db->get_where('comments', array('post_id' => $post_id));
			return $query->result_array();
		}
	}