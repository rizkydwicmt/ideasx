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

    <div id="container" class="easyui-panel" style="width:100%;height:460px;padding:10px;">
        <table id="dgMain" class="easyui-datagrid" style="width:100%;height:420px;;" url="<?= base_url(); ?>accfin/Payment/getPayment/<?= $notrans; ?>" singleSelect="true" rownumbers="true" pagination="true" toolbar="#toolbarFilter">
            <thead>
                <tr>
                    <th field="id_payment" width="70">Index</th>
                    <th field="no_payment" width="150">Cash Disbursement #</th>
                    <th field="dt_payment" width="80">Date</th>
                    <th field="nama_rekanan" width="150" align="left">Employee/Supplier</th>
                    <th field="remarks" width="200" align="left">Remarks</th>
                    <th field="nominal" width="100" formatter="datagridFormatNumber" align="right">Total</th>
                    <th field="usr_ins" width="50" align="left">Usr Ins</th>
                    <th field="usr_upd" width="50" align="left">Usr Upd</th>
                    <th field="ispost" width="40" align="center">Post</th>
                    <th field="iscancel" width="40" align="center">Cancel</th>
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
    <div id="dlg" class="easyui-panel" style="width:100%;height:500px;padding:10px;" data-options="iconCls:'icon-save',closable:true,
                collapsible:true,minimizable:true,maximizable:true" closed="true">


        <form id="fm">

            <div class="row">
                <!-- BEGIN col-4 -->
                <div class="col-md-2">
                    <!-- BEGIN panel -->

                    <label>Index #</label>
                    <input id="id_payment" name="id_payment" class="form-control m-b-10 input-sm" readonly="true" />

                    <label>Cash Disbursement #</label>
                    <input id="no_payment" name="no_payment" class="form-control m-b-10 input-sm" readonly="true" />

                </div>

                <!-- BEGIN col-4 -->
                <div class="col-md-2">
                    <label class="control-label">Date<span class="text-danger">*</span></label>
                    <input id="dt_payment" name="dt_payment" class="form-control m-b-10 input-sm" required />
                    <div class="row">
                        <div class="col-xs-6">
                            <label style="width: 130px">Currency<span class="text-danger">*</span></label>
                            <Select id="id_curr" name="id_curr" class="form-control m-b-10 input-sm" required="true">
                                <option value="0">Select Currency</option>
                                <?php
                                foreach ($Currency as $row) {
                                    echo '<option value="' . $row["id_curr"] . '">' . $row["id_curr"] . '</option>';
                                }
                                ?>
                            </Select>
                        </div>
                        <div class="col-xs-6">
                            <label style="width: 130px">Rate :</label>
                            <input id="kurs" name="kurs" type="number" class="form-control m-b-10 input-sm" required="true" />
                        </div>
                    </div>
                </div>

                <!-- BEGIN col-4 -->
                <div class="col-md-4">
                    <label>Employee/Supplier Name<span class="text-danger">*</span></label>
                    <Select id="kd_rekanan" name="kd_rekanan" class="form-control m-b-10 input-sm" required="true">
                        <option value="0">Select Employee/Supplier</option>
                        <?php
                        foreach ($vendor as $row) {
                            echo '<option value="' . $row["kd_rekanan"] . '">' . $row["nama_rekanan"] . '</option>';
                        }
                        ?>
                    </Select>

                    <label class="control-label">Account [Cr]<span class="text-danger">*</span></label>
                    <Select id="id_rek_gl" name="id_rek_gl" class="form-control m-b-10 input-sm" required="true">
                        <option value="0">Select Account</option>
                        <?php
                        foreach ($coa_m as $row) {
                            echo '<option value="' . $row["id_rek_gl"] . '">' . $row["descriptions"] . '</option>';
                        }
                        ?>
                    </Select>
                </div>

                <div class="col-md-4">
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
                            name: "no_reff",
                            sizing: "small",
                            display: "Reff Number",
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
                            name: "description",
                            sizing: "large",
                            display: "Description",
                            ctrlCss: {
                                width: "450px"
                            },
                            ctrlAttr: {
                                required: "required"
                            }
                        },
                        {
                            name: "id_cc_project",
                            display: "CC/Project",
                            ctrlCss: {
                                width: "80px"
                            },
                            ctrlAttr: {
                                placeholder: "Click me!",
                                required: "required"
                            },
                            events: {
                                click: function(e) {
                                    rowIndex = myAppendGrid.getRowIndex(parseInt(e.uniqueIndex));
                                    fect_ccpro_data(rowIndex); // show modal
                                }
                            }
                        },
                        {
                            name: "id_rek_gl",
                            display: "Account [Dr]",
                            ctrlAttr: {
                                placeholder: "Click me!",
                                required: "required"
                            },
                            ctrlCss: {
                                width: "80px"
                            },
                            events: {
                                click: function(e) {
                                    rowIndex = myAppendGrid.getRowIndex(parseInt(e.uniqueIndex));
                                    fect_coa_data(rowIndex);
                                    //$("#myModalCoa").modal('show'); // show modal
                                }
                            }
                        },

                        {
                            name: "dibayar",
                            display: "Nominal",
                            type: "number",
                            ctrlClass: "text-right",
                            ctrlCss: {
                                "width": "120px",
                            },
                            ctrlAttr: {
                                required: "required"
                            },
                            events: {
                                change: function(e) {
                                    reTotalGrid();
                                }
                            }
                        },
                        {
                            name: "id_payment_detail",
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
                    afterRowRemoved: function(caller, rowIndex) {
                        reTotalGrid();
                    },
                    sectionClasses: {
                        table: "table-sm",
                        control: "form-control-sm",
                        buttonGroup: "btn-group-sm"
                    }
                });
                // //--------------------------------
            </script>

            <hr>
            <div class="row">
                <div class="col-md-3">

                </div>
                <div class="col-md-3">

                </div>


                <span style="width: 50px"> </span>

                <div class="col-md-4">
                    <div class="row">
                        <div class="row">
                            <div class="col">
                            </div>
                            <div class="col">
                                <label style="width:110px; text-align: Center;">Total</label>
                            </div>
                            <div class="col">
                                <input id="vtotal" name="vtotal" class="easyui-numberbox" data-options="precision:2,groupSeparator:','" style="width:150px;text-align: right;height: 30px" />
                            </div>
                            <div class="col"></div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="ftitle"></div>
            <div id="dlg-buttons">
                <a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="saveDatax()">Save</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').panel('close')">Cancel</a>
            </div>


        </form>

    </div>

