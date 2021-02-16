<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($this->session->userdata("username"))) {
    redirect(site_url(), 'refresh');
} elseif (empty($this->session->userdata("rmb"))) {
    redirect(base_url('accfin/Reimbursement'), 'refresh');
};
?>

<table style="width: 100%;" cellspacing="0px" border="0">
    <tr>
        <td style="width:50%;text-align:left">
            <h2><?= $caption; ?></h2>
        </td>
        <td style="width:50%;text-align:right"><input id="id_settlement" class="easyui-textbox" readonly="true" style="width:150px;"></td>
    </tr>
</table>
<hr>

<table style="width: auto;" cellspacing="5px" cellpadding="5px" border="0">
    <tr>

        <td><input id="no_settlement" class="easyui-textbox" label="Reimbursement #:" labelPosition="top" readonly="true" style="width:150px;"></td>
        <td rowspan="2"><input id="id_cc_project" class="easyui-combogrid" label="CC/Project:" labelPosition="top" multiline="true" required="true" style="width:250px; height:100px"></td>
        <td><input id="kd_rekanan" class="easyui-combogrid" label="Employee:" labelPosition="top" required="true" style="width:200px;"></td>

    </tr>

    <tr>
        <td><input id="dt_settlement" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="Date:" labelPosition="top" required="true" style="width:150px;"></td>
        <td><input id="id_rek_gl" class="easyui-combogrid" label="Account  [Cr]:" labelPosition="top" required="true" style="width:200px;"></td>
    </tr>

    <tr>
    </tr>


</table>

<br>
<hr>

<div>
    <!-- div detail -->
    <table id="dg" class="easyui-datagrid" title="Reimbusement Detail" style="width:89%;height:auto" data-options="
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
                <th data-options="field:'dt_biaya',width:150,
                                            editor:{
                                                type:'datebox',
                                                options:{
                                                    readonly:false,
                                                    required:true,
                                                    formatter:myformatter,
                                                    parser:myparser
                                                }
                                            }">Date</th>
                <th data-options="field:'id_rek_gl',width:150,
                                        formatter:function(value,row){
                                            return row.id_rek_gl;
                                        },
                                        editor:{
                                            type:'combogrid',
                                            options:{
                                                panelWidth:400,
                                                url:'<?= base_url(); ?>accfin/Reimbursement/getCoaDetail',
                                                required:true,
                                                idField: 'id_rek_gl',
                                                textField: 'id_rek_gl',
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
                                                            width: 300
                                                        }

                                                    ]
                                                ]
                                            }
                                        }">Account [Dr]</th>
                <th data-options="field:'no_mrir',width:150,editor:{type:'textbox'}">AP Number</th>
                <th data-options="field:'diskripsi',width:550,editor:{type:'textbox',options:{required:true,readonly:false}}">Descriptions</th>
                <th data-options="field:'biaya',width:140,align:'right',formatter:datagridFormatNumber,editor:{type:'numberbox',options:{precision:2,required:true,readonly:false}}">Nominal</th>
                <th data-options="field:'id_settlement_detail'" hidden="true">id_settlement_detail</th>

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

    <table id="dgx" style="width:89%;height:auto" border="0">
        <tr>
            <td style="width:60%;height:30px" rowspan="3"><input id="remarks" class="easyui-textbox" label="Remarks:" required="true" labelPosition="top" multiline="true" style="width:300px;height:100px"></td>
            <td style="width:10%;height:30px;text-align:right">TOTAL</td>
            <td style="width:13%;height:30px;text-align:right"><input id="vtotal" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
        </tr>


    </table>

</div> <!-- end of div detail -->

<hr>
<div id="dlg-buttons" style="text-align: center;">
    <a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="saveDatax()">Save</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="cancelData()">Cancel</a>
</div>

