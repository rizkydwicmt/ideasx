<html>

<head>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/panels'); ?>/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/panels'); ?>/dataTables.bootstrap.min.css" />
    <script type="text/javascript" src="<?= base_url('assets/panels'); ?>/jquery.min.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/panels'); ?>/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/panels'); ?>/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/panels'); ?>/dataTables.bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Data Mahasiswa</h3>
            </div>
            <div class="panel-body">
                <form>
                    <div class="form-group">
                        <label for="varchar">ID Mahasiswa</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="form-control pencarian" placeholder="Nomor Induk Mahasiswa" id="textbox"><br>
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="Simpan" class="btn btn-parimary">
                </form>
            </div>
        </div>
        <!-- Trigger the modal with a button -->
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">DATA MAHASISWA</h4>
                    </div>
                    <div class="modal-body">
                        <table id="example" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID MHS</th>
                                    <th>NAMA MHS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="data" onClick="masuk(this,'MHS001')" href="javascript:void(0)">
                                    <td><a id="data" onClick="masuk(this,'MHS001')" href="javascript:void(0)">MHS001</a></td>
                                    <td>Muhammad Iqbal Ramadhan</td>
                                </tr>
                                <tr id="data" onClick="masuk(this,'MHS002')" href="javascript:void(0)">
                                    <td><a id="data" onClick="masuk(this,'MHS002')" href="javascript:void(0)">MHS002</a></td>
                                    <td>Muhammad Ramdan Fauzi</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


<?php
foreach ($coa as $row) {
    echo  "<tr id='data' onClick='masuk(this,'MHS001')' href='javascript:void(0)'>";
    echo "<td><a id='data' onClick='masuk(this,'MHS001')' href='javascript:void(0)'>MHS001</a></td>";
    echo "<td>Muhammad Iqbal Ramadhan</td>";
    echo "</tr>";
}
?>

</html>