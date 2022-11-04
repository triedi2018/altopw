<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Data_driver_m extends CI_Model {

	public function edit(){
		$data = $this->db
		->select('u.*')
		->from('driver u')
		->where(['md5(u.id)' => $this->input->post('id')])
		->get()->row_array();
		return $data;
	}
	
	public function get_no_urut(){
		$data = $this->db
		->select('u.*')
		->from('driver u')
		->order_by("id", "desc")
		->limit(1)
		->get()->row_array();
		
		$kode = "DRV-" . date('Ym');
		
		if($data) {
			$kode_temp = $data['kode'];
			$init = substr($kode_temp,0,10);
			$final = substr($kode_temp,10,strlen($kode_temp)-10);
			//$no_surat_jalan = $final;
			
			if($kode == $init) {
				$value = (int)$final;
				$kode .= str_pad($value+1, 8, '0', STR_PAD_LEFT);
			}
			else
			{
				$kode = "DRV-" . date('Ym') . '00000001';
			}

		}
		else 
		{
			$kode = "DRV-" . date('Ym') . '00000001';
		}
				
		
		return $kode;
	}	
	
	public function simpan_tambah(){
		// cek user exist
		$cek = $this->db->get_where('driver',['kode' => $this->input->post('kode')])->row_array();
		if ($cek){
			return json_encode(['status' => 'error','pesan' => 'Gagal menyimpan data, Kode Driver sudah ada..']);
		}
		// insert ke table user
		$this->db->insert('driver',
		['nama_driver' => $this->input->post('nama_driver'),
		'kode' => $this->input->post('kode'),
		'nik' => $this->input->post('nik'),
		'alamat' => $this->input->post('alamat'),
		'hp' => $this->input->post('hp'),
		'created_at' => date('Y-m-d H:i:s')
		]);

		return json_encode(['status' => 'success','pesan' => 'Data berhasil disimpan']);

	}
	public function simpan_edit(){

		$this->db->where('md5(id)',$this->input->post('id'))->update('driver',
		[
			'nama_driver' => $this->input->post('nama_driver'),
			'kode' => $this->input->post('kode'),
			'nik' => $this->input->post('nik'),
			'alamat' => $this->input->post('alamat'),
			'hp' => $this->input->post('hp')
		]);

		if ($this->db->affected_rows() > 0){
			return json_encode(['status' => 'success','pesan' => 'Data berhasil diperbaharui']);
		}else{
			return json_encode(['status' => 'success','pesan' => 'Tidak ada data yang diperbaharui']);
		}
	}
	
	public function hapus(){
		$this->db
		->where(['md5(u.id)' => $this->input->post('id')]);
		$this->db->delete('driver u');
		return $this->db->affected_rows();
	}

    var $table = 'driver u';
	var $column_order = array('','u.id'); //set order berdasarkan field yang di mau
	var $column_search = array('u.nama_driver'); //set field yang bisa di search
	var $order = array('u.id' => 'asc'); // default order 

	private function _get_data()
	{		
        $this->db->select('u.*');
		$this->db->from($this->table);
		$i = 0;	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // cek kalo ada search data
			{				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open group like or like
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close group like or like
			}
			$i++;
		}		
		if(isset($_POST['order'])) // cek kalo click order
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function tampildata()
	{
		$this->_get_data();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result_array();
	}

	function count_filtered()
	{
		$this->_get_data();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
}
