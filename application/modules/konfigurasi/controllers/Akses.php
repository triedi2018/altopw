<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Akses extends CI_Controller {
    private $cek_akses_user;
    public function __construct(){
        parent::__construct();
        cek_aktif_login();
        $this->cek_akses_user = cek_akses_user();
        $this->load->model('Akses_m','Data_model');
    }

    public function index(){
        
        $data['main_menu'] = main_menu();
        $data['sub_menu'] = sub_menu();

        $this->load->view('templates/header-top');
        //css for this page only
        
        //======== end
        $this->load->view('templates/header-bottom');
        $this->load->view('templates/header-notif');
        $this->load->view('templates/main-navigation',$data);

        $data['list_level_user'] = $this->Data_model->list_level_user();
        $this->load->view('akses_v',$data);
        
        $this->load->view('templates/footer-top');
        // js for this page only
        $this->load->view('akses_js');
        //========= end
        $this->load->view('templates/footer-bottom');

        
    }
    public function edit(){
        if ($this->cek_akses_user['edit'] != '1'){
            redirect(base_url('unauthorized'));
        }
        $data['list_menu'] = $this->Data_model->list_menu();
        $this->load->view('akses_edit_v',$data);
    }
    public function simpan(){
        if ($this->cek_akses_user['edit'] != '1'){
            redirect(base_url('unauthorized'));
        }
        $this->Data_model->simpan();
        redirect(base_url($this->uri->segment(1,0).$this->uri->slash_segment(2,'both')));
        
    }
}