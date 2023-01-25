<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Proforma_invoice_m extends CI_Model {
	
	public function list_produk(){
		return $this->db->get('data_produk')->result_array();
	}

	public function list_customers(){
		return $this->db->get('data_pelanggan')->result_array();
	}

	public function list_surat_jalan(){
		$data = $this->db
		->select('u.*')
		->from('surat_jalan u')
		->where('customer_id',$this->input->post('customer_id'))
		->get()->result_array();
		return $data;
	}

	public function list_proforma_invoices_join($invoice_no){
		$data = $this->db
		->select('u.*')
		->from('vw_proforma_invoices_join u')
		->where('invoice_no',$invoice_no)
		->get()->result_array();
		return $data;
	}	

	public function edit(){
		$data = $this->db
		->select('u.*')
		->from('proforma_invoices u')
		->get()->row_array();
		return $data;
	}
	
	public function edit_get($id){
		$data = $this->db
		->select('u.*')
		->from('proforma_invoices u')
		->where(['md5(u.id)' => $id])
		->get()->row_array();
		return $data;
	}
	
	public function get_no_urut(){
		$data = $this->db
		->select('u.*')
		->from('proforma_invoices u')
		->order_by("id", "desc")
		->limit(1)
		->get()->row_array();
		
		$no_urut = "INV-" . date('Ym');
		
		if($data) {
			$no_urut_temp = $data['invoice_no'];
			$init = substr($no_urut_temp,0,10);
			$final = substr($no_urut_temp,10,strlen($no_urut_temp)-10);
			
			if($no_urut == $init) {
				$value = (int)$final;
				$no_urut .= str_pad($value+1, 8, '0', STR_PAD_LEFT);
			}
			else
			{
				$no_urut = "INV-" . date('Ym') . '00000001';
			}

		}
		else 
		{
			$no_urut = "INV-" . date('Ym') . '00000001';
		}
				
		
		return $no_urut;
	}	

	public function customer_profile($id){
		$data = $this->db
		->select('u.*')
		->from('data_pelanggan u')
		->where(['id' => $id])
		->get()->row_array();
		return $data;
	}

	public function produk_profile($id){
		$data = $this->db
		->select('u.*')
		->from('data_produk u')
		->where(['id' => $id])
		->get()->row_array();
		return $data;
	}

	public function surat_jalan_profile($id){
		$data = $this->db
		->select('u.*')
		->from('surat_jalan u')
		->where(['id' => $id])
		->get()->row_array();
		return $data;
	}	
	
	public function simpan_tambah(){
		// cek user exist
		$cek = $this->db->get_where('proforma_invoices',['invoice_no' => $this->input->post('invoice_no')])->row_array();
		if ($cek){
			return json_encode(['status' => 'error','pesan' => 'Gagal menyimpan data, Invoice No sudah ada..']);
		}
		// insert ke table user
		$this->db->insert('proforma_invoices',
		[
			'invoice_no' => $this->input->post('invoice_no'),
			'invoice_date' => convert_date_to_en($this->input->post('invoice_date')),
			'customer_id' => $this->input->post('customer_id'),
			'items' => $this->input->post('items'),
			'diskon' => $this->input->post('diskon'),
			'created_at' => date('Y-m-d H:i:s')
		]);
				

		return json_encode(['status' => 'success','pesan' => 'Data berhasil disimpan']);

	}
		
	
	public function simpan_edit(){

		$this->db->where('md5(id)',$this->input->post('id'))->update('proforma_invoices',
		[
			'invoice_no' => $this->input->post('invoice_no'),
			'invoice_date' => convert_date_to_en($this->input->post('invoice_date')),
			'customer_id' => $this->input->post('customer_id'),
			'items' => $this->input->post('items')
		]);

		if ($this->db->affected_rows() > 0){
			return json_encode(['status' => 'success','pesan' => 'Data berhasil diperbaharui']);
		}else{
			return json_encode(['status' => 'success','pesan' => 'Tidak ada data yang diperbaharui']);
		}
	}
	
	public function simpan_status_edit(){

		$this->db->where('md5(id)',$this->input->post('id'))->update('proforma_invoices',
		[
			'status' => $this->input->post('status')
		]);

		if ($this->db->affected_rows() > 0){
			return json_encode(['status' => 'success','pesan' => 'Data berhasil diperbaharui']);
		}else{
			return json_encode(['status' => 'success','pesan' => 'Tidak ada data yang diperbaharui']);
		}
	}	
	
	public function hapus(){
		
		$cek = $this->db->get_where('proforma_invoices u',['md5(u.id)' => $this->input->post('id')])->row_array();
		
		$this->db
		->where(['md5(u.id)' => $this->input->post('id')]);
		$this->db->delete('proforma_invoices u');
		return $this->db->affected_rows(); 		
		
	}

    var $table = '( select a.* , b.nama_pelanggan, DATE_ADD(a.invoice_date, INTERVAL b.term_of_payment WEEK) as expire_date from proforma_invoices a left join data_pelanggan b on a.customer_id = b.id ) u';
	var $column_order = array('','u.id'); //set order berdasarkan field yang di mau
	var $column_search = array('u.invoice_no','items'); //set field yang bisa di search
	var $order = array('u.expire_date' => 'ASC'); // default order 

	private function _get_data()
	{		
        $this->db->select('u.*');
		$this->db->from($this->table);
		
		$sql = " id is not null ";
		if ($this->input->post('startdate') != '') {
			$startdate = $this->input->post('startdate');
			$sql .= " and invoice_date > '$startdate 00:00:00' ";
		}
		if ($this->input->post('enddate') != '') {
			$enddate = $this->input->post('enddate');
			$sql .= " and invoice_date < '$enddate 23:59:59' ";
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
		return $this->db->count_all_results();
	}
}
