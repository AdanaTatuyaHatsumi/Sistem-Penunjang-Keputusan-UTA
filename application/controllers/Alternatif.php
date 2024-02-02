<?php 

class Alternatif extends CI_Controller{
    public function index(){

        $data['alternatif'] = $this->db->query("SELECT * FROM alternatif")->result();
        

        $data['kriteria'] = $this->db->query("SELECT * FROM kriteria")->result();
        

        $this->load->view('templates/header');
        $this->load->view('templates/navbar');
        $this->load->view('templates/settingPanel');
        $this->load->view('templates/sidebar');
        $this->load->view('alternatif',$data);
        $this->load->view('templates/footer');
    }
    public function tambahAlternatif(){


        $this->load->view('templates/header');
        $this->load->view('templates/navbar');
        $this->load->view('templates/settingPanel');
        $this->load->view('templates/sidebar');
        $this->load->view('tambahAlternatif');
        $this->load->view('templates/footer');
    }
    public function tambahAlternatifAksi(){
        $this->_rulesAlternatif();

        if ($this->form_validation->run() == FALSE) {
            $this->tambahAlternatif();
        } else {
            $alternatif = strtolower($this->input->post('kode'));
            
            $cek = $this->db->query("SELECT * FROM alternatif WHERE alternatif = '$alternatif'")->result();
            if (!empty($cek)) {
                $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Kode Alternatif Sudah Ada!</strong> Silahkan input ulang :)
              </div>');
              $this->tambahAlternatif();
            } else {
                $nama              = strtolower($this->input->post('alternatif'));
                $keterangan     = str_replace(" ","-",$nama);
                


                $data = array(
                    'alternatif'      =>  $alternatif,
                    'keterangan'   =>  $keterangan,
                );

                $this->CodasModel->insert_data($data,'alternatif');
                $this->session->set_flashdata('pesan','<div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>Data Berhasil Ditambahkan!</strong>
                </div>');
                redirect('alternatif');
            }
        }
    }
    public function editAlternatif($id){

        $data['selectAlternatif'] = $this->db->query("SELECT * FROM alternatif WHERE id = '$id'")->result();

        $this->load->view('templates/header');
        $this->load->view('templates/navbar');
        $this->load->view('templates/settingPanel');
        $this->load->view('templates/sidebar');
        $this->load->view('editAlternatif',$data);
        $this->load->view('templates/footer');
    }
    public function editAlternatifAksi(){
        $this->_rulesAlternatif();

        $id = $this->input->post('id');

        if ($this->form_validation->run() == FALSE) {
            $this->editAlternatif($id);
        } else {
            $alternatif = strtolower($this->input->post('kode'));
            $nama              = strtolower($this->input->post('alternatif'));
            $keterangan     = str_replace(" ","-",$nama);
                


            $data = array(
                'alternatif'      =>  $alternatif,
                'keterangan'   =>  $keterangan,
            );

            $where = array(
                'id'    => $id,
            );

            $this->CodasModel->update_data('alternatif',$data,$where);
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Data Berhasil Diupdate!</strong>
            </div>');
            redirect('alternatif');
        }
    }
    public function deleteAlternatif($alter){
        $where = array('alternatif' => $alter);
		$this->CodasModel->delete_data($where,'alternatif');
        $this->CodasModel->delete_data($where,'membentuk_matriks_keputusan');
        $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Data Berhasil Dihapus!</strong>
        </div>');

		redirect('alternatif');
    }
    public function _rulesAlternatif(){
        $this->form_validation->set_rules('kode','Code Alternatif','required');
        $this->form_validation->set_rules('alternatif','Alternatif','required');
    }
}

?>