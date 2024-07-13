<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.inputmask.js?>"></script>
<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script> -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-user" aria-hidden="true"></i> <?php echo $title; ?>
            <small>Control panel</small>
        </h1>

    </section>

    <section class="content">
        <?php
        $this->load->helper('form');
        $error = $this->session->flashdata('error_msg');
        if ($error) {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $this->session->flashdata('error_msg'); ?>
        </div>
        <?php } ?>
        <?php
        $success = $this->session->flashdata('success_msg');
        if ($success) {
        ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $this->session->flashdata('success_msg'); ?>
        </div>
        <?php } ?>
        <!--   <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

</div>-->
        <form enctype="multipart/form-data" id="add" action="<?php echo base_url() ?>editProfile" method="POST">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="username">Username</label>
                        <div class="input-group">
                            <input type="hidden" name="id_pengguna" value="<?= $user['id_pengguna'] ?>" />
                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user"></i></span>
                            <input type="text" name="username" id="username" readonly value="<?= $user['username'] ?>"
                                class="form-control" placeholder="Username" aria-describedby="basic-addon1">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="Nama">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user"></i></span>
                            <input type="text" name="nama" id="nama" value="<?= $user['nama'] ?>" class="form-control"
                                placeholder="Your Name" aria-describedby="basic-addon1">
                            <?php echo form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="Nama">NPWP</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1"><i
                                    class="fa fa-sort-numeric-desc"></i></span>
                            <input type="text" name="npwp" id="npwp" readonly value="<?= $user['npwp'] ?>"
                                class="form-control" placeholder="npwp" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="Nama">Email</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-envelope"></i></span>
                            <input type="hidden" name="oldemail" id="oldemail" value="<?= $user['email'] ?>"
                                pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" class="form-control required email"
                                placeholder="Your Email" aria-describedby="basic-addon1">

                            <input type="text" name="email" id="email" value="<?= $user['email'] ?>"
                                pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" class="form-control required email"
                                placeholder="Your Email" aria-describedby="basic-addon1">
                        </div>
                        <?php echo form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6">
                        <label for="Nama">NO Telepon</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-phone-square"
                                    aria-hidden="true"></i></span>
                            <input type="text" name="mobile" id="mobile" value="<?= $user['mobile'] ?>"
                                class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <=58"
                                placeholder="Mobile" aria-describedby="basic-addon1">

                        </div>
                        <?php echo form_error('mobile', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="col-md-6">
                        <label for="Nama">Gender </label>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user"
                                    aria-hidden="true"></i></span>
                            <select class="form-control required" id="jk" name="jk">
                                <option value="L"
                                    <?php if ($user['jenis_kelamin'] == "L") echo "selected='selected'" ?>>Laki-Laki
                                </option>
                                <option value="P"
                                    <?php if ($user['jenis_kelamin'] == "P") echo "selected='selected'" ?>>
                                    Perempuan
                                </option>

                            </select>
                            <?php echo form_error('jk', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-6">
                        <label for="Nama">Alamat</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-map-marker"></i></span>
                            <input type="text" name="alamat" id="alamat" value="<?= $user['alamat'] ?>"
                                class="form-control" placeholder="Alamat" aria-describedby="basic-addon1">
                            <?php echo form_error('alamat', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="Nama">Tempat Perusahaan</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-building"></i></span>
                            <input type="text" name="ni" id="ni" value="<?= $user['nama_instansi'] ?>"
                                class="form-control" placeholder="Nama Instansi" aria-describedby="basic-addon1">
                            <?php echo form_error('ni', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                </div>



                <div class="row">


                </div>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="img">Profile</label>

                            <input type="file" class="form-control" id="img" name="img" accept="image/*"
                                value="<?= set_value('img') ?>">
                            <small>Masukkan File Foto Profile Max Size 3 MB</small>

                        </div>
                    </div>
                </div>
                <div class="row">


                    <div class="col-md-6">
                        <label for="Nama">Profile </label>
                        <div class="input-group">
                            <?php echo form_hidden('new_img', $user['img']) ?>
                            <a class="thumbnail">
                                <img width="150" height="120" class="card-img-top" alt="NOT FOUND"
                                    src="<?php echo base_url(); ?>assets/img/<?php echo $user['img']; ?>">
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="box-footer">
                <input type="submit" class="btn btn-primary" value="Update" name="submit" />
                <input value="Back" class="btn btn-primary" onclick="history.back(-1)" type="Button" value="Back ">


            </div>

        </form>






    </section>



</div>

<script>
$(function() {
    //Initialize Select2 Elements
    // $('.select2').select2()
    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', {
        'placeholder': 'dd/mm/yyyy'
    })


});
</script>