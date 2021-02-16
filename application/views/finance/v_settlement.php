<!-- BEGIN #content -->
<div id="content" class="content">
    <!-- BEGIN breadcrumb -->
    <ul class="breadcrumb">
        <!--
        <li class="breadcrumb-item"><a href="#">LAYOUT</a></li>
        <li class="breadcrumb-item active">STARTER PAGE</li>-->
        <li class="breadcrumb-item"><a href="#">Finance</a></li>
        <li class="breadcrumb-item active"> <?= $tittle; ?></li>
    </ul>
    <!-- END breadcrumb -->

    <!-- BEGIN page-header -->
    <h1 class="page-header">
        <?= $notrans; ?> | <?= strtoupper($tittle); ?> | <small>This form contain <?= $tittle; ?> data...</small>
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


    <br>

    <div id="container" class="easyui-panel" style="width:100%;height:500px;padding:10px;">
        <table id="dgMain" class="easyui-datagrid" style="width:100%;height:460px;" nowrap="false" fitColumns="true" url="<?= base_url(); ?>accfin/Settlement/getSettlement/<?= $notrans; ?>" singleSelect="true" rownumbers="true" pagination="true" toolbar="#toolbarFilter">
            <thead>
                <tr>
                    <th field="id_settlement" width="70">Index</th>
                    <th field="no_settlement" width="120">Settlement #</th>
                    <th field="dt_settlement" width="80">Date</th>
                    <th field="nama_rekanan" width="150" align=left>Employee/Supplier</th>
                    <th field="remarks" width="100" align=left>Remarks</th>
                    <th field="id_cc_project" width="80">CC/Project #</th>
                    <th field="total" width="100" formatter="datagridFormatNumber" align="right">Total</th>
                    <th field="total_kasbon" width="100" formatter="datagridFormatNumber" align="right">CA Value</th>
                    <th field="lebih_kurang" width="100" formatter="datagridFormatNumber" align="right">Difference</th>
                    <th field="usr_ins" width="50" align=left>Usr Ins</th>
                    <th field="usr_upd" width="50" align=left>Usr Upd</th>
                </tr>
            </thead>
        </table>

        <div id="toolbarFilter" style="padding-left: 10px">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="newData()">New</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editData()">Edit</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onClick="removeData()">Destroy</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="javascript:$('#dgMain').datagrid('reload'); ">Refresh</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
        </div>




    </div>
    <!-- Modal -->
    <br>


</div>

<!-- END #content -->


<!-- BEGIN btn-scroll-top -->
<a href="#" data-click="scroll-top" class="btn-scroll-top fade"><i class="ti-arrow-up"></i></a>
<!-- END btn-scroll-top -->
</div>
<!-- END #page-container -->

<div>
    <!-- Alert Simpan data baru -->
    <a hidden href="#" id='addSuccess' class="btn btn-default btn-sm" data-toggle="notification" data-icon="ti-save" data-icon-class="bg-gradient-blue-purple" data-title="Operation Success" data-content="New data added successfully!" data-autoclose="true"></a>
    <a hidden href="#" id='addError' class="btn btn-default btn-sm" data-toggle="notification" data-icon="ti-save-alt" data-icon-class="bg-gradient-blue-purple" data-title="Operation Error" data-content="Can't added New Data!" data-autoclose="true"></a>

    <!-- Alert update data baru -->
    <a hidden href="#" id='editSuccess' class="btn btn-default btn-sm" data-toggle="notification" data-icon="ti-save" data-icon-class="bg-gradient-blue-purple" data-title="Operation Success" data-content="Data update successfully" data-autoclose="true"></a>
    <a hidden href="#" id='editError' class="btn btn-default btn-sm" data-toggle="notification" data-icon="ti-save-alt" data-icon-class="bg-gradient-blue-purple" data-title="Operation Error" data-content="Can't Update Data!" data-autoclose="true"></a>

    <!-- Alert delete data  -->
    <a hidden href="#" id='delSuccess' class="btn btn-default btn-sm" data-toggle="notification" data-icon="ti-save" data-icon-class="bg-gradient-blue-purple" data-title="Operation Success" data-content="Delete data successfully" data-autoclose="true"></a>
    <a hidden href="#" id='delError' class="btn btn-default btn-sm" data-toggle="notification" data-icon="ti-save-alt" data-icon-class="bg-gradient-blue-purple" data-title="Operation Error" data-content="Can't Delete Data!" data-autoclose="true"></a>
