<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Kas_m extends CI_Model {
	
	public function list_produk(){
		return $this->db->get('data_produk')->result_array();
	}	

	public function edit(){
		$data = $this->db
		->select('u.*')
		->from('kas u')
		->where(['md5(u.id)' => $this->input->post('id')])
		->get()->row_array();
		return $data;
	}
	public function simpan_tambah(){
		// cek user exist
		//$cek = $this->db->get_where('barang_masuk',['nama_produk' => $this->input->post('nama_produk')])->row_array();
		//if ($cek){
			//return json_encode(['status' => 'error','pesan' => 'Gagal menyimpan data, Nama Pelanggan sudah ada..']);
		//}
		// insert ke table user
		$this->db->insert('kas',
		[
			'tanggal' => convert_date_to_en($this->input->post('tanggal')),
			'jenis_transaksi' => $this->input->post('jenis_transaksi'),
			'jumlah' => $this->input->post('jumlah'),
			'keterangan' => $this->input->post('keterangan'),
			'created_at' => date('Y-m-d H:i:s')
		]);

		return json_encode(['status' => 'success','pesan' => 'Data berhasil disimpan']);

	}
	public function simpan_edit(){

		$this->db->where('md5(id)',$this->input->post('id'))->update('kas',
		[
			'tanggal' => convert_date_to_en($this->input->post('tanggal')),
			'jenis_transaksi' => $this->input->post('jenis_transaksi'),
			'keterangan' => $this->input->post('keterangan'),
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
		$this->db->delete('kas u');
		return $this->db->affected_rows(); 
	}

    var $table = '( select * from kas ) u';
	var $column_order = array('','u.id'); //set order berdasarkan field yang di mau
	var $column_search = array('u.jenis_transaksi','keterangan'); //set field yang bisa di search
	var $order = array('u.tanggal' => 'asc'); // default order 

	private function _get_data()
	{		
        $this->db->select('u.*');
		$this->db->from($this->table);
		
		$sql = " id is not null ";
		
		if ($this->input->post('view') != '') {
			if($this->input->post('view') == 'all') {
				if ($this->input->post('startdate') != '') {
					$startdate = $this->input->post('startdate');
					$sql .= " and tanggal > '$startdate 00:00:00' ";
				}
				if ($this->input->post('enddate') != '') {
					$enddate = $this->input->post('enddate');
					$sql .= " and tanggal < '$enddate 23:59:59' ";
				}
			}
			else if($this->input->post('view') == 'DEBIT') {
				$sql .= " and jenis_transaksi = 'DEBIT' " ;
				if ($this->input->post('startdate') != '') {
					$startdate = $this->input->post('startdate');
					$sql .= " and tanggal > '$startdate 00:00:00' ";
				}
				if ($this->input->post('enddate') != '') {
					$enddate = $this->input->post('enddate');
					$sql .= " and tanggal < '$enddate 23:59:59' ";
				}				
				
			}
			else if($this->input->post('view') == 'KREDIT') {
				$sql .= " and jenis_transaksi = 'KREDIT' " ;
				if ($this->input->post('startdate') != '') {
					$startdate = $this->input->post('startdate');
					$sql .= " and tanggal > '$startdate 00:00:00' ";
				}
				if ($this->input->post('enddate') != '') {
					$enddate = $this->input->post('enddate');
					$sql .= " and tanggal < '$enddate 23:59:59' ";
				}				
			}
			
		}	
		
		$this->db->where($sql);		
		
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
		
		$sql = " id is not null ";
		
		if ($this->input->post('view') != '') {
			if($this->input->post('view') == 'all') {
				if ($this->input->post('startdate') != '') {
					$startdate = $this->input->post('startdate');
					$sql .= " and tanggal > '$startdate 00:00:00' ";
				}
				if ($this->input->post('enddate') != '') {
					$enddate = $this->input->post('enddate');
					$sql .= " and tanggal < '$enddate 23:59:59' ";
				}
			}
			else if($this->input->post('view') == 'DEBIT') {
				$sql .= " and jenis_transaksi = 'DEBIT' " ;
				if ($this->input->post('startdate') != '') {
					$startdate = $this->input->post('startdate');
					$sql .= " and tanggal > '$startdate 00:00:00' ";
				}
				if ($this->input->post('enddate') != '') {
					$enddate = $this->input->post('enddate');
					$sql .= " and tanggal < '$enddate 23:59:59' ";
				}				
				
			}
			else if($this->input->post('view') == 'KREDIT') {
				$sql .= " and jenis_transaksi = 'KREDIT' " ;
				if ($this->input->post('startdate') != '') {
					$startdate = $this->input->post('startdate');
					$sql .= " and tanggal > '$startdate 00:00:00' ";
				}
				if ($this->input->post('enddate') != '') {
					$enddate = $this->input->post('enddate');
					$sql .= " and tanggal < '$enddate 23:59:59' ";
				}				
			}
			
		}	
		
		$this->db->where($sql);			
		
		return $this->db->count_all_results();
	}
}
