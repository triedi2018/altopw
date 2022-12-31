<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('max_execution_time', 0); // time

//load Spout Library
require_once APPPATH.'/third_party/spout/src/Spout/Autoloader/autoload.php';

//lets Use the Spout Namespaces
use Box\Spout\Reader\Common\Creator\ReaderFactory;
use Box\Spout\Common\Type;

class Data_pelanggan extends CI_Controller {
	
	public $CI = NULL;
	
    public function __construct(){
        parent::__construct();
		$this->load->library('form_validation');
		$this->CI = & get_instance();
        $this->load->model('Data_customer_m','Data_model');
        cek_aktif_login();
        cek_akses_user();
    }

    public function index(){
        $data['main_menu'] = main_menu();
        $data['sub_menu'] = sub_menu();
        $data['cek_akses'] = cek_akses_user();
        // $data['notifikasi'] = list_notifikasi();

        $this->load->view('templates/header-top');
        //css for this page only
        
        //======== end
        $this->load->view('templates/header-bottom');
        $this->load->view('templates/header-notif');
        $this->load->view('templates/main-navigation',$data);

        $this->load->view('data_customer_v',$data);
        
        $this->load->view('templates/footer-top');
        // js for this page only
        $this->load->view('data_customer_js');
        //========= end
        $this->load->view('templates/footer-bottom');
    }
    public function tambah(){
        cek_ajax();
        if (cek_akses_user()['tambah'] == 0){
            redirect(base_url('unauthorized'));
        }
        $this->load->view('data_customer_tambah_v');
    }
    public function upload(){
        cek_ajax();
        if (cek_akses_user()['tambah'] == 0){
            redirect(base_url('unauthorized'));
        }
        $this->load->view('data_customer_upload_v');
    }
    public function simpan_tambah(){
        cek_ajax();
        if (cek_akses_user()['tambah'] == 0){
            redirect(base_url('unauthorized'));
        }
        echo $this->Data_model->simpan_tambah();
    }

    public function simpan_edit(){
        cek_ajax();
        if (cek_akses_user()['edit'] == 0){
            redirect(base_url('unauthorized'));
        }
        echo $this->Data_model->simpan_edit();
    }
    
    public function edit(){
        cek_ajax();
        $this->security->get_csrf_hash();
        if (cek_akses_user()['edit'] == 0){
            echo "error";
        }

            $data['data'] = $this->Data_model->edit();
            
            $this->load->view('data_customer_edit_v',$data);

    }
	
    public function hapus(){
        cek_ajax();
        $this->security->get_csrf_hash();
        if (cek_akses_user()['hapus'] == 0){
            echo "error";
        }

		$data['data'] = $this->Data_model->hapus();
		
		echo "done";
		//$this->load->view('data_sparepart_edit_v',$data);

    }

    public function list_agen(){
        cek_ajax();
        $data = $this->Data_model->list_agen();
        if ($data){
            echo "<option value=''>Pilih Agen</option>";
            foreach($data as $customer){
                echo "<option data-address='$customer[alamat]' data-phone='$customer[phone]' data-attn='$customer[contact_person]' value='$customer[id]'>$customer[nama_pelanggan]</option>";
            }
        }
    }

    public function list_agen_selected($id){
        cek_ajax();
        $data = $this->Data_model->list_agen();
        if ($data){
            echo "<option value=''>Pilih Agen</option>";
            foreach($data as $customer){
				if($customer['id'] == $id) {
					echo "<option data-address='$customer[alamat]' data-phone='$customer[phone]' data-attn='$customer[contact_person]' value='$customer[id]' selected >$customer[nama_pelanggan]</option>";
				}
				else
				{
					echo "<option data-address='$customer[alamat]' data-phone='$customer[phone]' data-attn='$customer[contact_person]' value='$customer[id]'>$customer[nama_pelanggan]</option>";
				}
            }
        }
    }	
	
    public function tampildata()
	{
        // $this->security->get_csrf_token_name();
        // $this->security->get_csrf_hash();
        cek_ajax();
		$list = $this->Data_model->tampildata();
		$record = array();
		$no = $_POST['start'];
		foreach ($list as $data) {
			$no++;

            // tombol action - dicek juga punya akses apa engga gengs....
            $tombol_action = (cek_akses_user()['edit'] == 1 ? '<a href="#" ><span class="badge badge-primary btn-edit" data-jenis_action="edit" data-id="'.md5($data['id']).'" data-'.$this->security->get_csrf_token_name().'='.$this->security->get_csrf_hash().'>Edit</span></a>' : '' ). 
            (cek_akses_user()['hapus'] == 1 ? ' <a href="#" ><span class="badge badge-danger btn-hapus" data-jenis_action="hapus" data-id="'.md5($data['id']).'">Hapus</span></a>' : '');

            // column buat data tables --
            $row = ['nama_pelanggan' => $data['nama_pelanggan'] ,'status_pelanggan' => $data['status_pelanggan'],'referensi'=>$data['referensi'],
			'status_ref' => $data['status_ref'] ,'no_npwp' => $data['no_npwp'],'faktur_pajak'=>$data['faktur_pajak'],
            'alamat' => $data['alamat'] ,'contact_person' => $data['contact_person'],'phone'=>$data['phone'],
			'email' => $data['email'] ,'alamat_pengiriman' => $data['alamat_pengiriman'],'kode_pos'=>$data['kode_pos'],
            'action' => $tombol_action,
            
            ];
			$record[] = $row;

        }
		$output = array(
						"draw" => $this->input->post('draw'),
						"recordsTotal" => $this->Data_model->count_all(),
						"recordsFiltered" => $this->Data_model->count_filtered(),
						"data" => $record,
						"length" => 5,
				);
		//output to json format
		echo json_encode($output);
	}
	
