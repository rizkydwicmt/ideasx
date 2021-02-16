<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($this->session->userdata("username"))) {
    redirect(site_url(), 'refresh');
} elseif (empty($this->session->userdata("mm"))) {
    redirect(base_url('accfin/Memorial'), 'refresh');
};
?>

<table style="width: 89%;" cellspacing="0px" border="0">
    <tr>
        <td style="width:50%;text-align:left">
            <h2><?= $caption; ?></h2>
        </td>
        <td style="width:50%;text-align:right"><input id="id_jurnal" class="easyui-textbox" readonly="true" style="width:150px;"></td>
    </tr>
</table>

<hr>

<table style="width: auto;" cellspacing="0px" cellpadding="5px" border="0">
    <tr>

        <td><input id="no_jurnal" class="easyui-textbox" label="Memorial #:" labelPosition="top" readonly="true" style="width:150px;"> </td>
        <td rowspan="2"><input id="kd_rekanan" class="easyui-combogrid" label="Vendor:" labelPosition="top" required="true" style="width:250px;height:100px"></td>
        <td rowspan="2"><input id="remark" class="easyui-textbox" label="Remarks:" labelPosition="top" required="true" multiline="true" style="width:300px;height:100px"></td>

    </tr>

    <tr>
        <td><input id="dt_jurnal" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="Date:" labelPosition="top" required="true" style="width:150px;"></td>
    </tr>

    <tr>
    </tr>


</table>

<br>
<hr>

