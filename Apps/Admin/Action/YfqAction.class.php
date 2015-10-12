<?php

namespace Admin\Action;

class YfqAction extends BaseAction {
	public function index() {
		$m = M ( 'Yfq_fenqi' );
		$r = $m->order('id desc')->find();
		
// 		dump($r);die;
		$this->assign('fenqi',$r);
		
		$this->display ( './yfq/index' );
	}
	
	public function index_users_verify(){
		$m = M('users');
		$r = $m->join('wst_users_info on wst_users.userId=wst_users_info.u_id')->select();
		
		$info = array();
		foreach ($r as $k=>$v){
			$info[$v['u_id']] = $v;
		}
		session('ver_info',$info);
// 		var_dump($r);
		$this->assign('info',$r);
		$this->display('./yfq/index_users_verify');
	}
	
	public function index_user() {
		$m = M ( 'yfq_role' );
		$r = $m->select();
		
		$this->assign('roles',$r);
		$this->display ( './yfq/index_user' );
	}
	public function add_fqinfo() {
		$qishu = trim ( I ( 'qishu' ), ',' );
		$lixi = trim ( I ( 'lixi' ), ',' );
		$yuqi = trim ( I ( 'yuqi' ) );
		$re = $this->check_str ( $qishu, $lixi );
		if ($re === true) {
			$yfq_lixi = D ( 'Yfq_fenqi' );
			$data ['qishu'] = $qishu;
			$data ['lixi'] = $lixi;
			$data ['yuqi'] = $yuqi;
			if ($yfq_lixi->add ( $data )) {
				$this->ajaxReturn('success');
				// $this->index();
				die ();
			}
			// $yfq_lixi->create();
			// $yfq_lixi->add();
		}
// 		$this->ajaxReturn("false");
	}	
	
	// 添加角色
	public function add_uroles() {
		if (I('r_name') == null || I('r_qishu') == null || I('r_ed')== null) {
			return false;
		}
		$m = M ( 'yfq_role' );
		$m->create ();
		if ($m->add ()) {
			echo "success";
			die ();
		}
	}
	public function del_uroles(){
		$m = M ( 'yfq_role' );
		if ($m->delete(I('id',0))) {
			echo "success";
			die ();
		}
	}
	
	
	// 比较两个数组长度
	public function check_str($arr = null, $arr2 = null) {
		if ($arr == null && $arr2 == null) {
			return true;
		} else {
			$a = substr_count ( $arr, ',' );
			$b = substr_count ( $arr2, ',' );
			if ($a == $b) {
				return true;
			} else {
				return false;
			}
			
			// $a = explode(",",$arr);
			// $b = explode(",",$arr2);
			
			// if (count($a) == count($b)) {
			// return true;
			// }else {
			// return false;
			// }
		}
	}
	
	
	//获取用户认证信息
	public function get_verifyinfo(){
		$id = I('id',0);
		$info = session('ver_info');
// 		dump($info[$id]);
		$this->assign('info',$info[$id]);
		$this->display('./yfq/get_verifyinfo');
		
	}
	//打回处理
	public function back_info(){
		$str = I('back_str');
		$uid = I('uid',0);
		
		$m = M('users_info');
		$map['u_id'] = $uid;
		$m->back_info = $str;
		$m->status = 2;
		$m->where($map)->save();
		echo "success";die;
	}
	//通过处理
	public function yes_info(){
		$uid = I('uid',0);
		$m = M('users_info');
		$map['u_id'] = $uid;
		$m->back_info = '';
		$m->status = 1;
		$m->where($map)->save();
		echo "success";die;
	}
	
}