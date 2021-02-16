<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($this->session->userdata("username"))) {
    redirect(site_url(), 'refresh');
} elseif (empty($this->session->userdata("qse"))) {
    redirect(base_url('sales/Quotsheet'), 'refresh');
};
?>


<table style="width: 100%;" cellspacing="0px" border="0">
    <tr>
        <td style="width:50%;text-align:left">
            <h4><?= $caption; ?></h4>
        </td>
        <td style="width:50%;text-align:right"><input id="id_qs" class="easyui-textbox" readonly="true" style="width:150px;"></td>
    </tr>
</table>
<hr>
<!-- <h2><?//= $dtx;
        ?></h2>
    <h2><?//= $mode;
        ?></h2> -->
<table style="width: auto;" cellspacing="10px" cellpadding="5px" border="0">
    <tr>

        <td><input id="no_qs" class="easyui-combogrid" label="Quotsheet #:" labelPosition="top" readonly="true" style="width:200px;"></td>
        <td><input id="nama_kontak" class="easyui-textbox" label="Contact Name:" labelPosition="top" required="true" style="width:300px;" data-options="
                    prompt: 'Search From Master',
                    iconWidth: 22,
                    icons: [{
                        iconCls:'icon-search',
                        handler: function(e){
                            onclick=CariCustomer();
                        }
                    }]"></td>
        <td><input id="id_cat_project" class="easyui-combogrid" label="Project Category:" labelPosition="top" style="width:300px;"></td>
        <td>
            <div id="pkd_rekanan">
                <input id="kd_rekanan" class="easyui-textbox" style="width:100px;">
            </div>
        </td>
    </tr>


    <tr>
        <td><input id="revision" name="revision" class="easyui-textbox" label="Revision:" labelPosition="top" readonly="true" style="width:200px;"></td>
        <td rowspan="3"><input id="nama_rekanan" class="easyui-textbox" label="Customer Name:" labelPosition="top" multiline="true" required="true" style="width:300px;height:100px"></td>
        <td rowspan="3"><input id="proposal_description" class="easyui-textbox" label="Proposal Description:" labelPosition="top" multiline="true" required="true" style="width:300px;height:100px"></td>
    </tr>
    <tr>
        <td><input id="dt_qs" name="dt_qs" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="Quotsheet Date:" labelPosition="top" required="true" style="width:200px;"></td>
    </tr>

</table>
<div>
    <table style="width: auto;" cellspacing="0px" border="0">
        <tr>
            <td colspan="4" style="width:auto;height:25px;">
                <form method="post" id="form_ticketing" style="display: inline;">
                    <input class="easyui-filebox" label="Upload:" labelPosition="left" data-options="prompt:'Choose a file...'" style="width:500px;height: 25px" name="file" id="import_file">
                    <button style="text-align: center;height: 25px;width: 80px" class="easyui-linkbutton" iconCls="icon-ok" plain="te" id="open-window" type="submit">Import</button>
                    <input type="hidden" name="preview" value="Preview">
                </form>
            </td>
            <td>
                <a href="<?php echo base_url() . 'excel/template_qs.xls' ?>" class="easyui-linkbutton" style="height:25px;width: 100px" iconCls="icon-add" plain="te">Template</a>

            </td>

        </tr>

    </table>
</div>
<br>
<hr>

