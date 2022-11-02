<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Proforma_invoice extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('Proforma_invoice_m','Data_model');
		$this->load->library('Pdf');
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

        $this->load->view('proforma_invoice_v',$data);
        
        $this->load->view('templates/footer-top');
        // js for this page only
        $this->load->view('proforma_invoice_js');
        //========= end
        $this->load->view('templates/footer-bottom');
    }
    public function tambah(){
        cek_ajax();
        if (cek_akses_user()['tambah'] == 0){
            redirect(base_url('unauthorized'));
        }
		$data['no_urut'] = $this->Data_model->get_no_urut();
        $this->load->view('proforma_invoice_tambah_v', $data);
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
            
            $this->load->view('barang_masuk_edit_v',$data);

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

    public function list_produk(){
        cek_ajax();
        $data = $this->Data_model->list_produk();
        if ($data){
            echo "<option value=''>Pilih Produk</option>";
            foreach($data as $produk){
                echo "<option data-id='$produk[id]' data-nama_produk='$produk[nama_produk]' data-harga='$produk[harga]' data-satuan='$produk[satuan]' value='$produk[id]'>$produk[nama_produk]</option>";
            }
        }
    }

    public function list_customers(){
        cek_ajax();
        $data = $this->Data_model->list_customers();
        if ($data){
            echo "<option value=''>Pilih Pelanggan</option>";
            foreach($data as $customer){
                echo "<option data-address='$customer[alamat]' data-phone='$customer[phone]' data-attn='$customer[contact_person]' value='$customer[id]'>$customer[nama_pelanggan]</option>";
            }
        }
    }

    public function list_surat_jalan(){
        cek_ajax();
        $data = $this->Data_model->list_surat_jalan();
        if ($data){
            echo "<option value=''>Pilih Surat Jalan</option>";
            foreach($data as $surat_jalan){
                echo "<option data-no_surat_jalan='$surat_jalan[no_surat_jalan]' data-tanggal_surat_jalan='$surat_jalan[tanggal_surat_jalan]' value='$surat_jalan[id]'>$surat_jalan[no_surat_jalan]</option>";
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
            (cek_akses_user()['hapus'] == 1 ? ' <a href="#" ><span class="badge badge-danger btn-hapus" data-jenis_action="hapus" data-id="'.md5($data['id']).'">Hapus</span></a>' : '').
			(cek_akses_user()['hapus'] == 1 ? ' <a href="#" ><span class="badge badge-warning btn-print" data-jenis_action="hapus" data-id="'.md5($data['id']).'">Print</span></a>' : '');

            // column buat data tables --
            $row = [
			'invoice_no' => $data['invoice_no'],
			'invoice_date'=>date("d-m-Y", strtotime($data['invoice_date'])),
            'nama_pelanggan' => $data['nama_pelanggan'],
			'items' => $this->json_description($data['items']),
			'faktur_number' => $data['faktur_number'],
			'total' => $data['total'],
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
	
	public function json_description($json)
	{
		$manage = json_decode($json, true);
		$result = '<table>';
		foreach ($manage as $value) {
			$surat_jalan = $this->Data_model->surat_jalan_profile($value['no_surat_jalan']);
			$result .= "<tr><td>$surat_jalan[no_surat_jalan]</td></tr>";
		}
		$result .= '<table>';
		return $result;
	}

	public function printdata($id=0)
	{

		$data = $this->Data_model->edit_get($id);
		$customer = $this->Data_model->customer_profile($data['customer_id']);
		$proforma_invoices_join = $this->Data_model->list_proforma_invoices_join($data['invoice_no']);

		$pdf = new MyTCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetMargins(10, 20, 10, 10);
		$pdf->SetHeaderMargin(25);
		$pdf->SetFooterMargin(10);

		// set font
		$pdf->SetFont('times', 'B', 10);
		
		// add a page
		$pdf->AddPage();

$url_image = base_url() . "assets/images/orbit_logo.png" ;	
$invoice_date = date("d-m-Y", strtotime($data['invoice_date']));
//$cust_order_date = date("d-m-Y", strtotime($data['cust_order_date']));
//$due_date = date("d-m-Y", strtotime($data['due_date']));

$items = "";
$i = 0;

$total_price_all = 0;


if(!empty($proforma_invoices_join)) {
	
	foreach ($proforma_invoices_join as $item) {
		$i++;
		$total_price = (double)$item['jumlah'] * (double)$item['harga'];
		$total_price_all += $total_price;
		$items .= "<tr><td style=\"width: 5%;\">$i</td><td style=\"width: 20%;\">$item[no_surat_jalan]</td><td style=\"width: 20%;\">".date("d-m-Y", strtotime($item['tanggal_surat_jalan']))."</td><td style=\"width: 28%;\">$item[nama_produk]</td><td style=\"width: 7%;\">$item[satuan]</td><td style=\"width: 10%;\">$item[jumlah]</td><td style=\"width: 10%;\">".thousands($total_price)."</td></tr>";
		
	}
	
}

$total_price_all_tax = $total_price_all * 0.11;

$total_price_all_tax_plus_all = $total_price_all_tax + $total_price_all;

$total_price_all_format = number_format($total_price_all, 0, ',', ',');
$total_price_all_tax_format = number_format($total_price_all_tax, 0, ',', ',');
$total_price_all_tax_plus_all_format = number_format($total_price_all_tax_plus_all, 0, ',', ',');

// Set some content to print
$html = <<<EOD
<table style="width: 100%; border-collapse: collapse;" border="0">
<tbody>
<tr>
<td style="width: 50%">
	<table style="width: 100%; border-collapse: collapse;" border="0">
	<tbody>
	<tr>
	<td>
	PT. ALTO ANUGERAH ABADI
	</td>
	</tr>
	<tr>
	<td>
	Jl. Bojong Raya No. 10
	</td>
	</tr>
	</tbody>
	</table>	
	
</td>
<td style="width: 50%; text-align:left;" >
	<table style="width: 100%; border-collapse: collapse;" border="0">
	<tbody>
	<tr>
	<td>
	No. Invoice : $data[invoice_no]
	</td>	
	</tr>
	<tr>
	<td>
	Tanggal Invoice : $invoice_date
	</td>	
	</tr>	
	</tbody>
	</table>
</td>	
</tr>

</tbody>
</table>

<table style="width: 100%; border-collapse: collapse; padding-top:10px;padding-bottom:10px;" border="0">
<tbody>
<tr>
<td style="width: 100%; text-align:center; ">
PROFORMA INVOICE
</td>
</tr>
</tbody>
</table>

<table style="width: 100%; border-collapse: collapse;padding-top:5px;padding-bottom:5px; text-align:center; " border="0">
<thead>
	<tr style="background-color:#869c98">
		<th rowspan="2" style="width: 5%;">NO</th>
		<th colspan="2" style="width: 40%;">SURAT JALAN</th>
		<th rowspan="2" style="width: 28%;">JENIS BARANG</th>
		<th rowspan="2" style="width: 7%;">SATUAN</th>
		<th rowspan="2" style="width: 10%;">JUMLAH</th>
		<th rowspan="2" style="width: 10%;">TOTAL HARGA</th>
	</tr>
	<tr style="background-color:#869c98">
		<th>Nomor</th>
		<th>Tanggal</th>
	</tr>	
</thead>
<tbody>
	$items
</tbody>
</table>


<table style="width: 100%; border-collapse: collapse;padding-top:30px;" border="0">
<tbody>
<tr>
<td style="width: 50%">
	<table style="width: 100%; border-collapse: collapse;padding-bottom:50px;" border="0">
	<tbody>
	<tr>
	<td>
		
	</td>
	</tr>
	</tbody>
	</table>

	<table style="width: 100%; border-collapse: collapse;" border="0">
	<tbody>
	<tr>
	<td>
		
	</td>
	</tr>
	<tr>
	<td>
		Keterangan :
	</td>
	</tr>
	<tr>
	<td>
		1. Proforma Ini Bukan Bukti Pembayaran
	</td>
	</tr>
	<tr>
	<td>
		2. Pembayaran dengan cek/giro ditujukan ke : <br> BCA a/c 879.120.130.0 a/n PT. ALTO ANUGERAH ABADI
	</td>
	</tr>
	<tr>
	<td>
		3. Mohon lakukan pembayaran sebelum tanggal 
	</td>
	</tr>
	<tr>
	<td>
		4. Konfirmasi Pembayaran ke 0812 8301 3061
	</td>
	</tr>	
	</tbody>
	</table>

	
</td>
<td style="width: 50%; text-align:left;" >
	<table style="width: 100%; border-collapse: collapse;" border="0">
	<tbody>
	<tr style="background-color:#869c98">
	<td>
	SUB TOTAL
	</td>
	<td>
		:
	</td>
	<td>
	$total_price_all_format
	</td>	
	</tr>
	<tr style="background-color:#869c98">
	<td>
	11% TAX
	</td>
	<td>
		:
	</td>	
	<td>
	$total_price_all_tax_format
	</td>	
	</tr>
	<tr style="background-color:#869c98">
	<td>
	TOTAL :
	</td>
	<td>
		:
	</td>	
	<td>
	$total_price_all_tax_plus_all_format
	</td>	
	</tr>

	</tbody>
	</table>
</td>	
</tr>

</tbody>
</table>

<table style="width: 100%; border-collapse: collapse;padding-top:10px; text-align:center;" border="0">
<tbody>
	<tr><td>TERIMA KASIH</td></tr>
</tbody>
</table>

EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);			
		
		ob_end_clean();
		$pdf->Output('invoice.pdf', 'I');
		
	}	
	
	
}