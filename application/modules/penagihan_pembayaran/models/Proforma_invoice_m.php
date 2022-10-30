<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Proforma_invoice_m extends CI_Model {
	
	public function list_produk(){
		return $this->db->get('data_produk')->result_array();
	}

	public function list_customers(){
		return $this->db->get('data_pelanggan')->result_array();
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

	public function customer_profile($id){
		$data = $this->db
		->select('u.*')
		->from('data_pelanggan u')
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
		$stok = $this->json_description($this->input->post('items'));
		if(!$stok->status) {
			return json_encode(['status' => 'error','pesan' => $stok->pesan]);
		}
		// insert ke table user
		$this->db->insert('proforma_invoices',
		[
			'invoice_no' => $this->input->post('invoice_no'),
			'invoice_date' => convert_date_to_en($this->input->post('invoice_date')),
			'subject' => $this->input->post('subject'),
			'cust_order_no' => $this->input->post('cust_order_no'),
			'cust_order_date' => convert_date_to_en($this->input->post('cust_order_date')),
			'payment_term' => $this->input->post('payment_term'),
			'due_date' => convert_date_to_en($this->input->post('due_date')),
			'customer_id' => $this->input->post('customer_id'),
			'faktur_number' => $this->input->post('faktur_number'),
			'items' => $this->input->post('items'),
			'total' => $this->input->post('total'),
			'created_at' => date('Y-m-d H:i:s')
		]);
		
		$manage = json_decode($this->input->post('items'), true);
		foreach ($manage as $value) {
			$description_name = $value['description_name'];
			$description_quantity = $value['description_quantity'];
			$description_price = $value['description_price'];
			$this->db->insert('barang_keluar',
			[
				'id_produk' => $description_name,
				'jumlah' => $description_quantity,
				'harga' => $description_price,
				'invoice_no' => $this->input->post('invoice_no'),
				'tanggal_invoice' => convert_date_to_en($this->input->post('invoice_date')),
				'created_at' => date('Y-m-d H:i:s')
			]);
			
		}		
		
		
		

		return json_encode(['status' => 'success','pesan' => 'Data berhasil disimpan']);

	}
	
	public function json_description($json)
	{
		$manage = json_decode($json, true);
		foreach ($manage as $value) {
			$description_name = $value['description_name'];
			$description_quantity = $value['description_quantity'];
			$cek = $this->db->get_where("( select a.*, b.nama_produk from ( select id_produk, sum(jumlah) as jumlah from barang_masuk group by id_produk ) a left join data_produk b on a.id_produk = b.id ) u"," u.id_produk = $description_name and jumlah >= $description_quantity ")->row_array();
			if ($cek){
				return json_decode(json_encode(['status' => TRUE,'pesan' => 'Gagal menyimpan data, Jumlah Stok mencukupi..']));
			}
			else
			{
				return json_decode(json_encode(['status' => FALSE,'pesan' => 'Gagal menyimpan data, Jumlah Stok tidak mencukupi..']));
			}
			
		}
		//return true;
	}	
	
	
	public function simpan_edit(){

		$this->db->where('md5(id)',$this->input->post('id'))->update('proforma_invoices',
		[
			'invoice_no' => $this->input->post('invoice_no'),
			'invoice_date' => convert_date_to_en($this->input->post('invoice_date')),
			'subject' => $this->input->post('subject'),
			'cust_order_no' => $this->input->post('cust_order_no'),
			'cust_order_date' => convert_date_to_en($this->input->post('cust_order_date')),
			'payment_term' => $this->input->post('payment_term'),
			'due_date' => convert_date_to_en($this->input->post('due_date')),
			'customer_id' => $this->input->post('customer_id'),
			'faktur_number' => $this->input->post('faktur_number'),
			'items' => $this->input->post('items'),
			'total' => $this->input->post('total')
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
		//return $this->db->affected_rows(); 
		
		$this->db
		->where(['u.invoice_no' => $cek['invoice_no']]);
		$this->db->delete('barang_keluar u');
		return $this->db->affected_rows(); 		
		
	}

    var $table = 'proforma_invoices u';
	var $column_order = array('','u.id'); //set order berdasarkan field yang di mau
	var $column_search = array('u.invoice_no','items'); //set field yang bisa di search
	var $order = array('u.id' => 'desc'); // default order 

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