<hr>



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
            url: '<?= base_url()  ?>accfin/Reimbursement/getCCProject',
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
            panelWidth: 350,
            url: '<?= base_url()  ?>accfin/Reimbursement/getRekanan',
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
                    }

                ]
            ]

        });


        $('#id_rek_gl').combogrid({
            panelWidth: 400,
            url: '<?= base_url()  ?>accfin/Reimbursement/getCoa',
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
                        width: 300
                    }

                ]
            ]

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
            //alert(idx);
            fetchMasterData(idx);
            fetchDetailData(idx);
        } else if (mode == 'add') {
            //alert(mode);
            // $('id_curr').combobox('setValue', 'IDR');
            // $('kurs').numberbox('setValue', 1);

        }

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
                    index: index
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
            index: index
            //field: 'kd_satuan'
        });
        //row.kd_satuan = $(ed.target).combobox('getText');
        //$('#dg').datagrid('getRows')[index]['kd_satuan'] = $(ed.target).combobox('getText');
    }

    function append() {
        if (endEditing()) {
            $('#dg').datagrid('appendRow', {
                id_settlement_detail: 0
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


    //------------------------------end of $('#dg').datagrid -------------------------


    function fetchMasterData(idx) {
        $.ajax({
            url: "<?= base_url(); ?>accfin/Reimbursement/getMasterData",
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
                //alert(data[0]['id_rek_gl']);
                $('#id_settlement').textbox('setValue', data[0]['id_settlement']);
                $('#no_settlement').textbox('setValue', data[0]['no_settlement']);
                $('#dt_settlement').datebox('setValue', data[0]['dt_settlement']);
                $('#id_curr').combobox('setValue', data[0]['id_curr']);
                $('#kurs').numberbox('setValue', data[0]['kurs']);
                $('#kd_rekanan').combogrid('setValue', data[0]['kd_rekanan']);
                $('#id_rek_gl').combogrid('setValue', data[0]['id_rek_gl']);
                $('#id_cc_project').combogrid('setValue', data[0]['id_cc_project']);
                $('#remarks').textbox('setValue', data[0]['remarks']);
                $('#vtotal').numberbox('setValue', data[0]['total']);
            }
        });
    }

    function fetchDetailData(idx) {
        $.ajax({
            url: "<?= base_url(); ?>accfin/Reimbursement/getDetailData",
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


    function hitung_total() {
        var data = $('#dg').datagrid('getRows');
        var jml = 0;
        if (data.length > 0) {
            for (i = 0; i < data.length; i++) {
                jml += parseFloat(data[i].biaya);
            }
        }
        $('#vtotal').numberbox('setValue', jml);
    }



    function saveDatax() {

        var id_settlement = $('#id_settlement').textbox('getValue');
        var no_settlement = $('#no_settlement').textbox('getValue');
        var dt_settlement = $('#dt_settlement').datebox('getValue');
        var kd_rekanan = $('#kd_rekanan').combogrid('getValue');
        var id_cc_project = $('#id_cc_project').combogrid('getValue');
        var id_rek_gl = $('#id_rek_gl').combogrid('getValue');
        var remarks = $('#remarks').textbox('getValue');

        var total = $('#vtotal').numberbox('getValue');

        var detail = $('#dg').datagrid('getRows');

        // VALIDATION FORM --------------------------------------
        if (dt_settlement == '') {
            $.messager.alert('Warning', 'Settlement date have value', 'warning');
            return false;
        } else if (id_cc_project == '') {
            $.messager.alert('Warning', 'CC/Project must have value', 'warning');
            return false;
        } else if (kd_rekanan == '') {
            $.messager.alert('Warning', 'Employee must have value', 'warning');
            return false;
        } else if (remarks == '') {
            $.messager.alert('Warning', 'Remarks must have value', 'warning');
            return false;
        }

        //console.log(detail);
        var master = [];

        master.push({
            id_settlement: id_settlement,
            no_settlement: no_settlement,
            dt_settlement: dt_settlement,
            id_curr: 'IDR',
            kurs: 1,
            kd_rekanan: kd_rekanan,
            id_rek_gl: id_rek_gl,
            id_cc_project: id_cc_project,
            remarks: remarks,
            total: total,
            idtrans: <?= $idtrans; ?>

        });



        var data = [];
        data.push({
            master: master,
            detail: detail
        });

        var uri;
        if (mode == 'edit') {
            uri = '<?= base_url(); ?>accfin/Reimbursement/updateReimbursement';
        } else if (mode == 'add') {
            uri = '<?= base_url(); ?>accfin/Reimbursement/insertReimbursement';
        }

        $.ajax({
            url: uri,
            method: "POST",
            dataType: 'json',
            data: {
                info: data
            },
            error: function() {
                $.messager.alert('iDeas', 'Some Error Ocured', 'error');
            },
            success: function(data) {
                window.open('<?= base_url(); ?>accfin/Reimbursement', '_self');
            }
        });
    }

    function cancelData() {
        window.open('<?= base_url(); ?>accfin/Reimbursement', '_self');
        // window.open('<?//= base_url(); ?>procurement/Pr/index/<?//= $dtx ?>', '_self');
    }
</script>


</body>