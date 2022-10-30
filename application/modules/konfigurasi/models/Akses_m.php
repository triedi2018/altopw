<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Akses_m extends CI_Model {

	public function list_level_user(){
		return $this->db->get('level_user')->result_array();
	}

	public function list_menu(){
		$menu = $this->db->where('aktif','1')->get('menu')->result_array();
		foreach ($menu as $mn){
			$ada = false;
			foreach($this->list_akses() as $a){
				if ($mn['kode_menu'] == $a['kode_menu']){
					$ada = true;
				}
			}

			if (!$ada){
				$insert[] = [
					'kode_menu' => $mn['kode_menu'],
					'level_user' => $this->input->post('level_user'),
					'akses' => '0',
					'tambah' => '0',
					'edit' => '0',
					'hapus' => '0',
					'tanggal' => date('Y-m-d H:i:s'),
					'user' => $this->session->nik
				];
			}
		}

		if (isset($insert)){
			$this->db->insert_batch('akses',$insert);
		}

		// return $this->input->post('level_user');

		return $this->db->select('m.nama_menu,m.level,a.*')
		->from('menu m')
		->join('akses a','a.kode_menu = m.kode_menu','left')
		->where('a.level_user',$this->input->post('level_user'))
		->order_by('m.no_urut')
		->get()->result_array();
	}
	public function list_akses(){
		return $this->db->get_where('akses',['level_user' => $this->input->post('level_user')])->result_array();

	}
	public function simpan(){
		cek_csrf();
		$list = $this->list_menu();
		$no = 0;
		foreach($list as $ls){
			$data[] = [
				'kode_menu' => $ls['kode_menu'],
				'akses' => ($this->input->post('akses'.$no) ? 1 : 0),
				'tambah' => ($this->input->post('tambah'.$no) ? 1 : 0),
				'edit' => ($this->input->post('edit'.$no) ? 1 : 0),
				'hapus' => ($this->input->post('hapus'.$no) ? 1 : 0),
			];
			$no++;
		}
		if ($this->input->post('id_level_user') != hash_id($this->input->post('level_user'))){
			redirect(base_url('unauthorized'));
		}
		$this->db->where('level_user',$this->input->post('level_user'));
		$this->db->update_batch('akses',$data,'kode_menu');

		// return $data;
	}
	public function edit(){
		$data = $this->db
		->select('dk.*,u.level_user')
		->from('users u')
		->join('data_karyawan dk','dk.nik = u.nik','left')
		->where(['dk.nik' => $this->input->post('nik')])
		->get()->row_array();
		return $data;
	}
}