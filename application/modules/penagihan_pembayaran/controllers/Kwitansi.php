<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Kwitansi extends CI_Controller {
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

        $this->load->view('kwitansi_v',$data);
        
        $this->load->view('templates/footer-top');
        // js for this page only
        $this->load->view('kwitansi_js');
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
            //(cek_akses_user()['hapus'] == 1 ? ' <a href="#" ><span class="badge badge-danger btn-hapus" data-jenis_action="hapus" data-id="'.md5($data['id']).'">Hapus</span></a>' : '').
			(1 == 1 ? ' <a href="#" ><span class="badge badge-warning btn-print" data-jenis_action="hapus" data-id="'.md5($data['id']).'">Print</span></a>' : '');

            // column buat data tables --
            $row = [
			'invoice_no' => str_replace("PRO","KWI",$data['invoice_no']),
			'kwitansi_no'=> $data['invoice_no'],
            'nama_pelanggan' => $data['nama_pelanggan'],
			//'items' => $this->json_description($data['items']),
			//'faktur_number' => $data['faktur_number'],
			'status' => (($data['status'] == null)?'BLM DIBAYAR':'SUDAH DIBAYAR'),
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

	public function printkwitansi($id)
	{

		$pdf = new MyTCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetMargins(10, 10, 10, 10);
		$pdf->SetHeaderMargin(25);
		$pdf->SetFooterMargin(10);

// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
//$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetAuthor('Nicola Asuni');
//$pdf->SetTitle('TCPDF Example 061');
//$pdf->SetSubject('TCPDF Tutorial');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 061', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 12);

// add a page
$pdf->AddPage();

/* NOTE:
 * *********************************************************
 * You can load external XHTML using :
 *
 * $html = file_get_contents('/path/to/your/file.html');
 *
 * External CSS files will be automatically loaded.
 * Sometimes you need to fix the path of the external CSS.
 * *********************************************************
 */

$url_image = base_url() . "assets/images/logo_alto.png" ;	

		$data = $this->Data_model->edit_get($id);
		$customer = $this->Data_model->customer_profile($data['customer_id']);
		$proforma_invoices_join = $this->Data_model->list_proforma_invoices_join($data['invoice_no']);
		
	$no_kwitansi = str_replace("PRO","KWI",$data['invoice_no']);	
		
$items = "";
$i = 0;

$total_price_all = 0;


if(!empty($proforma_invoices_join)) {
	
	$items .= "<table>";
	foreach ($proforma_invoices_join as $item) {
		$i++;
		$total_price = (double)$item['jumlah'] * (double)$item['harga'];
		$total_price_all += $total_price;
		$items .= "<tr><td style=\"width: 5%;\">$i</td><td style=\"width: 58%;\">$item[nama_produk]</td><td style=\"width: 7%;\">$item[satuan]</td><td style=\"width: 10%;\">$item[jumlah]</td><td style=\"width: 20%;text-align:left;\">".rupiah($total_price)."</td></tr>";
		
	}
	$items .= "</table>";
	
}

$total_price_all_tax = $total_price_all * 0.11;

$total_price_all_tax_plus_all = $total_price_all_tax + $total_price_all;

$terbilang = $this->terbilang($total_price_all_tax_plus_all);

$total_price_all_format = rupiah($total_price_all); //number_format($total_price_all, 0, ',', ',');
$total_price_all_tax_format = rupiah($total_price_all_tax);//number_format($total_price_all_tax, 0, ',', ',');
$total_price_all_tax_plus_all_format = rupiah($total_price_all_tax_plus_all); //number_format($total_price_all_tax_plus_all, 0, ',', ',');

$tanggal = date('d-m-Y');

// define some HTML content with style
$html = <<<EOF
<!-- EXAMPLE OF CSS STYLE -->
<style>
    h1 {
        color: navy;
        font-family: times;
        font-size: 24pt;
        text-decoration: underline;
    }
    p.first {
        color: #003300;
        font-family: helvetica;
        font-size: 12pt;
    }
    p.first span {
        color: #006600;
        font-style: italic;
    }
    p#second {
        color: rgb(00,63,127);
        font-family: times;
        font-size: 12pt;
        text-align: justify;
    }
    p#second > span {
        background-color: #FFFFAA;
    }
    table.first {
        color: #003300;
        font-family: helvetica;
        font-size: 12pt;
        #border-left: 3px solid red;
        #border-right: 3px solid #FF00FF;
        #border-top: 3px solid green;
        #border-bottom: 3px solid blue;
        background-color: #ccffcc;
    }
    td {
        #border: 2px solid blue;
        #background-color: #ffffee;
    }
    td.second {
        border: 2px dashed green;
    }
    div.test {
        color: #CC0000;
        background-color: #FFFF66;
        font-family: helvetica;
        font-size: 10pt;
        border-style: solid solid solid solid;
        border-width: 2px 2px 2px 2px;
        border-color: green #FF00FF blue red;
        text-align: center;
    }
    .lowercase {
        text-transform: lowercase;
    }
    .uppercase {
        text-transform: uppercase;
    }
    .capitalize {
        text-transform: capitalize;
    }
</style>

<table class="first1" cellpadding="4" cellspacing="6">
 <tr>
  <td width="33.3%" align="center"><table><tr><td><img src="$url_image" alt="" width="150" /></td></tr><tr><td><b>Jl Bojong Raya No. 10 Jakarta Barat</b></td></tr></table></td>
  <td width="33.3%" align="center" bgcolor="#FFFFFF"> </td>
  <td width="33.3%" align="center"><table><tr><td><b>KWITANSI</b></td></tr><tr><td><b>Nomor : $no_kwitansi</b></td></tr></table></td>
 </tr>
  <tr>
  <td width="100%" align="left" colspan="3">
  <table>
	<tr style="vertical-align:middle;"><td width="23.3%">Terima Dari</td><td width="3.3%">:</td><td width="43.3%">$customer[nama_pelanggan]</td><td width="30%" rowspan="2" align="center" style="height: 30px;vertical-align: middle;padding: 5px;" style="border-style: solid solid solid solid;"><b>$total_price_all_tax_plus_all_format</b></td></tr>
	<tr><td>Alamat</td><td>:</td><td>$customer[alamat]</td></tr>
	<tr><td>Uang Sebanyak</td><td>:</td><td colspan="3" style="font-size: 16pt;"><b>$terbilang</b></td></tr>
  </table>
  </td>
 </tr>
  <tr>
  <td width="100%" align="center" colspan="3" style="border-style: solid solid solid solid;">$items</td>
 </tr>
  <tr>
  <td width="100%" align="center" colspan="3">Total Harga ( termasuk PPN 11% )   :  <b>$total_price_all_tax_plus_all_format</b></td>
 </tr>
  <tr>
  <td width="100%" align="left" colspan="3" style="font-size: 10pt;"><b>Pembayaran ke : BCA a/c 879.120.030.0 a/n PT ALTO ANUGERAH ABADI</b></td>
 </tr> 
 <tr>
  <td width="33.3%" align="center">Ketentuan : Pembayaran dengan Cek/Giro dianggap sah apabila Cek/Giro dapat diuangkan.</td>
  <td width="33.3%" align="center" bgcolor="#FFFFFF"> </td>
  <td width="33.3%" align="center">Jakarta, $tanggal</td>
 </tr>
</table>
EOF;

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//============================================================+
// END OF FILE
//============================================================+
		
		ob_end_clean();
		$pdf->Output('kwitansi.pdf', 'I');
		
	}

	function kata($x)
	{
		$x = abs($x);
		$angka = array(
			"", "satu", "dua", "tiga", "empat", "lima",
			"enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"
		);
		$temp = "";
		if ($x < 12) {
			$temp = " " . $angka[$x];
		} else if ($x < 20) {
			$temp = $this->kata($x - 10) . " belas";
		} else if ($x < 100) {
			$temp = $this->kata($x / 10) . " puluh" . $this->kata($x % 10);
		} else if ($x < 200) {
			$temp = " seratus" . $this->kata($x - 100);
		} else if ($x < 1000) {
			$temp = $this->kata($x / 100) . " ratus" . $this->kata($x % 100);
		} else if ($x < 2000) {
			$temp = " seribu" . $this->kata($x - 1000);
		} else if ($x < 1000000) {
			$temp = $this->kata($x / 1000) . " ribu" . $this->kata($x % 1000);
		} else if ($x < 1000000000) {
			$temp = $this->kata($x / 1000000) . " juta" . $this->kata($x % 1000000);
		} else if ($x < 1000000000000) {
			$temp = $this->kata($x / 1000000000) . " milyar" . $this->kata(fmod($x, 1000000000));
		} else if ($x < 1000000000000000) {
			$temp = $this->kata($x / 1000000000000) . " trilyun" . $this->kata(fmod($x, 1000000000000));
		}
		return $temp;
	}

	function terbilang($x, $style = 3)
	{
		if ($x < 0) {
			$hasil = "minus " . trim($this->kata($x));
		} else {
			$hasil = trim($this->kata($x));
		}
		switch ($style) {
			case 1:
				// mengubah semua karakter menjadi huruf besar
				$hasil = strtoupper($hasil);
				break;
			case 2:
				// mengubah karakter pertama dari setiap kata menjadi huruf besar
				$hasil = ucwords($hasil);
				break;
			case 3:
				// mengubah karakter pertama menjadi huruf besar
				$hasil = ucfirst($hasil);
				break;
		}
		return $hasil;
	}	
	
	
}