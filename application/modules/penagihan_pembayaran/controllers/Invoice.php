<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Invoice extends CI_Controller {
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
			$description = $data['data']['items'];
			if(!empty($description)) {
				$manage = json_decode($description, true);
				$items = "";
				foreach ($manage as $item) {
					//$items = $items . "<li style='margin-bottom:10px;'> Produk: &nbsp;<select id='list_produk' class='description_name' type='text' style='width:250px;' required >".$this->list_produk2($data['data']['customer_id'],$item['description_name'])."</select> &nbsp; Quantity: &nbsp;<input type='text' value='$item[description_quantity]' style='width:50px;' required align='center' class='allow_only_numbers description_quantity'  /> &nbsp; Harga: &nbsp;<input type='text' value='$item[description_price]' style='width:150px;' required class='allow_only_numbers description_price'  />&nbsp; <a href='javascript:void(0);' class='remove'>×</a></li>";
					$items = $items . "<li style='margin-bottom:10px;'> No Surat Jalan: &nbsp;<select id='list_surat_jalan' class='description_no_surat_jalan' type='text' style='width:250px;' required  >".$this->list_surat_jalan2($data['data']['customer_id'],$item['no_surat_jalan'])."</select> &nbsp; Tgl : &nbsp;<input type='text' value='$item[tanggal_surat_jalan]' style='width:150px;' required align='center' class='description_tanggal_surat_jalan'  /> &nbsp; <a href='javascript:void(0);' class='remove'>×</a></li>";
					//echo "<option data-no_surat_jalan='$surat_jalan[no_surat_jalan]' data-tanggal_surat_jalan='$surat_jalan[tanggal_surat_jalan]' value='$surat_jalan[id]'>$surat_jalan[no_surat_jalan]</option>";					
					
					
				}
				$data['data']['items'] = $items;
			}            
            $this->load->view('proforma_invoice_edit_v',$data);

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

    public function list_surat_jalan2($customer_id, $id){
        //cek_ajax();
		$list_surat_jalan2 = "";
        $data = $this->Data_model->list_surat_jalan2($customer_id);
        if ($data){
            $list_surat_jalan2 = "<option value=''>Pilih Produk</option>";
            foreach($data as $surat_jalan){
				if($id == $surat_jalan['id'])
					$list_surat_jalan2 .= "<option data-no_surat_jalan='$surat_jalan[no_surat_jalan]' data-tanggal_surat_jalan='$surat_jalan[tanggal_surat_jalan]' value='$surat_jalan[id]' selected >$surat_jalan[no_surat_jalan]</option>";
				else
					$list_surat_jalan2 .= "<option data-no_surat_jalan='$surat_jalan[no_surat_jalan]' data-tanggal_surat_jalan='$surat_jalan[tanggal_surat_jalan]' value='$surat_jalan[id]'>$surat_jalan[no_surat_jalan]</option>";
            }
        }
		return $list_surat_jalan2;
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
			'expire_date' => date("d-m-Y", strtotime($data['expire_date'])),
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
			$description_detail = $this->json_description_detail($surat_jalan['items']);
			$result .= "<tr><td>$surat_jalan[no_surat_jalan]</td><td>$description_detail</td></tr>";
		}
		$result .= '<table>';
		return $result;
	}
	
	public function json_description_detail($json)
	{
		$manage = json_decode($json, true);
		$result = '<table width="400">';
		foreach ($manage as $value) {
			$produk = $this->Data_model->produk_profile($value['description_name']);
			$rupiah = rupiah($value['description_price']);
			$total_rupiah = rupiah(($value['description_price']*$value['description_quantity']));
			$result .= "<tr><td width='40%' >$produk[nama_produk]</td><td width='10%' >$value[description_quantity]</td><td width='25%' >$rupiah</td><td width='25%' ><b>$total_rupiah</b></td></tr>";
		}
		$result .= '</table>';
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
		$pdf->SetFont('times', '', 10);
		
		// add a page
		$pdf->AddPage();

$url_image = base_url() . "assets/images/orbit_logo.png" ;	
$invoice_date = date("d-m-Y", strtotime($data['invoice_date']));
$expire_date = date("d-m-Y", strtotime($data['expire_date']));
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
		$items .= "<tr><td style=\"width: 5%;\">$i</td><td style=\"width: 20%;\">$item[no_surat_jalan]</td><td style=\"width: 20%;\">".date("d-m-Y", strtotime($item['tanggal_surat_jalan']))."</td><td style=\"width: 28%;\">$item[nama_produk]</td><td style=\"width: 7%;\">$item[satuan]</td><td style=\"width: 10%;\">$item[jumlah]</td><td style=\"width: 10%;text-align:left;\">".rupiah($total_price)."</td></tr>";
		
	}
	
}


$total_price_all_disc = $total_price_all * 0;

if(isset($data['diskon'])) {
	$total_price_all_disc = $total_price_all * ($data['diskon']/100);
}



$total_price_all_tax_plus_all =  $total_price_all - $total_price_all_disc;

