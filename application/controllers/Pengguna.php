<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Login (LoginController)
 * Login class to control to authenticate user credentials and starts user's session.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Pengguna extends CI_Controller
{
    /**
     * This is default constructor of the class
     */

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('text');
        $this->load->model('pengguna_model');
        $this->load->model('user_model');
        $this->load->library('session');
        $this->load->library('form_validation');
        if ($this->session->userdata('login') != true) {
            redirect(base_url("viewpenggunaLogin"));
        }
    }

    public function index()
    {
        $data['title'] = 'Dahsbord';
        $data['user'] = $this->db->get_where('tbl_pengguna', ['username' =>
        $this->session->userdata('username')])->row_array();
        $data['pengguna'] = $this->pengguna_model->countpenggunai();
        $data['diskusi'] = $this->pengguna_model->countBeritapenggunai($data['user']);
        $this->load->view('dashbordPengguna/header', $data);
        $this->load->view('dashbordPengguna/mid');
        $this->load->view('dashbordPengguna/footer');
    }




    public function profilePengguna()
    {
        $data['user'] = $this->db->get_where('tbl_pengguna', ['username' =>
        $this->session->userdata('username')])->row_array();
        $data['title'] = 'Profile Pengguna';
        $this->load->view('dashbordPengguna/header', $data);
        $this->load->view('dashbordPengguna/profile');
        $this->load->view('dashbordPengguna/footer');
    }




    public function editProfile()
    {

        $data['user'] = $this->db->get_where('tbl_pengguna', ['id_pengguna' =>
        $this->session->userdata('id_pengguna')])->row_array();
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->form_validation->set_rules('nama', 'nama', 'trim|required|max_length[128]');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|min_length[10]|max_length[13]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required|max_length[128]');
        $this->form_validation->set_rules('ni', 'Nama Instansi', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->profilePengguna()();
        } else {
            $this->load->library('upload');
            $path = 'assets/img/';
            $config['upload_path'] = 'assets/img/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']     = '3048';
            $config['file_name'] = $_FILES['img']['name'];

            $this->upload->initialize($config);
            $id = $this->input->post('id_pengguna');
            $gambar_lama = $this->input->post('new_img');
            if ($_FILES['img']['name']) {
                $field_name = "img";
                if ($this->upload->do_upload($field_name)) {
                    $img = $this->upload->data();
                    //compres ukuran gambar
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = 'assets/img/' . $img['file_name'];
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = FALSE;
                    $config['quality'] = '50%';
                    $config['width'] = 500;
                    $config['height'] = 700;
                    $config['new_image'] = 'assets/img/' . $img['file_name'];
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();

                    $user = ([

                        'username' => $this->input->post('username'),
                        'nama' => $this->input->post('nama'),
                        'mobile' => $this->input->post('mobile'),
                        'email' => $this->input->post('email'),
                        'nama_instansi' => $this->input->post('ni'),
                        'alamat' => $this->input->post('alamat'),
                        'modified' => date("Y-m-d H:i:s"),
                        'img' => $img['file_name']

                    ]);
                    $user1 = ([
                        'username' => $this->input->post('username'),
                        'img' => $img['file_name'],
                    ]);


                    @unlink($path, $gambar_lama);
                    $data = array_merge($user);
                    $where = array('id_pengguna' => $id);
                    $query = $this->pengguna_model->updatejointable('tbl_pengguna', $data, $where);
                    $query2 = $this->pengguna_model->updatejointable('tbl_diskusi', $user1, $where);

                    if ($query && $query2 == true) {
                        $this->session->set_flashdata('success_msg', 'Sukses Update Profil !!');
                        redirect('profilepengguna');
                    } else {
                        $this->session->set_flashdata('error_msg', 'Error, Update Profil !!');
                        redirect('profilepengguna');
                    }
                }
            }
        }
        if ($_FILES['img'] != null) {
            $id = $this->input->post('id_pengguna');
            $data = array(
                'username' => $this->input->post('username'),
                'nama' => $this->input->post('nama'),
                'mobile' => $this->input->post('mobile'),
                'email' => $this->input->post('email'),
                'nama_instansi' => $this->input->post('ni'),
                't_msk' => $this->input->post('tmsk'),
                't_tmt' => $this->input->post('tklr'),
                'pekerjaan' => $this->input->post('pekerjaan'),
                'jenis_kelamin' => $this->input->post('jk'),
                'tgl_lahir' => $this->input->post('tgllahir'),
                'alamat' => $this->input->post('alamat'),
                'prestasi' => $this->input->post('prestasi'),
                'modified' => date("Y-m-d H:i:s"),
            );

            $this->db->where('id_pengguna', $id);
            $this->db->update('tbl_pengguna', $data);
            $this->session->set_flashdata('success_msg', 'Sukses Update Profil !!');
            //Form for update profile
            redirect('profilepengguna');
        }
    }


    function DataUpload()
    {
        $data['user'] = $this->db->get_where('tbl_pengguna', ['username' =>
        $this->session->userdata('username')])->row_array();
        $data['title'] = 'Profile Pengguna';
        $this->global['pageTitle'] = 'Four Best Energy : Data Upload';
        $data['work'] = $this->user_model->detailupload()->result();
        $this->load->view('dashbordPengguna/header', $data);
        $this->load->view('dashbordPengguna/pajak', $data);
        $this->load->view('dashbordPengguna/footer');
    }
    public function cetak_upload($jenis = 'pdf')
    {

        if ($jenis == 'pdf') {
            $data['detail'] = $this->pengguna_model->get_pajak('upload')->result();
            $html = $this->load->view('dashbordPengguna/laporan_upload_pdf', $data, TRUE);
            // echo $html;
            generatePdf($html, 'Data  Pajak ', 'A4', 'landscape');
        }
    }

    //change password pengguna
    function ChangePasswordpengguna()
    {
        $data['user'] = $this->db->get_where('tbl_pengguna', ['id_pengguna' =>
        $this->session->userdata('id_pengguna')])->row_array();
        $data['title'] = 'Change Password Profile ';

        $this->form_validation->set_rules('oldpassword', 'Password Lama', 'required|trim');
        $this->form_validation->set_rules('newpassword', 'Password Baru', 'required|trim|min_length[3]|matches[newpassword2]');
        $this->form_validation->set_rules('newpassword2', 'Konfirmasi Password Baru', 'required|trim|min_length[3]|matches[newpassword]');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('dashbordPengguna/header', $data);
            $this->load->view('dashbordPengguna/change_password', $data);
            $this->load->view('dashbordPengguna/footer');
        } else {
            $oldpassword = $this->input->post('oldpassword');
            $newpassword = $this->input->post('newpassword');
            if (!password_verify($oldpassword, $data['user']['password'])) {
                $this->session->set_flashdata('error_msg', ' Error, Password Tidak Sesuai !!');
                redirect('ChangePasswordpengguna');
            } else {
                if ($oldpassword == $newpassword) {
                    $this->session->set_flashdata('error_msg', ' Error, Gunakan Password Yang Baru !!');
                    redirect('ChangePasswordpengguna');
                } else {
                    // PASSWORD BENAR
                    $password_hash = password_hash($newpassword, PASSWORD_DEFAULT);
                    $this->db->set('password', $password_hash);
                    $this->db->where('username', $this->session->userdata('username'));
                    $this->db->update('tbl_pengguna');
                    $this->session->set_flashdata('success_msg', 'Sukses Ubah Password !!');
                    redirect('ChangePasswordpengguna');
                }
            }
        }
    }
    //
}