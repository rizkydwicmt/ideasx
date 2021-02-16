<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($this->session->userdata("username"))) {
    redirect(site_url(), 'refresh');
} elseif (empty($this->session->userdata("pro"))) {
    redirect(base_url('master/Project'), 'refresh');
};
?>

<table style="width: 100%;" cellspacing="5px" border="0">
    <tr>
        <td style="width:50%;text-align:left">
            <h2><?= $caption; ?></h2>
        </td>
        <td style="width:50%;text-align:right"><input id="idx" class="easyui-textbox" readonly="true" style="width:150px;"></td>
    </tr>
</table>
<hr>
<table style="width: auto;" cellspacing="5px" cellpadding="5px" border="0">
    <tr>
        <td style="width:200px;"></td>
        <td><input id="id_cc_project" class="easyui-textbox" label="Project ID #:" labelPosition="top" required="true" style="width:200px;"></td>
        <td rowspan="2"><input id="kd_rekanan" class="easyui-combogrid" label="Customer:" labelPosition="top" required="true" multiline="true" style="width:250px;height:110px"></td>
        <td rowspan="2"><input id="cc_project_name" class="easyui-textbox" label="Project Name:" labelPosition="top" required="true" multiline="true" style="width:250px;height:110px"></td>
        <td rowspan="2"><input id="lokasi" class="easyui-textbox" label="Project Location:" labelPosition="top" required="true" multiline="true" style="width:250px;height:110px"></td>
    </tr>

    <tr>
        <td style="width:200px;"></td>
        <td><input id="dt_announcement" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="Announce Date:" labelPosition="top" required="true" style="width:200px;"></td>

    </tr>
    <tr>
        <td style="width:200px;"></td>
        <td><input id="id_rek_gl" class="easyui-combogrid" label="Account [Dr]:" labelPosition="top" required="true" style="width:200px;"></td>
        <td><input id="po_number" class="easyui-textbox" label="PO/Contract Reff:" labelPosition="top" required="true" style="text-align: left; width: 250px;"></td>
        <td><input id="nilai" class="easyui-numberbox" label="Value Ex VAT:" labelPosition="top" required="true" style="text-align: right; width: 250px;" data-options="min:0,precision:2,groupSeparator:','"></td>
        <td><input id="id_cat_project" class="easyui-combogrid" label="Project Category:" labelPosition="top" required="true" style="width:250px;"></td>
    </tr>
    <tr>
        <td style="width:200px;"></td>
        <td><input id="dt_order" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="PO/Contract Date:" labelPosition="top" required="true" style="width:200px;"></td>
        <td><input id="dt_start" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="Start Date:" labelPosition="top" required="true" style="width:250px;"></td>
        <td><input id="dt_finish" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="Finish Date:" labelPosition="top" required="true" style="width:250px;"></td>
        <td><input id="manager" class="easyui-combogrid" label="Manager :" labelPosition="top" style="width:250px;"></td>
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
            url: '<?= base_url()  ?>master/Project/getCustomer',
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
                $('#lokasi').textbox('setValue',row.alamat);
                // $('#tunggakan').numberbox('setValue', 2020);
            }

        });


        $('#manager').combogrid({
            panelWidth: 400,
            url: '<?= base_url()  ?>master/Project/getManager',
            idField: 'nk',
            textField: 'full_name',
            mode: 'remote',
            fitColumns: true,
            nowrap: false,
            columns: [
                [{
                        field: 'nk',
                        title: 'NK',
                        width: 100,
                        align: 'center'
                    },
                    {
                        field: 'full_name',
                        title: 'Full Name',
                        align: 'left',
                        width: 300
                    }

                ]
            ],
            onSelect: function(index, row) {
                $('#lokasi').textbox('setValue',row.alamat);
                // $('#tunggakan').numberbox('setValue', 2020);
            }

        });


        $('#id_rek_gl').combogrid({
            panelWidth: 400,
            url: '<?= base_url()  ?>master/Project/getCoa',
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

        $('#id_cat_project').combogrid({
            panelWidth: 400,
            url: '<?= base_url()  ?>master/Project/getCatProject',
            idField: 'id_cat_project',
            textField: 'descriptions',
            mode: 'remote',
            fitColumns: true,
            nowrap: false,
            columns: [
                [{
                        field: 'id_cat_project',
                        title: 'ID',
                        width: 100,
                        align: 'center'
                    },
                    {
                        field: 'descriptions',
                        title: 'Descriptions',
                        align: 'left',
                        width: 250
                    }

                ]
            ]

        });


        if (mode == 'edit') {
            fetchMasterData(idx);
        };

    });



    function fetchMasterData(idx) {
        $.ajax({
            url: "<?= base_url(); ?>master/Project/getMasterData",
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
                $('#idx').textbox('setValue', data[0]['id_cc_project']);
                $('#id_cc_project').textbox('setValue', data[0]['id_cc_project']);
                $('#cc_project_name').textbox('setValue', data[0]['cc_project_name']);
                $('#lokasi').textbox('setValue', data[0]['lokasi']);
                $('#po_number').textbox('setValue', data[0]['po_number']);

                $('#dt_announcement').datebox('setValue', data[0]['dt_announcement_char']);
                $('#dt_order').datebox('setValue', data[0]['dt_order_char']);
                $('#dt_start').datebox('setValue', data[0]['dt_start_char']);
                $('#dt_finish').datebox('setValue', data[0]['dt_finish_char']);

                $('#kd_rekanan').combogrid('setValue', data[0]['kd_rekanan']);
                $('#id_cat_project').combogrid('setValue', data[0]['id_cat_project']);
                $('#id_rek_gl').combogrid('setValue', data[0]['id_rek_gl']);
                $('#manager').combogrid('setValue', data[0]['manager']);
                $('#nilai').numberbox('setValue', data[0]['nilai']);
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






    function saveDatax() {

        var idx = $('#idx').textbox('getValue');
        var id_cc_project = $('#id_cc_project').textbox('getValue');
        var cc_project_name = $('#cc_project_name').textbox('getValue');
        var lokasi = $('#lokasi').textbox('getValue');
        var po_number = $('#po_number').textbox('getValue');
        var nilai = $('#nilai').numberbox('getValue');


        var dt_announcement = $('#dt_announcement').datebox('getValue');
        var dt_order = $('#dt_order').datebox('getValue');
        var dt_start = $('#dt_start').datebox('getValue');
        var dt_finish = $('#dt_finish').datebox('getValue');

        var kd_rekanan = $('#kd_rekanan').combogrid('getValue');
        var id_cat_project = $('#id_cat_project').combogrid('getValue');
        var manager = $('#manager').combogrid('getValue');
        var id_rek_gl = $('#id_rek_gl').combogrid('getValue');

        //var detail = $('#dg').datagrid('getRows');

        // VALIDATION FORM --------------------------------------
        if (id_cc_project == '') {
            $.messager.alert('Warning', 'Project ID must have value', 'warning');
            return false;
        } else if (cc_project_name == '') {
            $.messager.alert('Warning', 'CC/Project must have value', 'warning');
            return false;
        } else if (dt_announcement == '') {
            $.messager.alert('Warning', 'Announce Date must have value', 'warning');
            return false;
        } else if (dt_order == '') {
            $.messager.alert('Warning', 'Order Date must have value', 'warning');
            return false;
        } else if (nilai == '') {
            $.messager.alert('Warning', 'Nominal must have value', 'warning');
            return false;
        } else if (nilai == 0) {
            $.messager.alert('Warning', 'Nominal must have value', 'warning');
            return false;
        } else if (id_rek_gl == '') {
            $.messager.alert('Warning', 'Account [Dr] must have value', 'warning');
            return false;
        } else if (kd_rekanan == '') {
            $.messager.alert('Warning', 'Remarks must have value', 'warning');
            return false;
        }

        var master = [];

        master.push({
            idx: idx,
            id_cc_project: id_cc_project,
            cc_project_name: cc_project_name,
            lokasi: lokasi,
            po_number: po_number,
            nilai: nilai,
            dt_announcement: dt_announcement,
            dt_order: dt_order,
            dt_start: dt_start,
            dt_finish: dt_finish,
            kd_rekanan: kd_rekanan,
            id_cat_project: id_cat_project,
            manager: manager,
            id_rek_gl: id_rek_gl

        });


      
        var data = [];
        data.push({
            master: master
        });

        var uri;
        if (mode == 'edit') {
            uri = '<?= base_url(); ?>master/Project/updatePro';
        } else if (mode == 'add') {
            uri = '<?= base_url(); ?>master/Project/insertPro';
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
                window.open('<?= base_url(); ?>master/Project/index/', '_self');
            }
        });
    }

    function cancelData() {
        window.open('<?= base_url(); ?>master/Project', '_self');
        // window.open('<?//= base_url(); ?>procurement/Pr/index/<?//= $dtx ?>', '_self');
    }
</script>


</body>