<div>
    <!-- div detail -->
    <table id="dg" class="easyui-datagrid" title="Memorial Detail" style="width:89%;height:auto" data-options="
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
                <th data-options="field:'no_reff',width:150,editor:{type:'textbox'}">No. Reff</th>
                <th data-options="field:'id_cc_project',width:150,
                                        formatter:function(value,row){
                                            return row.id_cc_project;
                                        },
                                        editor:{
                                            type:'combogrid',
                                            options:{
                                                panelWidth:500,
                                                url:'<?= base_url(); ?>accfin/Memorial/getCcProject',
                                                required:true,
                                                idField: 'id_cc_project',
                                                textField: 'id_cc_project',
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
                                                            width: 300
                                                        },
                                                        {
                                                            field: 'jenis',
                                                            title: 'Group',
                                                            align: 'left',
                                                            width: 100
                                                        }

                                                    ]
                                                ]
                                            }
                                        }">CC/Project</th>
                <th data-options="field:'id_rek_gl',width:150,
                                        formatter:function(value,row){
                                            return row.id_rek_gl;
                                        },
                                        editor:{
                                            type:'combogrid',
                                            options:{
                                                panelWidth:400,
                                                url:'<?= base_url(); ?>accfin/Memorial/getCoaDetail',
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
                                        }">Account</th>
                <th data-options="field:'description',width:400,editor:{type:'textbox',options:{required:true,readonly:false}}">Descriptions</th>
                <th data-options="field:'debet',width:140,align:'right',formatter:datagridFormatNumber,editor:{type:'numberbox',options:{precision:2,required:true,readonly:false}}">Debit</th>
                <th data-options="field:'kredit',width:140,align:'right',formatter:datagridFormatNumber,editor:{type:'numberbox',options:{precision:2,required:true,readonly:false}}">Credit</th>
                <th data-options="field:'id_jurnal_detail'" hidden="true">id_jurnal_detail</th>

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
            <td style="width:60%;height:30px"></td>
            <td style="width:10%;height:30px;text-align:right">TOTAL</td>
            <td style="width:13%;height:30px;text-align:right"><input id="tdebet" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
            <td style="width:13%;height:30px;text-align:right"><input id="tkredit" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
        </tr>



    </table>

    <hr>
    <div id="dlg-buttons" style="text-align: center;">
        <a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="saveDatax()">Save</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="cancelData()">Cancel</a>
    </div>
    <hr>
</div> <!-- end of div detail -->




<script src="<?php echo base_url('assets/js/accounting.min.js') ?>"></script>
<script type="text/javascript">
    var editIndex = undefined;
    var lastIndex;
    var mode = '<?= $mode ?>';
    var idx = '<?= $idx; ?>';


    //-----------------------------$('#dg').datagrid-----------------------------

    $(function() {
        $("#pkd_rekanan").hide();
        $("#pid_qs").hide();



        $('#kd_rekanan').combogrid({
            panelWidth: 550,
            url: '<?= base_url()  ?>accfin/Memorial/getRekanan',
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
                        width: 350
                    },
                    {
                        field: 'jenis',
                        title: 'Jenis',
                        align: 'left',
                        width: 100
                    }

                ]
            ]

        });




        if (mode == 'edit') {
            //alert(idx);
            fetchMasterData(idx);
            fetchDetailData(idx);
        } else if (mode == 'add') {
            // alert(mode);
        }

        $('#dg').datagrid({
            onClickRow: function(rowIndex) {
                if (lastIndex != rowIndex) {
                    $(this).datagrid('endEdit', lastIndex);
                    $(this).datagrid('beginEdit', rowIndex);
                }
                lastIndex = rowIndex;
            }
        });



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
            index: index
            //field: 'kd_satuan'
        });
        //row.kd_satuan = $(ed.target).combobox('getText');
        //$('#dg').datagrid('getRows')[index]['kd_satuan'] = $(ed.target).combobox('getText');
    }

    function append() {

        if (endEditing()) {
            $('#dg').datagrid('appendRow', {
                id_jurnal_detail: 0
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
            url: "<?= base_url(); ?>accfin/Memorial/getMasterData",
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
                $('#id_jurnal').textbox('setValue', data[0]['id_jurnal']);
                $('#no_jurnal').textbox('setValue', data[0]['no_jurnal']);
                $('#dt_jurnal').datebox('setValue', data[0]['dt_jurnal']);
                $('#kd_rekanan').combogrid('setValue', data[0]['kd_rekanan']);
                $('#remark').textbox('setValue', data[0]['remark']);
                $('#tdebet').numberbox('setValue', data[0]['debet']);
                $('#tkredit').numberbox('setValue', data[0]['kredit']);
            }
        });
    }

    function fetchDetailData(idx) {
        $.ajax({
            url: "<?= base_url(); ?>accfin/Memorial/getDetailData",
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
        var jml_debet = 0;
        var jml_kredit = 0;
        if (data.length > 0) {
            for (i = 0; i < data.length; i++) {
                jml_debet += parseFloat(data[i].debet);
                jml_kredit += parseFloat(data[i].kredit);
            }
        }

        $('#tdebet').numberbox('setValue', jml_debet);
        $('#tkredit').numberbox('setValue', jml_kredit);
    }



    function saveDatax() {

        var id_jurnal = $('#id_jurnal').textbox('getValue');
        var no_jurnal = $('#no_jurnal').textbox('getValue');
        var dt_jurnal = $('#dt_jurnal').datebox('getValue');
        var kd_rekanan = $('#kd_rekanan').combogrid('getValue');
        var remarks = $('#remark').textbox('getValue');

        var total_debet = $('#tdebet').numberbox('getValue');
        var total_kredit = $('#tkredit').numberbox('getValue');

        var detail = $('#dg').datagrid('getRows');

        // VALIDATION FORM --------------------------------------
        if (dt_jurnal == '') {
            $.messager.alert('Warning', 'Memorial date have value', 'warning');
            return false;
            // } else if (id_cc_project == '') {
            //     $.messager.alert('Warning', 'CC/Project must have value', 'warning');
            //     return false;
        } else if (kd_rekanan == '') {
            $.messager.alert('Warning', 'Vendor must have value', 'warning');
            return false;
        } else if (remarks == '') {
            $.messager.alert('Warning', 'Remarks must have value', 'warning');
            return false;
        }

        //console.log(detail);
        var master = [];

        master.push({
            id_jurnal: id_jurnal,
            no_jurnal: no_jurnal,
            dt_jurnal: dt_jurnal,
            kd_rekanan: kd_rekanan,
            remarks: remarks,
            total_debet: total_debet,
            total_kredit: total_kredit,
            idtrans: <?= $idtrans; ?>

        });

        var data = [];
        data.push({
            master: master,
            detail: detail
        });

        var uri;
        if (mode == 'edit') {
            uri = '<?= base_url(); ?>accfin/Memorial/updateMemorial';
        } else if (mode == 'add') {
            uri = '<?= base_url(); ?>accfin/Memorial/insertMemorial';
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
                window.open('<?= base_url(); ?>accfin/Memorial', '_self');
            }
        });
    }

    function cancelData() {
        window.open('<?= base_url(); ?>accfin/Memorial', '_self');
        // window.open('<?//= base_url(); ?>procurement/Pr/index/<?//= $dtx ?>', '_self');
    }
</script>


</body>

</html>