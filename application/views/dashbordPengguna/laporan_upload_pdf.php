<!DOCTYPE html>
<html>

<head>
    <title>FBS</title>
    <style type="text/css">
    .table {
        width: 100%;
        border-spacing: 0;
    }

    .table tr th,
    .table tr td {
        border: 1px solid #000
    }

    .text-center {
        text-align: center;
    }
    </style>
</head>

<body>
    <h4 class="text-center"> FOUR BEST ENERGY</h4>
    <table class="table table-bordered">
        <tr>
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
            if (!empty($detail)) {
                $no = 1;
                foreach ($detail as $record) {
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

</body>

</html>