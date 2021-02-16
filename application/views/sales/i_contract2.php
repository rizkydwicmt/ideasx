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
    <table style="width: auto;" cellspacing="10px" border="0">
        <tr>

            <td><input id="so_number" class="easyui-combogrid" label="Contract/Project #:" labelPosition="top" required="true" style="width:150px;"></td>
            <td><input id="no_qt" class="easyui-textbox" required="true" style="width:160px;" data-options="
                                                                                                        label: 'Quotation # :',
                                                                                                        labelPosition: 'top',
                                                                                                        prompt: 'Get data from Quotation',
                                                                                                        iconWidth: 22,
                                                                                                        icons: [{
                                                                                                            iconCls:'icon-search',
                                                                                                            handler: function(e){
                                                                                                                onclick=getQuotationNo();
                                                                                                            }
                                                                                                        }]
                                                                                                        "></td>
            <td rowspan="2"><input id="kd_rekanan" class="easyui-combogrid" label="Customer Name:" labelPosition="top" multiline="true" required="true" style="width:300px;height:100px;"></td>
            <td><input id="id_cat_project" class="easyui-combogrid" label="Project Category:" labelPosition="top" required="true" style="width:250px"></td>
            <td><input id="id_rek_gl" class="easyui-combogrid" label="Profit Center:" labelPosition="top" required="true" style="width:200px"></td>
            <td>
                <select id="vat_str" class="easyui-combobox" label="VAT:" labelPosition="top" style="width:100px">
                    <option value="EXCLUDE">EXCLUDE</option>
                    <option value="INCLUDE">INCLUDE</option>
                    <option value="NONE">NONE</option>
                </select>
            </td>

        </tr>


        <tr>
            <td><input id="dt_so" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="Contract Date:" labelPosition="top" required="true" style="width:150px;"></td>
            <td><input id="no_qs" class="easyui-textbox" label="Quotsheet #:" labelPosition="top" required="true" style="width:160px;"></td>
            <td rowspan="2"><input id="remarks" class="easyui-textbox" label="Project Description:" labelPosition="top" multiline="true" required="true" style="width:250px;height:100px;"></td>
            <td rowspan="2" colspan="2"><input id="cara_bayar" class="easyui-textbox" label="Payment Terms: (separate line by '|')" labelPosition="top" multiline="true" style="width:300px;height:100px;"></td>
        </tr>
        <tr>
            <td><input id="cust_po_number" class="easyui-textbox" label="Cust.PO/Contract #:" labelPosition="top" required="true" style="width:150px;"></td>
            <td><input id="dt_finish" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="Delivery Date:" labelPosition="top" required="true" style="width:160px;"></td>
            <td rowspan="2"><input id="lokasi" class="easyui-textbox" label="Project Location:" labelPosition="top" multiline="true" required="true" style="width:300px;height:100px"></td>

        </tr>
        <tr>
            <td colspan="2"><input id="manager" class="easyui-combogrid" label="Project Manager:" labelPosition="top" required="true" style="width:300px"></td>
            <td><input id="id_cc_project" class="easyui-textbox" label="cc/project #:" labelPosition="top" readonly="true" style="width:250px;"></td>
            <td><input id="id_qt" class="easyui-textbox" label="Quotation ID" labelPosition="top" readonly="true" style="width:100px;"></td>
            <td><input id="id_qs" class="easyui-textbox" label="Quotsheet ID" labelPosition="top" readonly="true" style="width:100px;"></td>
        </tr>

    </table>
    <br>
    <div>
        <table style="width: auto;" cellspacing="0px" border="0">
            <tr>
                <td colspan="4" style="width:auto;height:25px;">
                    <form method="post" id="form_ticketing" style="display: inline;">
                        <input class="easyui-filebox" label="Upload:" labelPosition="left" data-options="prompt:'Choose a file...'" style="width:500px;height: 25px" name="file" id="import_file">
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
                    <th data-options="field:'kd_item',width:150,editor:{type:'textbox',options:{required:true,
					icons:[{
						iconCls:'icon-search',
						handler: function(e){
							onclick=listItemAdd();
                            
                        }
					}]}}">Item ID</th>
                    <th data-options="field:'descriptions',width:450,editor:{type:'textbox',options:{required:true}}">Descriptions</th>
                    <th data-options="field:'qty',width:70,align:'right',editor:{type:'numberbox',options:{precision:0,required:true}}">Qty</th>
                    <th data-options="field:'kd_satuan',width:100,
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
                    <th data-options="field:'unit_price',width:150,formatter:datagridFormatNumber,align:'right',editor:{type:'numberbox',options:{precision:2,required:true}}">Unit Price</th>
                    <th data-options="field:'sub_total',width:150,formatter:datagridFormatNumber,align:'right',editor:{type:'numberbox',options:{precision:2},readonly:true}">Ammount</th>
                    <th data-options="field:'id_so_detail'" hidden="true">id_so_detail</th>
                </tr>
            </thead>
        </table>
        <br>
        <table id="dgx" style="width:100%;height:auto" border="0">
            <tr>
                <td style="width:60%;height:30px" rowspan="4">
                    <!----------------------TABEL RESUME ------------------------------------------->
                    <table id="dgr" class="easyui-datagrid" style="width:550px;height:120px;" url="" nowrap="false" fitColumns="true" showFooter="true" rownumbers="true" pagination="false">
                        <thead>
                            <tr>
                                <th field="diskripsi" width="150" align=left>Descriptions</th>
                                <th field="sub_total" width="150" align="right">Sub Total</th>
                                <th field="vat_num" width="150" align="right">Vat</th>
                                <th field="total" width="150" align="right">Total</th>

                            </tr>
                        </thead>
                    </table>
                    <!--------------------------------END OF TABEL RESUME------------------------------->

                </td>
                <td style="width:10%;height:30px;text-align:right">SUB TOTAL</td>
                <td style="width:13%;height:30px;text-align:right"><input id="sub_total" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
                <td style="width:auto;height:30px"></td>
            </tr>
            <tr>

                <td style="width:10%;height:30px;text-align:right">VAT NUM</td>
                <td style="width:13%;height:30px;text-align:right"><input id="vat_num" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
                <td style="width:auto;height:30px"></td>
            </tr>
            <tr>
                <td style="width:10%;height:30px;text-align:right">TOTAL</td>
                <td style="width:13%;height:30px;text-align:right"><input id="total" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
                <td style="width:auto;height:30px"></td>
            </tr>
            <tr>
                <td style="width:auto;height:50px"></td>
                <td style="width:auto;height:50px"></td>
                <td style="width:auto;height:50px"></td>
            </tr>
        </table>

        <div id="tb" style="height:auto">
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="append()">Append</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeit()">Remove</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="acceptit()">Accept</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="reject()">Reject</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-pdf',plain:true" onclick="viewContract()">View Contract</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-reload',plain:true" onclick="loadQuotation()">Load Quotation</a>
            <!--
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-details',plain:true" onclick="loadQuotation()">Load Quotation</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-upload',plain:true" onclick="loadQuotsheet()">Load Quotsheet</a>
                    -->
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



    <!-- QUOTATION -->
    <div id="dlgQuot" class="easyui-dialog" style="width: 800px;height: 600px;" closed="true" buttons="#dlg-buttons-list-quot-add">
        <table id="grdQuot" class="easyui-datagrid" style="width:auto;height:auto;" toolbar="#tbQuot" fitColumns="true" sortable="true" singleSelect="true" rownumbers="true" striped="true" nowrap="false" pagination="true" pageSize="15" pageList="[15, 30, 45, 60]">
            <thead>
                <tr>
                    <th field="no_qt" width="150" align="left" sortable="true">Quotation #</th>
                    <th field="dt_qt" width="100" align="left" sortable="true">Date</th>
                    <th field="proposal_description" width="170" align="left" sortable="true">Project Name</th>
                    <th field="nama_rekanan" width="200" align="left" sortable="true">Customer Name</th>
                    <th field="nama_kontak" width="100" align="left" sortable="true">Contact Name</th>
                </tr>
            </thead>
        </table>
    </div>
    <div id="dlg-buttons-list-quot-add">
        <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgQuot').dialog('close');">Close</a>
    </div>
    <div id="tbQuot" style="padding:10px;">
        <input id="filterValQuot" onkeyup="inputKeyEnterQuot(event)" style="line-height:26px;border:1px solid #ccc;">
        <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearchQuot();">Cari</a>
    </div>
    <!-- END OF QUOTATION -->

    <script src="<?php echo base_url('assets/js/accounting.min.js') ?>"></script>
    <script type="text/javascript">
        var editIndex = undefined;
        var lastIndex;
        var mode = '<?= $mode ?>';
        var idx = '<?= $idx; ?>';

        //-----------------------------$('#dg').datagrid-----------------------------

        $(function() {

            // $("#pid_cc_project").hide();
            // $("#pid_qs").hide();
            // $("#pid_qt").hide();


            $('#id_cat_project').combogrid({
                panelWidth: 300,
                url: '<?= base_url()  ?>sales/Contract/getCatProject',
                idField: 'id_cat_project',
                textField: 'cpdescriptions',
                mode: 'remote',
                fitColumns: true,
                columns: [
                    [{
                            field: 'id_cat_project',
                            title: 'ID',
                            width: 50,
                            align: 'center'
                        },
                        {
                            field: 'cpdescriptions',
                            title: 'Category Project',
                            align: 'left',
                            width: 250
                        }
                    ]
                ]

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
                    $('#lokasi').textbox('setValue', row.alamat);
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


            $('#grdQuot').datagrid({
                onDblClickRow: function() {
                    var row = $('#grdQuot').datagrid('getSelected');
                    $('#id_qs').textbox('setValue', row.id_qs);
                    $('#no_qs').textbox('setValue', row.no_qs);
                    $('#id_qt').textbox('setValue', row.id_qt);
                    $('#no_qt').textbox('setValue', row.no_qt);
                    $('#cara_bayar').textbox('setValue', row.pterm);
                    $('#remarks').textbox('setValue', row.proposal_description);
                    $('#category').textbox('setValue', row.id_cat_project);
                    fetchResumeData('get');
                    $('#dlgQuot').dialog('close');
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
                    n2.add(n4).numberbox({
                        onChange: function() {
                            var qty = parseFloat(n2.numberbox('getValue'));
                            var hrg = parseFloat(n4.numberbox('getValue'));
                            n5.numberbox('setValue', qty * hrg);
                        }
                    });

                }
            });



            if (mode == 'add') {
                //  $('#dt_so').datebox('setValue', '0');
            } else {
                fetchMasterData();
                fetchDetailData();
                fetchResumeData('load');
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
            if (data.length > 0) {
                for (i = 0; i < data.length; i++) {
                    jml += parseFloat(data[i].sub_total);
                }
            }

            var ppn = jml * (10 / 100);
            $('#sub_total').numberbox('setValue', jml);
            $('#vat_num').numberbox('setValue', ppn);
            $('#total').numberbox('setValue', jml + ppn);
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
                    $('#no_qs').textbox('setValue', data[0]['no_qs']);
                    $('#id_qs').textbox('setValue', data[0]['id_qs']);
                    $('#no_qt').textbox('setValue', data[0]['no_qt']);
                    $('#id_qt').textbox('setValue', data[0]['id_qt']);

                    $('#cust_po_number').textbox('setValue', data[0]['cust_po_number']);
                    $('#kd_rekanan').combogrid('setValue', data[0]['kd_rekanan']);
                    $('#lokasi').textbox('setValue', data[0]['lokasi']);
                    $('#vat_str').textbox('setValue', data[0]['vat_str']);
                    $('#manager').combogrid('setValue', data[0]['manager']);
                    $('#id_cat_project').combogrid('setValue', data[0]['id_cat_project']);
                    $('#id_rek_gl').combogrid('setValue', data[0]['id_rek_gl']);
                    $('#cara_bayar').textbox('setValue', data[0]['cara_bayar']);
                    $('#remarks').textbox('setValue', data[0]['remarks']);

                    $('#sub_total').numberbox('setValue', data[0]['sub_total']);
                    $('#vat_num').numberbox('setValue', data[0]['vat_num']);
                    $('#total').numberbox('setValue', data[0]['total']);


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



        function fetchResumeData(m) {
            var idCont;
            var idQuot;
            if (m == 'get') {
                var id_qt = $("#id_qt").val();
                if (id_qt == '') {
                    $.messager.alert('Warning', 'Quotation Number must have value', 'warning');
                    return false;
                } else {
                    idQuot = id_qt;
                    idCont = 0;
                }
            } else if (m == 'load') {
                idQuot = 0;
                idCont = idx;
            }


            $.ajax({
                url: "<?= base_url(); ?>sales/Contract/getResumeValue",
                method: "POST",
                dataType: 'json',
                data: {
                    idQuot: idQuot,
                    idCont: idCont
                },
                error: function() {
                    $.messager.alert('Error', 'Can Not Get Resume Data', 'error');

                },
                success: function(data) {
                    $('#dgr').datagrid('loadData',
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
            var no_qs = $('#no_qs').textbox('getValue');
            var id_qs = $('#id_qs').textbox('getValue');
            var no_qt = $('#no_qt').textbox('getValue');
            var id_qt = $('#id_qt').textbox('getValue');

            var cust_po_number = $('#cust_po_number').textbox('getValue');
            var kd_rekanan = $('#kd_rekanan').combogrid('getValue');
            var vat_str = $('#vat_str').textbox('getValue');
            var id_cc_project = $('#id_cc_project').textbox('getValue');
            var category = $('#id_cat_project').combogrid('getValue');
            var id_rek_gl = $('#id_rek_gl').combogrid('getValue');
            var manager = $('#manager').combogrid('getValue');
            var cara_bayar = $('#cara_bayar').textbox('getValue');
            var remarks = $('#remarks').textbox('getValue');
            var lokasi = $('#lokasi').textbox('getValue');

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
            } else if (vat_str == '') {
                $.messager.alert('Warning', 'VAT must have value', 'warning');
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
                no_qs: no_qs,
                id_qs: id_qs,
                no_qt: no_qt,
                id_qt: id_qt,
                kd_rekanan: kd_rekanan,
                cust_po_number: cust_po_number,
                manager: manager,
                id_rek_gl: id_rek_gl,
                id_cat_project: category,
                id_cc_project: id_cc_project,
                vat_str: vat_str,
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
                    unit_price: parseFloat(row.unit_price),
                    sub_total: parseFloat(row.sub_total)
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



        // QUOTATION
        function getQuotationNo() {
            $('#dlgQuot').dialog({
                title: 'Active Quotation',
                closed: false,
                cache: false,
                modal: true,
                width: $(window).width() - 400
            });
            $('#grdQuot').datagrid({
                url: '<?= base_url(); ?>sales/Contract/getQuotation'
            });
            $('#grdQuot').datagrid('load', {
                searching: $('#filterValQuot').val()
            });
        }

        function inputKeyEnterQuot(e) {
            e.which = e.which || e.keyCode;
            if (e.which == 13) {
                doSearchQuot();
            }
        }

        function doSearchQuot() {
            $('#grdQuot').datagrid('load', {
                searching: $('#filterValQuot').val()
            });
        }
        //END OF QUOTATION

        function loadQuotation() {
            var id_qt = $("#id_qt").val();

            if (id_qt == '') {
                $.messager.alert('Warning', 'Quotation Number must have value', 'warning');
                return false;
            }

            $.ajax({
                url: "<?= base_url(); ?>sales/Contract/getDQuotation",
                method: "POST",
                dataType: 'json',
                data: {
                    id_qt: id_qt
                },
                error: function() {
                    $.messager.alert('Error', 'Can Not Get Quotation Data', 'error');
                },
                success: function(data) {
                    $('#dg').datagrid('loadData',
                        data
                    );
                    hitung_total();
                }
            });

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