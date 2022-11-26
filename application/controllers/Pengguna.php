<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."libraries/Server.php";

class Pengguna extends Server{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_User','mdl',TRUE);
    }
    public function service_get(){
		$search = $this->get('search');
		if($search==null){
			$hasil = $this->mdl->get_data();
		}else{
			$hasil = $this->mdl->get_data($search);
		}
        $this->response($hasil);
    }
    public function service_delete($username){
        $hasil = $this->mdl->delete_data($username);

        if($hasil==1){
            $this->response([
                "status" => "Data User Berhasil Dihapus"
            ],200);
        }else{
            $this->response([
                "status" => "Data User Gagal Dihapus"
            ],200);
        }
    }

    function service_post(){
		// // panggil model Mmahasiswa
		// $this->load->model("Mmahasiswa","model",TRUE);

		// membuat data array untuk mengambil parameter data yang akan diisi
		$data = [
			"username" => $this->post("username"),
			"email" => $this->post("email"),
			"password" => $this->post("password"),
			"nama_lengkap" => $this->post("nama_lengkap"),
			"no_hp" => $this->post("no_hp"),
			"level" => $this->post("level"),
			
		];

		// panggil method save_data, dengan memasukkan argumen berupa array
		$hasil = $this->mdl->save_data($data['username'] ,$data['email'],$data['password'],$data['nama_lengkap'],$data['no_hp'],$data['level']);

		// jika hasil = 0, kenapa 0 karena kita akan memasukkan data yang belum ada di dalam database
		if($hasil==0){
			$this->response(array("status" => "Data User Berhasil Disimpan"),200);
		}
		// jika hasil tidak sama dengan 0
		else{
			$this->response(array("status" => "Data User Gagal Disimpan"),200);
		}

	}

    function service_put(){
		// // panggil model Mmahasiswa
		// $this->load->model("Mmahasiswa","model",TRUE);

		// membuat data array untuk mengambil parameter data yang akan diisi
		$data = [
			"username" => $this->put("username"),
			"email" => $this->put("email"),
			"password" => $this->put("password"),
			"nama_lengkap" => $this->put("nama_lengkap"),
			"no_hp" => $this->put("no_hp"),
			"level" => $this->put("level"),
			"token" => $this->put('token')
		];

        

		// panggil method update_data, dengan memasukkan argumen berupa array
		$hasil = $this->mdl->update_data($data['username'] ,$data['email'],$data['password'],$data['nama_lengkap'],$data['no_hp'],$data['level'],$data['token']);

        
		// jika hasil = 0, kenapa 0 karena kita akan memasukkan data yang belum ada di dalam database
		if($hasil==1){
			$this->response(array("status" => 'Data Berhasil Diubah'),200);
		}
		// jika hasil tidak sama dengan 0
		else{
			$this->response(array("status" => 'Data Berhasil Diubah'),200);
		}
		
	}
}