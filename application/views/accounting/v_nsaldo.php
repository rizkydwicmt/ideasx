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
        <span>Date Filter :</span>
        <input id="dds" type="text">
        <span>to :</span>
        <input id="dde" type="text">
        <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearch()">Search</a>
    </div>


    <div id="container" class="easyui-panel" style="width:100%;height:500px;padding:10px;">
        <table id="dgMain" class="easyui-datagrid" style="width:99%;height:auto;" toolbar="#tb4" url="<?= base_url(); ?>accfin/Nsaldo/getNsaldo" singleSelect="true" showFooter="true" striped="true" nowrap="false" fitcoloumn="true">
            <thead>
                <tr>
                    <th field="id_rek_gl" width="100" rowspan="2" align="left">Account ID</th>
                    <th field="rekening" width="200" rowspan="2" align="left">Description</th>
                    <th width="300" colspan="3">Starting Balance</th>
                    <th width="300" colspan="3">Mutasi</th>
                    <th width="300" colspan="3">End Balance</th>
                </tr>
                <tr>
                    <th field="awal_debet" width="100" align="right">Debit</th>
                    <th field="awal_kredit" width="100" align="right">Credit</th>
                    <th field="saldo_awal" width="100" align="right">Saldo</th>
                    <th field="debet_berjalan" width="100" align="right">Debit</th>
                    <th field="kredit_berjalan" width="100" align="right">Credit</th>
                    <th field="saldo_mutasi" width="100" align="right">Saldo</th>
                    <th field="akhir_debet" width="100" align="right">Debit</th>
                    <th field="akhir_kredit" width="100" align="right">Credit</th>
                    <th field="saldo_akhir" width="100" align="right">Saldo</th>
                </tr>
            </thead>
        </table>

        <!-- TOOLBAR --->
        <div id="tb4" style="padding:3px">
            <a id="print" href="#" class="easyui-linkbutton" iconCls="icon-excel" plain="false" onclick="xls4();">XLS</a>
        </div>

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
            $("#dds").datepicker("option", "dateFormat", "dd/mm/yy");
            $("#dds").datepicker("setDate", "today");


            $("#dde").datepicker({
                changeMonth: true,
                changeYear: true,
                gotoCurrent: true
            });
            $("#dde").datepicker("option", "dateFormat", "dd/mm/yy");
            $("#dde").datepicker("setDate", "today");

            doSearch();
        });



        function inputKeyEnter(e) {
            e.which = e.which || e.keyCode;
            if (e.which == 13) {
                doSearch();
            }
        }

        function scrollSmoothToBottom(id) {
            var div = document.getElementById(id);
            $('#' + id).animate({
                scrollTop: div.scrollHeight - div.clientHeight
            }, 500);
        }

        function doSearch() {
            $('#dgMain').datagrid('load', {
                dt_awal: $("#dds").val(),
                dt_akhir: $("#dde").val()
            });

        }
    </script>