$total_price_all_format = rupiah($total_price_all); //number_format($total_price_all, 0, ',', ',');
$total_price_all_disc_format = rupiah($total_price_all_disc);//number_format($total_price_all_tax, 0, ',', ',');
$total_price_all_tax_plus_all_format = rupiah($total_price_all_tax_plus_all); //number_format($total_price_all_tax_plus_all, 0, ',', ',');

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
	<img src="data:image/png;base64,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" alt="" width="100" />
	</td>
	</tr>	
	<tr>
	<td>
	PT. ALTO ANUGERAH ABADI
	</td>
	</tr>
	<tr>
	<td>
	Jl. Kembangan Utara No.25, RT.2/RW.2, <br>Kembangan Utara, Kec. Kembangan, Kota Jakarta Barat, <br>Daerah Khusus Ibukota Jakarta 11610
	</td>
	</tr>
	<tr>
	<td>
	Phone : +0821.1251.0875
	</td>
	</tr>
	<tr>
	<td>
	Email : alto.ab.premier@gmail.com
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
	
	<div style="height:20px;"></div>
	
	<table style="width: 100%; border-collapse: collapse;" border="0">
	<tbody>
	<tr>
	<td>
	
	</td>	
	</tr>
	<tr>
	<td>
	
	</td>	
	</tr>	
	</tbody>
	</table>	
	
</td>	
</tr>

</tbody>
</table>

<div style="height:100px;"></div>

<table style="width: 100%; border-collapse: collapse;" border="0">
<tbody>
<tr>
<td style="width: 100%">
	<table style="width: 100%; text-align:left;  border-collapse: collapse;" border="0">
	<tbody>
	<tr>
	<td colspan="2">
	Kepada Yth :
	</td>
	</tr>
	<tr>
	<td style="width:10%;">
	Nama :
	</td>
	<td>
	$customer[nama_pelanggan]
	</td>
	</tr>
	<tr>
	<td style="width:10%;">
	Alamat :
	</td>
	<td>
	$customer[alamat]
	</td>
	</tr>
	<tr>
	<td style="width:10%;">
	Telp :
	</td>
	<td>
	$customer[phone]
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
INVOICE
</td>
</tr>
</tbody>
</table>

<table style="width: 100%; border-collapse: collapse;padding-top:5px;padding-bottom:5px; text-align:center; " border="1">
<thead>
	<tr>
		<th rowspan="2" style="width: 5%;">NO</th>
		<th colspan="2" style="width: 40%;">SURAT JALAN</th>
		<th rowspan="2" style="width: 28%;">JENIS BARANG</th>
		<th rowspan="2" style="width: 7%;">SATUAN</th>
		<th rowspan="2" style="width: 10%;">JUMLAH</th>
		<th rowspan="2" style="width: 10%;">TOTAL HARGA</th>
	</tr>
	<tr>
		<th>Nomor</th>
		<th>Tanggal</th>
	</tr>	
</thead>
<tbody>
	$items
</tbody>
</table>

<div style="height:10px;"></div>

<table style="width: 100%; border-collapse: collapse;" border="0">
<tbody>
<tr>
<td style="width: 100%; text-align:center;" >
	<table style="width: 100%; border-collapse: collapse;" border="1">
	<tbody>
	<tr>
	<td style="width: 90%;">
	Total Harga Jual :
	</td>	
	<td style="width: 10%;">
		$total_price_all_format
	</td>	
	</tr>
	</tbody>
	</table>
</td>	
</tr>
<tr>
<td style="width: 100%; text-align:center;" >
	<table style="width: 100%; border-collapse: collapse;" border="1">
	<tbody>
	<tr>
	<td style="width: 90%;">
	Potongan Harga :
	</td>	
	<td style="width: 10%;">
		$total_price_all_disc_format
	</td>	
	</tr>
	</tbody>
	</table>
</td>	
</tr>
<tr>
<td style="width: 100%; text-align:center;" >
	<table style="width: 100%; border-collapse: collapse;" border="1">
	<tbody>
	<tr>
	<td style="width: 90%;">
	Total Harga Jual Netto:
	</td>	
	<td style="width: 10%;">
		$total_price_all_tax_plus_all_format
	</td>	
	</tr>
	</tbody>
	</table>
</td>	
</tr>

</tbody>
</table>

<table style="width: 100%; border-collapse: collapse;padding-top:5px;" border="0">
<tbody>
<tr>
<td style="width: 50%">
	<table style="width: 100%; border-collapse: collapse;padding-bottom:5px;" border="0">
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
		Keterangan :
	</td>
	</tr>
	<tr>
	<td>
		1. Harga jual sudah termasuk PPN
	</td>
	</tr>
	<tr>
	<td>
		2. Pembayaran ditujukan ke : <br> BCA a/c 879.120.030.0 a/n PT. ALTO ANUGERAH ABADI
	</td>
	</tr>
	<tr>
	<td>
		3. Mohon segera lakukan pembayaran sebelum tanggal $expire_date
	</td>
	</tr>
	<tr>
	<td>
		4. Konfirmasi Pembayaran ke 0812 8301 1061
	</td>
	</tr>	
	</tbody>
	</table>

	
</td>
<td style="width: 50%; text-align:left;" >

</td>	
</tr>

</tbody>
</table>

<table style="width: 100%; border-collapse: collapse;padding-top:10px; text-align:center;" border="0">
<tbody>
	<tr><td style="width: 50%;"></td><td>(     Levany Veglia     )</td></tr>
</tbody>
</table>

EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);			
		
		ob_end_clean();
		$pdf->Output('invoice.pdf', 'I');
		
	}	
	
	
}