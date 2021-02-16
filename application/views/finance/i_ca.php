<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($this->session->userdata("username"))) {
    redirect(site_url(), 'refresh');
} elseif (empty($this->session->userdata("ca"))) {
    redirect(base_url('accfin/Ca'), 'refresh');
};
?>

<table style="width: 100%;" cellspacing="5px" border="0">
    <tr>
        <td style="width:50%;text-align:left">
            <h2><?= $caption; ?></h2>
        </td>
        <td style="width:50%;text-align:right"><input id="id_kasbon" class="easyui-textbox" readonly="true" style="width:150px;"></td>
    </tr>
</table>
<hr>
<table style="width: auto;" cellspacing="5px" cellpadding="5px" border="0">
    <tr>
        <td style="width:200px;"></td>
        <td><input id="no_kasbon" class="easyui-textbox" label="Cash Advance #:" labelPosition="top" readonly="true" style="width:200px;"></td>
        <td><input id="kd_rekanan" class="easyui-combogrid" label="Requester:" labelPosition="top" required="true" style="width:250px;"></td>
        <td rowspan="2"><input id="id_cc_project" class="easyui-combogrid" label="CC/Project:" labelPosition="top" required="true" multiline="true" style="width:250px;height:110px"></td>

    </tr>

    <tr>
        <td style="width:200px;"></td>
        <td><input id="dt_purposed" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="Date:" labelPosition="top" required="true" style="width:200px;"></td>
        <td><input id="tunggakan" class="easyui-numberbox" label="Oustanding CA:" labelPosition="top" readonly="true" style="text-align: right; width: 250px;" data-options="min:0,precision:2,groupSeparator:','"></td>

    </tr>
    <tr>
        <td style="width:200px;"></td>
        <td><input id="kasbon_untuk" class="easyui-combobox" label="CA Purpose:" labelPosition="top" required="true" style="width:200px;" data-options="
            valueField: 'label',
            textField: 'value',
            data: [{
                label: 'Personal',
                value: 'Personal'
            },{
                label: 'Operational',
                value: 'Operational'
            }]">
        </td>

        <td><input id="id_rek_gl_debet" class="easyui-combogrid" label="Account [Dr]:" labelPosition="top" required="true" style="width:250px;"></td>
        <td><input id="jumlah" class="easyui-numberbox" label="Nominal CA:" labelPosition="top" required="true" style="text-align: right; width: 250px;" data-options="min:0,precision:2,groupSeparator:','"></td>
    </tr>
    <tr>
        <td style="width:200px;"></td>
        <td colspan="2"><input id="remarks" class="easyui-textbox" label="Remarks:" labelPosition="top" multiline="true" required="true" style="width:450px;height:80px"></td>

    </tr>

</table>

<br>
<hr>
<div id="dlg-buttons" style="text-align: center;">
    <a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="saveDatax()">Save</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="cancelData()">Cancel</a>
</div>

<hr>

