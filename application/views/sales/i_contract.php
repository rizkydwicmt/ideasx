<!DOCTYPE html>

<?php
defined('BASEPATH') or exit('No direct script access allowed');


if (empty($this->session->userdata("username"))) {
    redirect(site_url(), 'refresh');
} elseif (empty($this->session->userdata("con"))) {
    redirect(base_url('sales/Contract'), 'refresh');
};
?>

<body>
    <table style="width: 100%;" cellspacing="5px" cellpadding="5px" border="0">
        <tr>
            <td style="width:50%;text-align:left">
                <h4><?= $caption; ?></h4>
            </td>
            <td style="width:50%;text-align:right"><input id="id_so" class="easyui-textbox" readonly="true" style="width:150px;"></td>
        </tr>
    </table>
    <hr>
    <table style="width: auto;" cellspacing="5px" cellpadding="5px" border="0">
        <tr>

            <td><input id="so_number" class="easyui-combogrid" label="Contract/Project #:" labelPosition="top" required="true" style="width:200px;"></td>
            <td><input id="no_qt" class="easyui-textbox" label="Quotation No.:" labelPosition="top" required="true" style="width:300px;"> </td>
            <td rowspan="2"><input id="kd_rekanan" class="easyui-combogrid" label="Customer Name:" labelPosition="top" multiline="true" required="true" style="width:300px;height:100px;"></td>
            <td rowspan="2"><input id="remarks" class="easyui-textbox" label="Project Description:" labelPosition="top" multiline="true" required="true" style="width:300px;height:100px;"></td>
        </tr>


        <tr>
            <td><input id="dt_so" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="Contract Date:" labelPosition="top" required="true" style="width:200px;"></td>
            <td><input id="cust_po_number" class="easyui-textbox" label="PO/Contract Reff.:" labelPosition="top" required="true" style="width:300px;"></td>
           
           
        </tr>
        <tr>
           
            <td><input id="dt_finish" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="Delivery Date:" labelPosition="top" required="true" style="width:200px;"></td>
            <td><input id="id_cat_project" class="easyui-combogrid" label="Project Category:" labelPosition="top" required="true" style="width:300px"></td>
            <td rowspan="2"><input id="lokasi" class="easyui-textbox" label="Project Location:" labelPosition="top" multiline="true" required="true" style="width:300px;height:100px"></td>
            <td rowspan="2"><input id="cara_bayar" class="easyui-textbox" label="Payment Terms: (separate line by '|')" labelPosition="top" multiline="true" style="width:300px;height:100px;"></td>
        </tr>
        <tr>
             <td><input id="id_rek_gl" class="easyui-combogrid" label="Profit Center:" labelPosition="top" required="true" style="width:200px"></td>
            <td ><input id="manager" class="easyui-combogrid" label="Project Manager:" labelPosition="top" required="true" style="width:300px"></td>
            
        </tr>

    </table>
    <br>
    <div>
        <table style="width: auto;" cellspacing="0px" border="0">
            <tr>
                <td style="width:200px">Upload Contract/PO</td>
                <td colspan="4" style="width:auto;height:25px;">
                    <form method="post" id="form_ticketing" style="display: inline;">
                        <input class="easyui-filebox" data-options="prompt:'Choose a file...'" style="width:500px;height: 25px" name="file" id="import_file">
                        <button style="text-align: center;height: 25px;width: 80px" class="easyui-linkbutton" iconCls="icon-ok" plain="false" id="upload" type="submit">Import</button>
                        <input type="hidden" name="preview" value="Preview">
                    </form>
                </td>

            </tr>
        </table>
    </div>
    <br>
    <hr>

    <div>
        <table id="dg" class="easyui-datagrid" title="Contract Detail" style="width:90%;height:auto" data-options="
        iconCls: 'icon-edit',
        singleSelect: true,
        toolbar: '#tb',
        rownumbers: true,
        showfooter: true,
        url: '',
        method: 'post',
        onClickCell: onClickCell,
        onEndEdit: onEndEdit
        ">
            <thead>
                <tr>
                    <th rowspan="2" data-options="field:'kd_item',width:150,editor:{type:'textbox',options:{required:true,
					icons:[{
						iconCls:'icon-search',
						handler: function(e){
							onclick=listItemAdd();
                            
                        }
					}]}}">Item ID</th>
                    <th rowspan="2" data-options="field:'descriptions',width:350,editor:{type:'textbox',options:{required:true}}">Descriptions</th>
                    <th rowspan="2" data-options="field:'qty',width:70,align:'right',editor:{type:'numberbox',options:{precision:0,required:true}}">Qty</th>
                    <th rowspan="2" data-options="field:'kd_satuan',width:100,
                        formatter:function(value,row){
                            return row.kd_satuan;
                        },
                        editor:{
                            type:'combobox',
                            options:{
                                valueField:'kd_satuan',
                                textField:'kd_satuan',
                                method:'get',
                                url:'<?= base_url(); ?>sales/Contract/getUnit',
                                required:true
                            }
                        }">Unit</th>
                    <th colspan="2">HPP</th>
                    <th colspan="3">Contract</th>
                    <th rowspan="2" data-options="field:'id_so_detail'" hidden="true">id_so_detail</th>
                </tr>
                <tr>
                    <th data-options="field:'hpp_price',width:100,formatter:datagridFormatNumber,align:'right',editor:{type:'numberbox',options:{precision:2,required:true}}">Unit Price</th>
                    <th data-options="field:'hpp_sub_total',width:100,formatter:datagridFormatNumber,align:'right',editor:{type:'numberbox',options:{precision:2,required:true,readonly:true}}">Ammount</th>
                    <th data-options="field:'unit_price',width:100,formatter:datagridFormatNumber,align:'right',editor:{type:'numberbox',options:{precision:2,required:true}}">Unit Price</th>
                    <th data-options="field:'sub_total',width:100,formatter:datagridFormatNumber,align:'right',editor:{type:'numberbox',options:{precision:2,required:true,readonly:true}}">Ammount</th>
                    <th data-options="field:'margin_psn',width:70,formatter:datagridFormatNumber,align:'right',editor:{type:'numberbox',options:{precision:2,required:true,readonly:true}}">Margin[%]</th>
               

                </tr>
            </thead>
        </table>
        <br>
        <table id="dgx" style="width:100%;height:auto" border="0">
            <tr>
                <td style="width:47%;height:30px" rowspan="4">

                </td>
                <td style="width:10%;height:30px;text-align:right">SUB TOTAL</td>
                <td style="width:13%;height:30px;text-align:right"><input id="sub_total_hpp" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
                <td style="width:20%;height:30px;text-align:right"><input id="sub_total" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
                <td style="width:auto;height:30px"></td>
            </tr>
            <tr>

            <td style="width:10%;height:30px;text-align:right">VAT NUM</td>
                <td style="width:13%;height:30px;text-align:right"><input id="vat_num_hpp" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
                <td style="width:20%;height:30px;text-align:right"><input id="vat_num" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
                <td style="width:auto;height:30px"></td>
            </tr>
            <tr>
            <td style="width:10%;height:30px;text-align:right">TOTAL</td>
                <td style="width:13%;height:30px;text-align:right"><input id="total_hpp" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
                <td style="width:20%;height:30px;text-align:right"><input id="total" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
                <td style="width:auto;height:30px"></td>
            </tr>
        </table>

        <div id="tb" style="height:auto">
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="append()">Append</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeit()">Remove</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="acceptit()">Accept</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="reject()">Reject</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-pdf',plain:true" onclick="viewContract()">View Contract</a>
        </div>
    </div>
    <hr>
    <div id="dlg-buttons" style="text-align: center;">
        <a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="saveDatax()">Save</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="cancelData()">Cancel</a>
    </div>


    <hr>


    <!-- ITEM -->
    <div id="dlgListItemAdd" class="easyui-dialog" style="width: 800px;height: 600px;" closed="true" buttons="#dlg-buttons-list-item-add">
        <table id="grdListItemAdd" class="easyui-datagrid" style="width:auto;height:500px;" toolbar="#tbListItemAdd" fitColumns="true" sortable="true" singleSelect="true" rownumbers="true" striped="true" nowrap="false" pagination="true" pageSize="15" pageList="[15, 30, 45, 60]">
            <thead>
                <tr>
                    <th field="kd_item" width="80" align="center" sortable="true">Kode Item</th>
                    <th field="nama_item" width="170" align="left" sortable="true">Diskripsi</th>
                    <th field="kd_satuan" width="90" align="center" sortable="true">Satuan</th>
                    <th field="item_type_name" width="170" align="left" sortable="true">Type</th>
                </tr>
            </thead>
        </table>

        <div id="dlg-buttons-list-item-add" style="text-align: center;">
            <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgListItemAdd').dialog('close');">Close</a>
        </div>
        <div id="tbListItemAdd" style="padding:10px;">
            <select id="selectFilterLIA" name="selectFilterLIA" class="easyui-combobox" style="width:150px;">
                <option value="nama_item">Diskripsi</option>
                <option value="kd_item">Kode Item</option>
            </select>
            <input id="filterValLIA" onkeyup="inputKeyEnterLIA(event)" style="line-height:26px;border:1px solid #ccc;">
            <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearchLIA();">Cari</a>
            <!--
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="false" onClick="newItem()">New Item</a>
                    -->
        </div>
    </div>
    <!-- END OF ITEM -->





    <script src="<?php echo base_url('assets/js/accounting.min.js') ?>"></script>
    <script type="text/javascript">
        var editIndex = undefined;
        var lastIndex;
        var mode = '<?= $mode ?>';
        var idx = '<?= $idx; ?>';

        //-----------------------------$('#dg').datagrid-----------------------------

        $(function() {


            $('#so_number').combogrid({
                panelWidth: 500,
                url: '<?= base_url()  ?>sales/Contract/getProject',
                idField: 'id_cc_project',
                textField: 'id_cc_project',
                mode: 'remote',
                fitColumns: true,
                columns: [
                    [{
                            field: 'id_cc_project',
                            title: 'ID',
                            width: 150,
                            align: 'center'
                        },
                        {
                            field: 'cc_project_name',
                            title: 'Project Name',
                            align: 'left',
                            width: 350
                        }
                    ]
                ],
                onSelect: function(index, row) {
                    //var desc = row.alamat; // the product's description
                    $('#remarks').textbox('setValue', row.cc_project_name);
                    $('#cust_po_number').textbox('setValue', row.po_number);
                    $('#lokasi').textbox('setValue', row.lokasi);

                    $('#kd_rekanan').combogrid('setValue', row.kd_rekanan);
                    $('#id_cat_project').combogrid('setValue', row.id_cat_project);
                    $('#manager').combogrid('setValue', row.manager);
                    $('#id_rek_gl').combogrid('setValue', row.id_rek_gl);

                    $('#dt_so').datebox('setValue', row.dt_order_char);
                    $('#dt_finish').datebox('setValue', row.dt_finish_char);
                }

            });



            $('#kd_rekanan').combogrid({
                panelWidth: 800,
                url: '<?= base_url()  ?>sales/Contract/getCustomer',
                idField: 'kd_rekanan',
                textField: 'nama_rekanan',
                mode: 'remote',
                //fitColumns: true,
                nowrap: false,
                columns: [
                    [{
                            field: 'kd_rekanan',
                            title: 'ID',
                            width: 200,
                            align: 'left'
                        },
                        {
                            field: 'nama_rekanan',
                            title: 'Customer Name',
                            align: 'left',
                            width: 200
                        },
                        {
                            field: 'alamat',
                            title: 'Adddress',
                            align: 'left',
                            width: 200
                        }
                    ]
                ],
                onSelect: function(index, row) {
                    //var desc = row.alamat; // the product's description
                    $('#remarks').textbox('setValue', row.alamat);
                }
            });



            $('#id_cat_project').combogrid({
                panelWidth: 400,
                url: '<?= base_url()  ?>sales/Contract/getCatProject',
                idField: 'id_cat_project',
                textField: 'cpdescriptions',
                mode: 'remote',
                fitColumns: true,
                columns: [
                    [{
                            field: 'id_cat_project',
                            title: 'ID',
                            width: 100,
                            align: 'center'
                        },
                        {
                            field: 'cpdescriptions',
                            title: 'Category Name',
                            align: 'left',
                            width: 300
                        }
                    ]
                ]

            });

            $('#manager').combogrid({
                panelWidth: 400,
                url: '<?= base_url()  ?>sales/Contract/getManager',
                idField: 'nk',
                textField: 'full_name',
                mode: 'remote',
                fitColumns: true,
                columns: [
                    [{
                            field: 'nk',
                            title: 'ID',
                            width: 100,
                            align: 'center'
                        },
                        {
                            field: 'full_name',
                            title: 'Manager Name',
                            align: 'left',
                            width: 300
                        }
                    ]
                ]

            });



            $('#id_rek_gl').combogrid({
                panelWidth: 400,
                url: '<?= base_url()  ?>sales/Contract/getProfitCenter',
                idField: 'id_rek_gl',
                textField: 'descriptions',
                mode: 'remote',
                fitColumns: true,
                columns: [
                    [{
                            field: 'id_rek_gl',
                            title: 'ID',
                            width: 100,
                            align: 'center'
                        },
                        {
                            field: 'descriptions',
                            title: 'Description',
                            align: 'left',
                            width: 300
                        }
                    ]
                ]

            });

            $('#grdListItemAdd').datagrid({
                onDblClickRow: function() {
                    var editors = $('#dg').datagrid('getEditors', editIndex);
                    var n0 = $(editors[0].target);
                    var n1 = $(editors[1].target);
                    var n3 = $(editors[3].target);
                    var row = $('#grdListItemAdd').datagrid('getSelected');
                    n0.textbox('setValue', row.kd_item);
                    n1.textbox('setValue', row.nama_item);
                    n3.textbox('setValue', row.kd_satuan);
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
                },
                onBeginEdit: function(rowIndex) {
                    var editors = $('#dg').datagrid('getEditors', rowIndex);
                    var n2 = $(editors[2].target); //qty
                    var n4 = $(editors[4].target); //unit price
                    var n5 = $(editors[5].target); //sub_total
                    var n6 = $(editors[6].target); //hpp price
                    var n7 = $(editors[7].target); //hpp sub_total
                    var n8 = $(editors[8].target); //margin psn
                    n2.add(n4).add(n6).numberbox({
                        onChange: function() {
                            var qty = parseFloat(n2.numberbox('getValue'));
                            var hrg = parseFloat(n4.numberbox('getValue'));
                            var hrg2 = parseFloat(n6.numberbox('getValue'));
                            n5.numberbox('setValue', qty * hrg);
                            n7.numberbox('setValue', qty * hrg2);
                            n8.numberbox('setValue', ((hrg2-hrg)/hrg)*100);
                        }
                    });

                }
            });



            if (mode == 'add') {
                //  $('#dt_so').datebox('setValue', '0');
            } else {
                fetchMasterData();
                fetchDetailData();
            }

        });



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

        function onEndEdit(index, row) {
            var ed = $(this).datagrid('getEditor', {
                index: index,
                field: 'kd_satuan'

            });
            row.kd_satuan = $(ed.target).combobox('getText');
        }

        function append() {
            if (endEditing()) {
                $('#dg').datagrid('appendRow', {
                    id_so_detail: 0
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


        function hitung_total() {
            var data = $('#dg').datagrid('getRows');
            var jml = 0;
            var jml2 = 0;
            if (data.length > 0) {
                for (i = 0; i < data.length; i++) {
                    jml += parseFloat(data[i].hpp_sub_total);
                    jml2 += parseFloat(data[i].sub_total);
                }
            }

            var ppn = jml * (10 / 100);
            var ppn2 = jml2 * (10 / 100);
            $('#sub_total_hpp').numberbox('setValue', jml);
            $('#vat_num_hpp').numberbox('setValue', ppn);
            $('#total_hpp').numberbox('setValue', jml + ppn);

            $('#sub_total').numberbox('setValue', jml2);
            $('#vat_num').numberbox('setValue', ppn2);
            $('#total').numberbox('setValue', jml2 + ppn2);
        }


        //-----------------------------END OF $('#dg').datagrid---------------------------------------------
        function fetchMasterData() {
            $.ajax({
                url: "<?= base_url(); ?>sales/Contract/getMasterData",
                method: "POST",
                dataType: 'json',
                data: {
                    id: idx
                },
                error: function() {
                    $.messager.alert('Error', 'Some Error Ocurred', 'error');
                },
                success: function(data) {
                    $('#id_so').textbox('setValue', data[0]['id_so']);
                    $('#so_number').textbox('setValue', data[0]['so_number']);
                    $('#dt_so').datebox('setValue', data[0]['dt_so']);
                    $('#dt_finish').datebox('setValue', data[0]['dt_finish']);

                    $('#no_qt').textbox('setValue', data[0]['no_qt']);


                    $('#cust_po_number').textbox('setValue', data[0]['cust_po_number']);
                    $('#kd_rekanan').combogrid('setValue', data[0]['kd_rekanan']);
                    $('#lokasi').textbox('setValue', data[0]['lokasi']);

                    $('#manager').combogrid('setValue', data[0]['manager']);
                    $('#id_cat_project').combogrid('setValue', data[0]['id_cat_project']);
                    $('#id_rek_gl').combogrid('setValue', data[0]['id_rek_gl']);
                    $('#cara_bayar').textbox('setValue', data[0]['cara_bayar']);
                    $('#remarks').textbox('setValue', data[0]['remarks']);

                    $('#sub_total').numberbox('setValue', data[0]['sub_total']);
                    $('#vat_num').numberbox('setValue', data[0]['vat_num']);
                    $('#total').numberbox('setValue', data[0]['total']);

                    $('#sub_total_hpp').numberbox('setValue', data[0]['sub_total_hpp']);
                    $('#vat_num_hpp').numberbox('setValue', data[0]['vat_num_hpp']);
                    $('#total_hpp').numberbox('setValue', data[0]['total_hpp']);


                }
            });
        }


        function fetchDetailData() {

            $.ajax({
                url: "<?= base_url(); ?>sales/Contract/getDetailData",
                method: "POST",
                dataType: 'json',
                data: {
                    id: idx
                },
                error: function() {
                    $.messager.alert('Error', 'Some Error Ocurred', 'error');
                },
                success: function(data) {
                    $('#dg').datagrid('loadData',
                        data
                    );
                    //hitung_total();
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
            $('#dlgListItemAdd').dialog({
                title: 'Daftar Item',
                closed: false,
                cache: false,
                modal: true,
                width: $(window).width() - 400
            });
            $('#grdListItemAdd').datagrid({
                url: '<?= base_url(); ?>sales/Contract/getItem'
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

        function scrollSmoothToBottom(id) {
            var div = document.getElementById(id);
            $('#' + id).animate({
                scrollTop: div.scrollHeight - div.clientHeight
            }, 500);
        }


        function saveDatax() {
            var id_so = $('#id_so').textbox('getValue');
            var so_number = $('#so_number').textbox('getValue');
            var dt_so = $('#dt_so').datebox('getValue');
            var dt_finish = $('#dt_finish').datebox('getValue');
            var no_qt = $('#no_qt').textbox('getValue');


            var cust_po_number = $('#cust_po_number').textbox('getValue');
            var kd_rekanan = $('#kd_rekanan').combogrid('getValue');

            var category = $('#id_cat_project').combogrid('getValue');
            var id_rek_gl = $('#id_rek_gl').combogrid('getValue');
            var manager = $('#manager').combogrid('getValue');
            var cara_bayar = $('#cara_bayar').textbox('getValue');
            var remarks = $('#remarks').textbox('getValue');
            var lokasi = $('#lokasi').textbox('getValue');

            var sub_total_hpp = $('#sub_total').numberbox('getValue');
            var vat_num_hpp = $('#vat_num').numberbox('getValue');
            var total_hpp = $('#total').numberbox('getValue');

            var sub_total = $('#sub_total').numberbox('getValue');
            var vat_num = $('#vat_num').numberbox('getValue');
            var total = $('#total').numberbox('getValue');

            // var detail = $('#dg').datagrid('getRows');

            // VALIDATION FORM --------------------------------------
            if (cust_po_number == '') {
                $.messager.alert('Warning', 'Customer PO/Contract Number must have value', 'warning');
                return false;
            } else if (dt_so == '') {
                $.messager.alert('Warning', 'Contract Date must have value', 'warning');
                return false;
            } else if (kd_rekanan == '') {
                $.messager.alert('Warning', 'Customer Name must have value', 'warning');
                return false;
            } else if (remarks == '') {
                $.messager.alert('Warning', 'Project Description must have value', 'warning');
                return false;
            } else if (cara_bayar == '') {
                $.messager.alert('Warning', 'Payemnt Term must have value', 'warning');
                return false;
            } else if (no_qt == '') {
                $.messager.alert('Warning', 'Quotation Number must have value', 'warning');
                return false;
            } else if (dt_finish == '') {
                $.messager.alert('Warning', 'Delivery Date must have value', 'warning');
                return false;
            } else if (manager == '') {
                $.messager.alert('Warning', 'Project Manager must have value', 'warning');
                return false;
            } else if (category == '') {
                $.messager.alert('Warning', 'Project Category must have value', 'warning');
                return false;
            } else if (id_rek_gl == '') {
                $.messager.alert('Warning', 'Profit Center must have value', 'warning');
                return false;
            } else if (lokasi == '') {
                $.messager.alert('Warning', 'Project Location must have value', 'warning');
                return false;
            }
            var master = [];

            master.push({
                id_so: id_so,
                so_number: so_number,
                dt_so: dt_so,
                dt_finish: dt_finish,
                no_qt: no_qt,
                kd_rekanan: kd_rekanan,
                cust_po_number: cust_po_number,
                manager: manager,
                id_rek_gl: id_rek_gl,
                id_cat_project: category,

                sub_total_hpp: sub_total_hpp,
                vat_num_hpp: vat_num_hpp,
                total_hpp: total_hpp,

                sub_total: sub_total,
                vat_num: vat_num,
                total: total,

                cara_bayar: cara_bayar,
                remarks: remarks,
                lokasi: lokasi,
                idtrans: <?= $idtrans; ?>
            });

            ///---------------detail
            var detail = [];
            var dg = $('#dg');

            $.map(dg.datagrid('getRows'), function(row) {
                dg.datagrid('endEdit', dg.datagrid('getRowIndex', row))
            })

            $.map(dg.datagrid('getRows'), function(row) {
                detail.push({
                    id_so_detail: row.id_so_detail,
                    kd_item: row.kd_item,
                    descriptions: row.descriptions,
                    qty: row.qty,
                    kd_satuan: row.kd_satuan,
                    hpp_price: parseFloat(row.hpp_price),
                    hpp_sub_total: parseFloat(row.hpp_sub_total),
                    unit_price: parseFloat(row.unit_price),
                    sub_total: parseFloat(row.sub_total),
                    margin_psn: parseFloat(row.margin_psn)
                });
            })



            var data = [];
            data.push({
                master: master,
                detail: detail
            });

            var uri;
            if (mode == 'edit') {
                uri = '<?= base_url(); ?>sales/Contract/updateContract';
            } else if (mode == 'add') {
                uri = '<?= base_url(); ?>sales/Contract/insertContract';
            }

            $.ajax({
                url: uri,
                method: "POST",
                dataType: 'json',
                data: {
                    info: data
                },
                error: function() {
                    $.messager.show({
                        title: 'Error',
                        msg: result.errorMsg
                    });
                },
                success: function(data) {
                    window.open('<?= base_url(); ?>sales/Contract', '_self');
                }
            });
        }

        function cancelData() {
            window.open('<?= base_url(); ?>sales/Contract', '_self');
        }

        function viewContract() {
            var sox = $('#so_number').textbox('getValue');
            if (sox == '') {
                $.messager.alert('Warning', 'Contract Number must have value', 'warning');
                return false;
            }
            window.open('<?= base_url(); ?>/pdf/' + sox + '.pdf');
        }





        ///-----------------------------------IMPORT EXCEL-----------------------
        $('#form_ticketing').on('submit', function(e) {
            e.preventDefault();
            var sox = $('#so_number').textbox('getValue');
            if (sox == '') {
                $.messager.alert('Warning', 'Contract Number must have value', 'warning');
                return false;
            }

            $.ajax({

                url: "<?= base_url(); ?>sales/Contract/uploadContract/" + sox,
                type: "POST",
                data: $('#form_ticketing').serialize(),
                dataType: 'json',
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                success: function(data) {
                    $.messager.alert('Success', 'File Uploaded !');
                },
                error: function() {
                    $.messager.show({
                        title: 'Error',
                        msg: result.errorMsg
                    });
                }
            });
        });

        // END OF IMPORT EXCEL
    </script>


</body>

</html>