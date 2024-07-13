<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */

    const SESSION_KEY = 'user_id';
    private $_table = "tbl_pengguna";
    private $_table1 = "tbl_kategori";
    private $_table2 = "kategori";
    private $_table3 = "upload";
    function userListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, Role.role');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId', 'left');
        if (!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%" . $searchText . "%'
                            OR  BaseTbl.name  LIKE '%" . $searchText . "%'
                            OR  BaseTbl.mobile  LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.roleId !=', 0);
        $query = $this->db->get();

        return count($query->result());
    }

    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function userListing($page, $segment, $searchText = '')
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, Role.role');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId', 'left');
        if (!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%" . $searchText . "%'
                            OR  BaseTbl.name  LIKE '%" . $searchText . "%'
                            OR  BaseTbl.mobile  LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.roleId =', 1);
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function getUserRoles()
    {
        $this->db->select('roleId, role');
        $this->db->from('tbl_roles');
        $this->db->where('roleId !=', 0);
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkEmailExists($email, $userId = 0)
    {
        $this->db->select("email");
        $this->db->from("tbl_users");

        $this->db->where("email", $email);
        $this->db->where("isDeleted", 0);
        if ($userId != 0) {
            $this->db->where("userId !=", $userId);
        }
        $query = $this->db->get();

        return $query->result();
    }

    function checkEmailpengguna($email, $mobile, $id_pengguna = 0)
    {
        $this->db->select('id_pengguna');
        $where = array(
            'email' => $email,
            'moobile'   => $mobile
        );
        $this->db->where($where);
        $this->db->where('isDeleted', 0);
        $query = $this->db->get('tbl_pengguna');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewUser($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_users', $userInfo);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfo($userId)
    {
        $this->db->select('userId, name, email, mobile, roleId');
        $this->db->from('tbl_users');
        $this->db->where('isDeleted', 0);
        $this->db->where('roleId !=', 0);
        $this->db->where('userId', $userId);
        $query = $this->db->get();

        return $query->result();
    }


    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function editUser($userInfo, $userId)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);

        return TRUE;
    }



    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);

        return $this->db->affected_rows();
    }

    /**
     * This function is used to match users password for change password
     * @param number $userId : This is user id
     */
    function matchOldPassword($userId, $oldPassword)
    {
        $this->db->select('userId, password');
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $query = $this->db->get('tbl_users');

        $user = $query->result();

        if (!empty($user)) {
            if (sha1($oldPassword, $user[0]->password)) {
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }


    /**
     * This function is used to change users password
     * @param number $userId : This is user id
     * @param array $userInfo : This is user updation info
     */
    function changePassword($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_users', $userInfo);

        return $this->db->affected_rows();
    }

    public function current_user()
    {

        if (!$this->session->hash_userdata(self::SESSION_KEY)) {
            return null;
        }
        $user_id = $this->session->userdata(self::SESSION_KEY);
        $query = $this->db->get_where($this->_table, ['id_pengguna' => $user_id]);
        return $query->row();
    }


    //COUNT DATA DASHBORD

    function countpengguna()
    {
        return $this->db->count_all("tbl_pengguna");
    }
    function countBeritapengguna()
    {
        $query = $this->db->query('SELECT * FROM tbl_diskusi WHERE status= "0"');
        $count = $query->num_rows();
        return $count;
    }
    function countBeritaSekolah()
    {
        return $this->db->count_all("tbl_berita");
    }


    // END
    // Data pengguna
    function addNewpengguna($data)
    {

        return $this->db->insert('tbl_pengguna', $data);
    }

    function get_pengguna()
    {
        $hsl = $this->db->get("tbl_pengguna");
        return $hsl;
    }
    // Tambah Data Pengguna
    public function insert($data)
    {
        if (!array_key_exists("created", $data)) {
            $data['created'] = date("Y-m-d H:i:s");
        }

        $insert = $this->db->insert($this->_table, $data);
        if ($insert) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    // Nambah pengguna Menggunakan Excel
    function fetch_data($record)
    {
        $this->db->insert_batch($this->_table, $record);
    }
    function upload_excel($data)
    {
        return $this->db->insert_batch('upload', $data);
    }
    function deletework($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('upload');
    }

    function editpengguna($data, $id_pengguna)
    {
        if (!array_key_exists("modified", $data)) {
            $data['modified'] = date("Y-m-d H:i:s");
        }
        $this->db->where('id_pengguna', $id_pengguna);
        $b = $this->db->update('tbl_pengguna', $data);

        if ($b) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    function detailpengguna($id = null)
    {
        $query = $this->db->get_where('tbl_pengguna', array('id_pengguna' => $id))->row();
        return $query;
    }

    function delpengguna($id)
    {

        return $query = $this->db->delete('tbl_pengguna', ['id_pengguna' => $id]);
    }
    function deletejointable($id)
    {
        $this->db->trans_start();
        $this->db->delete('tbl_pengguna', array('id_pengguna' => $id));
        $this->db->trans_complete();
    }
    function updatestatuspengguna($id, $data)
    {
        $this->db->where('id_pengguna', $id);
        $this->db->update('tbl_pengguna', $data);
    }
    function passwordpengguna($id, $data)
    {
        $this->db->where('id_pengguna', $id);
        $this->db->update('tbl_pengguna', $data);
    }
    // Nampilkan Data pengguna Ke Table
    function detailupload()
    {
        $hsl = $this->db->get("upload");
        return $hsl;
    }

    function editAlum($id = null)
    {
        $query = $this->db->get_where('tbl_pengguna', array('id_pengguna' => $id))->row();
        return $query;
    }
    // Detail Berita pengguna 


    // Delete Berita pengguna 

    function detailKategori()
    {
        $hsl = $this->db->get("tbl_kategori");
        return $hsl;
    }
    function TambahKategori($data)
    {
        if (!array_key_exists("created", $data)) {
            $data['created'] = date("Y-m-d H:i:s");
        }

        $insert = $this->db->insert($this->_table1, $data);
        if ($insert) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function deleteKategoripengguna($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_kategori');
    }
    function insertBerita($table, $data)
    {
        $this->db->insert($table, $data);
    }

    // Berita Sekolah 

    function getBeritaSekolah()
    {
        $hsl = $this->db->get("tbl_berita");
        return $hsl;
    }
    function editberitasekolah($table, $data, $where)
    {
        return $this->db->update($table, $data, $where);
    }
    function detailberitasekolah($id = null)
    {
        $query = $this->db->get_where('tbl_berita', array('id' => $id))->row();
        return $query;
    }

    function deleteBeritaSekolah($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_berita');
    }
    function StatusBeritaSekolah($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_berita', $data);
    }



    // Kategori Berita Sekolah
    function detailKategoriSekolah()
    {
        $hsl = $this->db->get("kategori");
        return $hsl;
    }
    function TambahKategoriSekolah($data)
    {
        if (!array_key_exists("created", $data)) {
            $data['created'] = date("Y-m-d H:i:s");
        }

        $insert = $this->db->insert($this->_table2, $data);
        if ($insert) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    function deleteKategoriSekolah($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('kategori');
    }
    // Tampilkan Kategori Sekolah Tambah Berita Sekolah
    function get_data_kategori()
    {
        $query = $this->db->query("SELECT * FROM kategori ORDER by nama_kategori ASC");
        return $query->result();
    }
    // END

    // Modal Guru

    // Tampil Data Guru 
    function getGuru($id = null)
    {
        $hsl = $this->db->get("pegawai");
        return $hsl;
    }

    function addGuru()
    {
    }
}