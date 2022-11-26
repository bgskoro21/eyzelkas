<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_User extends CI_Model{

    public function get_data($search=null){
        if($search==null){
            $query = $this->db->get('user')->result();
        }else{
            $this->db->from('user');
            $this->db->like('username',$search);
            $this->db->or_like('level',$search);
            $query = $this->db->get()->result();
        }
        return $query;
    }

    public function login($username,$password ){
        $this->db->select('username,email,nama_lengkap');
        $this->db->from('user');
        $this->db->where("username = '$username' AND password = '$password' ");
        $query = $this->db->get()->result();

        if(count($query) == 1){
            $hasil = $query;
        }else{
            $hasil = null;
        }
        return $hasil;
    }

    public function delete_data($username){
        $this->db->select('username');
        $this->db->from('user');
        $this->db->where("username = '$username' ");
        $query = $this->db->get()->result();

        if(count($query) == 1){
            $this->db->where("username = '$username' ");
            $this->db->delete('user');
            $hasil = 1;
        }else{
            $hasil=0;
        }
        return $hasil;
    }

    function save_data($username, $email, $password, $namalengkap,$nohp,$level){
        // cek apakah npm ada atau tidak
        $this->db->select('username');
        $this->db->from("user");
        // teknik enkripsi
        $this->db->where("username = '$username'");
        // eksekusi query delete data
        $query = $this->db->get()->result();
        // jika npm tidak ditemukan
        if(count($query) == 0){
            // proses memasukkan data ke dalam array
            $data = array(
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'nama_lengkap' => $namalengkap,
                'no_hp' => $nohp,
                'level' => $level
            );

            // melakukan query simpan
            $this->db->insert('user',$data);
            $hasil = 0;
        }
        // jika npm ditemukan artinya data sudah ada 
        else{
            $hasil = 1;
        }

        return $hasil;
    }

    public function update_data($username, $email, $password, $namalengkap,$nohp,$level, $token){
        // cek apakah npm ada atau tidak
        $this->db->select('username');
        $this->db->from("user");
        // query untuk mencari data berdasarkan npm yang di encode dan juga npm biasa
        // Conditional agar menghasilkan nilai 0
        $this->db->where("username = '$token'");
        // eksekusi query delete data
        $query = $this->db->count_all_results();

        if($query == 1){
             // proses memasukkan data ke dalam array
             $data = array(
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'nama_lengkap' => $namalengkap,
                'no_hp' => $nohp,
                'level' => $level
            );

             // ubah data mahasiswa
             $this->db->where("username = '$token'");
             $this->db->update("user",$data);
             $hasil = 1;
        }else{
            $hasil = 0;
        }

        return $hasil;
    }
}