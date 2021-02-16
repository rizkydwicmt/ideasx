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

    <div id="container" class="easyui-panel" style="width:100%;height:400px;padding:10px;">
        <table id="dgMain" class="easyui-datagrid" style="width:100%;height:360px;;" url="<?= base_url(); ?>procurement/Pr/getPr" singleSelect="true" fitColumns="true" nowrap="false" rownumbers="true" pagination="true" toolbar="#toolbarFilter">
            <thead>
                <tr>
                    <th field="kd_pr" width="70">Index</th>
                    <th field="no_pr" width="120">Requiistion #</th>
                    <th field="dt_pr" width="80">Date</th>
                    <th field="id_cc_project" width="80">CC/Project #</th>
                    <th field="requester" width="100">Requester</th>
                    <th field="remarks" width="200">Remarks</th>
                    <th field="usr_ins" width="80" align="left">Usr Ins</th>
                    <th field="usr_upd" width="80" align="left">Usr Upd</th>
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
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
        </div>
    </div>
</div>
<!-- END #content -->




<!-- Modal ITEM -->

<div id="wi" class="easyui-window" title="Item Data" data-options="modal:true,closed:true,iconCls:'icon-save'" style="width:650px;height:500px;padding:10px;">
    <table id="dgItem" class="easyui-datagrid" stripped="true" style="width:620px;height:400px;" singleSelect="true" pagination="true" toolbar="#toolbarItem">
        <thead>
            <tr>
                <th field="kd_item" width="100">Item #</th>
                <th field="nama_item" width="250">Item Name</th>
                <th field="kd_satuan_beli" width="50">Unit</th>
                <th field="item_type_name" width="200">Item Type</th>
            </tr>
        </thead>
    </table>

    <div id="toolbarItem" style="padding-left: 10px">
        <span>Filter :</span>
        <input id="filterValitem" onkeyup="inputKeyEnteritem(event)" style="border:1px solid #ccc">
        <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearchitem()">Search</a>
    </div>

    <br>

    <div id="dlg-buttons">
        <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#wi').window('close')">Close</a>
    </div>

    <script type="text/javascript">
        function inputKeyEnteritem(e) {
            e.which = e.which || e.keyCode;
            if (e.which == 13) {
                doSearchitem();
            }
        };

        function doSearchitem() {
            $('#dgItem').datagrid('load', {
                searching_item: $('#filterValitem').val()
            });
        };

        function fect_item_data(irow) {

            $('#dgItem').datagrid({
                url: "<?= base_url(); ?>procurement/Pr/fetchItem"
            });

            $('#wi').window('open');

            $('#dgItem').datagrid({
                onDblClickRow: function() {
                    var row = $('#dgItem').datagrid('getSelected');
                    if (row) {
                        // myAppendGrid.setCtrlValue("kd_item", irow, row.kd_item);
                        // myAppendGrid.setCtrlValue("deskripsi", irow, row.nama_item);
                        // myAppendGrid.setCtrlValue("kd_satuan", irow, row.kd_satuan_beli);
                        $('#wi').window('close'); // hide modal
                    }
                }
            });

        };
    </script>
</div>
<!-- END item modal -->

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
            url: "<?= base_url(); ?>procurement/Pr/newPr",
            method: "POST",
            dataType: 'json',
            data: {
                dtx: tg1 + '_' + tg2
            },
            error: function() {
                document.getElementById("addError").click();
            },
            success: function(data) {
                window.open('<?= base_url(); ?>procurement/Pr/loadPr', '_self');
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
                url: "<?= base_url(); ?>procurement/Pr/editPr",
                method: "POST",
                dataType: 'json',
                data: {
                    dtx: tg1 + '_' + tg2,
                    id: row.kd_pr
                },
                error: function() {
                    document.getElementById("editError").click(); // Click on the checkbox
                },
                success: function(data) {
                    //myAppendGrid.load(data);
                    //document.getElementById("addSuccess").click(); // Click on the checkbox
                    window.open('<?= base_url(); ?>procurement/Pr/loadPr', '_self');
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
                    url: "<?= base_url(); ?>procurement/Pr/destroyPr",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        id: row.kd_pr
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

    $(function() {
        $('#dgMain').datagrid({
            view: detailview,
            detailFormatter: function(index, row) {
                return '<div style="padding:2px"><table id="ddv-' + index + '"></table></div>';
            },
            onExpandRow: function(index, row) {
                $('#ddv-' + index).datagrid({
                    url: '<?= base_url(); ?>procurement/Pr/fetchPrDetail/' + row.kd_pr,
                    fitColumns: true,
                    singleSelect: true,
                    nowrap: false,
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
                                field: 'deskripsi',
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
                                field: 'dt_kebutuhan',
                                title: 'Expected Delivery',
                                align: 'left',
                                width: 150
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