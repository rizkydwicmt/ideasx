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
        <table id="dgMain" class="easyui-datagrid" style="width:100%;height:460px;;" url="<?= base_url(); ?>accfin/Settlement/getSettlement/<?= $notrans; ?>" singleSelect="true" rownumbers="true" pagination="true" toolbar="#toolbarFilter">
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
    <div id="dlg" class="easyui-panel" style="width:100%;height:500px;padding:10px;" data-options="iconCls:'icon-save',closable:true,
                collapsible:true,minimizable:true,maximizable:true" closed="true">


        <form id="fm">

            <div class="row">
                <!-- BEGIN col-4 -->
                <div class="col-md-2">
                    <!-- BEGIN panel -->

                    <div class="row">
                        <div class="col-xs-4">
                            <label style="width: 130px">Index #</label>
                            <input id="id_settlement" name="id_settlement" class="form-control m-b-10 input-sm" readonly="true" />
                        </div>
                        <div class="col-xs-8">
                            <label style="width: 130px">Settlement #</label>
                            <input id="no_settlement" name="no_settlement" class="form-control m-b-10 input-sm" readonly="true" />
                        </div>
                    </div>


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
                <div class="col-md-2">
                    <label class="control-label">Date<span class="text-danger">*</span></label>
                    <input id="dt_settlement" name="dt_settlement" class="form-control m-b-10 input-sm" required />
                    <div class="row">
                        <div class="col-xs-6">
                            <label style="width: 130px">Departure<span class="text-danger">*</span></label>
                            <input id="dt_berangkat" name="dt_berangkat" class="form-control m-b-10 input-sm" />
                        </div>
                        <div class="col-xs-6">
                            <label style="width: 130px">Arrival<span class="text-danger">*</span></label>
                            <input id="dt_datang" name="dt_datang" class="form-control m-b-10 input-sm" />
                        </div>
                    </div>
                </div>

                <!-- BEGIN col-4 -->
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-xs-8">
                            <label>Employee/Supplier Name<span class="text-danger">*</span></label>
                            <Select id="kd_rekanan" name="kd_rekanan" class="form-control m-b-10 input-sm" required="true">
                                <option value="0">Select Employee/Supplier</option>
                                <?php
                                foreach ($vendor as $row) {
                                    echo '<option value="' . $row["kd_rekanan"] . '">' . $row["nama_rekanan"] . '</option>';
                                }
                                ?>
                            </Select>
                        </div>
                        <div class="col-xs-4">
                            <label class="control-label" onclick="fetchCaData()" style="cursor:pointer">CA Number <span class="text-danger">*</span> <i class="ti-search"></i></label>
                            <input id="nokasbon" name="nokasbon" class="form-control m-b-10 input-sm" readonly="true">

                        </div>
                    </div>

                    <label style="width: 130px">CC/Project<span class="text-danger">*</span></label>
                    <Select id="id_cc_project" name="id_cc_project" class="form-control m-b-10 input-sm" required="tue">
                        <option value="0">Select CC/Project</option>
                        <?php
                        foreach ($project as $row) {
                            echo '<option value="' . $row["id_cc_project"] . '">' . $row["id_cc_project"] . ' | ' . $row["cc_project_name"] . ' -> ' . $row["vccpro"] . '</option>';
                        }
                        ?>
                    </Select>
                </div>

                <div class="col-md-4">


                    <label>CA Purpose</label>
                    <input class="form-control m-b-10 input-sm" name="kasbon_untuk" id="kasbon_untuk" readonly="true"></input>
                    <div class="row">
                        <div class="col-xs-6">
                            <label class="control-label">CA Date</label>
                            <input id="dt_kasbon" name="dt_kasbon" class="form-control m-b-10 input-sm" readonly="true" />
                        </div>
                        <div class="col-xs-6">
                            <label class="control-label">Account [Cr] #</label>
                            <input id="id_rek_gl" name="id_rek_gl" class="form-control m-b-10 input-sm" readonly="true" />
                        </div>
                    </div>

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
                            name: "dt_biaya",
                            sizing: "small",
                            display: "Date",
                            type: "date",
                            ctrlAttr: {
                                maxlength: 5,
                                required: "required"
                            },
                            ctrlCss: {
                                width: "135px"
                            },
                        },
                        {
                            name: "id_rek_gl",
                            display: "Account[Dr]",
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
                            name: "kd_item",
                            sizing: "small",
                            display: "Item ID.",
                            ctrlAttr: {
                                placeholder: "Click me!"
                            },
                            ctrlCss: {
                                width: "80px"
                            },
                            events: {
                                click: function(e) {
                                    rowIndex = myAppendGrid.getRowIndex(parseInt(e.uniqueIndex));
                                    fect_item_data(rowIndex); // show modal
                                }
                            }
                        },

                        {
                            name: "no_mrir",
                            sizing: "small",
                            display: "AP Number #",
                            ctrlAttr: {
                                placeholder: "Click me!"
                            },
                            ctrlCss: {
                                width: "80px"
                            },
                            events: {
                                click: function(e) {
                                    rowIndex = myAppendGrid.getRowIndex(parseInt(e.uniqueIndex));
                                    fect_ap_data(rowIndex); // show modal
                                }
                            }
                        },



                        {
                            name: "diskripsi",
                            sizing: "large",
                            display: "Description",
                            ctrlCss: {
                                width: "320px"
                            },
                            ctrlAttr: {
                                required: "required"
                            }
                        },

                        {
                            name: "biaya",
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
                            name: "isterima",
                            sizing: "small",
                            type: "checkbox",
                            display: "Receipt",
                            cellClass: "text-center"
                        },
                        {
                            name: "id_settlement_detail",
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
                    <label>Remarks</label>
                    <textarea class="form-control" name="remarks" id="remarks" rows="3"></textarea>

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
                    <div class="row">
                        <div class="row">
                            <div class="col">
                            </div>
                            <div class="col">
                                <label style="width:110px; text-align: Center;">CA Value</label>
                            </div>
                            <div class="col">
                                <input id="vcaval" name="vcaval" class="easyui-numberbox" data-options="precision:2,groupSeparator:','" style="width:150px;text-align: right;height: 30px" />
                            </div>
                            <div class="col"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row">
                            <div class="col">
                            </div>
                            <div class="col">
                                <label style="width:110px; text-align: Center;">Difference</label>
                            </div>
                            <div class="col">
                                <input id="vdiff" name="vdiff" class="easyui-numberbox" data-options="precision:2,groupSeparator:','" style="width:150px;text-align: right;height: 30px" />
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

<!--  easyui CA Number modal -->
<div id="wca" class="easyui-window" title="CA Data" data-options="modal:true,closed:true,iconCls:'icon-save'" style="width:650px;height:500px;padding:10px;">
    <table id="dgCa" class="easyui-datagrid" style="width:620px;height:400px;" singleSelect="true">
        <thead>
            <tr>
                <th field="no_kasbon" width="100">CA Number #</th>
                <th field="dt_kasbon" width="80">Date</th>
                <th field="id_cc_project" width="80">CC/Project</th>
                <th field="kasbon_untuk" width="200">Purpose</th>
                <th field="jumlah" width="80" formatter="datagridFormatNumber" align="right">Value</th>
                <th field="sisa_ca" width="80" formatter="datagridFormatNumber" align="right">Not yet Settle</th>

            </tr>
        </thead>
    </table>

    <br>

    <div id="dlg-buttons">
        <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#wca').window('close')">Close</a>
    </div>
</div>
<!-- END easyui CA Number modal -->

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

        $("#dt_settlement").datepicker({
            changeMonth: true,
            changeYear: true,
            gotoCurrent: true
        });
        $("#dt_settlement").datepicker("option", "dateFormat", "dd/mm/yy");
        $("#dt_settlement").datepicker("setDate", "today");

        $("#dt_berangkat").datepicker({
            changeMonth: true,
            changeYear: true
        });
        $("#dt_berangkat").datepicker("option", "dateFormat", "dd/mm/yy");

        $("#dt_datang").datepicker({
            changeMonth: true,
            changeYear: true
        });
        $("#dt_datang").datepicker("option", "dateFormat", "dd/mm/yy");

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
        $("#dlg").panel('setTitle', 'New Settlement');
        $('#dlg').panel('open');
        $('#fm').form('clear');
        document.getElementById('id_settlement').value = '';
        document.getElementById('no_settlement').value = '';
        document.getElementById('kd_rekanan').value = '0';
        $("#dt_settlement").datepicker("setDate", "today");
        document.getElementById('dt_berangkat').value = '';
        document.getElementById('dt_datang').value = '';
        document.getElementById('id_curr').value = 'IDR';
        document.getElementById('kurs').value = '1';
        document.getElementById('id_cc_project').value = '0';
        document.getElementById('kasbon_untuk').value = '';
        document.getElementById('remarks').value = '';
        document.getElementById('nokasbon').value = '';
        document.getElementById('id_rek_gl').value = '0';
        document.getElementById('dt_kasbon').value = '';


        $('#vtotal').numberbox('setValue', 0);
        $('#vcaval').numberbox('setValue', 0);
        $('#vdiff').numberbox('setValue', 0);

        url = '<?= base_url(); ?>accfin/Settlement/insertSettlement/<?= $notrans; ?>';
        mode = 'add';
        myAppendGrid.load([{
            dt_biaya: "",
            kd_item: "",
            diskripsi: "",
            id_rek_gl: "",
            no_mrir: "",
            isterima: false,
            biaya: ""
        }]);
        scrollSmoothToBottom('content')
    }

    function editData() {
        var row = $('#dgMain').datagrid('getSelected');
        if (row) {
            $("#dlg").panel('setTitle', 'Update Settlement');
            $('#dlg').panel('open');
            //  $('#fm').form('load', row);
            document.getElementById('id_settlement').value = row.id_settlement;
            document.getElementById('no_settlement').value = row.no_settlement;

            $("#dt_settlement").datepicker("setDate", row.dt_settlement_str);
            $("#dt_berangkat").datepicker("setDate", row.dt_berangkat_str);
            $("#dt_datang").datepicker("setDate", row.dt_datang_str);

            document.getElementById('id_rek_gl').value = row.id_rek_gl;
            document.getElementById('kd_rekanan').value = row.kd_rekanan;

            document.getElementById('id_curr').value = row.id_curr;
            document.getElementById('kurs').value = row.kurs;
            document.getElementById('id_cc_project').value = row.id_cc_project;
            document.getElementById('kasbon_untuk').value = row.kasbon_untuk;
            document.getElementById('nokasbon').value = row.no_kasbon;
            document.getElementById('remarks').value = row.remarks;
            document.getElementById('dt_kasbon').value = row.dt_kasbon_str;


            $('#vtotal').numberbox('setValue', row.total);
            $('#vcaval').numberbox('setValue', row.total_kasbon);
            $('#vdiff').numberbox('setValue', row.lebih_kurang);

            // alert(row.nama_rekanan);
            url = '<?= base_url(); ?>accfin/Settlement/updateSettlement/' + row.id_settlement;
            mode = 'edit';
            getDetailData(row.id_settlement);
            scrollSmoothToBottom('content')
        }
    }

    function saveDatax() {

        reTotalGrid();

        var kd_rekanan = $("#kd_rekanan").val();
        var dt_settlement = $("#dt_settlement").val();
        var dt_berangkat = $("#dt_berangkat").val();
        var dt_datang = $("#dt_datang").val();
        var id_curr = $("#id_curr").val();
        var kurs = $("#kurs").val();
        var id_cc_project = $("#id_cc_project").val();
        var kasbon_untuk = $("#kasbon_untuk").val();
        var remarks = $("#remarks").val();
        var nokasbon = $("#nokasbon").val();
        var id_rek_gl = $("#id_rek_gl").val();
        var dt_kasbon = $("#dt_kasbon").val();
        var total = $('#vtotal').numberbox('getValue');
        var ca_value = $('#vcaval').numberbox('getValue');
        var selisih = $('#vdiff').numberbox('getValue');


        // VALIDATION FORM --------------------------------------
        if (dt_settlement == '') {
            Swal.fire(
                'Field Date Required.....!!!'
            )
            return false;
        } else if (kd_rekanan == '0') {
            Swal.fire(
                'Field Employee/Supplier Required.....!!!'
            )
            return false;
        } else if (nokasbon == '0') {
            Swal.fire(
                'Field CA Number Required.....!!!'
            )
            return false;
        } else if (nokasbon == '') {
            Swal.fire(
                'Field CA Number Required.....!!!'
            )
            return false;
        } else if (id_curr == '0') {
            Swal.fire(
                'Field Currency Required.....!!!'
            )
            return false;
        }


        if ((dt_berangkat)) {
            dt_berangkat = dt_berangkat;
        } else {
            dt_berangkat = '-'
        };
        if ((dt_datang)) {
            dt_datang = dt_datang;
        } else {
            dt_datang = '-'
        };


        var master = [];

        master.push({
            kd_rekanan: kd_rekanan,
            dt_settlement: dt_settlement,
            dt_berangkat: dt_berangkat,
            dt_datang: dt_datang,
            id_curr: id_curr,
            kurs: kurs,
            id_cc_project: id_cc_project,
            kasbon_untuk: kasbon_untuk,
            remarks: remarks,
            nokasbon: nokasbon,
            id_rek_gl: id_rek_gl,
            dt_kasbon: dt_kasbon,
            total: total,
            ca_value: ca_value,
            selisih: selisih,
            issettle: 1
        });


        var rows = [];

        var data = myAppendGrid.getAllValue();
        var rowCount = myAppendGrid.getRowCount();

        //cek field first
        for (var i = 0; i <= rowCount - 1; i++) {
            var rowValues = myAppendGrid.getRowValue(i);
            if (rowValues.dt_biaya == '') {
                Swal.fire(
                    'Field Date -> row ' + [i] + ' must have value.....!!!'
                )
                return false
            } else if (rowValues.diskripsi == '') {
                Swal.fire(
                    'Field Description -> row ' + [i] + ' must have value.....!!!'
                )
                return false
            } else if (rowValues.id_rek_gl == '') {
                Swal.fire(
                    'Field Account # -> row ' + [i] + ' must have value.....!!!'
                )
                return false
            } else if (rowValues.biaya == '') {
                Swal.fire(
                    'Field Nominal -> row ' + [i] + ' must have value.....!!!'
                )
                return false
            } else if (rowValues.biaya == '0') {
                Swal.fire(
                    'Field Nominal -> row ' + [i] + ' must have value.....!!!'
                )
                return false
            }
        };

        for (var i = 0; i <= rowCount - 1; i++) {
            if ((data[i].id_rek_gl)) {
                if ((data[i].kd_item)) {
                    var kd_item = data[i].kd_item;
                } else {
                    var kd_item = '-'
                }

                rows.push({
                    uid: data[i].id_settlement_detail,
                    dt_biaya: data[i].dt_biaya,
                    kd_item: kd_item,
                    diskripsi: data[i].diskripsi,
                    id_rek_gl: data[i].id_rek_gl,
                    no_mrir: data[i].no_mrir,
                    biaya: data[i].biaya,
                    isterima: data[i].isterima
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

    function doSearchcoa() {
        $('#dgCoa').datagrid('load', {
            searching_coa: $('#filterValcoa').val()
        });
        alert(searching_coa);
    }

    function doSearchitem() {
        $('#dgItem').datagrid('load', {
            searching_item: $('#filterValitem').val()
        });
    }


    function reTotalGrid() {
        var data = myAppendGrid.getAllValue();
        var rowCount = myAppendGrid.getRowCount();
        var xca = $('#vcaval').numberbox('getValue');

        var xtotal = 0;
        for (var i = 0; i <= rowCount - 1; i++) {
            if (data[i].biaya != '') {
                xtotal = xtotal + parseFloat(data[i].biaya);
            };
        };

        var xselisih = xtotal - xca;
        $('#vtotal').numberbox('setValue', xtotal);
        $('#vdiff').numberbox('setValue', xselisih);
    }



    function getDetailData($idd) {

        $.ajax({
            url: "<?= base_url(); ?>accfin/Settlement/getSettlementDetail",
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



    function fetchCaData() {
        var idx = $("#kd_rekanan").val();
        if (idx == '0') {
            Swal.fire(
                'Field Employee/Supplier Required.....!!!'
            )
            return false;
        }

        $('#dgCa').datagrid({
            url: "<?= base_url(); ?>accfin/Settlement/fetchCaNumber/" + idx
        });

        $('#wca').window('open');

        $('#dgCa').datagrid({
            onDblClickRow: function() {
                var row = $('#dgCa').datagrid('getSelected');
                if (row) {
                    document.getElementById('nokasbon').value = row.no_kasbon;
                    document.getElementById('kasbon_untuk').value = row.kasbon_untuk;
                    document.getElementById('remarks').value = row.kasbon_untuk;
                    document.getElementById('id_rek_gl').value = row.id_rek_gl_debet;
                    document.getElementById('dt_kasbon').value = row.dt_kasbon;
                    document.getElementById('id_cc_project').value = row.id_cc_project;
                    $('#vcaval').numberbox('setValue', row.sisa_ca);
                    $('#wca').window('close'); // hide modal
                }
            }
        });

    };



    function fect_coa_data(irow) {
        var idx = $("#id_cc_project").val();
        if (idx == '0') {
            Swal.fire(
                'Field Cost Center/Project Required.....!!!'
            )
            return false;
        }

        $('#dgCoa').datagrid({
            url: "<?= base_url(); ?>accfin/Settlement/fetchCoaNumber/" + idx
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


    function fect_item_data(irow) {

        $('#dgItem').datagrid({
            url: "<?= base_url(); ?>accfin/Settlement/fetchItem"
        });

        $('#wi').window('open');

        $('#dgItem').datagrid({
            onDblClickRow: function() {
                var row = $('#dgItem').datagrid('getSelected');
                if (row) {
                    myAppendGrid.setCtrlValue("kd_item", irow, row.kd_item);
                    myAppendGrid.setCtrlValue("diskripsi", irow, row.nama_item);
                    $('#wi').window('close'); // hide modal
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
                    url: '<?= base_url(); ?>accfin/Settlement/getDetailSettlement/' + row.id_settlement,
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
                                field: 'kd_item',
                                title: 'Item ID',
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