<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class User extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('text');
        $this->load->library('session');
        $this->load->model('user_model');
        $this->load->helper('form', 'url');
        $this->load->library('form_validation');
        $this->isLoggedIn();
        $this->load->library("PHPExcel"); // Pastikan library PHPExcel sudah di-load
    }

    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'Four Best Energy : Dashboard';
        $data['pengguna'] = $this->user_model->countpengguna();
        $data['diskusi'] = $this->user_model->countBeritapengguna();
        $data['berita'] = $this->user_model->countBeritaSekolah();
        $this->loadViews("dashboard", $this->global, $data, NULL);
    }



    /**
     * This function is used to load the user list
     */
    function userListing()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $this->load->model('user_model');

            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;

            $this->load->library('pagination');

            $count = $this->user_model->userListingCount($searchText);

            $returns = $this->paginationCompress("userListing/", $count, 5);

            $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = 'Four Best Energy : User Listing';

            $this->loadViews("users", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $this->load->model('user_model');
            $data['roles'] = $this->user_model->getUserRoles();

            $this->global['pageTitle'] = 'Four Best Energy : Add New User';

            $this->loadViews("addNew", $this->global, $data, NULL);
        }
    }


    /**
     * This function is used to check whether email already exist or not
     */
    function checkEmailExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if (empty($userId)) {
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if (empty($result)) {
            echo ("true");
        } else {
            echo ("false");
        }
    }
    function checkEmailpengguna()
    {
        $id_pengguna = $this->input->post("id_pengguna");
        $email = $this->input->post("email");
        $mobile = $this->input->post("mobile");

        if (empty($id_pengguna)) {
            $result = $this->user_model->checkEmailpengguna($email, $mobile);
        } else {
            $result = $this->user_model->checkEmailpengguna($email, $mobile, $id_pengguna);
        }

        if (empty($result)) {
            echo ("true");
        } else {
            echo ("false");
        }
    }

    /**
     * This function is used to add new user to the system
     */
    function addNewUser()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('fname', 'Full Name', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('password', 'Password', 'required|max_length[20]');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]|max_length[20]');
            $this->form_validation->set_rules('role', 'Role', 'trim|required|numeric');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|min_length[10]');

            if ($this->form_validation->run() == FALSE) {
                $this->addNew();
            } else {
                $name = ucwords(strtolower($this->input->post('fname')));
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->input->post('mobile');

                $userInfo = array(
                    'email' => $email, 'password' => getHashedPassword($password), 'roleId' => $roleId, 'name' => $name,
                    'mobile' => $mobile, 'createdBy' => $this->vendorId, 'createdDtm' => date('Y-M-d H:i:s')
                );

                $this->load->model('user_model');
                $result = $this->user_model->addNewUser($userInfo);

                if ($result > 0) {
                    $this->session->set_flashdata('success', 'New User created successfully');
                } else {
                    $this->session->set_flashdata('error', 'User creation failed');
                }

                redirect('addNew');
            }
        }
    }


    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editOld($userId = NULL)
    {
        if ($this->isAdmin() == TRUE || $userId == 1) {
            $this->loadThis();
        } else {
            if ($userId == null) {
                redirect('userListing');
            }

            $data['roles'] = $this->user_model->getUserRoles();
            $data['userInfo'] = $this->user_model->getUserInfo($userId);

            $this->global['pageTitle'] = 'Four Best Energy : Edit User';

            $this->loadViews("editOld", $this->global, $data, NULL);
        }
    }


    /**
     * This function is used to edit the user information
     */
    function editUser()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $userId = $this->input->post('userId');

            $this->form_validation->set_rules('fname', 'Full Name', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('password', 'Password', 'matches[cpassword]|max_length[20]');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'matches[password]|max_length[20]');
            $this->form_validation->set_rules('role', 'Role', 'trim|required|numeric');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|min_length[10]');

            if ($this->form_validation->run() == FALSE) {
                $this->editOld($userId);
            } else {
                $name = ucwords(strtolower($this->input->post('fname')));
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->input->post('mobile');

                $userInfo = array();

                if (empty($password)) {
                    $userInfo = array(
                        'email' => $email, 'roleId' => $roleId, 'name' => $name,
                        'mobile' => $mobile, 'updatedBy' => $this->vendorId, 'updatedDtm' => date('Y-m-d H:i:s')
                    );
                } else {
                    $userInfo = array(
                        'email' => $email, 'password' => getHashedPassword($password), 'roleId' => $roleId,
                        'name' => ucwords($name), 'mobile' => $mobile, 'updatedBy' => $this->vendorId,
                        'updatedDtm' => date('Y-m-d H:i:s')
                    );
                }

                $result = $this->user_model->editUser($userInfo, $userId);

                if ($result == true) {
                    $this->session->set_flashdata('success', 'User updated successfully');
                } else {
                    $this->session->set_flashdata('error', 'User updation failed');
                }

                redirect('userListing');
            }
        }
    }


    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser()
    {
        if ($this->isAdmin() == TRUE) {
            echo (json_encode(array('status' => 'access')));
        } else {
            $userId = $this->input->post('userId');
            $userInfo = array('isDeleted' => 1, 'updatedBy' => $this->vendorId, 'updatedDtm' => date('Y-m-d H:i:s'));

            $result = $this->user_model->deleteUser($userId, $userInfo);

            if ($result > 0) {
                echo (json_encode(array('status' => TRUE)));
            } else {
                echo (json_encode(array('status' => FALSE)));
            }
        }
    }

    /**
     * This function is used to load the change password screen
     */
    function loadChangePass()
    {
        $this->global['pageTitle'] = 'Four Best Energy : Change Password';

        $this->loadViews("changePassword", $this->global, NULL, NULL);
    }


    /**
     * This function is used to change the password of the user
     */
    function changePassword()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('oldPassword', 'Old password', 'required|max_length[20]');
        $this->form_validation->set_rules('newPassword', 'New password', 'required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword', 'Confirm new password', 'required|matches[newPassword]|max_length[20]');

        if ($this->form_validation->run() == FALSE) {
            $this->loadChangePass();
        } else {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');

            $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);

            if (empty($resultPas)) {
                $this->session->set_flashdata('nomatch', 'Your old password not correct');
                redirect('loadChangePass');
            } else {
                $usersData = array(
                    'password' => getHashedPassword($newPassword), 'updatedBy' => $this->vendorId,
                    'updatedDtm' => date('Y-m-d H:i:s')
                );

                $result = $this->user_model->changePassword($this->vendorId, $usersData);

                if ($result > 0) {
                    $this->session->set_flashdata('success', 'Password updation successful');
                } else {
                    $this->session->set_flashdata('error', 'Password updation failed');
                }

                redirect('loadChangePass');
            }
        }
    }

    function pageNotFound()
    {
        $this->global['pageTitle'] = 'Four Best Energy : 404 - Page Not Found';

        $this->loadViews("404", $this->global, NULL, NULL);
    }
    // END DATA USER




    /**
     * Data pengguna
     */
    public function pengguna()
    {

        $this->global['pageTitle'] = 'Four Best Energy : Data pengguna';
        $data['x'] = $this->user_model->get_pengguna()->result();
        $this->loadViews("User/pengguna", $this->global, $data, NULL);
    }
    public function tambah_pengguna()
    {

        $this->load->model('user_model');
        $data['x'] = $this->user_model->get_pengguna()->result();
        $this->global['pageTitle'] = 'Four Best Energy : Add New pengguna';

        $this->loadViews("User/tambah_pengguna", $this->global, $data, NULL);
    }

    public function detailAlum($id)
    {
        $this->load->model('user_model');
        $detail = $this->user_model->detailpengguna($id);
        $data['detail'] = $detail;
        $this->global['pageTitle'] = 'Four Best Energy : Detail User ';
        $this->loadViews("User/detail_pengguna", $this->global, $data, NULL);
    }


    public function newpengguna()
    {
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->form_validation->set_rules(
            'npwp',
            'NPWP',
            'required|min_length[3]|max_length[15]|is_unique[tbl_pengguna.npwp]',
            array(
                'required'      => 'You have not provided %s.',
                'is_unique'     => '%s ini telah digunakan.'
            )
        );
        $this->form_validation->set_rules(
            'username',
            'Username',
            'required|min_length[3]|max_length[15]|is_unique[tbl_pengguna.username]',
            array(
                'required'      => 'You have not provided %s.',
                'is_unique'     => '%s ini telah digunakan.'
            )
        );
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Konfirmasi Password ', 'required|trim|min_length[3]|matches[password]');


        if ($this->form_validation->run() == false) {

            $this->tambah_pengguna();
        } else {
            if ($this->input->post('submit')) {
                //Check whether user upload picture

                //Prepare array of user data
                $data = array(
                    'npwp' => $this->input->post('npwp'),
                    'username' => $this->input->post('username'),
                    'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'img' => 'default.jpg'
                );

                //Pass user data to model
                $insertUserData = $this->user_model->insert($data);

                //Storing insertion status message.
                if ($insertUserData) {
                    $this->session->set_flashdata('success_msg', 'Sukses Menambahkan pengguna !!');
                } else {
                    $this->session->set_flashdata('error_msg', ' Error, Kesalahan Menambahkan Data!!');
                }
            }

            //Form for adding user data
            redirect('pengguna');
        }
    }


    public function Work()
    {
        $this->global['pageTitle'] = 'Four Best Energy : Data Upload';
        $data['work'] = $this->user_model->detailupload()->result();
        $this->loadViews("User/work",  $this->global, $data, NULL);
    }

    public function upload_work()
    {
        $this->form_validation->set_rules('file', 'File', 'callback_file_check');

        if ($this->form_validation->run() == false) {
            $this->load->view('work');
        } else {
            $tmp_name = $_FILES["file"]["tmp_name"];
            $excel = PHPExcel_IOFactory::load($tmp_name);

            $data = [];
            foreach ($excel->getWorksheetIterator() as $worksheet) {
                $row = $worksheet->getHighestRow();
                for ($i = 2; $i <= $row; $i++) {
                    $id_dipotong = $worksheet->getCellByColumnAndRow(0, $i)->getValue();
                    $nama = $worksheet->getCellByColumnAndRow(1, $i)->getValue();
                    $pasal = $worksheet->getCellByColumnAndRow(2, $i)->getValue();
                    $kode_objek_pajak = $worksheet->getCellByColumnAndRow(3, $i)->getValue();
                    $no_bukti_potong = $worksheet->getCellByColumnAndRow(4, $i)->getValue();
                    $tanggal_bupot = $worksheet->getCellByColumnAndRow(5, $i)->getValue();
                    $pph_potong = $worksheet->getCellByColumnAndRow(6, $i)->getValue();
                    $jumlah_bruto = $worksheet->getCellByColumnAndRow(7, $i)->getValue();
                    $data[] = [
                        "id_potong"        => $id_dipotong,
                        "nama_file"             => $nama,
                        "pasal"            => $pasal,
                        "kode_objek_pajak" => $kode_objek_pajak,
                        "no_bukti_potong"  => $no_bukti_potong,
                        "tanggal_bupot"    => $tanggal_bupot,
                        "pph_potong"       => $pph_potong,
                        "jumlah_bruto"     => $jumlah_bruto,
                    ];
                }
            }

            if (!empty($data)) {
                $this->user_model->upload_excel($data);
                $this->session->set_flashdata('success_msg', 'Data berhasil di-import ke database.');
            } else {
                $this->session->set_flashdata('error_msg', 'Tidak ada data yang di-import.');
            }

            redirect('work');
        }
    }

    public function file_check($str)
    {
        $allowed_mime_type_arr = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
        $mime = get_mime_by_extension($_FILES['file']['name']);
        if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
            if (in_array($mime, $allowed_mime_type_arr)) {
                return true;
            } else {
                $this->form_validation->set_message('file_check', 'Silakan pilih hanya file excel.');
                return false;
            }
        } else {
            $this->form_validation->set_message('file_check', 'Silakan pilih file untuk diunggah.');
            return false;
        }
    }

    public function deletework($id)
    {
        $query = $this->user_model->deletework($id);
        $this->session->set_flashdata('success_msg', 'Sukses Mengahpus Berita !!');
        //Form for delete data Berita
        redirect('work');
    }

    public function cetakpdf($jenis = 'pdf')
    {

        if ($jenis == 'pdf') {
            $data['detail'] = $this->user_model->get_pengguna('tbl_pengguna')->result();
            $html = $this->load->view('User/laporan_pdf', $data, TRUE);
            // echo $html;
            generatePdf($html, 'Data pengguna SMPN 25 Pekanbaru', 'A4', 'landscape');
        }
        // $this->load->library('dompdf_gen');
        // $data['detail'] = $this->user_model->get_pengguna('tbl_pengguna')->result();

        // $this->load->view('User/laporan_pdf', $data);

        // $paper_size = 'A4';
        // $orientation = 'landscape';
        // $html = $this->output->get_output();
        // $this->dompdf->set_paper($paper_size, $orientation);

        // $this->dompdf->load_html($html);
        // $this->dompdf->render();
        // $this->dompdf->stream("Data pengguna SMPN 25 Pekanbaru", array('Attachment' => 0));
    }


    function deletepengguna($id)
    {
        $this->user_model->deletejointable($id);
        $this->session->set_flashdata('success_msg', 'Sukses Mengahpus Berita !!');
        redirect('pengguna');
    }

    function prosesupdate()
    {

        $this->form_validation->set_rules(
            'password',
            'Password Baru',
            'required|trim|min_length[3]|matches[password2]'
        );
        $this->form_validation->set_rules(
            'password2',
            'Konfirmasi Password Baru',
            'required|trim|min_length[3]|matches[password]'
        );

        if ($this->form_validation->run() == FALSE) {   //validation fails
            $this->session->set_flashdata('error_msg', 'Error !! Ubah Password');
            redirect('pengguna');
        } else {
            $id = $this->input->post('id_pengguna');
            $newpassword = $this->input->post('password');
            $password_hash = password_hash($newpassword, PASSWORD_DEFAULT);
            $this->db->set('password', $password_hash);
            $this->db->where('id_pengguna', $id);
            $this->db->update('tbl_pengguna');
            $this->session->set_flashdata('success_msg', 'Sukses Update Status Data !!');
            redirect('pengguna');
        }
    }
    function updateStatuspengguna()
    {
        $id = $this->input->post('id_pengguna');
        $data = array(
            'status' => $this->input->post('status'),
            'modified' => date("Y-M-d H:i:s"),
        );
        $this->user_model->updatestatuspengguna($id, $data);
        $this->session->set_flashdata('success_msg', 'Sukses Update Status Data !!');

        redirect('pengguna');
    }



    // END DATA pengguna

    // LIST BERITA pengguna DAHSBORD ADMIN 

}