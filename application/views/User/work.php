<!-- LIST BERITA  DASHBORD ADMIN DAN USER -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Data Upload
            <small>List Upload Data</small>
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
            </div>
        </div>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Upload File
        </button>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">List Upload</h3>

                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table id="datatables" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th class="text-center">No</th>
                                    <th class="text-center">ID POTONG</th>
                                    <th class="text-center">Nama </th>
                                    <th class="text-center">Pasal </th>
                                    <th class="text-center">Kode Pajak</th>
                                    <th class="text-center">No Bukti Potong</th>
                                    <th class="text-center">Tanggal Potong</th>
                                    <th class="text-center">PPH</th>
                                    <th class="text-center">Jumlah Bruto</th>
                                    <th class="text-center">Action</th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($work)) {
                                    $no = 1;
                                    foreach ($work as $record) {
                                ?>
                                <tr class="text-center">
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $record->id_potong ?></td>
                                    <td><?php echo $record->nama_file ?></td>
                                    <td><?php echo $record->pasal ?></td>
                                    <td><?php echo $record->kode_objek_pajak ?></td>
                                    <td><?php echo $record->no_bukti_potong ?></td>
                                    <td><?php echo $record->tanggal_bupot ?></td>
                                    <td><?php echo $record->pph_potong ?></td>
                                    <td><?php echo $record->jumlah_bruto ?></td>

                                    <td width="150px">
                                        <a class="btn btn-sm btn-success"
                                            href="<?php echo base_url() . 'DetailDataBeritaAlumni/' . $record->id ?>"><i
                                                class=" fa fa-search-plus"></i></a>

                                        <a class="btn btn-sm btn-danger" href="#modalDelete" onclick="$('#modalDelete #formDelete')
                                        .attr('action','<?php echo base_url() . 'deletework/' . $record->id; ?>')"
                                            data-toggle="modal"><i class="fa fa-trash"></i></a>
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

    <!-- Modal Upload -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" action="<?php echo base_url() ?>User/upload_work">
                        <div class="form-group">
                            <label for="exampleInputFile">File input</label>
                            <input type="file" accept=".xlsx" name="file" id="exampleInputFile">
                            <p class="help-block">Masukkan File Dalam Bentuk Excel.</p>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                </div>
            </div>
            </form>
        </div>

    </div>
</div>
</div>

<!-- Modal Delete -->
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