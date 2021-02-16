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
        <?= $notrans ?> | <?= $tittle ?> | <small>This form contain <?= $tittle ?> data...</small>
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

    <div id="container" class="panel-body" style="width:100%;height:500px;padding:10px;">
        <table id="dgMain" class="easyui-datagrid" style="width:100%;height:460px;" url="<?= base_url(); ?>procurement/Ap/getAp/<?= $notrans; ?>" singleSelect="true" rownumbers="true" pagination="true" toolbar="#toolbarFilter">
            <thead>
                <tr>
                    <th field="kd_ap" width="50">Index</th>
                    <th field="ap_number" width="100">AP Number</th>
                    <th field="dt_ap" width="80">Date</th>
                    <th field="nama_rekanan" width="250" align="left">Supplier</th>
                    <th field="invoice_no" width="100" align="left">Invoice #</th>
                    <th field="ordering_no" width="120" align="left">PO #</th>
                    <th field="inv_amount" width="100" formatter="datagridFormatNumber" align="right">Value</th>
                    <th field="id_cc_project" width=80 allign="left">CC/Project</th>
                    <th field="usr_ins" width="70" align="left">Usr Insert</th>
                    <th field="usr_upd" width="70" align="left">Usr Update</th>
                    <th field="ispost" width="50" align="center">Posted</th>
                    <th field="iscancel" width="50" align="center">Cancel</th>
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
    <div id="dlg" class="easyui-panel" title="--" style="width:100%;height:400px;padding:10px;" data-options="iconCls:'icon-save',closable:true,
                collapsible:true,minimizable:true,maximizable:true" closed="true">

        <form id="fm">

            <div class="row">
                <!-- BEGIN col-4 -->
                <div class="col-md-3">
                    <!-- BEGIN panel -->
                    <div class="row">
                        <div class="col-xs-4">
                            <label>Index #</label>
                            <input id="kd_ap" name="kd_ap" class="form-control m-b-10 input-sm" readonly="true" />
                        </div>
                        <div class="col-xs-8">
                            <label>Account Payable #</label>
                            <input id="ap_number" name="ap_number" class="form-control m-b-10 input-sm" readonly="true" />
                        </div>
                    </div>
                    <label>Invoice Number #</label>
                    <input id="invoice_no" name="invoice_no" class="form-control m-b-10 input-sm" />

                    <div class="row">
                        <div class="col-xs-6">
                            <label>Invoice Date</label>
                            <input id="dt_invoice" name="dt_invoice" class="form-control m-b-10 input-sm" />
                        </div>
                        <div class="col-xs-6">
                            <label>Due Date</label>
                            <input id="dt_jth_tempo" name="dt_jth_tempo" class="form-control m-b-10 input-sm" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-4">
                            <label>Bank<span class="text-danger">*</span></label>
                            <input id="bank" name="bank" class="form-control m-b-10 input-sm">
                        </div>
                        <div class="col-xs-8">
                            <label>Bank A/C </label>
                            <input id="nama_akun" name="nama_akun" class="form-control m-b-10 input-sm" />
                        </div>
                    </div>


                </div>

                <!-- BEGIN col-4 -->
                <div class="col-md-2">
                    <label>Date<span class="text-danger">*</span></label>
                    <input id="dt_ap" name="dt_ap" class="form-control m-b-10 input-sm" />

                    <div class="row">
                        <div class="col-xs-6">
                            <label>Currency #<span class="text-danger">*</span></label>
                            <Select id="id_curr" name="id_curr" class="form-control m-b-10 input-sm">
                                <option value="0">Select Currency</option>
                                <?php
                                foreach ($Currency as $row) {
                                    echo '<option value="' . $row["id_curr"] . '">' . $row["id_curr"] . '</option>';
                                }
                                ?>
                            </Select>
                        </div>
                        <div class="col-xs-6">
                            <label>Rate </label>
                            <input id="kurs" name="kurs" class="form-control m-b-10 input-sm" />
                        </div>
                    </div>


                    <label>Comments </label>
                    <input id="commentar" name="commentar" class="form-control m-b-10 input-sm" />
                    <label>Invoice Ammount</label>
                    <input id="inv_amount" name="inv_amount" class="easyui-numberbox" data-options="precision:2,groupSeparator:','" style="width:160px;text-align: right;height: 30px;" />

                </div>

                <!-- BEGIN col-4 -->
                <div class="col-md-3">

                    <label>Supplier<span class="text-danger">*</span></label>
                    <Select id="kd_rekanan" name="kd_rekanan" class="form-control m-b-10 input-sm">
                        <option value="0">Select Supplier</option>
                        <?php
                        foreach ($vendor as $row) {
                            echo '<option value="' . $row["kd_rekanan"] . '">' . $row["kd_rekanan"] . ' | ' . $row["nama_rekanan"] . '</option>';
                        }
                        ?>
                    </Select>

                    <label>Cost Center/Project</label>
                    <Select id="id_cc_project" name="id_cc_project" class="form-control m-b-10 input-sm">
                        <option value="">Select CC/Project</option>
                        <?php
                        foreach ($ccpro as $row) {
                            echo '<option value="' . $row["id_cc_project"] . '">' . $row["id_cc_project"] . ' | ' . $row["cc_project_name"] . '</option>';
                        }
                        ?>
                    </Select>
                    <div class="row">
                        <label>COA Account [Cr]<span class="text-danger">*</span></label>
                        <Select id="id_rek_gl" name="id_rek_gl" class="form-control m-b-10 input-sm">
                            <option value="">Select Account</option>
                            <?php
                            foreach ($coa_ap as $row) {
                                echo '<option value="' . $row["id_rek_gl"] . '">' . $row["descriptions"] . '</option>';
                            }
                            ?>
                        </Select>

                        <label>COA Account [Dr]<span class="text-danger">*</span></label>
                        <Select id="id_rek_gl_debet" name="id_rek_gl_debet" class="form-control m-b-10 input-sm">
                            <option value="">Select Account</option>
                            <?php
                            foreach ($coa_debet as $row) {
                                echo '<option value="' . $row["id_rek_gl"] . '">' . $row["descriptions"] . '</option>';
                            }
                            ?>
                        </Select>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="row">
                        <div class="col-xs-6">
                            <span class="input-group-addon"><i class="ti-search"></i></span>
                            <label onclick="fetchPoRef()" style="cursor:pointer">Purchase Order (PO) #</label>
                            <input id="ordering_no" name="ordering_no" class="form-control m-b-10 input-sm" />
                        </div>
                        <div class="col-xs-6">
                            <label>PO Value</label>
                            <input id="po_balance" name="po_balance" class="easyui-numberbox" data-options="precision:2,groupSeparator:','" style="width:160px;text-align: right;height: 30px;" readonly="true" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <label>VAT Ammount<span class="text-danger">*</span></label>
                            <input id="vat_rp" name="vat_rp" class="easyui-numberbox" data-options="precision:2,groupSeparator:','" style="width:160px;text-align: right;height: 30px;">
                        </div>
                        <div class="col-xs-6">
                            <label>VAT Account [Dr]</label>
                            <Select id="id_rek_gl_vat" name="id_rek_gl_vat" class="form-control m-b-10 input-sm">
                                <option value="">Select Account</option>
                                <?php
                                foreach ($coa_vat as $row) {
                                    echo '<option value="' . $row["id_rek_gl"] . '">' . $row["descriptions"] . '</option>';
                                }
                                ?>
                            </Select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <label>WHT Ammount</label>
                            <input id="wht_rp" name="wht_rp" class="easyui-numberbox" data-options="precision:2,groupSeparator:','" style="width:160px;text-align: right;height: 30px;">
                        </div>
                        <div class="col-xs-6">
                            <label>WHT Account [Cr] </label>
                            <Select id="id_rek_gl_wht" name="id_rek_gl_wht" class="form-control m-b-10 input-sm">
                                <option value="">Select Account</option>
                                <?php
                                foreach ($coa_wht as $row) {
                                    echo '<option value="' . $row["id_rek_gl"] . '">' . $row["descriptions"] . '</option>';
                                }
                                ?>
                            </Select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <label>Down Payment[DP]</label>
                            <input id="vat_pr" name="vat_pr" class="easyui-numberbox" data-options="precision:2,groupSeparator:','" style="width:160px;text-align: right;height: 30px;">
                        </div>
                        <div class="col-xs-6">
                            <label>DP Account [Cr]</label>
                            <Select id="id_rek_gl_dp" name="id_rek_gl_dp" class="form-control m-b-10 input-sm">
                                <option value="">Select Account</option>
                                <?php
                                foreach ($coa_dp as $row) {
                                    echo '<option value="' . $row["id_rek_gl"] . '">' . $row["descriptions"] . '</option>';
                                }
                                ?>
                            </Select>
                        </div>
                    </div>


                </div>
            </div>

            <!-- BEGIN #detail -->
            <table id="tblAppendGrid"></table>
            <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-upload" onclick="getDetailPoData()">Load Data [PO]</a>
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
                            name: "descriptions",
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
                            },
                            events: {
                                change: function(e) {
                                    calculate(e.uniqueIndex);
                                    reTotalGrid();
                                }
                            }
                        },


                        {
                            name: "unit_price",
                            display: "Unit Price",
                            type: "number",
                            ctrlClass: "text-right",
                            ctrlCss: {
                                "width": "100px",
                            },
                            events: {
                                change: function(e) {
                                    calculate(e.uniqueIndex);
                                    reTotalGrid();
                                }
                            }
                        },

                        {
                            name: "sub_total",
                            display: "Ammount",
                            type: "readonly",
                            ctrlClass: "text-right",
                            ctrlCss: {
                                backgroundColor: "#ebf0ec",
                                color: "#ff0000",
                                width: "100px"
                            },
                        },
                        {
                            name: "kd_ap_detail",
                            type: "hidden",
                            value: "0"
                        },
                        {
                            name: "extended",
                            type: "hidden",
                            valuw: 0,
                            events: {
                                change: function(e) {}
                            }
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
                //--------------------------------
                function calculate(uniqueIndex) {
                    var rowIndex = myAppendGrid.getRowIndex(uniqueIndex);
                    var number1 = parseFloat(myAppendGrid.getCtrlValue("qty", rowIndex) || 0);
                    var number2 = parseFloat(myAppendGrid.getCtrlValue("unit_price", rowIndex) || 0);
                    var total = number1 * number2;
                    var nummask = datagridFormatNumber(total, rowIndex);
                    myAppendGrid.setCtrlValue("extended", rowIndex, total);
                    myAppendGrid.setCtrlValue("sub_total", rowIndex, nummask);
                }
            </script>


            <hr>
            <div class="row">
                <div class="col-md-3">

                </div>
                <div class="col-md-3">

                </div>


                <span style="width: 100px"> </span>

                <div class="col-md-4">
                    <div class="row">
                        <div class="row">
                            <div class="col">
                            </div>
                            <div class="col">
                                <label style="width:110px; text-align: Center;">Total</label>
                            </div>
                            <div class="col">
                                <input id="total_mrir" name="total_mrir" class="easyui-numberbox" data-options="precision:2,groupSeparator:','" style="width:150px;text-align: right;height: 30px" />
                            </div>
                            <div class="col"></div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>


            <hr>
            <div class="ftitle"></div>
            <div id="dlg-buttons">
                <a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="saveDatax()">Save</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').panel('close')">Cancel</a>
            </div>
        </form>
    </div>
    <!-- END #detail -->

    <!-- modal po #detail -->

    <div id="w" class="easyui-window" title="Puchase Order Data" data-options="modal:true,closed:true,iconCls:'icon-save'" style="width:550px;height:450px;padding:10px;">
        <table id="dgPo" class="easyui-datagrid" stripped="true" style="width:500px;height:350px;" singleSelect="true" pagination="false" toolbar="#toolbarPo">
            <thead>
                <tr>
                    <th field="po_number" width="150">PO Number</th>
                    <th field="po_date" width="100">Date</th>
                    <th field="id_cc_project" width="100">CC/Project</th>
                    <th field="total" width="100" formatter="datagridFormatNumber" align="right">Nominal</th>
                </tr>
            </thead>
        </table>

        <div id="toolbarPo" style="padding-left: 10px">
            <span>Filter :</span>
            <input id="filterValPo" onkeyup="inputKeyEnterPo(event)" style="border:1px solid #ccc">
            <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearchPo()">Search</a>
        </div>

        <br>

        <div id="dlg-buttons">
            <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#w').window('close')">Close</a>
        </div>
        <script type="text/javascript">
            function inputKeyEnterPo(e) {
                e.which = e.which || e.keyCode;
                if (e.which == 13) {
                    doSearchPo();
                }
            };

            function doSearchPo() {
                $('#dgPay').datagrid('load', {
                    searching_po: $('#filterValPo').val()
                });
            };

            function fetchPoRef() {

                var kd_rekanan = $("#kd_rekanan").val();
                if (kd_rekanan == '0') {
                    Swal.fire(
                        'Field Supplier Required.....!!!'
                    )
                    return false;
                } else if (kd_rekanan == '') {
                    Swal.fire(
                        'Field Supplier Required.....!!!'
                    )
                    return false;
                }

                $('#dgPo').datagrid({
                    url: "<?= base_url(); ?>procurement/Ap/fetchPoRef/" + kd_rekanan
                });

                $('#w').window('open');

                $('#dgPo').datagrid({
                    onDblClickRow: function() {
                        var row = $('#dgPo').datagrid('getSelected');
                        if (row) {
                            document.getElementById('ordering_no').value = row.po_number;
                            $('#vat_rp').numberbox('setValue', row.vat_num);
                            $('#po_balance').numberbox('setValue', row.total);
                            document.getElementById('id_cc_project').value = row.id_cc_project;
                            $('#w').window('close'); // hide modal
                        }
                    }
                });

            };
        </script>

    </div>
    <!-- END po modal -->
    <!-- END modal -->

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
    var mj_no;
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

        $("#dt_ap").datepicker({
            changeMonth: true,
            changeYear: true,
            gotoCurrent: true
        });
        $("#dt_ap").datepicker("option", "dateFormat", "dd/mm/yy");

        $("#dt_invoice").datepicker({
            changeMonth: true,
            changeYear: true,
            gotoCurrent: true
        });
        $("#dt_invoice").datepicker("option", "dateFormat", "dd/mm/yy");

        $("#dt_jth_tempo").datepicker({
            changeMonth: true,
            changeYear: true,
            gotoCurrent: true
        });
        $("#dt_jth_tempo").datepicker("option", "dateFormat", "dd/mm/yy");


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

    function scrollSmoothToBottom(id) {
        var div = document.getElementById(id);
        $('#' + id).animate({
            scrollTop: div.scrollHeight - div.clientHeight
        }, 500);
    }

    function newData() {
        $("#dlg").panel('setTitle', 'New Account Payable [AP]');
        $('#dlg').panel('open');
        //   $('#fm').form('clear');

        document.getElementById('kd_ap').value = '';
        document.getElementById('ap_number').value = '';
        document.getElementById('id_curr').value = 'IDR';
        document.getElementById('kurs').value = '1';
        document.getElementById('kd_rekanan').value = '0';
        document.getElementById('invoice_no').value = '';
        document.getElementById('ordering_no').value = '';
        document.getElementById('id_cc_project').value = '0';
        document.getElementById('bank').value = '';
        document.getElementById('nama_akun').value = '';
        document.getElementById('commentar').value = '';


        document.getElementById('id_rek_gl').value = '';
        document.getElementById('id_rek_gl_debet').value = '';
        document.getElementById('id_rek_gl_vat').value = '';
        document.getElementById('id_rek_gl_wht').value = '';
        document.getElementById('id_rek_gl_dp').value = '';

        $("#dt_ap").datepicker("setDate", "today");
        $("#dt_invoice").datepicker("setDate", "today");
        $("#dt_jth_temp").datepicker("setDate", "today");

        $('#inv_amount').numberbox('setValue', 0);
        $('#po_balance').numberbox('setValue', 0);
        $('#total_mrir').numberbox('setValue', 0);
        $('#vat_pr').numberbox('setValue', 0);
        $('#vat_rp').numberbox('setValue', 0);
        $('#wht_rp').numberbox('setValue', 0);

        url = '<?= base_url(); ?>procurement/Ap/insertAp';
        myAppendGrid.load([{
            kd_item: "",
            descriptions: "",
            kd_satuan: "",
            qty: "",
            unit_price: ""
        }]);
        mode = 'add';
        scrollSmoothToBottom('content');

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
            $("#dlg").panel('setTitle', 'Update Account Payable [AP]');
            $('#dlg').panel('open');
            //  $('#fm').form('load', row);
            document.getElementById('kd_ap').value = row.kd_ap;
            document.getElementById('ap_number').value = row.ap_number;
            document.getElementById('id_curr').value = row.id_curr;
            document.getElementById('kurs').value = row.kurs;
            document.getElementById('kd_rekanan').value = row.kd_rekanan;
            document.getElementById('invoice_no').value = row.invoice_no;
            document.getElementById('ordering_no').value = row.ordering_no;
            document.getElementById('commentar').value = row.commentar;

            document.getElementById('bank').value = row.bank;
            document.getElementById('nama_akun').value = row.nama_akun;
            document.getElementById('id_cc_project').value = row.id_cc_project;
            document.getElementById('id_rek_gl').value = row.id_rek_gl;
            document.getElementById('id_rek_gl_debet').value = row.id_rek_gl_debet;
            document.getElementById('id_rek_gl_vat').value = row.id_rek_gl_vat;
            document.getElementById('id_rek_gl_wht').value = row.id_rek_gl_wht;
            document.getElementById('id_rek_gl_dp').value = row.id_rek_gl_dp;

            $("#dt_ap").datepicker("setDate", row.dt_ap_char);
            $("#dt_invoice").datepicker("setDate", row.dt_invoice);
            $("#dt_jth_tempo").datepicker("setDate", row.dt_jth_tempo);

            $('#inv_amount').numberbox('setValue', row.inv_amount);
            $('#po_balance').numberbox('setValue', row.po_balance);
            $('#total_mrir').numberbox('setValue', row.total_mrir);
            $('#vat_pr').numberbox('setValue', row.vat_pr);
            $('#vat_rp').numberbox('setValue', row.vat_rp);
            $('#wht_rp').numberbox('setValue', row.wht_rp);

            // alert(row.nama_rekanan);
            url = '<?= base_url(); ?>procurement/Ap/updateAp/' + row.kd_ap;
            mode = 'edit';
            getDetailData(row.kd_ap);
            scrollSmoothToBottom('content');
        }
    }

    function saveDatax() {
        var kd_rekanan = $("#kd_rekanan").val();
        var id_curr = $("#id_curr").val();
        var kurs = $("#kurs").val();


        var invoice_no = $("#invoice_no").val();
        var ordering_no = $("#ordering_no").val();
        var bank = $("#bank").val();
        var nama_akun = $("#nama_akun").val();
        var id_cc_project = $("#id_cc_project").val();
        var commentar = $("#commentar").val();

        var id_rek_gl = $("#id_rek_gl").val();
        var id_rek_gl_debet = $("#id_rek_gl_debet").val();
        var id_rek_gl_vat = $("#id_rek_gl_vat").val();
        var id_rek_gl_wht = $("#id_rek_gl_wht").val();
        var id_rek_gl_dp = $("#id_rek_gl_dp").val();

        var dt_ap = $("#dt_ap").val();
        var dt_invoice = $("#dt_invoice").val();
        var dt_jth_tempo = $("#dt_ap").val();

        var inv_amount = $('#inv_amount').numberbox('getValue');
        var po_balance = $('#po_balance').numberbox('getValue');
        var total_mrir = $('#total_mrir').numberbox('getValue');
        var vat_pr = $('#vat_pr').numberbox('getValue');
        var vat_rp = $('#vat_rp').numberbox('getValue');
        var wht_rp = $('#wht_rp').numberbox('getValue');

        var no_trans = <?= $notrans ?>;


        // VALIDATION FORM --------------------------------------
        if (dt_ap == '') {
            Swal.fire(
                'Field AP Date Required.....!!!'
            )
            return false;
        } else if (kd_rekanan == '0' || kd_rekanan == '') {
            Swal.fire(
                'Field Supplier Required.....!!!'
            )
            return false;
        } else if (id_rek_gl == '0' || id_rek_gl == '') {
            Swal.fire(
                'Field Account [Cr] Required.....!!!'
            )
            return false;
        } else if (invoice_no == '') {
            Swal.fire(
                'Field Invoice Number Required.....!!!'
            )
            return false;
        } else if (id_curr == '0') {
            Swal.fire(
                'Field Currency Required.....!!!'
            )
            return false;
        } else if (id_cc_project == '0' || id_cc_project == '') {
            Swal.fire(
                'Field CC/Project Required.....!!!'
            )
            return false;
        } else if (ordering_no == '') {
            Swal.fire(
                'Field PO Number Required.....!!!'
            )
            return false;
        } else if (dt_ap == '') {
            Swal.fire(
                'Field AP Date Required.....!!!'
            )
            return false;
        } else if (dt_invoice == '') {
            Swal.fire(
                'Field Invoice Date Required.....!!!'
            )
            return false;
        } else if (dt_jth_tempo == '') {
            Swal.fire(
                'Field Due Date Required.....!!!'
            )
            return false;
        } else if (id_rek_gl_wht == '' && wht_rp > 0) {
            Swal.fire(
                'Field WHT Account Required.....!!!'
            )
            return false;
        } else if (id_rek_gl_dp == '' && vat_pr > 0) {
            Swal.fire(
                'Field DP Account Required.....!!!'
            )
            return false;
        }

        var master = [];

        master.push({
            kd_rekanan: kd_rekanan,
            id_curr: id_curr,
            kurs: kurs,
            invoice_no: invoice_no,
            ordering_no: ordering_no,
            bank: bank,
            nama_akun: nama_akun,
            nama_akun: nama_akun,
            id_cc_project: id_cc_project,
            commentar: commentar,
            id_rek_gl: id_rek_gl,
            id_rek_gl_debet: id_rek_gl_debet,
            id_rek_gl_vat: id_rek_gl_vat,
            id_rek_gl_wht: id_rek_gl_wht,
            id_rek_gl_dp: id_rek_gl_dp,
            dt_ap: dt_ap,
            dt_invoice: dt_invoice,
            dt_jth_tempo: dt_jth_tempo,
            inv_amount: parseFloat(inv_amount || 0),
            po_balance: parseFloat(po_balance || 0),
            total_mrir: parseFloat(total_mrir || 0),
            vat_pr: parseFloat(vat_pr || 0),
            vat_rp: parseFloat(vat_rp || 0),
            wht_rp: parseFloat(wht_rp || 0),
            notrans: no_trans
        });

        var rows = [];

        var data = myAppendGrid.getAllValue();
        var rowCount = myAppendGrid.getRowCount();

        //cek field first
        for (var i = 0; i <= rowCount - 1; i++) {
            var rowValues = myAppendGrid.getRowValue(i);
            if (rowValues.descriptions == '') {
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
            } else if (rowValues.unit_price == '') {
                Swal.fire(
                    'Field Unit Price -> row ' + [i] + ' must have value.....!!!'
                )
                return false
            } else if (rowValues.unit_price == '0') {
                Swal.fire(
                    'Field Unit Price -> row ' + [i] + ' must have value.....!!!'
                )
                return false
            }
        };

        for (var i = 0; i <= rowCount - 1; i++) {
            if (data[i].kd_item != '') {
                rows.push({
                    kd_ap_detail: data[i].kd_ap_detail,
                    kd_item: data[i].kd_item,
                    descriptions: data[i].descriptions,
                    unit_price: data[i].unit_price,
                    qty: data[i].qty,
                    kd_satuan: data[i].kd_satuan,
                    extended: data[i].extended
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
            type: "POST",
            dataType: 'json',
            data: {
                info: data
            },
            success: function(data) {
                if (mode == 'add') {
                    document.getElementById("addSuccess").click(); // Click on the checkbox; 
                } else if (mode == 'edit') {
                    document.getElementById("editSuccess").click(); // Click on the checkbox; 
                }
                $('#dgMain').datagrid('reload')
                $('#dlg').panel('close');
            },
            error: function() {
                if (mode == 'add') {
                    document.getElementById("addError").click(); // Click on the checkbox
                } else if (mode == 'edit') {
                    document.getElementById("editError").click(); // Click on the checkbox 
                }

            }
        });
    }



    function removeData() {
        var row = $('#dgMain').datagrid('getSelected');
        if (row) {
            //alert(row.kd_rekanan);
            if (row.ispost == '1') {
                Swal.fire(
                    'Data has been Posted !!!'
                )
                return false;
            }
            var result = confirm("Are you sure to delete?");
            if (result) {
                // Delete logic goes here
                //alert(row.kd_rekanan);
                $.ajax({
                    url: "<?= base_url(); ?>procurement/Ap/destroyAp",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        id: row.kd_ap
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

    function reTotalGrid() {
        var data = myAppendGrid.getAllValue();
        var rowCount = myAppendGrid.getRowCount();

        var xtotal = 0;


        for (var i = 0; i <= rowCount - 1; i++) {
            if (data[i].extended != '') {
                xtotal = xtotal + parseFloat(data[i].extended);
            };
        };

        // alert(xtotal);
        // var xgtotal = xtotal + xppn;
        $('#total_mrir').numberbox('setValue', xtotal);
    }

    function getDetailData($idd) {

        $.ajax({
            url: "<?= base_url(); ?>procurement/Ap/getApDetail",
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


    function getDetailPoData() {

        var pon = $("#ordering_no").val();
        if (pon == '0') {
            Swal.fire(
                'Field PO Number Required.....!!!'
            )
            return false;
        } else if (pon == '') {
            Swal.fire(
                'Field PO Number Required.....!!!'
            )
            return false;
        }

        // alert(pon);

        $.ajax({
            url: "<?= base_url(); ?>procurement/Ap/getPoData",
            method: "POST",
            dataType: 'json',
            data: {
                idd: pon
            },
            error: function() {
                document.getElementById("addError").click(); // Click on the checkbox
            },
            success: function(data) {
                myAppendGrid.load(data);
                reTotalGrid();
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
                    url: '<?= base_url(); ?>procurement/Ap/fetchApDetail/' + row.kd_ap,
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