<!-- BEGIN #content -->
<div id="content" class="content">
    <!-- BEGIN breadcrumb -->
    <ul class="breadcrumb">
        <!--
        <li class="breadcrumb-item"><a href="#">LAYOUT</a></li>
        <li class="breadcrumb-item active">STARTER PAGE</li>-->
        <li class="breadcrumb-item"><a href="#">Accounting</a></li>
        <li class="breadcrumb-item active"><?= $tittle ?></li>
    </ul>
    <!-- END breadcrumb -->

    <!-- BEGIN page-header -->
    <h1 class="page-header">
        <?= $tittle ?> | <small>This form contain <?= $tittle ?> data...</small>
    </h1>
    <!-- END page-header -->

    <div class="panel-body" style="width:100%;height:50px;padding-top:10px;padding-left:10px;">
        < <span>Date Filter :</span>
            <input id="dds" type="text">
            <span>to :</span>
            <input id="dde" type="text">
            <span>Filter :</span>
            <Select id="id_rek_gl" name="id_rek_gl" style="width:250px; ">
                <option value="">Select Account</option>
                <?php
                foreach ($coa as $row) {
                    echo '<option value="' . $row["id_rek_gl"] . '">' . $row["descriptions"] . '</option>';
                }
                ?>
            </Select>
            <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearch()">Search</a>
    </div>


    <div id="container" class="easyui-panel" style="width:100%;height:480px;padding:0px;">
        <!--url="report/mod_rep_nsaldo/get_saldo_bb.php"-->
        <table id="dgMBB" class="easyui-datagrid" style="width:auto;height:100px" toolbar="#tbBukuBesar" fitColumns="true" singleSelect="true" striped="true" nowrap="False">
            <thead>
                <tr>
                    <th field="id_rek_gl" width="100">Account ID</th>
                    <th field="nama_rekening" width="500">Description</th>
                    <th field="awal" width="150" align="right">Starting Balance</th>
                    <th field="berjalan" width="150" align="right">This Periode</th>
                    <th field="akhir" width="150" align="right">Ending Balance</th>
                </tr>
            </thead>
        </table>

        <!--url="report/mod_rep_nsaldo/get_buku_besar.php"-->
        <table id="dgDBB" class="easyui-datagrid" style="width:auto;height:350px" pagination="true" pageSize="15" pageList="[15,25,70,100]" rownumbers="true" sortable="true" showfooter="true" singleSelect="true" striped="true" nowrap="false">
            <thead>
                <tr>
                    <th field="no_jurnal" width="110" sortable="true">Memorial #</th>
                    <th field="no_bukti" width="80" sortable="true">Reff #</th>
                    <th field="dt_memorial" width="80" sortable="true">Date</th>
                    <th field="id_cc_project" width="80" sortable="true">CC/Project</th>
                    <th field="nama_rekanan" width="200" sortable="true">Vendor</th>
                    <th field="descriptions" width="300" sortable="true" align="left">Description</th>
                    <th field="debet" width="80" align="right" sortable="true">Debet</th>
                    <th field="kredit" width="80" align="right" sortable="true">Credit</th>
                </tr>
            </thead>
        </table>



        <!-- TOOLBAR --->
        <div id="tbBukuBesar" style="padding:3px">
            <a id="neraca_saldo" href="#" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="cetak_bb()">Cetak</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="cetak_bb_Excel();">Excel</a>
        </div>

        <!-- END TOOLBAR -->

        <br>

        <!-- END po modal -->

    </div>
    <!-- END #content -->

    <!-- BEGIN btn-scroll-top -->
    <a href="#" data-click="scroll-top" class="btn-scroll-top fade"><i class="ti-arrow-up"></i></a>
    <!-- END btn-scroll-top -->
    </d>
    <!-- END #page-container -->

    <script type="text/javascript">
        //jQuery.noConflict(); // 
        var url;
        var mode;
        $(function() {


            $("#dds").datepicker({
                changeMonth: true,
                changeYear: true,
                gotoCurrent: true
            });
            $("#dds").datepicker("option", "dateFormat", "dd-mm-yy");
            $("#dds").datepicker("setDate", "today");


            $("#dde").datepicker({
                changeMonth: true,
                changeYear: true,
                gotoCurrent: true
            });
            $("#dde").datepicker("option", "dateFormat", "dd-mm-yy");
            $("#dde").datepicker("setDate", "today");

            // doSearch();
        });




        function scrollSmoothToBottom(id) {
            var div = document.getElementById(id);
            $('#' + id).animate({
                scrollTop: div.scrollHeight - div.clientHeight
            }, 500);
        }

        function doSearch() {
            var dt_awal = $("#dds").val();
            var dt_akhir = $("#dde").val();
            var id_rek_gl = $("#id_rek_gl").val();



            if (dt_awal == '' || dt_akhir == '') {
                Swal.fire(
                    'Field Date Filter Required.....!!!'
                )
                return false;
            } else if (id_rek_gl == '0') {
                Swal.fire(
                    'Field Account Required.....!!!'
                )
                return false;
            } else if (id_rek_gl == '') {
                Swal.fire(
                    'Field Account Required.....!!!'
                )
                return false;
            } else {
                $('#dgMBB').datagrid({
                    url: "<?= base_url(); ?>accfin/Nsaldo/getMBukuBesar/" + dt_awal + "_" + dt_akhir + "_" + id_rek_gl
                });

                $('#dgDBB').datagrid({
                    url: "<?= base_url(); ?>accfin/Nsaldo/getDBukuBesar/" + dt_awal + "_" + dt_akhir + "_" + id_rek_gl
                });

                // $('#dgMBB').datagrid('load', {
                //     dt_awal: $("#dds").val(),
                //     dt_akhir: $("#dde").val()

                // });

            }




        }
    </script>