</div>

<!-- END #content -->

<!-- Modal ITEM -->

<div id="wi" class="easyui-window" title="Reference Data" data-options="modal:true,closed:true,iconCls:'icon-save'" style="width:650px;height:500px;padding:10px;">
    <table id="dgItem" class="easyui-datagrid" stripped="true" style="width:620px;height:400px;" singleSelect="true" pagination="true" toolbar="#toolbarItem">
        <thead>
            <tr>
                <th field="no_doc" width="100">Reff Number</th>
                <th field="dt_doc" width="100">Date</th>
                <th field="remarks" width="250">Remarks</th>
                <th field="id_rek_gl" width="50">Account #</th>
                <th field="id_cc_project" width="50">CC/Project</th>
                <th field="nama_transaksi" width="200">Transaction</th>
                <th field="sisa" width="100" formatter="datagridFormatNumber" align="right">Nominal</th>
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
</div>
<!-- END item modal -->


<!--  easyui Coa modal -->
<div id="w" class="easyui-window" title="COA Data" data-options="modal:true,closed:true,iconCls:'icon-save'" style="width:550px;height:500px;padding:10px;">
    <table id="dgCoa" class="easyui-datagrid" style="width:520px;height:400px;" singleSelect="true" pagination="true" toolbar="#toolbarCoa">
        <thead>
            <tr>
                <th field="id_rek_gl" width="100">Accouont #</th>
                <th field="descriptions" width="300">Description</th>
            </tr>
        </thead>
    </table>

    <div id="toolbarCoa" style="padding-left: 10px">
        <span>Filter :</span>
        <input id="filterValcoa" onkeyup="inputKeyEntercoa(event)" style="border:1px solid #ccc">
        <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearchcoa()">Search</a>
    </div>

    <br>

    <div id="dlg-buttons">
        <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#w').window('close')">Close</a>
    </div>