<div>
    <table id="dg" class="easyui-datagrid" title="Quotsheet Detail" style="width:100%;height:auto" data-options="
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
                <th data-options="field:'kd_item',width:80,editor:{type:'textbox',options:{precision:2,
					icons:[{
						iconCls:'icon-search',
						handler: function(e){
							onclick=listItemAdd();
                            
                        }
					}]}}">Item ID</th>
                <th data-options="field:'descriptions',width:250,editor:{type:'textbox',options:{required:true}}">Descriptions</th>
                <th data-options="field:'part_number',width:100,editor:'textbox'">Part Number</th>
                <th data-options="field:'merk',width:100,editor:'textbox'">Merk</th>
                <th data-options="field:'id_parent',width:100,
                                    formatter:function(value,row){
                                            return row.parentname;
                                        },
                                        editor:{
                                            type:'combobox',
                                            options:{
                                                valueField:'id_parent',
                                                textField:'parentname',
                                                method:'get',
                                                url:'<?= base_url(); ?>sales/Quotsheet/getParent',
                                                required:false
                                            }
                                        }">Item Group</th>

                <th data-options="field:'qty',width:70,align:'right',editor:{type:'numberbox',options:{precision:2,required:true}}">Qty</th>
                <th data-options="field:'kd_satuan', width:70,
                                        formatter:function(value,row){
                                            return row.kd_satuan;
                                        },
                                        editor:{
                                            type:'combobox',
                                            options:{
                                                valueField:'kd_satuan',
                                                textField:'kd_satuan',
                                                method:'get',
                                                url:'<?= base_url(); ?>sales/Quotsheet/getUnit',
                                                required:true
                                            }
                                        }">Unit</th>
                <th data-options="field:'unit_price',width:100,formatter:datagridFormatNumber,align:'right',editor:{type:'numberbox',options:{precision:2,required:true}}">Unit Price</th>
                <th data-options="field:'extended',width:100,formatter:datagridFormatNumber,align:'right',editor:{type:'numberbox',options:{precision:2},readonly:true}">Ammount</th>
                <th data-options="field:'remarks',width:250,editor:'textbox'">Remarks</th>
                <th data-options="field:'id_qs_detail'" hidden="true">id_qs_detail</th>
            </tr>
        </thead>
    </table>
    <br>
    <table id="dgx" style="width:100%;height:auto" border="0">
        <tr>
            <td style="width:62%;height:30px" rowspan="4">
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
    </table>

    <div id="tb" style="height:auto">
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="append()">Append</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeit()">Remove</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="acceptit()">Accept</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="reject()">Reject</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-folder',plain:true" onclick="newGroup()">Item Group</a>
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
    <table id="grdListItemAdd" class="easyui-datagrid" style="width:auto;height:auto;" toolbar="#tbListItemAdd" fitColumns="true" sortable="true" singleSelect="true" rownumbers="true" striped="true" nowrap="false" pagination="true" pageSize="15" pageList="[15, 30, 45, 60]">
        <thead>
            <tr>
                <th field="kd_item" width="80" align="center" sortable="true">Kode Item</th>
                <th field="nama_item" width="170" align="left" sortable="true">Diskripsi</th>
                <th field="kd_satuan" width="90" align="center" sortable="true">Satuan</th>
                <th field="item_type_name" width="170" align="left" sortable="true">Type</th>
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


<!-- CUSTOMER -->
<div id="dlgCariCustomer" class="easyui-dialog" style="width: 800px;height: 600px;" closed="true" buttons="#dlg-buttons-list-customer-add">
    <table id="grdCariCustomer" class="easyui-datagrid" style="width:auto;height:auto;" toolbar="#tbCariCustomer" fitColumns="true" sortable="true" singleSelect="true" rownumbers="true" striped="true" nowrap="false" pagination="true" pageSize="15" pageList="[15, 30, 45, 60]">
        <thead>
            <tr>
                <th field="kd_rekanan" width="50" align="left" sortable="true">Customer ID</th>
                <th field="nama_rekanan" width="170" align="left" sortable="true">Customer Name</th>
                <th field="alamat" width="200" align="left" sortable="true">Address</th>
                <th field="contact" width="100" align="left" sortable="true">Contact Name</th>
            </tr>
        </thead>
    </table>
</div>
<div id="dlg-buttons-list-customer-add">
    <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgCariCustomer').dialog('close');">Close</a>
</div>
<div id="tbCariCustomer" style="padding:10px;">>
    <span>Filter :</span>
    <input id="filterValCust" onkeyup="inputKeyEnterCust(event)" style="line-height:26px;border:1px solid #ccc;">
    <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearchCust();">Cari</a>
</div>
<!-- END OF CUSTOMER -->



