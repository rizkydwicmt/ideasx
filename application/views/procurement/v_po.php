<!-- BEGIN #content -->
<div id="content" class="content">
    <!-- BEGIN breadcrumb -->
    <ul class="breadcrumb">
        <!--
        <li class="breadcrumb-item"><a href="#">LAYOUT</a></li>
        <li class="breadcrumb-item active">STARTER PAGE</li>-->
        <li class="breadcrumb-item"><a href="#">Procurement</a></li>
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
        <table id="dgMain" class="easyui-datagrid" style="width:100%;height:460px;;" url="<?= base_url(); ?>procurement/Po/getPo" singleSelect="true" striped="true" nowrap="false" rownumbers="true" fitColumns="true" pagination="true" toolbar="#toolbarFilter">
            <thead>
                <tr>
                    <th field="kd_po" width="70">Index</th>
                    <th field="po_number" width="120">PO Number</th>
                    <th field="po_date" width="80">Date</th>
                    <th field="dt_delivery" width="80">Delivery Date</th>
                    <th field="nama_rekanan" width="270" align=left>Supplier Name</th>
                    <th field="id_cc_project" width="80">CC/Project #</th>
                    <th field="total" width="100" formatter="datagridFormatNumber" align="right">PO Value</th>
                    <th field="vat_str" width="100" align="left">VAT</th>
                    <th field="usr_ins" width="50" align="left">Usr Ins</th>
                    <th field="usr_upd" width="50" align="left">Usr Upd</th>
                    <th field="ispost" width="60" align="center">Posted</th>
                    <th field="iscancel" width="60" align="center">Cancel</th>
                </tr>
            </thead>
        </table>

        <div id="toolbarFilter" style="padding-left: 10px">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="newData()">New</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editData()">Edit</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onClick="removeData()">Destroy</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="javascript:$('#dgMain').datagrid('reload'); ">Refresh</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true" onClick="printData()">Print</a>
            <!-- <a href="<?= base_url(); ?>procurement/Po/cetakPo/" target="_blank" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a> -->
        </div>




    </div>
    <!-- Modal -->
    <br>

    <!-- END #content -->s


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

    function doSearch() {
        $('#dgMain').datagrid('load', {
            dt_awal: $("#dds").val(),
            dt_akhir: $("#dde").val(),
            searching: $('#filterVal').val()
        });
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
            url: "<?= base_url(); ?>procurement/Po/newPo",
            method: "POST",
            dataType: 'json',
            data: {
                dtx: tg1 + '_' + tg2
            },
            error: function() {
                document.getElementById("addError").click();
            },
            success: function(data) {
                window.open('<?= base_url(); ?>procurement/Po/loadPo', '_self');
            }
        });
    }


    function editData() {
        var row = $('#dgMain').datagrid('getSelected');
        if (row) {
            if (row.ispost == '1') {
                Swal.fire(
                    'Data has been Posted !!!'
                )
                return false;
            }
            var artg1 = $("#dds").val().split('/');
            var tg1 = artg1[0] + artg1[1] + artg1[2];
            var artg2 = $("#dde").val().split('/');
            var tg2 = artg2[0] + artg2[1] + artg2[2];

            $.ajax({
                url: "<?= base_url(); ?>procurement/Po/editPo",
                method: "POST",
                dataType: 'json',
                data: {
                    dtx: tg1 + '_' + tg2,
                    id: row.kd_po
                },
                error: function() {
                    document.getElementById("editError").click(); // Click on the checkbox
                },
                success: function(data) {
                    //myAppendGrid.load(data);
                    //document.getElementById("addSuccess").click(); // Click on the checkbox
                    window.open('<?= base_url(); ?>procurement/Po/loadPo', '_self');
                }
            });
        }
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
                    url: "<?= base_url(); ?>procurement/Po/destroyPo",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        id: row.kd_po
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


    function printData() {
        var row = $('#dgMain').datagrid('getSelected');
        if (row) {
            window.open('<?= base_url(); ?>procurement/Po/cetakPo/' + row.kd_po);
        }
    }


    function getDetailData($idd) {

        $.ajax({
            url: "<?= base_url(); ?>procurement/Po/getPoDetail",
            method: "POST",
            dataType: 'json',
            data: {
                idd: $idd
            },
            error: function() {
                document.getElementById("delError").click(); // Click on the checkbox
            },
            success: function(data) {
                myAppendGrid.load(data);
            }
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
                    url: '<?= base_url(); ?>procurement/Po/fetchPoDetail/' + row.kd_po,
                    // fitColumns: true,
                    singleSelect: true,
                    height: 'auto',
                    //pagination: true,
                    showFooter: true,
                    columns: [
                        [{
                                field: 'kd_item',
                                title: 'Item Id',
                                width: 100
                            },
                            {
                                field: 'descriptions',
                                title: 'Description',
                                width: 400
                            },
                            {
                                field: 'kd_satuan',
                                title: 'Unit',
                                width: 80
                            },
                            {
                                field: 'qty',
                                title: 'Qty',
                                width: 80
                            },
                            {
                                field: 'unit_price',
                                title: 'Unit Price',
                                align: 'right',
                                width: 100
                            },
                            {
                                field: 'extended',
                                title: 'Ammount',
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