<script type="text/javascript">
    var editIndex = undefined;
    var lastIndex;
    var mode = '<?= $mode ?>';
    var idx = '<?= $idx; ?>';


    //-----------------------------$('#dg').datagrid-----------------------------

    $(function() {

        $('#kd_rekanan').combogrid({
            panelWidth: 400,
            url: '<?= base_url()  ?>accfin/Ca/getRekanan',
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
            ],
            onSelect: function(index, row) {
                //var desc = row.alamat; // the product's description
                // $('#tunggakan').numberbox('setValue', 2020);
                getOutCa(row.kd_rekanan)
            }

        });


        $('#id_rek_gl_debet').combogrid({
            panelWidth: 400,
            url: '<?= base_url()  ?>accfin/Ca/getCoa',
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

        $('#id_cc_project').combogrid({
            panelWidth: 700,
            url: '<?= base_url()  ?>accfin/Ca/getCCProject',
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


        if (mode == 'edit') {
            fetchMasterData(idx);
        };

    });



    function fetchMasterData(idx) {
        $.ajax({
            url: "<?= base_url(); ?>accfin/Ca/getMasterData",
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
                $('#id_kasbon').textbox('setValue', data[0]['id_kasbon']);
                $('#no_kasbon').textbox('setValue', data[0]['no_kasbon']);
                $('#requester').textbox('setValue', data[0]['requester']);
                $('#remarks').textbox('setValue', data[0]['remarks']);
                $('#dt_purposed').datebox('setValue', data[0]['dt_purposed']);
                $('#kd_rekanan').combogrid('setValue', data[0]['kd_rekanan']);
                $('#id_cc_project').combogrid('setValue', data[0]['id_cc_project']);
                $('#id_rek_gl_debet').combogrid('setValue', data[0]['id_rek_gl_debet']);
                $('#kasbon_untuk').combobox('setValue', data[0]['kasbon_untuk']);
                $('#jumlah').numberbox('setValue', data[0]['jumlah']);
                $('#tunggakan').numberbox('setValue', data[0]['tunggakan']);
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



    function getOutCa($idc) {
        $.ajax({
            url: "<?= base_url(); ?>accfin/Ca/getOustandCa",
            method: "POST",
            dataType: 'json',
            data: {
                idx: $idc
            },
            error: function() {
                document.getElementById("addError").click(); // Click on the checkbox
            },
            success: function(data) {
                $('#tunggakan').numberbox('setValue', data)
            }
        });
    }


    function saveDatax() {

        var id_kasbon = $('#id_kasbon').textbox('getValue');
        var no_kasbon = $('#no_kasbon').textbox('getValue');
        var dt_purposed = $('#dt_purposed').datebox('getValue');
        var kd_rekanan = $('#kd_rekanan').combogrid('getValue');
        var id_cc_project = $('#id_cc_project').combogrid('getValue');
        var kasbon_untuk = $('#kasbon_untuk').combobox('getValue');
        var jumlah = $('#jumlah').numberbox('getValue');
        var tunggakan = $('#tunggakan').numberbox('getValue');
        var remarks = $('#remarks').textbox('getValue');
        var id_rek_gl_debet = $('#id_rek_gl_debet').combogrid('getValue');

        //var detail = $('#dg').datagrid('getRows');

        // VALIDATION FORM --------------------------------------
        if (kd_rekanan == '') {
            $.messager.alert('Warning', 'Requester must have value', 'warning');
            return false;
        } else if (id_cc_project == '') {
            $.messager.alert('Warning', 'CC/Project must have value', 'warning');
            return false;
        } else if (dt_purposed == '') {
            $.messager.alert('Warning', 'CA Date must have value', 'warning');
            return false;
        } else if (kasbon_untuk == '') {
            $.messager.alert('Warning', 'CA Purpose must have value', 'warning');
            return false;
        } else if (jumlah == '') {
            $.messager.alert('Warning', 'Nominal must have value', 'warning');
            return false;
        } else if (jumlah == 0) {
            $.messager.alert('Warning', 'Nominal must have value', 'warning');
            return false;
        } else if (id_rek_gl_debet == '') {
            $.messager.alert('Warning', 'Account [Dr] must have value', 'warning');
            return false;
        } else if (remarks == '') {
            $.messager.alert('Warning', 'Remarks must have value', 'warning');
            return false;
        }

        var master = [];

        master.push({
            id_kasbon: id_kasbon,
            no_kasbon: no_kasbon,
            dt_purposed: dt_purposed,
            kd_rekanan: kd_rekanan,
            id_cc_project: id_cc_project,
            remarks: remarks,
            id_rek_gl_debet: id_rek_gl_debet,
            jumlah: jumlah,
            tunggakan: tunggakan,
            kasbon_untuk: kasbon_untuk,
            idtrans: <?= $idtrans; ?>
        });


        alert(mode);
        var data = [];
        data.push({
            master: master
        });
        alert(mode);

        var uri;
        if (mode == 'edit') {
            uri = '<?= base_url(); ?>accfin/Ca/updateCa';
        } else if (mode == 'add') {
            uri = '<?= base_url(); ?>accfin/Ca/insertCa';
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
                window.open('<?= base_url(); ?>accfin/Ca/index/<?= $dtx ?>', '_self');
            }
        });
    }

    function cancelData() {
        window.open('<?= base_url(); ?>accfin/Ca', '_self');
        // window.open('<?//= base_url(); ?>procurement/Pr/index/<?//= $dtx ?>', '_self');
    }
</script>


</body>