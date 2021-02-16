<!DOCTYPE html>

<?php
defined('BASEPATH') or exit('No direct script access allowed');

if ($mode == 'edit') {
    $url = base_url() . "sales/Quot/updateQuot/" . $idx;
    // $url_get = base_url() . "sales/Quot/getQuotDetail/" . $idx;
} else if ($mode == 'add') {
    $url = base_url() . "sales/Quot/insertQuot";
    // $url_get = base_url() . "sales/Quot/getQuotDetail/0";
} else if ($mode == 'rev') {
    $url = base_url() . "sales/Quot/revisionQuot";
    // $url_get = base_url() . "sales/Quot/getQuotDetail/" . $idx;
}
?>

<html>

<head>
    <meta charset="UTF-8">
    <title>iDeas | <?= $caption; ?></title>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/easyui'); ?>/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/easyui'); ?>/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/easyui'); ?>/demo/demo.css">
    <script type="text/javascript" src="<?= base_url('assets/js'); ?>/number.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/easyui'); ?>/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/easyui'); ?>/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/easyui'); ?>/jquery.edatagrid.js"></script>
</head>

<body>
    <h2 style="text-align:right"><?= $caption . '-' . $mode; ?></h2>
    <hr>
    <!-- <h2><? //= $dtx;
                ?></h2>
    <h2><? //= $mode;
        ?></h2> -->
    <table style="width: auto;" cellspacing="10px" border="0">
        <tr>
            <td><input id="no_qs" class="easyui-textbox" label="Quotation #:" labelPosition="top" readonly="true" style="width:200px;"></td>
            <td><input id="nama_kontak" class="easyui-textbox" label="Contact Name:" labelPosition="top" required="true" style="width:300px;"></td>
            <td><input id="lampiran" class="easyui-textbox" label="Attachment:" labelPosition="top" style="width:300px;"></td>
            <td rowspan="4"><input id="pterm" class="easyui-textbox" label="Payment Terms:" labelPosition="top" multiline="true" style="width:300px;height:100%;"></td>
        </tr>
        <tr>
            <td><input id="revision" name="revision" class="easyui-textbox" label="Revision:" labelPosition="top" readonly="true" style="width:200px;"></td>
            <td rowspan="3"><input id="nama_rekanan" name="nama_rekanan" class="easyui-textbox" label="Customer Name:" labelPosition="top" multiline="true" required="true" style="width:300px;height:100px"></td>
            <td rowspan="3"><input id="proposal_description" name="proposal_description" class="easyui-textbox" label="Proposal Description:" labelPosition="top" multiline="true" required="true" style="width:300px;height:100px"></td>
        </tr>
        <tr>
            <td><input id="dt_qs" name="dt_qs" class="easyui-datebox" data-options="formatter:myformatter" label="Quotation Date:" labelPosition="top" required="true" style="width:200px;"></td>

        </tr>
        <tr></tr>
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
                    <a href="<?php echo base_url() . 'excel/template.xls' ?>" class="easyui-linkbutton" style="height:25px;width: 100px" iconCls="icon-add" plain="te">Template</a>

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
                
                method: 'post',
                onClickCell: onClickCell,
                onEndEdit: onEndEdit
            ">
            <thead>
                <tr>
                    <th data-options="field:'kd_item',width:80,editor:{type:'textbox',options:{precision:2,
					icons:[{
						iconCls:'icon-search',
						handler: function(e){
							onclick=listItemAdd();
                            
                        }
					}]}}" rowspan="2">Item ID</th>
                    <th data-options="field:'descriptions',width:250,editor:{type:'textbox',options:{required:true}}" rowspan="2">Descriptions</th>
                    <th data-options="field:'part_number',width:100,editor:'textbox'" rowspan="2">Part Number</th>
                    <th data-options="field:'id_parent',width:100,editor:'textbox'" rowspan="2">Category</th>

                    <th data-options="field:'qty',width:70,align:'right',editor:{type:'numberbox',options:{precision:0,required:true}}" rowspan="2">Qty</th>
                    <th data-options="field:'id_unit',width:70,
                        formatter:function(value,row){
                            return row.id_unit;
                        },
                        editor:{
                            type:'combobox',
                            options:{
                                valueField:'id_unit',
                                textField:'id_unit',
                                method:'get',
                                url:'<?= base_url(); ?>sales/Quot/getUnit',
                                required:true
                            }
                        }" rowspan="2">Unit</th>
                    <th colspan="2">HPP</th>
                    <th colspan="3">Quot Price</th>
                    <th data-options="field:'remarks',width:150,editor:'textbox'" rowspan="2">Remarks</th>
                    <th data-options="field:'id_qs_detail'" hidden="true" rowspan="2">id_qs_detail</th>
                </tr>
                <tr>
                    <th data-options="field:'unit_price',width:100,formatter:datagridFormatNumber,align:'right',editor:{type:'numberbox',options:{precision:2,required:true}}">Unit Price</th>
                    <th data-options="field:'extended',width:100,formatter:datagridFormatNumber,align:'right',editor:{type:'numberbox',options:{precision:2},readonly:true}">Ammount</th>
                    <th data-options="field:'margin_psn',width:70,align:'right',editor:{type:'numberbox',options:{precision:2,required:true}}">Margin[%]</th>
                    <th data-options="field:'quot_price',width:100,formatter:datagridFormatNumber,align:'right',editor:{type:'numberbox',options:{precision:2,required:true}}">Unit Price</th>
                    <th data-options="field:'quot_extended',width:100,formatter:datagridFormatNumber,align:'right',editor:{type:'numberbox',options:{precision:2}}">Ammount</th>
                </tr>
            </thead>
        </table>
        <br>
        <table id="dgx" style="width:100%;height:auto" cellspacing="0px" border="0">
            <tr>
                <td rowspan="4" style="width:40%;height:30px">
                    <input id="remarks" class="easyui-textbox" label="Term & Condition :" labelPosition="top" multiline="true" style="width:100%;height:100%;"></td>
                <td style="width:13%;height:30px;text-align:right">SUB TOTAL</td>
                <td style="width:15%;height:30px;text-align:right"><input id="sub_total" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
                <td style="width:21%;height:30px;text-align:right"><input id="sub_total_quot" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
                <td style="width:auto;height:30px"></td>
            </tr>
            <tr>
                <td style="width:13%;height:30px;text-align:right">VAT NUM</td>
                <td style="width:15%;height:30px;text-align:right"><input id="vat_num" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
                <td style="width:21%;height:30px;text-align:right"><input id="vat_num_quot" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
                <td style="width:auto;height:30px"></td>
            </tr>
            <tr>
                <td style="width:13%;height:30px;text-align:right">TOTAL</td>
                <td style="width:15%;height:30px;text-align:right"><input id="total" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
                <td style="width:21%;height:30px;text-align:right"><input id="total_quot" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
                <td style="width:auto;height:30px"></td>
            </tr>
            <tr>
                <td colspan="4" style="width:auto;height:70px">
                    <div id="dlg-buttons" style="text-align: right;">
                        <a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="saveDatax()">Save</a>
                        <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="cancelData()">Cancel</a>
                    </div>
                </td>
            </tr>
        </table>

        <div id="tb" style="height:auto">
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="append()">Append</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeit()">Remove</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="acceptit()">Accept</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="reject()">Reject</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-excel',plain:true" onclick="importExcel()">Import From Excel</a>
        </div>
    </div>

    <hr>


    <!-- ITEM -->
    <div id="dlgListItemAdd" class="easyui-dialog" style="width: 800px;height: 600px;" closed="true" buttons="#dlg-buttons-list-item-add">
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




    <script src="<?php echo base_url('assets/js/accounting.min.js') ?>"></script>
    <script type="text/javascript">
        var editIndex = undefined;
        var lastIndex;
        var mode = '<?= $mode ?>';

        //-----------------------------$('#dg').datagrid-----------------------------

        $(function() {

            $('#grdListItemAdd').datagrid({
                onClickRow: function() {
                    var editors = $('#dg').datagrid('getEditors', editIndex);
                    var n1 = $(editors[0].target);
                    var n2 = $(editors[1].target);
                    var n5 = $(editors[5].target);
                    var row = $('#grdListItemAdd').datagrid('getSelected');
                    n1.textbox('setValue', row.kd_item);
                    n2.textbox('setValue', row.nama_item);
                    n5.textbox('setValue', row.kd_satuan);
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
                    var n1 = $(editors[4].target); //qty
                    var n2 = $(editors[6].target); //hpp price
                    var n3 = $(editors[7].target); //subtotal hpp
                    var n4 = $(editors[8].target); //margin
                    var n5 = $(editors[9].target); //quot price
                    var n6 = $(editors[10].target); //subtotal quot
                    // x1.add(x2).numberbox({
                    // 	onChange: function() {
                    // 		var c1 = x1.numberbox('getValue') * x2.numberbox('getValue');
                    // 		x3.numberbox('setValue', c1);
                    // 	}
                    // });
                    n2.add(n4).numberbox({
                        onChange: function() {
                            var qty = parseFloat(n1.numberbox('getValue'));
                            var hrg = parseFloat(n2.numberbox('getValue'));
                            var mrg = (parseFloat(n4.numberbox('getValue')) / 100);
                            n3.numberbox('setValue', qty * hrg);
                            n5.numberbox('setValue', hrg * (1 + mrg));
                            n6.numberbox('setValue', qty * (hrg * (1 + mrg)));
                        }
                    });

                }
            });

            if (mode == 'add') {
                $('#revision').textbox('setValue', '0');
                fetchDetailData(0);
            } else {
                var idx = '<?= $idx; ?>';
                fetchMasterData(idx);
                fetchDetailData(idx);
            }
        });


        function fetchMasterData($idp) {
            $.ajax({
                url: "<?= base_url(); ?>sales/Quot/getMasterData",
                method: "POST",
                dataType: 'json',
                data: {
                    idx: $idp
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

                    $('#dt_qs').textbox('setValue', data[0]['dt_qs']);
                    $('#no_qs').textbox('setValue', data[0]['no_qs']);

                    $('#proposal_description').textbox('setValue', data[0]['proposal_description']);
                    $('#nama_rekanan').textbox('setValue', data[0]['nama_rekanan']);
                    $('#nama_kontak').textbox('setValue', data[0]['nama_kontak']);
                    $('#lampiran').textbox('setValue', data[0]['lampiran']);
                    $('#proposal_description').textbox('setValue', data[0]['proposal_description']);

                    $('#sub_total').numberbox('setValue', data[0]['sub_total']);
                    $('#vat_num').numberbox('setValue', data[0]['vat_num']);
                    $('#total').numberbox('setValue', data[0]['total']);
                    $('#sub_total_quot').numberbox('setValue', data[0]['sub_total_quot']);
                    $('#vat_num_quot').numberbox('setValue', data[0]['vat_num_quot']);
                    $('#total_quot').numberbox('setValue', data[0]['total_quot']);


                }
            });
        }

        function fetchDetailData(idx2) {
            alert('masuk');
            $.ajax({
                url: "<?= base_url(); ?>sales/Quot/getQuotDetail",
                method: "POST",
                dataType: 'json',
                data: {
                    idx: idx2
                },
                error: function() {
                    document.getElementById("addError").click(); // Click on the checkbox
                },
                success: function(data) {
                    $('#dg').datagrid('loadData',
                        data
                    );
                    //console.log(data);
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

        function onEndEdit(index, row) {
            var ed = $(this).datagrid('getEditor', {
                index: index,
                field: 'id_unit'

            });
            row.id_unit = $(ed.target).combobox('getText');
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
            hitung_total($('#dg').datagrid('getRows'));
        }

        function acceptit() {
            if (endEditing()) {
                $('#dg').datagrid('acceptChanges');
            }
            hitung_total($('#dg').datagrid('getRows'));
        }

        function reject() {
            $('#dg').datagrid('rejectChanges');
            editIndex = undefined;
        }


        function hitung_total(data) {
            var jml = 0;
            var jmlq = 0;
            if (data.length > 0) {
                for (i = 0; i < data.length; i++) {
                    jml += parseFloat(data[i].extended);
                    jmlq += parseFloat(data[i].quot_extended);
                }
            }

            var ppn = jml * (10 / 100);
            var ppnq = jmlq * (10 / 100);


            $('#sub_total').numberbox('setValue', jml);
            $('#sub_total_quot').numberbox('setValue', jmlq);
            $('#vat_num').numberbox('setValue', ppn);
            $('#vat_num_quot').numberbox('setValue', ppnq);
            $('#total').numberbox('setValue', jml + ppn);
            $('#total_quot').numberbox('setValue', jmlq + ppnq);
        }


        //-----------------------------END OF $('#dg').datagrid-----------------------------



        function myformatter(date) {
            var y = date.getFullYear();
            var m = date.getMonth() + 1;
            var d = date.getDate();
            return (d < 10 ? ('0' + d) : d) + '-' + (m < 10 ? ('0' + m) : m) + '-' + y;
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
                url: '<?= base_url(); ?>sales/Quot/getItem'
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



            var no_qs = $("#no_qs").val();
            var dt_qs = $("#dt_qs").val();
            var nama_kontak = $("#nama_kontak").val();
            var nama_rekanan = $("#nama_rekanan").val();
            var proposal_description = $("#proposal_description").val();
            var lampiran = $("#lampiran").val();
            var revision = $("#revision").val();
            var pterm = $("#pterm").val();
            var remarks = $("#remarks").val();

            var sub_total = $('#sub_total').numberbox('getValue');
            var vat_num = $('#vat_num').numberbox('getValue');
            var total = $('#total').numberbox('getValue');
            var sub_total_quot = $('#sub_total_quot').numberbox('getValue');
            var vat_num_quot = $('#vat_num_quot').numberbox('getValue');
            var total_quot = $('#total_quot').numberbox('getValue');

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
            } else if (pterm == '') {
                $.messager.alert('Warning', 'Payemnt Term must have value', 'warning');
                return false;
            } else if (remarks == '') {
                $.messager.alert('Warning', 'Remarks must have value', 'warning');
                return false;
            }

            var master = [];

            master.push({
                no_qs: no_qs,
                dt_qs: dt_qs,
                nama_kontak: nama_kontak,
                nama_rekanan: nama_rekanan,
                proposal_description: proposal_description,
                lampiran: lampiran,
                revision: revision,
                sub_total: sub_total,
                vat_num: vat_num,
                total: total,
                sub_total_quot: sub_total_quot,
                vat_num_quot: vat_num_quot,
                total_quot: total_quot,
                pterm: pterm,
                remarks: remarks,
                idtrans: <?= $idtrans; ?>
            });


            var data = [];
            data.push({
                master: master,
                detail: detail
            });

            //alert('ok');

            //console.log(data);

            $.ajax({
                //url: '<?//= base_url(); ?>sales/Quot/insertQuot',
                url: '<?= $url ?>',
                method: "POST",
                dataType: 'json',
                processData: true,
                contentType: false,
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
                    alert('ok');
                    window.open('<?= base_url(); ?>sales/Quot/index/<?= $dtx ?>', '_self');
                }
            });
        }

        function cancelData() {
            window.open('<?= base_url(); ?>sales/Quot/index/<?= $dtx ?>', '_self');
        }


        ///-----------------------------------IMPORT EXCEL-----------------------
        // $('form#form_ticketing').on('submit', function(e) {
        //     e.preventDefault();
        //     //alert('submit');

        //     $.ajax({
        //         url: "<?php echo base_url("sales/Quot/form"); ?>",
        //         type: "POST",
        //         data: $('#form_ticketing').serialize(),
        //         dataType: 'json',
        //         data: new FormData(this),
        //         processData: false,
        //         contentType: false,
        //         cache: false,
        //         async: false,
        //         success: function(data, textStatus, jqXHR) {
        //             $.messager.alert('Success', 'Import Data Berhasil');
        //             $('#simpan').linkbutton('disable');
        //             $('#close-window').linkbutton({
        //                 text: 'Tutup'
        //             });
        //             if (data.metadata.error == true) {
        //                 $.messager.alert('Error', data.metadata.message);
        //                 return;
        //             }

        //             load_jurnal_data_to_ui(data.list.mj_no, 'display')
        //         },
        //         error: function(jqXHR, textStatus, errorThrown) {
        //             alert('Error,something goes wrong');
        //         },
        //         complete: function() {
        //             $('#btn-save').prop('disabled', false);
        //             $('#btn-save').html('Save');
        //         }
        //     });
        // });

        // END OF IMPORT EXCEL
    </script>

</html>