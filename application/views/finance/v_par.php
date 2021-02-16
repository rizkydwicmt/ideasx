<!-- BEGIN #content -->
<div id="content" class="content">
    <!-- BEGIN breadcrumb -->
    <ul class="breadcrumb">
        <!--
        <li class="breadcrumb-item"><a href="#">LAYOUT</a></li>
        <li class="breadcrumb-item active">STARTER PAGE</li>-->
        <li class="breadcrumb-item"><a href="#">Finance</a></li>
        <li class="breadcrumb-item active"><?= $tittle ?></li>
    </ul>
    <!-- END breadcrumb -->

    <!-- BEGIN page-header -->
    <h1 class="page-header">
        <?= $tittle ?> | <small>This form contain <?= $tittle ?> data...</small>
    </h1>
    <!-- END page-header -->

    <div class="panel-body" style="width:100%;height:50px;padding-top:10px;padding-left:10px;">
        <!--  <span>Date Filter :</span>
        <input id="dds" type="text">
        <span>to :</span>
        <input id="dde" type="text">
        <span>Filter :</span> -->
        <span>Filter :</span>
        <input id="filterVal" onkeyup="inputKeyEnter(event)" style="border:1px solid #ccc">
        <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearch()">Search</a>
    </div>


    <div id="container" class="panel-body" style="width:100%;height:500px;padding:10px;">

        <table id="dgMain" class="easyui-datagrid" style="width:100%;height:420px;" toolbar="#tb4" url="<?= base_url(); ?>accfin/Par/getPar" singleSelect="true" rownumbers="true" pagination="true" showFooter="true" striped="true" fitColumns="true" nowrap="false" sortable="true">
            <thead>
                <tr>
                    <th field="no_doc" width="100" sortable="true">Doc Number</th>
                    <th field="dt_doc" width="100" sortable="true">Date</th>
                    <th field="nama_transaksi" width="100" sortable="true">Transaction</th>
                    <th field="id_cc_project" width="80" sortable="true">CC/Project</th>
                    <th field="id_rek_gl" width="80" sortable="true">COA</th>
                    <th field="nama_rekanan" width="250" sortable="true">Employee/Supplier</th>
                    <th field="remarks" width="250" sortable="true">Remarks</th>
                    <th field="total_idr" width="100" sortable="true" formatter="datagridFormatNumber" align="right">Nominal</th>
                </tr>
            </thead>
        </table>

    </div>

    <div id="tb4" style="padding:3px">
        <a id="print" href="#" class="easyui-linkbutton" iconCls="icon-whatsapp" plain="false" onclick="xls4();">XLS</a>
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

        doSearch();
    });


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

    function scrollSmoothToBottom(id) {
        var div = document.getElementById(id);
        $('#' + id).animate({
            scrollTop: div.scrollHeight - div.clientHeight
        }, 500);
    }

    function doSearch() {
        $('#dgMain').datagrid('load', {
            // dt_awal: $("#dds").val(),
            // dt_akhir: $("#dde").val(),
            searching: $('#filterVal').val()
        });

    }
</script>