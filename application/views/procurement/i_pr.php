<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($this->session->userdata("username"))) {
    redirect(site_url(), 'refresh');
} elseif (empty($this->session->userdata("pr"))) {
    redirect(base_url('procurement/Pr'), 'refresh');
};
?>

<table style="width: 100%;" cellspacing="0px" border="0">
    <tr>
        <td style="width:50%;text-align:left">
            <h2><?= $caption; ?></h2>
        </td>
        <td style="width:50%;text-align:right"><input id="kd_pr" class="easyui-textbox" readonly="true" style="width:150px;"></td>
    </tr>
</table>
<hr>
<table style="width: auto;" cellspacing="5px" border="0">
    <tr>

        <td><input id="no_pr" class="easyui-textbox" label="Requisition #:" labelPosition="top" readonly="true" style="width:200px;"></td>
        <td rowspan="2"><input id="requester" class="easyui-combogrid" label="Requester:" labelPosition="top" multiline="true" required="true" style="width:200px;height:100px"></td>
        <td rowspan="2"><input id="id_cc_project" class="easyui-combogrid" label="CC/Project:" labelPosition="top" required="true" multiline="true" style="width:200px;height:100px"></td>
        <td rowspan="2"><input id="remarks" class="easyui-textbox" label="Remarks:" labelPosition="top" multiline="true" required="true" style="width:200px;height:100px"></td>

    </tr>

    <tr>
        <td><input id="dt_pr" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="Requisition Date:" labelPosition="top" required="true" style="width:200px;"></td>

    </tr>

</table>

<br>
<hr>

<div>
    <!-- div detail -->
    <table id="dg" class="easyui-datagrid" title="Purchase Requisition Detail" style="width:80%;height:auto" data-options="
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
                <th data-options="field:'kd_item',width:150,editor:{type:'textbox',options:{precision:2,
					icons:[{
						iconCls:'icon-search',
						handler: function(e){
							onclick=listItemAdd();
                            
                        }
					}]}}">Item ID</th>
                <th data-options="field:'deskripsi',width:500,editor:{type:'textbox',options:{readonly:false}}">Descriptions</th>
                <th data-options="field:'qty',width:100,align:'right',editor:{type:'numberbox',options:{precision:1,required:true,readonly:false}}">Qty</th>
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
                                                url:'<?= base_url(); ?>procurement/Pr/getUnit',
                                                required:true
                                            }
                                        }">Unit</th>
                <th data-options="field:'dt_kebutuhan',width:150,
                                            
                                            editor:{
                                                type:'datebox',
                                                options:{
                                                    readonly:false,
                                                    required:true,
                                                    formatter:myformatter,
                                                    parser:myparser
                                                }
                                            }">Expected Delivery</th>
                <th data-options="field:'kd_pr_detail'" hidden="true">kd_pr_detail</th>

            </tr>
        </thead>
    </table>
    <div id="tb" style="height:auto">
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="append()">Append</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeit()">Remove</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="acceptit()">Accept</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="reject()">Reject</a>
    </div>



    <br>
    <hr>

    <div id="dlg-buttons" style="text-align: center;">
        <a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="saveDatax()">Save</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="cancelData()">Cancel</a>
    </div>

</div> <!-- end of div detail -->


<hr>





<!-- ITEM -->
<div id="dlgListItemAdd" class="easyui-dialog" style="width: 800px;height: 500px;" closed="true" buttons="#dlg-buttons-list-item-add">
    <table id="grdListItemAdd" class="easyui-datagrid" style="width:auto;height:auto;" toolbar="#tbListItemAdd" fitColumns="true" sortable="true" 
    singleSelect="true" rownumbers="true" striped="true" nowrap="false" pagination="false">
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
    var idx = '<?= $idx; ?>';


    //-----------------------------$('#dg').datagrid-----------------------------

    $(function() {
        // $("#pkd_rekanan").hide();
        // $("#pid_qs").hide();


        $('#requester').combogrid({
            panelWidth: 400,
            url: '<?= base_url()  ?>procurement/Pr/getRekanan',
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
                        width: 300
                    }

                ]
            ]

        });

        $('#id_cc_project').combogrid({
            panelWidth: 700,
            url: '<?= base_url()  ?>procurement/Pr/getCCProject',
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


        $('#grdListItemAdd').datagrid({
            onDblClickRow: function() {
                var editors = $('#dg').datagrid('getEditors', editIndex);
                var n0 = $(editors[0].target);
                var n1 = $(editors[1].target);
                var n2 = $(editors[2].target);
                var n3 = $(editors[3].target);
                var row = $('#grdListItemAdd').datagrid('getSelected');
                n0.textbox('setValue', row.kd_item);
                n1.textbox('setValue', row.nama_item);
                n2.textbox('setValue', row.qty);
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
                kd_pr_detail: 0
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
    }

    function acceptit() {
        if (endEditing()) {
            $('#dg').datagrid('acceptChanges');
        }
    }

    function reject() {
        $('#dg').datagrid('rejectChanges');
        editIndex = undefined;
    }


    //------------------------------end of $('#dg').datagrid -------------------------


    function fetchMasterData(idx) {
        $.ajax({
            url: "<?= base_url(); ?>procurement/Pr/getPrMaster",
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
                //alert('masuk');
                $('#kd_pr').datebox('setValue', data[0]['kd_pr']);
                $('#dt_pr').datebox('setValue', data[0]['dt_pr']);
                $('#no_pr').textbox('setValue', data[0]['no_pr']);
                $('#requester').textbox('setValue', data[0]['requester']);
                $('#id_cc_project').combogrid('setValue', data[0]['id_cc_project']);
                $('#remarks').textbox('setValue', data[0]['remarks']);
            }
        });
    }

    function fetchDetailData(idx) {
        $.ajax({
            url: "<?= base_url(); ?>procurement/Pr/getPrDetail",
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
            url: '<?= base_url(); ?>procurement/Pr/fetchItem/' + id_cc_project
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

        var no_pr = $('#no_pr').textbox('getValue');
        var dt_pr = $('#dt_pr').datebox('getValue');
        var requester = $('#requester').textbox('getValue');
        var id_cc_project = $('#id_cc_project').combogrid('getValue');
        var remarks = $('#remarks').textbox('getValue');

        var detail = $('#dg').datagrid('getRows');

        // VALIDATION FORM --------------------------------------
        if (requester == '') {
            $.messager.alert('Warning', 'Requester must have value', 'warning');
            return false;
        } else if (id_cc_project == '') {
            $.messager.alert('Warning', 'CC/Project must have value', 'warning');
            return false;
        } else if (dt_pr == '') {
            $.messager.alert('Warning', 'Requisition Date must have value', 'warning');
            return false;
        }

        console.log(detail);
        var master = [];

        master.push({
            no_pr: no_pr,
            dt_pr: dt_pr,
            requester: requester,
            id_cc_project: id_cc_project,
            remarks: remarks,
            idtrans: <?= $idtrans; ?>
        });



        var data = [];
        data.push({
            master: master,
            detail: detail
        });

        var uri;
        if (mode == 'edit') {
            uri = '<?= base_url(); ?>procurement/Pr/updatePr/' + idx;
        } else if (mode == 'add') {
            uri = '<?= base_url(); ?>procurement/Pr/insertPr';
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
                window.open('<?= base_url(); ?>procurement/Pr/index/<?= $dtx ?>', '_self');
            }
        });
    }

    function cancelData() {
        window.open('<?= base_url(); ?>procurement/Pr', '_self');
        // window.open('<?//= base_url(); ?>procurement/Pr/index/<?//= $dtx ?>', '_self');
    }
</script>


</body>