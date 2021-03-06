<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		checkLogged();
		$this->load->model('m_profil');
		$this->load->model('m_denah');
	}

	public function GetProfil($id=NULL)
	{
		if (is_null($id)) {
			$mode = 'create';
		} else {
			$mode = 'edit';
		}
		$id_session = $this->session->userdata("id_user");

		$data_content['profil'] = $this->m_profil->get_data('*', $id_session)->row();
		$data_content['mode'] = $mode;
		$data['content'] = $this->load->view('v_profil',$data_content,true);

		$all_denah = $this->m_denah->get_data("*")->result_array();
		$data["all_denah"] = $all_denah;
		$this->load->view('home',$data);
	}

	public function EditProfil()
	{
		$mode = $this->input->post("mode");

		//if ($mode == 'edit') {
			$id = $this->input->post("id_user");

			if ($this->m_profil->update_data($id,$this->getinput()) == FALSE) {
			 	$this->session->set_flashdata('message', 'gagal Edit data');
				$this->session->set_flashdata('message_status', 'Eroor');
				redirect(site_url('profil/getprofil'));
			} else {
				$this->session->set_flashdata('message', 'sukses edit profil');
				$this->session->set_flashdata('message_status', 'Sukses');
				redirect(site_url('profil/getprofil'));
			}
		//}
	}

	/*add data*/
	private function GetInput(){
		if($this->input->post()){
			$data	= array(
				"username" 		=> $this->input->post("username")
				//"password" 	=> $this->input->post("password"),
			);
			if ($this->input->post("password") != "") {
				$data['password'] = $this->input->post("password");
			}
		}

		return $data;
	}
}