      public function simpan_upload() { // 
	  
	    $data = array();
		
		$data["xxxxxxxxx"] = "cccccccccccccccc";
		
		$data_array = array();
	  
		if(isset($_FILES['file'])) {
			
				$data["bbbbbbbbbbbbbb"] = "bbbbbbbbbbbbbbbbbbbbbbbbb";
			
			  if($_FILES['file']['tmp_name'])//check if any picture is selected to upload
			  {
				  
				  $file = 'file' . date('YmdHis') . '_' . $_FILES['file']['name'] ;
				  
				  $config = array();
				  $config['upload_path']   = FCPATH . 'upload/';
				  $config['allowed_types'] = '*';
				  $config['file_name'] 		= $file;
				  //$config['max_size']      = '10000';
				  $this->load->library('upload', $config);
				  $this->upload->initialize($config);

				  if ( !$this->upload->do_upload('file',FALSE))
				  {

					if($_FILES['file']['error'] != 4) {
						$data['error'] = $_FILES['file']['error'];
					}
					else {
						$data['upload_data'] = $this->upload->data();
					}
				  }

					$data["yyyyyyyyyyy"] = "cccccccccccccccc";
				  
				  try {
					  
					  //$this->db->trans_start();
					  //$this->db->query("delete from energi_final_sektor_dashboard3");
					  //$this->db->trans_complete();
					  
					   //Lokasi file excel	      
					   $inputFileName = FCPATH . 'upload/' . str_replace( ' ', '_', $file );           	      
					   $reader = ReaderFactory::createFromType(Type::XLSX); //set Type file xlsx
						$reader->open($inputFileName); //open the file	  	      

						//echo "<pre>";	          
						
						$no = 0;
						$k = 0;
						$provinsi = NULL;
						
						
				 
						foreach ($reader->getSheetIterator() as $sheet) {

							//if ($sheet->getName() == 'Sheet1') {
							if ($sheet->getIndex() == 0) {
								//Rows iterator	               
								foreach ($sheet->getRowIterator() as $row) {
									
									$values = $row->toArray();
									
									
									if($k > 0) {
										
										array_push($data_array, $values);
										
										$row = array();
		
		$row['kode'] = $values[1];
		$row['kode_pelanggan'] = $values[2];
		$row['nama_pelanggan'] = $values[3];
		$row['status_pelanggan'] = 'Agen';
		$row['referensi'] = '-';
		$row['status_ref'] = '-';
		$row['no_npwp'] = '-';
		$row['faktur_pajak'] = '-';
		$row['alamat'] = $values[4];
		$row['contact_person'] = '-';
		$row['phone'] = $values[5];
		$row['email'] = '-';
		$row['alamat_pengiriman'] = $values[4];
		$row['kode_pos'] = '-';
		$row['term_of_payment'] = 1;
		
		$this->Data_model->simpan_upload($row);
		
										
										/*
										$query = $this->engine_m->getdata_like('jabatan','n_jabatan',$values[0]);
										
										foreach ($query as $row1) {

											$search = array();
											$search["nip"] = $row1->nip;
											$search["kegiatan"] = $values[1];
											$search["tahun"] = (int)$this->input->post('tahun');

											$result_array = $this->engine_m->get_sql3('skp',$search);

											if(count($result_array)==0) {
												
												//$r = $query->first_row();
												
												$row0["nip"] = $row1->nip;
												$row0["kegiatan"] = $values[1];
												$row0["tahun"] = (int)$this->input->post('tahun');
												
												//array_push($data_array, $row0);
												
												$this->engine_m->simpandata("skp",$row0);
												
												
											}

										}
										*/
											
									}
									
									$k++;
								}
							}
						}

						//echo "<br> Total Rows : ".$i." <br>";	  	          
						$reader->close();
										 

				 //echo "Peak memory:", (memory_get_peak_usage(true) / 1024 / 1024), " MB" ,"<br>";

			  } catch (Exception $e) {

					$data["getMessage"] = $e->getMessage();
 
			  }				  
				  
				  
			  }
			
		}
				
		$data["dt"] = $data_array;
		header("Content-type: application/json");
		echo  json_encode($data);	
	
  }//end of function 
	
}