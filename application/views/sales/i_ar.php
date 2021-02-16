<!DOCTYPE html>

<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($this->session->userdata("username"))) {
    redirect(site_url(), 'refresh');
} elseif (empty($this->session->userdata("ar"))) {
    redirect(base_url('sales/Ar'), 'refresh');
};
?>

<body>
    <table style="width: 100%;" cellspacing="0px" border="0">
        <tr>
            <td style="width:50%;text-align:left">
                <h4><?= $caption; ?></h4>
            </td>
            <td style="width:50%;text-align:right"><input id="id_sales_invoice" class="easyui-textbox" readonly="true" style="width:150px;"></td>
        </tr>
    </table>
    <hr>

    <table style="width: auto;" cellspacing="5px" border="0">
        <tr>

            <td><input id="no_sales_invoice" class="easyui-textbox" label="Invoice #:" labelPosition="top" readonly="true" style="width:200px;"></td>
            <td rowspan="2"><input id="kd_rekanan" class="easyui-combogrid" label="Customer Name:" labelPosition="top" multiline="true" required="true" style="width:300px;height:100px;"></td>
            <td rowspan="2"><input id="id_cc_project" class="easyui-combogrid" label="Cost Center/Project:" labelPosition="top" multiline="true" required="true" style="width:300px;height:100px;"></td>
            <td style="width:300px;height:100px;text-align:left;vertical-align:center;padding:5px;" rowspan="2">
                <input id="no_kontrak" class="easyui-textbox" label="Contr #:" labelPosition="left" readonly="true" style="width:250px;">
                <input id="dt_contract" readonly class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="Date:" labelPosition="left" readonly="true" style="width:250px;">
                <input id="nilai_kontrak" readonly class="easyui-numberbox" style="text-align: right; width: 250px;" label="Value:" labelPosition="left" readonly="true" data-options="min:0,precision:2,groupSeparator:','">
            </td>

        </tr>
        <tr>
            <td><input id="dt_sales_invoice" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="Invoice Date:" labelPosition="top" required="true" style="width:200px;"></td>
        </tr>


    </table>

    <br>
    <hr>

    <div>
        <table id="dg" class="easyui-datagrid" title="Invoice Detail" style="width:85%;height:auto" data-options="
                iconCls: 'icon-edit',
                singleSelect: true,
				toolbar: '#tb',
				rownumbers: true,
				showfooter: true,
                url: '',
                method: 'post',
                onClickCell: onClickCell,
                onEndEdit: onEndEditdg
            ">
            <thead>
                <tr>
                    <th data-options="field:'kd_item',width:100,editor:{type:'textbox',options:{required:false,
					icons:[{
						iconCls:'icon-search',
						handler: function(e){
							onclick=listItemAdd();
                            
                        }
					}]}}">Item ID</th>
                    <th data-options="field:'remarks',width:400,editor:{type:'textbox',options:{readonly:false}}">Descriptions</th>
                    <th data-options="field:'id_rek_gl',width:150,
                                        formatter:function(value,row){
                                            return row.id_rek_gl;
                                        },
                                        editor:{
                                            type:'combobox',
                                            options:{
                                                valueField:'id_rek_gl',
                                                textField:'descriptions',
                                                method:'get',
                                                url:'<?= base_url(); ?>sales/Ar/getCoaDetail',
                                                required:true
                                            }
                                        }">Account [Cr]</th>
                    <th data-options="field:'qty',width:70,align:'right',editor:{type:'numberbox',options:{precision:1,required:true,readonly:false}}">Qty [%]</th>
                    <th data-options="field:'qty_unit',width:70,align:'right',editor:{type:'numberbox',options:{precision:1,required:true,readonly:false}}">Qty Unit</th>



                    <th data-options="field:'kd_satuan',width:70,
                                        formatter:function(value,row){
                                            return row.kd_satuan;
                                        },
                                        editor:{
                                            type:'combobox',
                                            options:{
                                                valueField:'kd_satuan',
                                                textField:'kd_satuan',
                                                method:'get',
                                                url:'<?= base_url(); ?>sales/Ar/getUnit',
                                                required:true
                                            }
                                        }">Unit</th>
                    <th data-options="field:'unit_price',width:100,formatter:datagridFormatNumber,align:'right',readonly:'true',editor:{type:'numberbox',options:{precision:2,required:true,readonly:true}}">Unit Price</th>
                    <th data-options="field:'sub_total',width:100,formatter:datagridFormatNumber,align:'right',readonly:'true',editor:{type:'numberbox',options:{precision:2,required:true,readonly:true}}">Ammount</th>
                    <th data-options="field:'id_sales_invoice_detail'" hidden="true">id_sales_invoice_detail</th>
                </tr>
            </thead>
        </table>
        <br>
        <table id="dgx" style="width:85%;height:auto" border="0">
            <tr>
                <td style="width:24%;vertical-align:top;padding: 10px;" rowspan="7">
                    <input id="id_rek_gl" class="easyui-combogrid" label="Account [Dr]:" labelPosition="top" required="true" style="width:250px;">
                    <input id="due_date" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="Due Date:" labelPosition="top" required="true" style="width:250px;">
                    <input id="remarks" class="easyui-textbox" label="Remarks:" labelPosition="top" multiline="true" style="width:300px;height:100px;">
                </td>
                <td style="width:5%;height:30px;vertical-align:top" rowspan="7"></td>
                <td style="width:30%;height:30px;vertical-align:top;padding:10px;" rowspan="7">
                    <input id="vat_str" class="easyui-combobox" label="VAT:" labelPosition="left" required="true" style="width:250px;" data-options="
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
                    <p></p>
                    <input id="no_acc" class="easyui-combogrid" label="Bank A/C:" labelPosition="left" required="true" style="width:250px">
                    <p></p>
                    <input id="bank_transfer" class="easyui-textbox" style="width:250px;">
                    <p></p>
                    <input id="no_berita_acara" class="easyui-textbox" label="Berita Acara #:" labelPosition="top" style="width:250px">
                    <input id="dt_berita_acara" class="easyui-datebox" label="Tgl. Berita Acara:" labelPosition="top" data-options="formatter:myformatter,parser:myparser" style="width:250px;">
                </td>
                <td style="width:20%;height:30px;text-align:right">Sub Total</td>
                <td style="width:13%;height:30px;text-align:right"><input id="sub_total" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
            </tr>
            <tr>
                <td style="width:20%;height:30px;text-align:right">Discount</td>
                <td style="width:13%;height:30px;text-align:right"><input id="disc" class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
            </tr>
            <tr>

                <td style="width:20%;height:30px;text-align:right">Dasar Pengenaan Pajak [DPP]</td>
                <td style="width:13%;height:30px;text-align:right"><input id="dpp" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
            </tr>
            <tr>
                <td style="width:20%;height:30px;text-align:right">PPN</td>
                <td style="width:13%;height:30px;text-align:right"><input id="vat_num" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
            </tr>
            <tr>

                <td style="width:20%;height:30px;text-align:right">Dikurangi Pph23</td>
                <td style="width:13%;height:30px;text-align:right">
                    <input id="pph_psn" class="easyui-numberbox" style="text-align: right; width: 30px;" data-options="min:0,precision:1,groupSeparator:','"> [%]
                    <input id="pph_rp" class="easyui-numberbox" style="text-align: right; width: 80px;" data-options="min:0,precision:2,groupSeparator:','">
                </td>
            </tr>
            <tr>

                <td style="width:20%;height:30px;text-align:right">Dikurangi DP/Termin</td>
                <td style="width:13%;height:30px;text-align:right"><input id="dp_termin" class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
            </tr>
            <tr>

                <td style="width:20%;height:30px;text-align:right">Nilai Bersih Yang Dibayarkan</td>
                <td style="width:13%;height:30px;text-align:right"><input id="total" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
            </tr>
        </table>

        <div id="tb" style="height:auto">
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="append()">Append</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeit()">Remove</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="acceptit()">Accept</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="reject()">Reject</a>
        </div>
    </div>
    <hr>

    <div id="dlg-buttons" style="text-align: center;">
        <a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="saveDatax()">Save</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="cancelData()">Cancel</a>
    </div>

    <hr>


    <!-- ITEM -->
    <div id="dlgListItemAdd" class="easyui-dialog" style="width: 800px;height: 500px;" closed="true" buttons="#dlg-buttons-list-item-add">
        <table id="grdListItemAdd" class="easyui-datagrid" style="width:auto;height:auto;" toolbar="#tbListItemAdd" fitColumns="true" singleSelect="true" rownumbers="true" striped="true" nowrap="false" pagination="false">
            <thead>
                <tr>
                    <th field="kd_item" width="80" align="center">Item ID</th>
                    <th field="descriptions" width="170" align="left">Descriptions</th>
                    <th field="kd_pi" width="100" align="left">PI #</th>
                    <th field="qty" width="80" align="right">Qty</th>
                    <th field="kd_satuan" width="90" align="left">Unit</th>
                    <th field="unit_price" width="90" formatter="datagridFormatNumber" align="right">Unit Price</th>
                    <th field="sub_total" width="90" formatter="datagridFormatNumber" align="right">Ammount</th>
                </tr>
            </thead>
        </table>
    </div>
    <div id="dlg-buttons-list-item-add">
        <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgListItemAdd').dialog('close');">Close</a>
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
            // $("#pkd_rekanan").hide();
            // $("#pid_qs").hide();

            $('#kd_rekanan').combogrid({
                panelWidth: 500,
                url: '<?= base_url()  ?>sales/Ar/getCustomer',
                idField: 'kd_rekanan',
                textField: 'nama_rekanan',
                mode: 'remote',
                fitColumns: true,
                columns: [
                    [{
                            field: 'kd_rekanan',
                            title: 'ID',
                            width: 80,
                            align: 'center'
                        },
                        {
                            field: 'nama_rekanan',
                            title: 'Customer Name',
                            align: 'left',
                            width: 420
                        }
                    ]
                ]

            });

            $('#id_cc_project').combogrid({
                panelWidth: 400,
                url: '<?= base_url()  ?>sales/Ar/getProject',
                idField: 'id_cc_project',
                textField: 'cc_project_name',
                mode: 'remote',
                fitColumns: true,
                nowrap: false,
                columns: [
                    [{
                            field: 'id_cc_project',
                            title: 'ID',
                            width: 80,
                            align: 'center'
                        },
                        {
                            field: 'cc_project_name',
                            title: 'Descriptions',
                            align: 'left',
                            width: 320
                        }

                    ]
                ],
                onSelect: function(index, row) {
                    $('#no_kontrak').textbox('setValue', row.po_number);
                    $('#dt_contract').datebox('setValue', row.dt_order);
                    $('#nilai_kontrak').numberbox('setValue', row.nilai);
                }

            });



            $('#id_rek_gl').combogrid({
                panelWidth: 300,
                url: '<?= base_url()  ?>sales/Ar/getCoaMaster',
                idField: 'id_rek_gl',
                textField: 'descriptions',
                mode: 'remote',
                fitColumns: true,
                nowrap: false,
                columns: [
                    [{
                            field: 'id_rek_gl',
                            title: 'ID',
                            width: 100,
                            align: 'center'
                        },
                        {
                            field: 'descriptions',
                            title: 'Descriptions',
                            align: 'left',
                            width: 200
                        }

                    ]
                ]

            });

            $('#no_acc').combogrid({
                panelWidth: 400,
                url: '<?= base_url()  ?>sales/Ar/getBank',
                idField: 'no_acc',
                textField: 'no_acc',
                mode: 'remote',
                fitColumns: true,
                nowrap: false,
                columns: [
                    [{
                            field: 'no_acc',
                            title: 'ID',
                            width: 150,
                            align: 'center'
                        },
                        {
                            field: 'descriptions',
                            title: 'Descriptions',
                            align: 'left',
                            width: 250
                        }

                    ]
                ],
                onSelect: function(index, row) {
                    //var desc = row.desc; // the product's description
                    //console.log(desc);
                    $('#bank_transfer').textbox('setValue', row.descriptions);
                }

            });



            $('#grdListItemAdd').datagrid({
                onDblClickRow: function() {
                    var editors = $('#dg').datagrid('getEditors', editIndex);
                    var n0 = $(editors[0].target);
                    var n1 = $(editors[1].target);
                    var n2 = $(editors[2].target);
                    var n5 = $(editors[5].target);
                    var n6 = $(editors[6].target);
                    var n7 = $(editors[7].target);
                    var n8 = $(editors[8].target);
                    var row = $('#grdListItemAdd').datagrid('getSelected');
                    n0.textbox('setValue', row.kd_item);
                    n1.textbox('setValue', row.kd_pi);
                    n2.textbox('setValue', row.descriptions);
                    n5.textbox('setValue', row.qty);
                    n6.textbox('setValue', row.kd_satuan);
                    n7.textbox('setValue', row.unit_price);
                    n8.textbox('setValue', row.sub_total);
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
                    var n4 = $(editors[4].target); //qty
                    var n5 = $(editors[5].target); //qty psn
                    var n7 = $(editors[7].target); //unit price
                    var n8 = $(editors[8].target); //sub_total

                    // x1.add(x2).numberbox({
                    // 	onChange: function() {
                    // 		var c1 = x1.numberbox('getValue') * x2.numberbox('getValue');
                    // 		x3.numberbox('setValue', c1);
                    // 	}
                    // });
                    n4.add(n5).add(n7).numberbox({
                        onChange: function() {
                            var qp = parseFloat(n4.numberbox('getValue'));
                            var qu = parseFloat(n5.numberbox('getValue'));
                            var hrg = parseFloat(n7.numberbox('getValue'));

                            n8.numberbox('setValue', ((hrg * qu) + (hrg * (qp / 100))));
                            // n8.numberbox('setValue', qty * (hrg * (1 + mrg)));
                        }
                    });

                }
            });

            $('#disc').numberbox({
                onChange: function() {
                    hitung_total();
                }
            });

            $('#pph_rp').numberbox({
                onChange: function() {
                    hitung_total();
                }
            });

            $('#dp_termin').numberbox({
                onChange: function() {
                    hitung_total();
                }
            });



            if (mode == 'add') {
                $('#disc').numberbox('setValue', 0);
                $('#pph_psn').numberbox('setValue', 0);
                $('#pph_rp').numberbox('setValue', 0);
                $('#dp_termin').numberbox('setValue', 0);

            } else {
                fetchMasterData(idx);
                fetchDetailData(idx);

            }
        });


        function fetchMasterData($idp) {
            $.ajax({
                url: "<?= base_url(); ?>sales/Ar/getMasterData",
                method: "POST",
                dataType: 'json',
                data: {
                    idx: $idp
                },
                error: function() {
                    document.getElementById("addError").click(); // Click on the checkbox
                },
                success: function(data) {

                    $('#id_sales_invoice').textbox('setValue', data[0]['id_sales_invoice']);
                    $('#no_sales_invoice').textbox('setValue', data[0]['no_sales_invoice']);
                    $('#dt_sales_invoice').datebox('setValue', data[0]['dt_sales_invoice']);
                    $('#due_date').datebox('setValue', data[0]['due_date']);
                    $('#dt_berita_acara').datebox('setValue', data[0]['dt_berita_acara']);

                    $('#remarks').textbox('setValue', data[0]['remarks']);

                    $('#kd_rekanan').combogrid('setValue', data[0]['kd_rekanan']);
                    $('#id_rek_gl').combogrid('setValue', data[0]['id_rek_gl']);
                    $('#id_cc_project').combogrid('setValue', data[0]['id_cc_project']);
                    $('#no_acc').combogrid('setValue', data[0]['no_acc']);
                    $('#bank_transfer').textbox('setValue', data[0]['bank_transfer']);

                    $('#no_kontrak').textbox('setValue', data[0]['no_kontrak']);
                    $('#dt_contract').datebox('setValue', data[0]['dt_contract']);
                    $('#nilai_kontrak').numberbox('setValue', data[0]['nilai_kontrak']);


                    $('#vat_str').combobox('setValue', data[0]['vat_str']);
                    $('#no_berita_acara').textbox('setValue', data[0]['no_berita_acara']);

                    $('#sub_total').numberbox('setValue', data[0]['sub_total']);
                    $('#vat_num').numberbox('setValue', data[0]['vat_num']);
                    $('#total').numberbox('setValue', data[0]['total']);
                    $('#disc').numberbox('setValue', data[0]['disc']);
                    $('#dpp').numberbox('setValue', data[0]['dpp']);
                    $('#pph_psn').numberbox('setValue', data[0]['pph_psn']);
                    $('#pph_rp').numberbox('setValue', data[0]['pph_rp']);
                    $('#dp_termin').numberbox('setValue', data[0]['dp_termin']);

                }
            });
        }

        function fetchDetailData(idx) {
            $.ajax({
                url: "<?= base_url(); ?>sales/Ar/getDetailData",
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

            var ped = $(this).datagrid('getEditor', {
                index: index,
                field: 'id_rek_gl'
            });
            //row.id_parent = $(ed2.target).combobox('getText');
            $('#dg').datagrid('getRows')[index]['parentname'] = $(ped.target).combobox('getText');
        }

        function append() {
            if (endEditing()) {
                $('#dg').datagrid('appendRow', {
                    id_sales_invoice_detail: 0
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
            if (data.length > 0) {
                for (i = 0; i < data.length; i++) {
                    jml += parseFloat(data[i].sub_total);
                }
            }


            var disc = $('#disc').numberbox('getValue');
            var dp_termin = $('#dp_termin').numberbox('getValue');
            // var disc = $('#disc').numberbox('getValue');

            var dpp = jml - disc;
            var ppnrp = dpp * (10 / 100);



            $('#sub_total').numberbox('setValue', jml);
            $('#dpp').numberbox('setValue', dpp);
            $('#vat_num').numberbox('setValue', ppnrp);
            $('#total').numberbox('setValue', (dpp + ppnrp) - dp_termin);

        }


        //-----------------------------END OF $('#dg').datagrid---------------------------------------------


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
            var idx = $("#id_cc_project").combogrid('getValue');
            if (idx == '') {
                $.messager.alert('Warning', 'CC/Project must have value', 'warning');
                return false;
            }
            $('#dlgListItemAdd').dialog({
                title: 'Master Item Contract',
                closed: false,
                cache: false,
                modal: true,
                width: $(window).width() - 300
            });
            $('#grdListItemAdd').datagrid({
                url: '<?= base_url(); ?>sales/Ar/getItem/' + idx
            });

        }
        //END OF ITEM


        function saveDatax() {

            var id_sales_invoice = $("#id_sales_invoice").textbox('getValue');
            var no_sales_invoice = $("#no_sales_invoice").textbox('getValue');
            var no_kontrak = $("#no_kontrak").textbox('getValue');
            var remarks = $("#remarks").textbox('getValue');
            var bank_transfer = $("#bank_transfer").textbox('getValue');
            var no_berita_acara = $("#no_berita_acara").val();

            var kd_rekanan = $("#kd_rekanan").combogrid('getValue');
            var id_cc_project = $("#id_cc_project").combogrid('getValue');
            var id_rek_gl = $("#id_rek_gl").combogrid('getValue');
            var no_acc = $("#no_acc").combogrid('getValue');
            var vat_str = $("#vat_str").combobox('getValue');


            var dt_sales_invoice = $("#dt_sales_invoice").datebox('getValue');
            var due_date = $("#due_date").datebox('getValue');
            var dt_berita_acara = $("#dt_berita_acara").datebox('getValue');
            var dt_contract = $("#dt_contract").datebox('getValue');


            var sub_total = $('#sub_total').numberbox('getValue');
            var disc = $('#disc').numberbox('getValue');
            var dpp = $('#dpp').numberbox('getValue');
            var vat_num = $('#vat_num').numberbox('getValue');
            var pph_psn = $('#pph_psn').numberbox('getValue');
            var pph_rp = $('#pph_rp').numberbox('getValue');
            var dp_termin = $('#dp_termin').numberbox('getValue');
            var total = $('#total').numberbox('getValue');


            var detail = $('#dg').datagrid('getRows');

            // VALIDATION FORM --------------------------------------
            if (dt_sales_invoice == '') {
                $.messager.alert('Warning', 'Invoice Date must have value', 'warning');
                return false;
            } else if (no_berita_acara == '') {
                $.messager.alert('Warning', 'No. Berita Acara must have value', 'warning');
                return false;
            } else if (kd_rekanan == '') {
                $.messager.alert('Warning', 'Customer Name must have value', 'warning');
                return false;
            } else if (vat_str == '') {
                $.messager.alert('Warning', 'VAT must have value', 'warning');
                return false;
            } else if (no_acc == '') {
                $.messager.alert('Warning', 'Bank A/C must have value', 'warning');
                return false;
            } else if (id_cc_project == '') {
                $.messager.alert('Warning', 'CC/Project must have value', 'warning');
                return false;
            }
            var master = [];

            master.push({
                id_sales_invoice: id_sales_invoice,
                no_sales_invoice: no_sales_invoice,
                no_kontrak: no_kontrak,
                remarks: remarks,
                bank_transfer: bank_transfer,
                no_berita_acara: no_berita_acara,
                kd_rekanan: kd_rekanan,
                id_cc_project: id_cc_project,
                id_rek_gl: id_rek_gl,
                no_acc: no_acc,
                vat_str: vat_str,

                dt_sales_invoice: dt_sales_invoice,
                due_date: due_date,
                dt_berita_acara: dt_berita_acara,
                dt_contract: dt_contract,


                sub_total: sub_total,
                disc: disc,
                dpp: dpp,
                vat_num: vat_num,
                pph_psn: pph_psn,
                pph_rp: pph_rp,
                dp_termin: dp_termin,
                total: total,
                idtrans: <?= $idtrans; ?>
            });


            ////-----------------------------remarks-------------------------
            // var rows = [];
            // var dgr = $('#dgr');

            // $.map(dgr.datagrid('getRows'), function(row) {
            //     dgr.datagrid('endEdit', dgr.datagrid('getRowIndex', row))
            // })

            // $.map(dgr.datagrid('getRows'), function(row) {
            //     rows.push({
            //         id_qt_remarks: row.id_qt_remarks,
            //         nomor: row.nomor,
            //         descriptions: row.descriptions,
            //     });
            // })
            ////-----------------------------end of remarks-------------------------


            var data = [];
            data.push({
                master: master,
                detail: detail
            });

            var uri;
            if (mode == 'edit') {
                uri = '<?= base_url(); ?>sales/Ar/updateAr';
            } else if (mode == 'add') {
                uri = '<?= base_url(); ?>sales/Ar/insertAr';
            }


            $.ajax({
                url: uri,
                method: "POST",
                dataType: 'json',
                data: {
                    info: data
                },
                error: function() {
                    $.messager.alert('Error', result.errorMsg, 'Error');
                },
                success: function(data) {
                    window.open('<?= base_url(); ?>sales/Ar', '_self');
                }
            });
        }

        function cancelData() {
            window.open('<?= base_url(); ?>sales/Ar', '_self');
        }


        // END OF IMPORT EXCEL
    </script>


</body>

</html>