<!-- ITEM GROUP -->
<div id="dlgGitem" class="easyui-dialog" style="width: 600px;height: 500px;" closed="true" buttons="#dlg-buttons-list-Gitem-add">
    <table id="grdGitem" class="easyui-datagrid" style="width:auto;height:auto;" toolbar="#tbGitem" fitColumns="true" sortable="true" singleSelect="true" rownumbers="true" striped="true" nowrap="false" pagination="true" pageSize="15" pageList="[15, 30, 45, 60]">
        <thead>
            <tr>
                <th field="id_itemg" width="30" align="left" sortable="true">index</th>
                <th field="id_parent" width="30" align="left" sortable="true">Group ID</th>
                <th field="parentname" width="100" align="left" sortable="true">Group Name</th>
            </tr>
        </thead>
    </table>


    <!-- Modal -->
    <br>
    <div id="dlgNewGitem" class="easyui-panel" title="Item Group Data" style="width:550px;height:150px;padding:10px;" data-options="iconCls:'icon-save',closable:true,
                collapsible:true,minimizable:true,maximizable:true" closed="true">
        <form id="fm">
            <table>
                <tr>
                    <td><input id="id_parent" class="easyui-textbox" label="Group ID:" labelPosition="top" required="true" style="width:150px;"></td>
                    <td><input id="parentname" class="easyui-textbox" label="Group Name:" labelPosition="top" required="true" style="width:250px;"></td>
                </tr>
            </table>

            <br>

            <div class="ftitle"></div>
            <div id="dlg-buttons">
                <a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="saveDatax()">Save</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgNewGitem').panel('close')">Cancel</a>
            </div>

        </form>
    </div>
    <!-- end of Modal -->


</div>
<div id="dlg-buttons-list-Gitem-add">
    <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgGitem').dialog('close');">Close</a>
</div>
<div id="tbGitem" style="padding:10px;">
    <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="newData();">New</a>
    <span>Filter :</span>
    <input id="filterValGitem" onkeyup="inputKeyEnterGitem(event)" style="line-height:26px;border:1px solid #ccc;">
    <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearchGitem();">Cari</a>
</div>


<!-- END OF ITEM GROUP -->

