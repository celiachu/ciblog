<?php
    class Acl extends CI_Hooks{
        private $url_model; // 对应模块
        private $url_method; // 对应方法
        private $url_param; //url所带參数 可能是 1 也可能是 id=1&name=test
        private $CI;

        public function __construct(){
            $this->CI =& get_instance();
            $this->CI->load->library('session');
            $url = $_SERVER['PHP_SELF'];
            $arr = explode('/', $url);

            $arr = array_slice($arr, array_search('index.php', $arr) + 1, count($arr));
            $this->url_model = $arr[0] ?? '';
            $this->url_method = $arr[1] ?? 'index';
            $this->url_param = $arr[2] ?? '';
        }

        public function auth(){
             $except_url_model = array(
              'users',
            );
            if(in_array($this->url_model,$except_url_model)){
                return;
            }
            $user = $this->CI->session->userdata('user');
            if (empty($user)) {//游客visitor
                $role_name = 'visitor';
            } else {
                $role_name = $user['role'];
            }
            $this->CI->load->config('acl');
            $acl = $this->CI->config->item('acl');
            $role = $acl[$role_name];
            $acl_info = $this->CI->config->item('acl_info');

            if (array_key_exists($this->url_model, $role) &&(empty($role[$this->url_model]) ||in_array($this->url_method, $role[$this->url_model])) ) {
                return;
            } else {//无权限，给出提示，跳转url
                $this->CI->session->set_flashdata('info', $acl_info[$role_name]['info']);
                redirect($acl_info[$role_name]['return_url']);
            }
        }
    }