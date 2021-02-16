<!-- BEGIN #content -->
<div id="content" class="content">
    <!-- BEGIN breadcrumb -->
    <ul class="breadcrumb">
        <!--
        <li class="breadcrumb-item"><a href="#">LAYOUT</a></li>
        <li class="breadcrumb-item active">STARTER PAGE</li>-->
        <li class="breadcrumb-item"><a href="#">Procurement</a></li>
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
        <span>Filter :</span>
        <input id="filterVal" onkeyup="inputKeyEnter(event)" style="border:1px solid #ccc">
        <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearch()">Search</a>
    </div>


    <div id="container" class="panel-body" style="width:100%;height:500px;padding:10px;">

        <table id="dgMain" class="easyui-datagrid" style="width:100%;height:420px;" toolbar="#tb4" url="<?= base_url(); ?>procurement/RepProcurement/getApList" singleSelect="true" rownumbers="true" pagination="true" showFooter="true" striped="true" fitColumns="true" nowrap="false" sortable="true">
            <thead>
                <tr>
                    <th field="id_rekanan" width="100" sortable="true">Supplier ID</th>
                    <th field="nama_rekanan" width="250" sortable="true">Supplier Name</th>
                    <th field="awal_hutang" width="100" sortable="true" formatter="datagridFormatNumber" align="right">Starting Balance</th>
                    <th field="mutasi_total" width="100" sortable="true" formatter="datagridFormatNumber" align="right">Mutasi Hutang</th>
                    <th field="total_hutang" width="100" sortable="true" formatter="datagridFormatNumber" align="right">Ending Balance</th>
                </tr>
            </thead>
        </table>

    </div>

    <div id="tb4" style="padding:3px">
        <a id="print" href="#" class="easyui-linkbutton" iconCls="icon-whatsapp" plain="false" onclick="xls4();">XLS</a>
    </div>

    <br>
    <div id="dlg" class="easyui-panel" style="width:100%;height:550px;padding:10px;" closed="false">
        <div class="row">
            <div class="col-md-5">
            </div>
            <span style="width: 170px"> </span>

            <div class="col-md-4">
                <div class="row">
                    <div class="row">
                        <div class="col">
                        </div>
                        <div class="col">
                            <label style="width:110px; text-align: right;">Starting Balance</label>
                        </div>
                        <div class="col">
                            <input id="vstarting" name="vstarting" class="easyui-numberbox" data-options="precision:2,groupSeparator:','" style="width:150px;text-align: right;height: 30px" />
                        </div>
                        <div class="col"></div>
                    </div>
                </div>
            </div>
        </div>

        <br>


        <table id="dgDetail" class="easyui-datagrid" style="width:97%;height:380px;" url="<?= base_url(); ?>procurement/RepProcurement/getApListDetail" nowrap="false" singleSelect="true" rownumbers="true" showFooter="true" striped="true" fitColumns="true" pagination="true" toolbar="#toolbarFilter">
            <thead>
                <tr>
                    <th field="ap_number" width="150">AP Number</th>
                    <th field="dt_ap_str" width="100">Date</th>
                    <th field="invoice_no" width="100" align="left">Invoice #</th>
                    <th field="remarks" width="300" align="left">Remarks</th>
                    <th field="id_rek_gl" width="100" align="left">COA #</th>
                    <th field="id_cc_project" width=80 allign="left">CC/Project</th>
                    <th field="debet" width="150" formatter="datagridFormatNumber" align="right">Debit</th>
                    <th field="kredit" width="150" formatter="datagridFormatNumber" align="right">Credit</th>
                </tr>
            </thead>
        </table>

        <div id="toolbarFilter" style="padding-left: 10px">
            <span>Filter :</span>
            <input id="filterValDetail" onkeyup="inputKeyEnterDetail(event)" style="border:1px solid #ccc">
            <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearchDetail()">Search</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="javascript:$('#dgDetail').datagrid('reload'); ">Refresh</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-5">
            </div>
            <span style="width: 170px"> </span>

            <div class="col-md-4">
                <div class="row">
                    <div class="row">
                        <div class="col">
                        </div>
                        <div class="col">
                            <label style="width:110px; text-align: right;">Mutasi</label>
                        </div>
                        <div class="col">
                            <input id="vmutasi" name="vmutasi" class="easyui-numberbox" data-options="precision:2,groupSeparator:','" style="width:150px;text-align: right;height: 30px" />
                        </div>
                        <div class="col"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="row">
                        <div class="col">
                        </div>
                        <div class="col">
                            <label style="width:110px; text-align: right;">Ending Balance</label>
                        </div>
                        <div class="col">
                            <input id="vending" name="vending" class="easyui-numberbox" data-options="precision:2,groupSeparator:','" style="width:150px;text-align: right;height: 30px" />
                        </div>
                        <div class="col"></div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!-- modal po #detail -->
    <!-- Modal -->

    <!-- END po modal -->

</div>
<!-- END #content -->

<!-- BEGIN btn-scroll-top -->
<a href="#" data-click="scroll-top" class="btn-scroll-top fade"><i class="ti-arrow-up"></i></a>
<!-- END btn-scroll-top -->
</d>
<!-- END #page-container -->

<script src="<?php echo base_url('assets/js/accounting.min.js') ?>"></script>
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

        $('#dgMain').datagrid({
            onDblClickRow: function() {
                var row = $('#dgMain').datagrid('getSelected');
                if (row) {
                    $('#dgDetail').datagrid('load', {
                        idd: row.id_rekanan,
                        dt_awal: $("#dds").val(),
                        dt_akhir: $("#dde").val(),
                        searching: $('#filterValDetail').val()
                    });
                    $('#vstarting').numberbox('setValue', row.awal_hutang);
                    $('#vmutasi').numberbox('setValue', row.mutasi_total);
                    $('#vending').numberbox('setValue', row.total_hutang);
                    scrollSmoothToBottom('content');
                }
            }
        });


        doSearch();
    });

    function mouseOver() {
        document.getElementById("ordering_no").style.color = "red";
    }

    function mouseOut() {
        document.getElementById("ordering_no").style.color = "black";
    }




    // Number Format
    accounting.settings = {
        currency: {
            symbol: "Rp", // default currency symbol is '$'
            format: "%s %v", // controls output: %s = symbol, %v = value/number (can be object: see below)
            decimal: ",", // decimal point separator
            thousand: ".", // thousands separator
            precision: 2 // decimal places
        },
        number: {
            precision: 2,
            thousand: ".",
            decimal: ","
        }
    }

    // Data Grid Number Format
    function datagridFormatNumber(val, row) {
        return accounting.formatNumber(val);
    }



    function inputKeyEnter(e) {
        e.which = e.which || e.keyCode;
        if (e.which == 13) {
            doSearch();
        }
    }

    function inputKeyEnterDetail(e) {
        e.which = e.which || e.keyCode;
        if (e.which == 13) {
            doSearchDetail();
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
            dt_akhir: $("#dde").val(),
            searching: $('#filterVal').val()
        });

    }

    function doSearchDetail() {
        var row = $('#dgMain').datagrid('getSelected');
        if (row) {

            $('#dgDetail').datagrid('load', {
                idd: row.id_rekanan,
                dt_awal: $("#dds").val(),
                dt_akhir: $("#dde").val(),
                searching: $('#filterValDetail').val()
            });

        }
    }
</script>