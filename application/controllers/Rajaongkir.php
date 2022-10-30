<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Rajaongkir extends CI_Controller{
    public function index(){
        $data['ongkir'] = '';
        if(count($_POST)){
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=".$this->input->post('kota')."&destination=".
            $this->input->post('kota_penerima')."&weight=".$this->input->post('berat')."&courier=".
            $this->input->post('ekspedisi'),
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: 92114ef07b2b605ac63e62b05da1bba6"
            ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
            echo "cURL Error #:" . $err;
            } else {
                $data['ongkir'] = $response;
            }
        }
        $this->load->view('rajaongkir_v',$data);
    }
    public function kota($provinsi){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/city?&province=".$provinsi,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: 92114ef07b2b605ac63e62b05da1bba6"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
            $kota = json_decode($response,true);

            if ($kota['rajaongkir']['status']['code'] == '200'){
                echo "<option value=''>Pilih Kota</option>";
                foreach ($kota['rajaongkir']['results'] as $kt){
                    echo "<option value='$kt[city_id]'>$kt[city_name] </option>";
                }
            }
        }
    }
}