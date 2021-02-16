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
        <table id="dgMain" class="easyui-datagrid" style="width:100%;height:360px;;" url="<?= base_url(); ?>procurement/Pr/getPr" singleSelect="true" rownumbers="true" pagination="true" toolbar="#toolbarFilter">
            <thead>
                <tr>
                    <th field="kd_pr" width="70">Index</th>
                    <th field="no_pr" width="120">PR Number</th>
                    <th field="dt_pr" width="80">Date</th>
                    <th field="id_cc_project" width="80">CC/Project #</th>
                    <th field="requester" width="250">Requester</th>
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
    <!-- Modal -->
    <br>
    <div id="dlg" class="easyui-panel" style="width:100%;height:400px;padding:10px;" data-options="iconCls:'icon-save',closable:true,
                collapsible:true,minimizable:true,maximizable:true" closed="true">


        <form id="fm">

            <div class="row">
                <!-- BEGIN col-4 -->
                <div class="col-md-2">

                    <label>Index #</label>
                    <input id="kd_pr" name="kd_pr" class="form-control m-b-10 input-sm" readonly="true" />

                    <label>PR Number #</label>
                    <input id="no_pr" name="no_pr" class="form-control m-b-10 input-sm" readonly="true" />
                </div>



                <!-- BEGIN col-4 -->
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-xs-4">
                            <label class="control-label">Date<span class="text-danger">*</span></label>
                            <input id="dt_pr" name="dt_pr" class="form-control m-b-10 input-sm" />
                        </div>
                        <div class="col-xs-8">
                            <label style="width: 130px">Requester</label>
                            <input id="requester" name="requester" class="form-control m-b-10 input-sm" />
                        </div>
                    </div>
                    <label>CC/Project<span class="text-danger">*</span></label>
                    <Select id="id_cc_project" name="id_cc_project" class="form-control m-b-10 input-sm">
                        <option value="">Select CC/Project</option>
                        <?php
                        foreach ($project as $row) {
                            echo '<option value="' . $row["id_cc_project"] . '">' . $row["id_cc_project"] . ' | ' . $row["cc_project_name"] . '</option>';
                        }
                        ?>
                    </Select>
                </div>

                <div class="col-md-3">
                    <label>Remarks</label>
                    <textarea class="form-control" name="remarks" id="remarks" rows="4"></textarea>
                </div>





            </div>

            <!-- BEGIN #detail -->

            <table id="tblAppendGrid"></table>
            <!--JS required for Bootstrap-->

            <!--AppendGrid library-->
            <script src="<?= base_url('assets/appgrid/dist/'); ?>AppendGrid.js"></script>
            <!--Script for initialize AppendGrid-->
            <script>
                var rowIndex;
                var myAppendGrid = new AppendGrid({
                    element: "tblAppendGrid",
                    uiFramework: "bootstrap4",
                    iconFramework: "default",
                    sizing: "small",
                    columns: [{
                            name: "kd_item",
                            sizing: "small",
                            display: "Item #",
                            ctrlAttr: {
                                placeholder: "Click me!"
                            },
                            ctrlCss: {
                                width: "100px"
                            },
                            events: {
                                click: function(e) {
                                    rowIndex = myAppendGrid.getRowIndex(parseInt(e.uniqueIndex));
                                    fect_item_data(rowIndex); // show modal
                                }
                            }
                        },

                        {
                            name: "deskripsi",
                            sizing: "large",
                            display: "Description",
                            ctrlCss: {
                                width: "400px"
                            },
                        },

                        {
                            name: "kd_satuan",
                            sizing: "small",
                            display: "Unit",
                            ctrlCss: {
                                width: "80px"
                            },
                        },
                        {
                            name: "qty",
                            display: "Qty",
                            type: "number",
                            ctrlClass: "text-center",
                            ctrlCss: {
                                width: "80px"
                            }
                        },


                        {
                            name: "dt_kebutuhan",
                            display: "Expectation Delivery",
                            type: "date",
                            ctrlAttr: {
                                maxlength: 10
                            }
                        },

                        {
                            name: "kd_pr_detail",
                            type: "hidden",
                            value: "0"
                        }
                    ],
                    hideButtons: {
                        // Hide the move up and move down button on each row
                        moveUp: true,
                        moveDown: true,
                        insert: true
                    },
                    sectionClasses: {
                        table: "table-sm",
                        control: "form-control-sm",
                        buttonGroup: "btn-group-sm"
                    }
                });
            </script>

            <hr>

            <div class="ftitle"></div>
            <div id="dlg-buttons">
                <a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="saveDatax()">Save</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').panel('close')">Cancel</a>
            </div>


        </form>

    </div>

</div>