<script src="<?php echo base_url('assets/js/accounting.min.js') ?>"></script>
<script type="text/javascript">
    var editIndex = undefined;
    var lastIndex;
    var mode = '<?= $mode ?>';
    var idx = '<?= $idx; ?>';

    //-----------------------------$('#dg').datagrid-----------------------------

    $(function() {


        $("#pkd_rekanan").hide();
        
        $('#no_qs').combogrid({
                panelWidth: 500,
                url: '<?= base_url()  ?>sales/Quotsheet/getProject',
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




        $('#id_cat_project').combogrid({
            panelWidth: 300,
            url: '<?= base_url()  ?>sales/Quotsheet/getCatProject',
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


        $('#grdListItemAdd').datagrid({
            onDblClickRow: function() {
                var editors = $('#dg').datagrid('getEditors', editIndex);
                var n0 = $(editors[0].target);
                var n1 = $(editors[1].target);
                var n6 = $(editors[6].target);
                var row = $('#grdListItemAdd').datagrid('getSelected');
                n0.textbox('setValue', row.kd_item);
                n1.textbox('setValue', row.nama_item);
                n6.textbox('setValue', row.kd_satuan);
                $('#dlgListItemAdd').dialog('close');
            }
        });


        $('#grdCariCustomer').datagrid({
            onDblClickRow: function() {
                var row = $('#grdCariCustomer').datagrid('getSelected');
                $('#kd_rekanan').textbox('setValue', row.kd_rekanan);
                $('#nama_kontak').textbox('setValue', row.contact);
                $('#nama_rekanan').textbox('setValue', row.nama_rekanan + String.fromCharCode(13) + String.fromCharCode(10) + row.alamat);
                $('#dlgCariCustomer').dialog('close');
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
                var n5 = $(editors[5].target); //qty
                var n7 = $(editors[7].target); //unit price
                var n8 = $(editors[8].target); //sub_total
                // x1.add(x2).numberbox({
                // 	onChange: function() {
                // 		var c1 = x1.numberbox('getValue') * x2.numberbox('getValue');
                // 		x3.numberbox('setValue', c1);
                // 	}
                // });
                n5.add(n7).numberbox({
                    onChange: function() {
                        var qty = parseFloat(n5.numberbox('getValue'));
                        var hrg = parseFloat(n7.numberbox('getValue'));
                        n8.numberbox('setValue', qty * hrg);
                    }
                });

            }
        });


        if (mode == 'add') {
            $('#revision').textbox('setValue', '0');
            // $('#dt_qs').box('setValue', '0');
        } else {
            fetchMasterData(idx);
            fetchDetailData(idx);
        }
    });


    function fetchMasterData(idp) {
        $.ajax({
            url: "<?= base_url(); ?>sales/Quotsheet/getMasterData",
            method: "POST",
            dataType: 'json',
            data: {
                idx: idp
            },
            error: function() {
                document.getElementById("addError").click(); // Click on the checkbox
            },
            success: function(data) {
                var $norev = parseInt(data[0]['revision']);
                if (mode == 'rev') {
                    $('#revision').textbox('setValue', $norev + 1);
                } else {
                    $('#revision').textbox('setValue', $norev);
                }

                $('#dt_qs').datebox('setValue', data[0]['dt_qs']);
                $('#no_qs').textbox('setValue', data[0]['no_qs']);
                $('#id_qs').textbox('setValue', data[0]['id_qs']);

                $('#proposal_description').textbox('setValue', data[0]['proposal_description']);
                $('#kd_rekanan').textbox('setValue', data[0]['kd_rekanan']);
                $('#nama_rekanan').textbox('setValue', data[0]['nama_rekanan']);
                $('#nama_kontak').textbox('setValue', data[0]['nama_kontak']);
                $('#proposal_description').textbox('setValue', data[0]['proposal_description']);
                $('#id_cat_project').combogrid('setValue', data[0]['id_cat_project']);
                //$('#cc').combogrid('setValue', {itemid: 'customid',productname: 'CustomName'});

                $('#sub_total').numberbox('setValue', data[0]['sub_total']);
                $('#vat_num').numberbox('setValue', data[0]['vat_num']);
                $('#total').numberbox('setValue', data[0]['total']);

            }
        });
    }


    function fetchDetailData(idp) {
        $.ajax({
            url: "<?= base_url(); ?>sales/Quotsheet/getDetailData",
            method: "POST",
            dataType: 'json',
            data: {
                idx: idp
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
            field: 'id_parent'
        });
        //row.id_parent = $(ed2.target).combobox('getText');
        $('#dg').datagrid('getRows')[index]['parentname'] = $(ped.target).combobox('getText');
    }

    function append() {
        if (endEditing()) {
            $('#dg').datagrid('appendRow', {
                id_qs_detail: 0
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
                jml += parseFloat(data[i].extended);
            }
        }

        var ppn = jml * (10 / 100);

        $('#sub_total').numberbox('setValue', jml);
        $('#vat_num').numberbox('setValue', ppn);
        $('#total').numberbox('setValue', jml + ppn);
    }


    //-----------------------------END OF $('#dg').datagrid---------------------------------------------


    function myformatter(dt) {
        var y = dt.getFullYear();
        var m = dt.getMonth() + 1;
        var d = dt.getDate();
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
            title: 'Master Item List',
            closed: false,
            cache: false,
            modal: true,
            width: $(window).width() - 400
        });
        $('#grdListItemAdd').datagrid({
            url: '<?= base_url(); ?>sales/Quotsheet/getItem'
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



    // Gitem
    function newGroup() {
        $('#dlgGitem').dialog({
            title: 'Item Group List',
            closed: false,
            cache: false,
            modal: true
            //width: $(window).width() - 400
        });
        $('#grdGitem').datagrid({
            url: '<?= base_url(); ?>sales/Quotsheet/getGitem'
        });
        $('#grdGitem').datagrid('load', {
            searching: $('#filterValGitem').val()
        });
    }

    function inputKeyEnterGitem(e) {
        e.which = e.which || e.keyCode;
        if (e.which == 13) {
            doSearchGitem();
        }
    }

    function doSearchGitem() {
        $('#grdGitem').datagrid('load', {
            searching: $('#filterValGitem').val()
        });
    }

    function newData() {
        $("#dlgNewGitem").panel('setTitle', 'New Item Group');
        $('#dlgNewGitem').panel('open');
        $('#fm').form('clear');
    }

    function saveDatax() {

        var id_parent = $("#id_parent").val();
        var parentname = $("#parentname").val();

        url = '<?= base_url(); ?>sales/Quotsheet/simpanGitem';
        //alert(xurl);
        $.ajax({
            url: url,
            method: "POST",
            dataType: 'json',
            data: {
                id_parent: id_parent,
                parentname: parentname
            },
            error: function() {
                $.messager.show({
                    title: 'Error',
                    msg: result.errorMsg
                });
            },
            success: function(data) {
                $('#grdGitem').datagrid('reload');
                $('#dlgNewGitem').panel('close');
            }
        });
    }
    //END OF Gitem


    // CUSTOMER
    function CariCustomer() {
        $('#dlgCariCustomer').dialog({
            title: 'Master Customer List',
            closed: false,
            cache: false,
            modal: true,
            width: $(window).width() - 400
        });
        $('#grdCariCustomer').datagrid({
            url: '<?= base_url(); ?>sales/Quotsheet/getCustomer'
        });
        $('#grdCariCustomer').datagrid('load', {
            searching: $('#filterValCust').val()
        });
    }

    function inputKeyEnterCust(e) {
        e.which = e.which || e.keyCode;
        if (e.which == 13) {
            doSearchCust();
        }
    }

    function doSearchCust() {
        $('#grdCariCustomer').datagrid('load', {
            searching: $('#filterValCust').val()
        });
    }
    //END OF CUSTOMER

    function saveDatax() {

        var id_qs = $("#id_qs").val();
        var no_qs = $("#no_qs").val();
        var dt_qs = $("#dt_qs").val();
        var kd_rekanan = $("#kd_rekanan").val();
        var nama_kontak = $("#nama_kontak").val();
        var nama_rekanan = $("#nama_rekanan").val();
        var proposal_description = $("#proposal_description").val();
        var revision = $("#revision").val();
        var id_cat_project = $("#id_cat_project").val();

        var sub_total = $('#sub_total').numberbox('getValue');
        var vat_num = $('#vat_num').numberbox('getValue');
        var total = $('#total').numberbox('getValue');

        var detail = $('#dg').datagrid('getRows');

        // VALIDATION FORM --------------------------------------
        if (dt_qs == '') {
            $.messager.alert('Warning', 'Quotation Date must have value', 'warning');
            return false;
        } else if (nama_kontak == '') {
            $.messager.alert('Warning', 'Contact Name must have value', 'warning');
            return false;
        } else if (nama_rekanan == '') {
            $.messager.alert('Warning', 'Customer Name must have value', 'warning');
            return false;
        } else if (proposal_description == '') {
            $.messager.alert('Warning', 'Proposal Description must have value', 'warning');
            return false;
        } else if (id_cat_project == '') {
            $.messager.alert('Warning', 'Category must have value', 'warning');
            return false;
        }
        var master = [];

        master.push({
            id_qs: id_qs,
            no_qs: no_qs,
            dt_qs: dt_qs,
            kd_rekanan: kd_rekanan,
            nama_kontak: nama_kontak,
            nama_rekanan: nama_rekanan,
            proposal_description: proposal_description,
            revision: revision,
            sub_total: sub_total,
            vat_num: vat_num,
            total: total,
            id_cat_project: id_cat_project,
            idtrans: <?= $idtrans; ?>
        });


        var data = [];
        data.push({
            master: master,
            detail: detail
        });

        var uri;
        if (mode == 'edit') {
            uri = '<?= base_url(); ?>sales/Quotsheet/updateQuot';
        } else if (mode == 'add') {
            uri = '<?= base_url(); ?>sales/Quotsheet/insertQuot';
        }

        $.ajax({
            //url: '<?//= base_url(); ?>sales/Quot/insertQuot',
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
                window.open('<?= base_url(); ?>sales/Quotsheet', '_self');
            }
        });
    }

    function cancelData() {
        window.open('<?= base_url(); ?>sales/Quotsheet', '_self');
    }


    ///-----------------------------------IMPORT EXCEL-----------------------
    $('#form_ticketing').on('submit', function(e) {
        e.preventDefault();
        //alert('submit');

        $.ajax({
            url: '<?= base_url(); ?>sales/Quotsheet/importExcel/tqs',
            type: "POST",
            data: $('#form_ticketing').serialize(),
            dataType: 'json',
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function(data) {
                $.messager.alert('Success', 'Import Data Berhasil');
                $('#dg').datagrid('loadData',
                    data['rows']
                );
                hitung_total();

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