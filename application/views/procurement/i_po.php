<!DOCTYPE html>

<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($this->session->userdata("username"))) {
    redirect(site_url(), 'refresh');
} elseif (empty($this->session->userdata("po"))) {
    redirect(base_url('procurement/Po'), 'refresh');
};
?>

<html>

<head>
    <meta charset="UTF-8">
    <title>iDeas |
        <?= $caption; ?>
    </title>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/easyui'); ?>/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/easyui'); ?>/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/easyui'); ?>/demo/demo.css">
    <script type="text/javascript" src="<?= base_url('assets/js'); ?>/number.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/easyui'); ?>/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/easyui'); ?>/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/easyui'); ?>/jquery.edatagrid.js"></script>
</head>

<body>
    <table style="width: 100%;" cellspacing="0px" border="0">
        <tr>
            <td style="width:50%;text-align:left">
                <h2><?= $caption; ?></h2>
            </td>
            <td style="width:50%;text-align:right"><input id="kd_po" class="easyui-textbox" readonly="true" style="width:150px;"></td>
        </tr>
    </table>
    <hr>

    <table style="width: auto;" cellspacing="5px" border="0">
        <tr>

            <td><input id="po_number" class="easyui-textbox" label="Order #:" labelPosition="top" readonly="true" style="width:150px;"></td>
            <td><input id="dt_delivery" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="Delivery Date:" labelPosition="top" required="true" style="width:150px;"></td>
            <td rowspan="2"><input id="id_cc_project" class="easyui-combogrid" nowrap="true" label="CC/Project:" labelPosition="top" required="true" style="width:200px;height:100px""></td>
            <td rowspan="2"><input id="kd_rekanan" class="easyui-combogrid" label="Supplier:" labelPosition="top" required="true" style="width:200px;height:100px"></td>
            <td><input id="payment_terms" class="easyui-combobox" label="Payment Term:" labelPosition="top" required="true" style="width:200px;"></td>
            <td><input id="quotation_reff" class="easyui-textbox" label="Quotation Number:" labelPosition="top" required="true" style="width:200px;"></td>

        </tr>

        <tr>
            <td><input id="po_date" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="Order Date:" labelPosition="top" required="true" style="width:150px;"></td>
            <td><input id="vat_str" class="easyui-combobox" label="VAT:" labelPosition="top" required="true" style="width:150px;" data-options="
            valueField: 'label',
            textField: 'value',
            data: [{
                label: 'EXCLUDE',
                value: 'EXCLUDE'
            },{
                label: 'INCLUDE',
                value: 'INCLUDE'
            },{
                label: 'NONE',
                value: 'NONE'
            }]">
            </td>
            <td><input id="delivery_terms" class="easyui-textbox" label="Delivery Time:" labelPosition="top" required="true" style="width:200px;"></td>
            <td><input id="dt_quotation" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="Quotation Date:" labelPosition="top" required="true" style="width:200px;"></td>
        </tr>
    </table>

    <br>
    <hr>

    <div>
        <!-- div detail -->
        <table id="dg" class="easyui-datagrid" title="Purchase Requisition Detail" style="width:87%;height:auto" data-options="
                iconCls: 'icon-edit',
                singleSelect: true,
				toolbar: '#tb',
                rownumbers: true,
                nowrap: false,
				showfooter: true,
                url: '',
                method: 'post',
                onClickCell: onClickCell,
                onEndEdit: onEndEditdg
            ">
            <thead>
                <tr>
                    <th data-options="field:'kd_item',width:100,editor:{type:'textbox',options:{precision:2,
					icons:[{
						iconCls:'icon-search',
						handler: function(e){
							onclick=listItemAdd();
                            
                        }
					}]}}">Item ID</th>
                    <th data-options="field:'descriptions',width:450,editor:{type:'textbox',options:{readonly:false}}">Descriptions</th>
                    <th data-options="field:'kd_pi',width:100,editor:{type:'textbox',options:{readonly:false}}">PI #</th>
                    <th data-options="field:'qty',width:80,align:'right',editor:{type:'numberbox',options:{precision:1,required:true,readonly:false}}">Qty</th>
                    <th data-options="field:'kd_satuan',width:80,
                                        formatter:function(value,row){
                                            return row.kd_satuan;
                                        },
                                        editor:{
                                            type:'combobox',
                                            options:{
                                                valueField:'kd_satuan',
                                                textField:'kd_satuan',
                                                method:'get',
                                                url:'<?= base_url(); ?>procurement/Po/getUnit',
                                                required:true
                                            }
                                        }">Unit</th>
                    <th data-options="field:'unit_price',width:150,formatter:datagridFormatNumber,align:'right',editor:{type:'numberbox',options:{precision:2,required:true}}">Unit Price</th>
                    <th data-options="field:'extended',width:150,formatter:datagridFormatNumber,align:'right',editor:{type:'numberbox',options:{precision:2},readonly:true}">Ammount</th>
                    <th data-options="field:'requisition_no',editor:{type:'textbox',options:{readonly:false}}" hidden="true">requisition_no</th>
                    <th data-options="field:'kd_pr_detail',editor:{type:'textbox',options:{readonly:false}}" hidden="true">kd_pr_detail</th>
                    <th data-options="field:'kd_po_detail'" hidden="true">kd_po_detail</th>

                </tr>
            </thead>
        </table>
        <div id="tb" style="height:auto">
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="append()">Append</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeit()">Remove</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="acceptit()">Accept</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="reject()">Reject</a>
        </div>

    </div> <!-- end of div detail -->

    <br>

    <table style="width:87%;height:auto" border="0">
        <tr>
            <td rowspan="3" style="width:20%">
                <input id="ship_to" class="easyui-textbox" required="true" multiline="true" style="width:250px;height:90px" data-options="
                    label:'Delivery Place:', 
                    labelPosition:'top',
                    prompt: 'Search Delivery Place',
                    iconWidth: 22,
                    icons: [{
                        iconCls:'icon-search',
                        handler: function(e){
                            onclick=getDeliveryPlace();
                        }
                    }]">
                <input id="buyer" class="easyui-textbox" label="Attn:" labelPosition="top" required="true" style="width:250px;height:50px">
            </td>
            <td rowspan="3" style="width:30%"><input id="remarks" class="easyui-textbox" label="Remarks:" labelPosition="top" multiline="true" style="width:300px;height:130px"> </td>
            <td rowspan="3" style="width:10%"></td>
            <td style="width:10%;height:30px;text-align:right">SUB TOTAL</td>
            <td style="width:13%;height:30px;text-align:right"><input id="sub_total" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
        </tr>
        <tr>
            <td style="width:10%;height:30px;text-align:right">VAT NUM</td>
            <td style="width:13%;height:30px;text-align:right"><input id="vat_num" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
        </tr>
        <tr>
            <td style="width:10%;height:30px;text-align:right">TOTAL</td>
            <td style="width:13%;height:30px;text-align:right"><input id="total" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
        </tr>

    </table>
    <hr>

    <table style="width:87%;height:auto" border="0">
        <tr>
            <td style="width:20%;height:30px"><input id="prepared_by" class="easyui-textbox" required="true" label="Prepared By:" labelPosition="top" style="text-align: right; width: 90%;" data-options="min:0,precision:2,groupSeparator:','"></td>
            <td style="width:20%;height:30px"><input id="reviewed_by" class="easyui-combobox" required="true" label="Project Mng. Review:" labelPosition="top" style="width: 90%;"></td>
            <td style="width:20%;height:30px"><input id="reviewed_by_2" class="easyui-combobox" required="true" label="Technical Review:" labelPosition="top" style="width: 90%;"></td>
            <td style="width:20%;height:30px"><input id="reviewed_by_3" class="easyui-combobox" required="true" label="Financial Review:" labelPosition="top" style="width: 90%;"></td>
            <td style="width:20%;height:30px"><input id="approved_by" class="easyui-combobox" required="true" label="Approved By" labelPosition="top" style="width: 90%;"></td>
        </tr>
    </table>


    <div id="dlg-buttons" style="text-align: center;">
        <hr>
        <a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="saveDatax()">Save</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="cancelData()">Cancel</a>
    </div>


    <hr>





    <!-- ITEM -->
    <div id="dlgListItemAdd" class="easyui-dialog" style="width: 800px;height: 500px;" closed="true" buttons="#dlg-buttons-list-item-add">
        <table id="grdListItemAdd" class="easyui-datagrid" style="width:auto;height:auto;" toolbar="#tbListItemAdd" fitColumns="true" sortable="true" singleSelect="true" rownumbers="true" striped="true" nowrap="false" pagination="true" pageSize="15" pageList="[15, 30, 45, 60]">
            <thead>
                <tr>
                    <th field="no_pr" width="80" align="center" sortable="true">PR #</th>
                    <th field="kd_item" width="80" align="center" sortable="true">Kode Item</th>
                    <th field="deskripsi" width="170" align="left" sortable="true">Diskripsi</th>
                    <th field="qty" width="80" align="left" sortable="true">Qty</th>
                    <th field="kd_satuan" width="90" align="center" sortable="true">Satuan</th>
                    <th field="requester" width="100" align="left" sortable="true">Requester</th>
                </tr>
            </thead>
        </table>
    </div>
    <div id="dlg-buttons-list-item-add">
        <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgListItemAdd').dialog('close');">Close</a>
    </div>
    <div id="tbListItemAdd" style="padding:10px;">
        <select id="selectFilterLIA" name="selectFilterLIA" class="easyui-combobox" style="width:150px;">
            <option value="a.nama_item">Diskripsi</option>
            <option value="a.kd_item">Kode Item</option>
        </select>
        <input id="filterValLIA" onkeyup="inputKeyEnterLIA(event)" style="line-height:26px;border:1px solid #ccc;">
        <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearchLIA();">Cari</a>
    </div>
    <!-- END OF ITEM -->




    <!-- Delivery Term modal -->

    <div id="wp" class="easyui-window" title="Item Data" data-options="modal:true,closed:true,iconCls:'icon-save'" style="width:650px;height:500px;padding:10px;">
        <table id="dgPay" class="easyui-datagrid" stripped="true" style="width:620px;height:400px;" singleSelect="true" pagination="true" toolbar="#toolbarDelivery">
            <thead>
                <tr>
                    <th field="descriptions" width="100">Delivery Place</th>
                    <th field="alamat" width="250">Address</th>
                    <th field="kota" width="100">City</th>
                    <th field="propinsi" width="100">State</th>
                </tr>
            </thead>
        </table>

        <div id="toolbarDelivery" style="padding-left: 10px">
            <span>Filter :</span>
            <input id="filterValDelivery" onkeyup="inputKeyEnterDelivery(event)" style="border:1px solid #ccc">
            <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearcDelivery()">Search</a>
        </div>

        <br>

        <div id="dlg-buttons">
            <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#wp').window('close')">Close</a>
        </div>
    </div>
    <!-- END Payment Term modal -->






    <script src="<?php echo base_url('assets/js/accounting.min.js') ?>"></script>
    <script type="text/javascript">
        var editIndex = undefined;
        var lastIndex;
        var mode = '<?= $mode ?>';
        var idx = '<?= $idx; ?>';


        //-----------------------------$('#dg').datagrid-----------------------------

        $(function() {
            // $("#pkd_rekanan").hide();
            // $("#pid_qs").hide();

            $('#id_cc_project').combogrid({
                panelWidth: 700,
                url: '<?= base_url()  ?>procurement/Po/getCCProject',
                idField: 'id_cc_project',
                textField: 'cc_project_name',
                mode: 'remote',
                fitColumns: true,
                nowrap: false,
                columns: [
                    [{
                            field: 'id_cc_project',
                            title: 'ID',
                            width: 100,
                            align: 'center'
                        },
                        {
                            field: 'cc_project_name',
                            title: 'Descriptions',
                            align: 'left',
                            width: 250
                        },
                        {
                            field: 'jenis',
                            title: 'CC/ Project',
                            align: 'left',
                            width: 150
                        },

                    ]
                ]

            });

            $('#kd_rekanan').combogrid({
                panelWidth: 700,
                url: '<?= base_url()  ?>procurement/Po/getSupplier',
                idField: 'kd_rekanan',
                textField: 'nama_rekanan',
                mode: 'remote',
                fitColumns: true,
                nowrap: false,
                columns: [
                    [{
                            field: 'kd_rekanan',
                            title: 'ID',
                            width: 100,
                            align: 'center'
                        },
                        {
                            field: 'nama_rekanan',
                            title: 'Descriptions',
                            align: 'left',
                            width: 250
                        },
                        {
                            field: 'jenis',
                            title: 'CC/ Project',
                            align: 'left',
                            width: 150
                        },

                    ]
                ]

            });

            $('#payment_terms').combobox({
                url: '<?= base_url()  ?>procurement/Po/getPaymentTerm',
                valueField: 'description',
                textField: 'description'
            });

            $('#prepared_by').combobox({
                url: '<?= base_url()  ?>procurement/Po/getVuser',
                valueField: 'vuser',
                textField: 'full_name'
            });
            $('#reviewed_by').combobox({
                url: '<?= base_url()  ?>procurement/Po/getVuser',
                valueField: 'vuser',
                textField: 'full_name'
            });
            $('#reviewed_by_2').combobox({
                url: '<?= base_url()  ?>procurement/Po/getVuser',
                valueField: 'vuser',
                textField: 'full_name'
            });
            $('#reviewed_by_3').combobox({
                url: '<?= base_url()  ?>procurement/Po/getVuser',
                valueField: 'vuser',
                textField: 'full_name'
            });
            $('#approved_by').combobox({
                url: '<?= base_url()  ?>procurement/Po/getVuser',
                valueField: 'vuser',
                textField: 'full_name'
            });



            $('#grdListItemAdd').datagrid({
                onDblClickRow: function() {
                    var editors = $('#dg').datagrid('getEditors', editIndex);
                    var n0 = $(editors[0].target);
                    var n1 = $(editors[1].target);
                    var n2 = $(editors[2].target);
                    var n3 = $(editors[3].target);
                    var n4 = $(editors[4].target);
                    var n7 = $(editors[7].target);
                    var n8 = $(editors[8].target);
                    var row = $('#grdListItemAdd').datagrid('getSelected');
                    n0.textbox('setValue', row.kd_item);
                    n1.textbox('setValue', row.deskripsi);
                    n2.textbox('setValue', row.kd_pi);
                    n3.textbox('setValue', row.qty);
                    n4.textbox('setValue', row.kd_satuan);
                    n7.textbox('setValue', row.no_pr);
                    n8.textbox('setValue', row.kd_pr_detail);
                    $('#dlgListItemAdd').dialog('close');
                }
            });



            $('#dg').datagrid({
                onClickRow: function(rowIndex) {
                    if (lastIndex != rowIndex) {
                        $(this).datagrid('endEdit', lastIndex);
                        $(this).datagrid('beginEdit', rowIndex);
                    }
                    lastIndex = rowIndex;
                }
            });

            if (mode == 'edit') {
                fetchMasterData(idx);
                fetchDetailData(idx);
            };

        });


        //-----------------------------$('#dg').datagrid--------------------------------------------

        function endEditing() {
            if (editIndex == undefined) {
                return true
            }
            if ($('#dg').datagrid('validateRow', editIndex)) {
                $('#dg').datagrid('endEdit', editIndex);
                editIndex = undefined;
                return true;
            } else {
                return false;
            }
        }

        function onClickCell(index, field) {
            if (editIndex != index) {
                if (endEditing()) {
                    $('#dg').datagrid('selectRow', index)
                        .datagrid('beginEdit', index);
                    var ed = $('#dg').datagrid('getEditor', {
                        index: index,
                        field: field
                    });
                    if (ed) {
                        ($(ed.target).data('textbox') ? $(ed.target).textbox('textbox') : $(ed.target)).focus();
                    }
                    editIndex = index;
                } else {
                    setTimeout(function() {
                        $('#dg').datagrid('selectRow', editIndex);
                    }, 0);
                }
            }
        }

        function onEndEditdg(index, row) {
            var ed = $(this).datagrid('getEditor', {
                index: index,
                field: 'kd_satuan'
            });
            //row.kd_satuan = $(ed.target).combobox('getText');
            $('#dg').datagrid('getRows')[index]['kd_satuan'] = $(ed.target).combobox('getText');
        }

        function append() {
            if (endEditing()) {
                $('#dg').datagrid('appendRow', {
                    kd_po_detail: 0
                });
                editIndex = $('#dg').datagrid('getRows').length - 1;
                $('#dg').datagrid('selectRow', editIndex)
                    .datagrid('beginEdit', editIndex);
            }
        }

        function removeit() {
            if (editIndex == undefined) {
                return
            }
            $('#dg').datagrid('cancelEdit', editIndex)
                .datagrid('deleteRow', editIndex);
            editIndex = undefined;
            hitung_total();
        }

        function acceptit() {
            if (endEditing()) {
                $('#dg').datagrid('acceptChanges');
            }
            hitung_total();
        }

        function reject() {
            $('#dg').datagrid('rejectChanges');
            editIndex = undefined;
        }




        function hitungTotal() {
            var data = $('#dg').datagrid('getRows');
            var jml = 0;
            if (data.length > 0) {
                for (i = 0; i < data.length; i++) {
                    jml += parseFloat(data[i].extended);
                }
            }

            var ppn = jml * (10 / 100);

            $('#sub_total').numberbox('setValue', jml);
            $('#vat_num').numberbox('setValue', ppn);
            $('#total').numberbox('setValue', jml + ppn);
        }



        //------------------------------end of $('#dg').datagrid -------------------------


        function fetchMasterData(idx) {
            $.ajax({
                url: "<?= base_url(); ?>procurement/Po/getPoMaster",
                method: "POST",
                dataType: 'json',
                data: {
                    idx: idx
                },
                error: function() {
                    $.messager.show({
                        title: 'Error',
                        msg: result.errorMsg
                    });
                },
                success: function(data) {
                    //alert(data[0]['dt_quotation']);
                    $('#kd_po').textbox('setValue', data[0]['kd_po']);
                    $('#po_date').datebox('setValue', data[0]['po_date']);
                    $('#dt_delivery').datebox('setValue', data[0]['dt_delivery']);
                    $('#dt_quotation').datebox('setValue', data[0]['dt_quotation']);
                    $('#po_number').textbox('setValue', data[0]['po_number']);
                    $('#vat_str').combobox('setValue', data[0]['vat_str']);
                    $('#payment_terms').combobox('setValue', data[0]['payment_terms']);
                    $('#kd_rekanan').combogrid('setValue', data[0]['kd_rekanan']);
                    $('#id_cc_project').combogrid('setValue', data[0]['id_cc_project']);
                    $('#delivery_terms').textbox('setValue', data[0]['delivery_terms']);
                    $('#quotation_reff').textbox('setValue', data[0]['quotation_reff']);
                    $('#remarks').textbox('setValue', data[0]['remarks']);
                    $('#ship_to').textbox('setValue', data[0]['ship_to']);
                    $('#buyer').textbox('setValue', data[0]['buyer']);
                    $('#sub_total').numberbox('setValue', data[0]['sub_total']);
                    $('#vat_num').numberbox('setValue', data[0]['vat_num']);
                    $('#total').numberbox('setValue', data[0]['total']);

                    $('#prepared_by').combobox('setValue', data[0]['prepared_by']);
                    $('#reviewed_by').combobox('setValue', data[0]['reviewed_by']);
                    $('#reviewed_by_2').combobox('setValue', data[0]['reviewed_by_2']);
                    $('#reviewed_by_3').combobox('setValue', data[0]['reviewed_by_3']);
                    $('#approved_by').combobox('setValue', data[0]['approved_by']);
                }
            });
        }

        function fetchDetailData(idx) {
            $.ajax({
                url: "<?= base_url(); ?>procurement/Po/getPoDetail",
                method: "POST",
                dataType: 'json',
                data: {
                    idx: idx
                },
                error: function() {
                    $.messager.show({
                        title: 'Error',
                        msg: result.errorMsg
                    });
                    alert('error');
                },
                success: function(data) {
                    $('#dg').datagrid('loadData',
                        data
                    );
                }
            });

        }


        function myformatter(date) {
            var y = date.getFullYear();
            var m = date.getMonth() + 1;
            var d = date.getDate();
            return (d < 10 ? ('0' + d) : d) + '-' + (m < 10 ? ('0' + m) : m) + '-' + y;
        }

        function myparser(s) {
            if (!s) return new Date();
            var ss = (s.split('-'));
            var y = parseInt(ss[0], 10);
            var m = parseInt(ss[1], 10);
            var d = parseInt(ss[2], 10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
                return new Date(d, m - 1, y);
            } else {
                return new Date();
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


        // ITEM
        function listItemAdd() {
            var id_cc_project = $('#id_cc_project').combogrid('getValue');
            if (id_cc_project == '') {
                $.messager.alert('Warning', 'CC/Project must have value', 'warning');
                return false;
            }

            $('#dlgListItemAdd').dialog({
                title: 'Master Item List',
                closed: false,
                cache: false,
                modal: true,
                width: $(window).width() - 400
            });
            $('#grdListItemAdd').datagrid({
                url: '<?= base_url(); ?>procurement/Po/getItem/' + id_cc_project
            });
            $('#grdListItemAdd').datagrid('load', {
                searching: $('#filterValLIA').val() + "|" + $('#selectFilterLIA').combobox('getValue')
            });
        }

        function inputKeyEnterLIA(e) {
            e.which = e.which || e.keyCode;
            if (e.which == 13) {
                doSearchLIA();
            }
        }

        function doSearchLIA() {
            $('#grdListItemAdd').datagrid('load', {
                searching: $('#filterValLIA').val() + "|" + $('#selectFilterLIA').combobox('getValue')
            });
        }
        //END OF ITEM



        function saveDatax() {
            var kd_rekanan = $('#kd_rekanan').combogrid('getValue');
            var id_cc_project = $('#id_cc_project').combogrid('getValue');

            var vat_str = $('#vat_str').combobox('getValue');
            var payment_terms = $('#payment_terms').combobox('getValue');

            var po_date = $('#po_date').datebox('getValue');
            var dt_delivery = $('#dt_delivery').datebox('getValue');
            var dt_quotation = $('#dt_quotation').datebox('getValue');

            var ship_to = $('#ship_to').textbox('getValue');
            var delivery_terms = $('#delivery_terms').textbox('getValue');
            var buyer = $('#buyer').textbox('getValue');
            var remarks = $('#remarks').textbox('getValue');
            var quotation_reff = $('#quotation_reff').textbox('getValue');
            var remarks = $('#remarks').textbox('getValue');
            var kd_po = $('#kd_po').textbox('getValue');

            var sub_total = $('#sub_total').numberbox('getValue');
            var vat_num = $('#vat_num').numberbox('getValue');
            var total = $('#total').numberbox('getValue');

            var prepared_by = $('#prepared_by').combobox('getValue');
            var reviewed_by = $('#reviewed_by').combobox('getValue');
            var reviewed_by_2 = $('#reviewed_by_2').combobox('getValue');
            var reviewed_by_3 = $('#reviewed_by_3').combobox('getValue');
            var approved_by = $('#approved_by').combobox('getValue');

            var detail = $('#dg').datagrid('getRows');

            // VALIDATION FORM --------------------------------------
            if (kd_rekanan == '') {
                $.messager.alert('Warning', 'Supplier must have value', 'warning');
                return false;
            } else if (id_cc_project == '') {
                $.messager.alert('Warning', 'CC/Project must have value', 'warning');
                return false;
            } else if (po_date == '') {
                $.messager.alert('Warning', 'Order Date must have value', 'warning');
                return false;
            } else if (vat_str == '') {
                $.messager.alert('Warning', 'VAT must have value', 'warning');
                return false;
            } else if (dt_delivery == '') {
                $.messager.alert('Warning', 'Delivery Date must have value', 'warning');
                return false;
            } else if (prepared_by == '') {
                $.messager.alert('Warning', 'Prepared By must have value', 'warning');
                return false;
            } else if (reviewed_by == '') {
                $.messager.alert('Warning', 'Project Management Reviewer must have value', 'warning');
                return false;
            } else if (reviewed_by_3 == '') {
                $.messager.alert('Warning', 'Financial Reviewer must have value', 'warning');
                return false;
            } else if (approved_by == '') {
                $.messager.alert('Warning', 'Approver must have value', 'warning');
                return false;
            }

            var master = [];

            master.push({
                kd_po: kd_po,
                po_date: po_date,
                kd_rekanan: kd_rekanan,
                dt_delivery: dt_delivery,
                id_curr: 'IDR',
                kurs: 1,
                id_cc_project: id_cc_project,
                ship_to: ship_to,
                remarks: remarks,
                payment_terms: payment_terms,
                delivery_terms: delivery_terms,
                buyer: buyer,
                quotation_reff: quotation_reff,
                dt_quotation: dt_quotation,
                vat_str: vat_str,
                sub_total: sub_total,
                vat_num: vat_num,
                total: total,
                prepared_by: prepared_by,
                reviewed_by: reviewed_by,
                reviewed_by_2: reviewed_by_2,
                reviewed_by_3: reviewed_by_3,
                approved_by: approved_by
            });


            var rows = [];

            var uri;
            if (mode == 'edit') {
                uri = '<?= base_url(); ?>procurement/Po/updatePo/';
            } else if (mode == 'add') {
                uri = '<?= base_url(); ?>procurement/Po/insertPo';
            }


            var data = [];
            data.push({
                master: master,
                detail: detail
            })


            $.ajax({
                url: uri,
                method: "POST",
                dataType: 'json',
                data: {
                    info: data
                },
                error: function() {
                    $.messager.alert({
                        title: 'Error',
                        msg: result.errorMsg
                    });
                },
                success: function(data) {
                    window.open('<?= base_url(); ?>procurement/Po', '_self');
                }
            });
        }

        function cancelData() {
            window.open('<?= base_url(); ?>procurement/Po', '_self');
            // window.open('<?//= base_url(); ?>procurement/Pr/index/<?//= $dtx ?>', '_self');
        }
    </script>


</body>

</html>