<!-- END #content -->s


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
                        myAppendGrid.setCtrlValue("kd_item", irow, row.kd_item);
                        myAppendGrid.setCtrlValue("deskripsi", irow, row.nama_item);
                        myAppendGrid.setCtrlValue("kd_satuan", irow, row.kd_satuan_beli);
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
        $("#dds").datepicker("setDate", "today");


        $("#dde").datepicker({
            changeMonth: true,
            changeYear: true,
            gotoCurrent: true
        });
        $("#dde").datepicker("option", "dateFormat", "dd/mm/yy");
        $("#dde").datepicker("setDate", "today");

        $("#dt_pr").datepicker({
            changeMonth: true,
            changeYear: true,
            gotoCurrent: true
        });
        $("#dt_pr").datepicker("option", "dateFormat", "dd/mm/yy");

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
        $("#dlg").panel('setTitle', 'New Purchase Requisition');
        $('#dlg').panel('open');
        $('#fm').form('clear');
        document.getElementById('id_cc_project').value = '';
        document.getElementById('remarks').value = '';
        document.getElementById('requester').value = '';
        $("#dt_pr").datepicker("setDate", "today");

        url = '<?= base_url(); ?>procurement/Pr/insertPr';
        myAppendGrid.load([{
            kd_item: "",
            descriptions: "",
            kd_satuan: "",
            qty: "",
            dt_kebutuhan: ""
        }]);
        mode = 'add';
        scrollSmoothToBottom('content')
    }

    function editData() {
        var row = $('#dgMain').datagrid('getSelected');
        if (row) {
            $("#dlg").panel('setTitle', 'Update Purchase Requisition');
            $('#dlg').panel('open');
            //  $('#fm').form('load', row);
            document.getElementById('kd_pr').value = row.kd_pr;
            document.getElementById('no_pr').value = row.no_pr;
            document.getElementById('dt_pr').value = row.dt_pr_str;
            document.getElementById('id_cc_project').value = row.id_cc_project;
            document.getElementById('requester').value = row.requester;
            document.getElementById('remarks').value = row.remarks;


            // alert(row.nama_rekanan);
            url = '<?= base_url(); ?>procurement/Pr/updatePr/' + row.kd_pr;
            mode = 'edit';
            getDetailData(row.kd_pr);
            scrollSmoothToBottom('content')
        }
    }

    function saveDatax() {

        var dt_pr = $("#dt_pr").val();
        var id_cc_project = $("#id_cc_project").val();
        var remarks = $("#remarks").val();
        var requester = $("#requester").val();

        // VALIDATION FORM --------------------------------------
        if (dt_pr == '') {
            Swal.fire(
                'Field Date Required.....!!!'
            )
            return false;
        } else if (requester == '') {
            Swal.fire(
                'Field Requester Required.....!!!'
            )
            return false;
        } else if (id_cc_project == '') {
            Swal.fire(
                'Field CC/Project Required.....!!!'
            )
            return false;
        }


        var master = [];

        master.push({
            dt_pr: dt_pr,
            requester: requester,
            id_cc_project: id_cc_project,
            remarks: remarks,
            id_trans: <?= $notrans; ?>
        });


        var rows = [];

        var data = myAppendGrid.getAllValue();
        var rowCount = myAppendGrid.getRowCount();

        //cek field first
        for (var i = 0; i <= rowCount - 1; i++) {
            var rowValues = myAppendGrid.getRowValue(i);
            if (rowValues.deskripsi == '') {
                Swal.fire(
                    'Field Description -> row ' + [i] + ' must have value.....!!!'
                )
                return false
            } else if (rowValues.kd_item == '') {
                Swal.fire(
                    'Field Item ID # -> row ' + [i] + ' must have value.....!!!'
                )
                return false
            } else if (rowValues.qty == '') {
                Swal.fire(
                    'Field Qty -> row ' + [i] + ' must have value.....!!!'
                )
                return false
            } else if (rowValues.qty == '0') {
                Swal.fire(
                    'Field Qty -> row ' + [i] + ' must have value.....!!!'
                )
                return false
            } else if (rowValues.dt_kebutuhan == '') {
                Swal.fire(
                    'Field Expected Delivery -> row ' + [i] + ' must have value.....!!!'
                )
                return false
            }
        };

        for (var i = 0; i <= rowCount - 1; i++) {
            if (data[i].kd_item != '') {
                rows.push({
                    kd_pr_detail: data[i].kd_pr_detail,
                    kd_item: data[i].kd_item,
                    deskripsi: data[i].deskripsi,
                    qty: data[i].qty,
                    kd_satuan: data[i].kd_satuan,
                    dt_kebutuhan: data[i].dt_kebutuhan
                });

            }
        };



        var data = [];
        data.push({
            master: master,
            detail: rows
        })

        $.ajax({
            url: url,
            method: "POST",
            dataType: 'json',
            data: {
                info: data
            },
            error: function() {
                if (mode == 'add') {
                    document.getElementById("addError").click(); // Click on the checkbox
                } else {
                    document.getElementById("editError").click(); // Click on the checkbox
                }
            },
            success: function(data) {
                $('#dgMain').datagrid('reload'); // reload the user data
                $('#dlg').panel('close');
                if (mode == 'add') {
                    document.getElementById("addSuccess").click(); // Click on the checkbox
                } else {
                    document.getElementById("editSuccess").click(); // Click on the checkbox
                }
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



    function getDetailData($idd) {

        $.ajax({
            url: "<?= base_url(); ?>procurement/Pr/getPrDetail",
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
                    url: '<?= base_url(); ?>procurement/Pr/fetchPrDetail/' + row.kd_pr,
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