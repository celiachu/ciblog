<?php
	class User_model extends CI_Model{
		// 注册
		public function register($enc_password){
			$data = array(
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
                'username' => $this->input->post('username'),
                'password' => $enc_password,
                'zipcode' => $this->input->post('zipcode')
			);

			// 往数据库插入数据
			return $this->db->insert('users', $data);
		}

		// 用户登录
		public function login($username, $password){
			// 验证
			$this->db->where('username', $username);
			$this->db->where('password', $password);

			$result = $this->db->get('users');

			if($result->num_rows() == 1){
				return $result->row(0)->id;
			} else {
				return false;
			}
		}

		// 用户名是否存在
		public function check_username_exists($username){
			$query = $this->db->get_where('users', array('username' => $username));
			if(empty($query->row_array())){
				return true;
			} else {
				return false;
			}
		}

		// 邮箱是否存在
		public function check_email_exists($email){
			$query = $this->db->get_where('users', array('email' => $email));
			if(empty($query->row_array())){
				return true;
			} else {
				return false;
			}
		}

        // 得到用户邮箱
        public function get_user_email($user_id){
            $query = $this->db->get_where('users', array('id' => $user_id));
            if($query->num_rows() == 1){
				return $query->row(0)->email;
			} else {
				return false;
			}
        }
	}