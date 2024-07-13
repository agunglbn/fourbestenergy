<!-- LIST BERITA pengguna DASHBORD ADMIN DAN USER -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Data Pengguna
            <small>List Data Pengguna</small>
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



        <div class="row">
            <div class="col-xs-12 text-right">
                <!--  -->
                <a class="btn btn-primary" href="<?php echo base_url(); ?>tambah_pengguna"><i class="fa fa-plus"></i>
                    Add New</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-header">

                        <h3 class="box-title">List Pengguna</h3>
                        <div class="col-xs-12 text-right">
                            <!--  -->
                            <a class="btn btn-primary" href="<?php echo base_url(); ?>cetak_pdf"><i
                                    class="fa fa-file"></i>
                                Cetak PDF</a>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="row">

                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table id="datatables" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th class="text-center">No</th>
                                    <th class="text-center">npwp</th>
                                    <th class="text-center">Username</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Mobile</th>
                                    <th class="text-center">Alamat</th>
                                    <th class="text-center">Nama Instansi</th>
                                    <th class=" text-center">Status</th>
                                    <th class=" text-center">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($x)) {
                                    $no = 1;
                                    foreach ($x as $record) {
                                ?>
                                <tr class="text-center">
                                    <td width="10px"><?php echo $no++; ?></td>
                                    <td><?php echo $record->npwp ?></td>
                                    <td><?php echo $record->username ?></td>
                                    <td><?php echo $record->nama ?></td>
                                    <td><?php echo substr($record->email, 0, 12) ?></td>
                                    <td><?php echo $record->mobile ?></td>
                                    <td><?php echo substr($record->alamat, 0, 15) ?></td>
                                    <td><?php echo $record->nama_instansi ?></td>
                                    <td>

                                        <!-- Proses Update Status  -->
                                        <?php
                                                $status = $record->status;
                                                if ($status == 0) {
                                                ?>

                                        <span class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#exampleModal<?= $record->id_pengguna; ?>">Non-Active</span>

                                        <div class="modal fade" id="exampleModal<?= $record->id_pengguna; ?>"
                                            tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Aktivisasi Akun
                                                            Pengguna</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="<?php echo base_url() ?>updateStatuspengguna"
                                                            method="POST">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <input type="hidden" name="id_pengguna"
                                                                        value="<?= $record->id_pengguna; ?>" />
                                                                    <div class="form-group">
                                                                        <label for="status">Status</label>
                                                                        <select class="form-control required"
                                                                            id="status" name="status">
                                                                            <option value="1"
                                                                                <?php if ($record->status == "1") echo "selected='selected'" ?>>
                                                                                Active
                                                                            </option>
                                                                            <option value="0"
                                                                                <?php if ($record->status == "0") echo "selected='selected'" ?>>
                                                                                Non Active
                                                                            </option>

                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save
                                                                    changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                                } else { ?>
                                            <span class="btn btn-sm btn-success" data-toggle="modal"
                                                data-target="#exampleModalactive<?= $record->id_pengguna; ?>">Active</span>


                                            <div class="modal fade" id="exampleModalactive<?= $record->id_pengguna; ?>"
                                                tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Aktivisasi
                                                                Akun
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?php echo base_url() ?>updateStatuspengguna"
                                                                method="POST">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <input type="hidden" name="id_pengguna"
                                                                            value="<?= $record->id_pengguna; ?>" />
                                                                        <div class="form-group">
                                                                            <label for="status">Status</label>
                                                                            <select class="form-control required"
                                                                                id="status" name="status">

                                                                                <option value="1"
                                                                                    <?php if ($record->status == "1") echo "selected='selected'" ?>>
                                                                                    Active
                                                                                </option>
                                                                                <option value="0"
                                                                                    <?php if ($record->status == "0") echo "selected='selected'" ?>>
                                                                                    Non Active
                                                                                </option>

                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save
                                                                        changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>


                                                <?php
                                                    }
                                                        ?>


                                    </td>
                                    <!-- End Update Status Modal -->


                                    <td width="150px">
                                        <!-- Detail pengguna -->
                                        <a class="btn btn-sm btn-success"
                                            href="<?php echo base_url() . 'detailAlum/' . $record->id_pengguna ?>"><i
                                                class=" fa fa-search-plus"></i></a>

                                        <!-- Delete pengguna -->
                                        <a class="btn btn-sm btn-danger" href="#modalDelete"
                                            onclick="$('#modalDelete #formDelete')
                                        .attr('action','<?php echo base_url() . 'deletepengguna/' . $record->id_pengguna; ?>')" data-toggle="modal"><i
                                                class="fa fa-trash"></i></a>


                                        <button class="btn btn-sm btn-info" type="button" data-toggle="modal"
                                            data-target="#exampleModal<?= $record->id_pengguna; ?>"
                                            data-whatever="@mdo"><i class=" fa fa-pencil"></i></button>

                                        <!-- MODAL UPDATE PASSWORD -->
                                        <div class="modal fade" id="exampleModal<?= $record->id_pengguna; ?>"
                                            tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span
                                                                aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="exampleModalLabel">Ubah Password
                                                            pengguna</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="<?php echo base_url(); ?>prosesupdate"
                                                            method="POST">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="recipient-name"
                                                                            class="control-label">New
                                                                            Password:</label>
                                                                        <input type="hidden" name="id_pengguna"
                                                                            value="<?= $record->id_pengguna; ?>" />
                                                                        <input type="password" class="form-control"
                                                                            name="password" placeholder="*******"
                                                                            id="password">
                                                                    </div>
                                                                    <?php echo form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="recipient-name"
                                                                            class="control-label">Confirm
                                                                            Password:</label>
                                                                        <input type="password" placeholder="*******"
                                                                            class="form-control" name="password2"
                                                                            id="password2">
                                                                    </div>
                                                                    <?php echo form_error('password2', '<small class="text-danger pl-3">', '</small>'); ?>
                                                                </div>
                                                            </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <center>
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                        </center>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->

                </div><!-- /.box -->
            </div>
        </div>
    </section>
    <div class="modal fade" id="modalDelete">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-footer">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Yakin akan menghapus Data</h4>
                </div>
                <div class="modal-body">
                    <center>
                        <form id="formDelete" accept="" method="POST">
                            <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" type="submit">OK</button>
                        </form>
                    </center>
                </div>
            </div>
        </div>
    </div>

</div>