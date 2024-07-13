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


        <a class="btn btn-primary" href="<?php echo base_url(); ?>cetak_upload"><i class="fa fa-file"></i>
            Cetak PDF</a>
        <div class="row">
            <div class="col-xs-12 text-right">
                <!--  -->
            </div>
        </div>

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