</div>
<!-- END easyui Coa modal -->

<!--  CC/Project modal -->
<div id="wp" class="easyui-window" title="Cost Center/Project Data" data-options="modal:true,closed:true,iconCls:'icon-save'" style="width:550px;height:500px;padding:10px;">
    <table id="dgCcpro" class="easyui-datagrid" style="width:520px;height:400px;" singleSelect="true" pagination="true" toolbar="#toolbarCcpro">
        <thead>
            <tr>
                <th field="id_cc_project" width="100">CC/Project #</th>
                <th field="cc_project_name" width="300">Description</th>
                <th field="jenis" width="300">Group</th>
            </tr>
        </thead>
    </table>

    <div id="toolbarCcpro" style="padding-left: 10px">
        <span>Filter :</span>
        <input id="filterValCcpro" onkeyup="inputKeyEnterCcpro(event)" style="border:1px solid #ccc">
        <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearchCcpro()">Search</a>
    </div>

    <br>

    <div id="dlg-buttons">
        <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#wp').window('close')">Close</a>
    </div>
</div>
<!-- END easyui Coa modal -->


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

        $("#dt_payment").datepicker({
            changeMonth: true,
            changeYear: true,
            gotoCurrent: true
        });
        $("#dt_payment").datepicker("option", "dateFormat", "dd/mm/yy");
        $("#dt_payment").datepicker("setDate", "today");

        doSearch();

    });


    function inputKeyEnter(e) {
        e.which = e.which || e.keyCode;
        if (e.which == 13) {
            doSearch();
        }
    }

    function inputKeyEntercoa(e) {
        e.which = e.which || e.keyCode;
        if (e.which == 13) {
            doSearchcoa();
        }
    }

    function inputKeyEnteritem(e) {
        e.which = e.which || e.keyCode;
        if (e.which == 13) {
            doSearchitem();
        }
    }

    function inputKeyEnterCcpro(e) {
        e.which = e.which || e.keyCode;
        if (e.which == 13) {
            doSearchCcpro();
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
        $("#dlg").panel('setTitle', 'New Cash Disbursement');
        $('#dlg').panel('open');
        $('#fm').form('clear');
        document.getElementById('id_payment').value = '';
        document.getElementById('no_payment').value = '';
        document.getElementById('kd_rekanan').value = '0';
        $("#dt_payment").datepicker("setDate", "today");
        document.getElementById('id_curr').value = 'IDR';
        document.getElementById('kurs').value = '1';
        document.getElementById('remarks').value = '';
        document.getElementById('id_rek_gl').value = '0';


        $('#vtotal').numberbox('setValue', 0);

        url = '<?= base_url(); ?>accfin/Payment/insertPayment/<?= $notrans; ?>';
        mode = 'add';
        myAppendGrid.load([{
            no_reff: "",
            description: "",
            id_rek_gl: "",
            dibayar: ""
        }]);
        scrollSmoothToBottom('content')
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


            $("#dlg").panel('setTitle', 'Update Cash Disbursement');
            $('#dlg').panel('open');
            //  $('#fm').form('load', row);
            document.getElementById('id_payment').value = row.id_payment;
            document.getElementById('no_payment').value = row.no_payment;
            $("#dt_payment").datepicker("setDate", row.dt_payment_str);
            document.getElementById('id_rek_gl').value = row.id_rek_gl;
            document.getElementById('kd_rekanan').value = row.kd_rekanan;
            document.getElementById('id_curr').value = row.id_curr;
            document.getElementById('kurs').value = row.kurs;
            document.getElementById('remarks').value = row.remarks;
            $('#vtotal').numberbox('setValue', row.nominal);

            // alert(row.nama_rekanan);
            url = '<?= base_url(); ?>accfin/payment/updatepayment/' + row.id_payment;
            mode = 'edit';
            getDetailData(row.id_payment);
            scrollSmoothToBottom('content')
        }
    }

    function saveDatax() {

        reTotalGrid();


        var kd_rekanan = $("#kd_rekanan").val();
        var dt_payment = $("#dt_payment").val();
        var id_curr = $("#id_curr").val();
        var kurs = $("#kurs").val();
        var remarks = $("#remarks").val();
        var id_rek_gl = $("#id_rek_gl").val();
        var total = $('#vtotal').numberbox('getValue');


        // VALIDATION FORM --------------------------------------
        if (dt_payment == '') {
            Swal.fire(
                'Field Date Required.....!!!'
            )
            return false;
        } else if (kd_rekanan == '0') {
            Swal.fire(
                'Field Employee/Supplier Required.....!!!'
            )
            return false;
        } else if (id_rek_gl == '0') {
            Swal.fire(
                'Field Account [Cr] Required.....!!!'
            )
            return false;
        } else if (id_rek_gl == '') {
            Swal.fire(
                'Field Account [Cr] Required.....!!!'
            )
            return false;
        } else if (id_curr == '0') {
            Swal.fire(
                'Field Currency Required.....!!!'
            )
            return false;
        }


        var master = [];

        master.push({
            kd_rekanan: kd_rekanan,
            dt_payment: dt_payment,
            id_curr: id_curr,
            kurs: kurs,
            remarks: remarks,
            id_rek_gl: id_rek_gl,
            an: '-',
            bank: '-',
            jns_ttbg: '-',
            no_cek_bg_tt: '-',
            total: total
        });


        var rows = [];

        var data = myAppendGrid.getAllValue();
        var rowCount = myAppendGrid.getRowCount();

        //cek field first
        for (var i = 0; i <= rowCount - 1; i++) {
            var rowValues = myAppendGrid.getRowValue(i);
            if (rowValues.description == '') {
                Swal.fire(
                    'Field Description -> row ' + [i] + ' must have value.....!!!'
                )
                return false
            } else if (rowValues.id_rek_gl == '') {
                Swal.fire(
                    'Field Account # -> row ' + [i] + ' must have value.....!!!'
                )
                return false
            } else if (rowValues.dibayar == '') {
                Swal.fire(
                    'Field Nominal -> row ' + [i] + ' must have value.....!!!'
                )
                return false
            } else if (rowValues.dibayar == '0') {
                Swal.fire(
                    'Field Nominal -> row ' + [i] + ' must have value.....!!!'
                )
                return false
            } else if (rowValues.id_cc_project == '') {
                Swal.fire(
                    'Field CC/Project  -> row ' + [i] + ' must have value.....!!!'
                )
                return false;
            }
        };

        for (var i = 0; i <= rowCount - 1; i++) {
            if ((data[i].id_rek_gl)) {
                if ((data[i].no_reff)) {
                    var no_reff = data[i].no_reff;
                } else {
                    var no_reff = '-'
                }

                rows.push({
                    uid: data[i].id_payment_detail,
                    no_reff: no_reff,
                    description: data[i].description,
                    id_rek_gl: data[i].id_rek_gl,
                    id_cc_project: data[i].id_cc_project,
                    dibayar: data[i].dibayar
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
                    url: "<?= base_url(); ?>accfin/Payment/destroyPayment",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        id: row.id_payment
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

    function doSearchcoa() {
        $('#dgCoa').datagrid('load', {
            searching_coa: $('#filterValcoa').val()
        });
    }

    function doSearchCcpro() {
        $('#dgCcpro').datagrid('load', {
            searching_ccpro: $('#filterValCcpro').val()
        });
    }

    function doSearchitem() {
        $('#dgItem').datagrid('load', {
            searching_item: $('#filterValitem').val()
        });
    }


    function reTotalGrid() {
        var data = myAppendGrid.getAllValue();
        var rowCount = myAppendGrid.getRowCount();

        var xtotal = 0;
        for (var i = 0; i <= rowCount - 1; i++) {
            if (data[i].dibayar != '') {
                xtotal = xtotal + parseFloat(data[i].dibayar);
            };
        };

        $('#vtotal').numberbox('setValue', xtotal);
    }



    function getDetailData($idd) {

        $.ajax({
            url: "<?= base_url(); ?>accfin/Payment/getPaymentDetail",
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



    function fect_coa_data(irow) {
        $('#dgCoa').datagrid({
            url: "<?= base_url(); ?>accfin/Payment/fetchCoaNumber"
        });

        $('#w').window('open');

        $('#dgCoa').datagrid({
            onDblClickRow: function() {
                var row = $('#dgCoa').datagrid('getSelected');
                if (row) {
                    myAppendGrid.setCtrlValue("id_rek_gl", irow, row.id_rek_gl);
                    $('#w').window('close'); // hide modal
                }
            }
        });

    };

    function fect_ccpro_data(irow) {
        $('#dgCcpro').datagrid({
            url: "<?= base_url(); ?>accfin/Payment/fetchCcproData"
        });

        $('#wp').window('open');

        $('#dgCcpro').datagrid({
            onDblClickRow: function() {
                var row = $('#dgCcpro').datagrid('getSelected');
                if (row) {
                    myAppendGrid.setCtrlValue("id_cc_project", irow, row.id_cc_project);
                    $('#wp').window('close'); // hide modal
                }
            }
        });

    };


    function fect_item_data(irow) {
        var idx = $("#kd_rekanan").val();
        if (idx == '0') {
            Swal.fire(
                'Field Employee/Supplier Required.....!!!'
            )
            return false;
        }

        $('#dgItem').datagrid({
            url: "<?= base_url(); ?>accfin/Payment/fetchItem/" + idx
        });

        $('#wi').window('open');

        $('#dgItem').datagrid({
            onDblClickRow: function() {
                var row = $('#dgItem').datagrid('getSelected');
                if (row) {
                    myAppendGrid.setCtrlValue("no_reff", irow, row.no_doc);
                    myAppendGrid.setCtrlValue("description", irow, row.remarks);
                    myAppendGrid.setCtrlValue("id_rek_gl", irow, row.id_rek_gl);
                    myAppendGrid.setCtrlValue("id_cc_project", irow, row.id_cc_project);
                    myAppendGrid.setCtrlValue("dibayar", irow, row.sisa);
                    $('#wi').window('close'); // hide modal
                    reTotalGrid();
                }
            }
        });

    };



    $(function() {
        $('#dgMain').datagrid({
            view: detailview,
            detailFormatter: function(index, row) {
                return '<div style="padding:2px"><table id="ddv-' + index + '"></table></div>';
            },
            onExpandRow: function(index, row) {
                $('#ddv-' + index).datagrid({
                    url: '<?= base_url(); ?>accfin/Payment/getDetailPayment/' + row.id_payment,
                    // fitColumns: true,
                    singleSelect: true,
                    height: 'auto',
                    //pagination: true,
                    showFooter: true,
                    columns: [
                        [{
                                field: 'no_reff',
                                title: 'No. Reff',
                                width: 100
                            },
                            {
                                field: 'description',
                                title: 'Description',
                                width: 400
                            },
                            {
                                field: 'id_cc_project',
                                title: 'CC/Project',
                                width: 80
                            },
                            {
                                field: 'id_rek_gl',
                                title: 'Account [Dr]',
                                width: 80
                            },
                            {
                                field: 'dibayar',
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