</div>

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


        $("#dde").datepicker({
            changeMonth: true,
            changeYear: true,
            gotoCurrent: true
        });
        $("#dde").datepicker("option", "dateFormat", "dd/mm/yy");

        var dtnow = '<?= $dtnow ?>';
        //alert(dtnow);

        if (dtnow == 'today') {
            $("#dds").datepicker("setDate", "today");
            $("#dde").datepicker("setDate", "today");
        } else {
            var dt1 = dtnow.substring(0, 2) + '/' + dtnow.substring(2, 4) + '/' + dtnow.substring(4, 8);
            var dt2 = dtnow.substring(9, 11) + '/' + dtnow.substring(11, 13) + '/' + dtnow.substring(13, 17);

            $("#dds").datepicker("setDate", dt1);
            $("#dde").datepicker("setDate", dt2);
        }


        doSearch();

    });


    function inputKeyEnter(e) {
        e.which = e.which || e.keyCode;
        if (e.which == 13) {
            doSearch();
        }
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


    function scrollSmoothToBottom(id) {
        var div = document.getElementById(id);
        $('#' + id).animate({
            scrollTop: div.scrollHeight - div.clientHeight
        }, 500);
    }

    function newData() {
        var artg1 = $("#dds").val().split('/');
        var tg1 = artg1[0] + artg1[1] + artg1[2];
        var artg2 = $("#dde").val().split('/');
        var tg2 = artg2[0] + artg2[1] + artg2[2];

        $.ajax({
            url: "<?= base_url(); ?>accfin/Settlement/newSettlement",
            method: "POST",
            dataType: 'json',
            data: {
                dtx: tg1 + '_' + tg2
            },
            error: function() {
                document.getElementById("addError").click();
            },
            success: function(data) {
                window.open('<?= base_url(); ?>accfin/Settlement/loadSettlement', '_self');
            }
        });
    }

    function editData() {
        var artg1 = $("#dds").val().split('/');
        var tg1 = artg1[0] + artg1[1] + artg1[2];
        var artg2 = $("#dde").val().split('/');
        var tg2 = artg2[0] + artg2[1] + artg2[2];
        var row = $('#dgMain').datagrid('getSelected');

        $.ajax({
            url: "<?= base_url(); ?>accfin/Settlement/editSettlement",
            method: "POST",
            dataType: 'json',
            data: {
                dtx: tg1 + '_' + tg2,
                id: row.id_settlement
            },
            error: function() {
                document.getElementById("addError").click();
            },
            success: function(data) {
                window.open('<?= base_url(); ?>accfin/Settlement/loadSettlement', '_self');
            }
        });
    }

    function removeData() {
        var row = $('#dgMain').datagrid('getSelected');
        if (row) {
            //alert(row.kd_rekanan);
            var result = confirm("Are you sure to delete?");
            if (result) {
                // Delete logic goes here
                //alert(row.kd_rekanan);
                $.ajax({
                    url: "<?= base_url(); ?>accfin/Settlement/destroySettlement",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        id: row.id_settlement
                    },
                    error: function() {
                        document.getElementById("delError").click(); // Click on the checkbox
                    },
                    success: function(data) {
                        $('#dgMain').datagrid('reload'); // reload the user data
                        document.getElementById("delSuccess").click(); // Click on the checkbox;
                    }
                });
            }
        }
    }




    function doSearch() {
        $('#dgMain').datagrid('load', {
            dt_awal: $("#dds").val(),
            dt_akhir: $("#dde").val(),
            searching: $('#filterVal').val()
        });
    }









    $(function() {
        $('#dgMain').datagrid({
            view: detailview,
            detailFormatter: function(index, row) {
                return '<div style="padding:2px"><table id="ddv-' + index + '"></table></div>';
            },
            onExpandRow: function(index, row) {
                $('#ddv-' + index).datagrid({
                    url: '<?= base_url(); ?>accfin/Settlement/getSettlementDetail/' + row.id_settlement,
                    // fitColumns: true,
                    singleSelect: true,
                    height: 'auto',
                    //pagination: true,
                    showFooter: true,
                    columns: [
                        [{
                                field: 'dt_biaya',
                                title: 'Date',
                                width: 100
                            },
                            {
                                field: 'id_rek_gl',
                                title: 'Account [Dr]',
                                width: 80
                            },
                            {
                                field: 'no_mrir',
                                title: 'AP Number',
                                width: 100
                            },
                            {
                                field: 'diskripsi',
                                title: 'Description',
                                width: 400
                            },
                            {
                                field: 'biaya',
                                title: 'Nominal',
                                align: 'right',
                                width: 100
                            }
                        ]
                    ],
                    onResize: function() {
                        $('#dgMain').datagrid('fixDetailRowHeight', index);
                    },
                    onLoadSuccess: function() {
                        setTimeout(function() {
                            $('#dgMain').datagrid('fixDetailRowHeight', index);
                        }, 0);
                    }
                });
                $('#dgMain').datagrid('fixDetailRowHeight', index);
            }
        });
    });
</script>