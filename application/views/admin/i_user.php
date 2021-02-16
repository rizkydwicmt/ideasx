<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($this->session->userdata("username"))) {
    redirect(site_url(), 'refresh');
} elseif (empty($this->session->userdata("usr"))) {
    redirect(base_url('admin/User'), 'refresh');
};
?>

<style type="text/css">
    @import url("<?= base_url('assets/'); ?>css/upload.css");
</style>

<table style="width: 100%;" cellspacing="0px" border="0">
    <tr>
        <td style="width:50%;text-align:left">
            <h2><?= $caption; ?></h2>

        </td>
        <td style="width:50%;text-align:right"><input id="id_user" class="easyui-textbox" readonly="true" style="width:150px;"></td>
    </tr>
</table>
<hr>
<table style="width: auto;" cellpadding="2px" cellspacing="3px" border="0">
    <tr>

        <td><input id="vuser" class="easyui-textbox" label="User Name:" labelPosition="top" required="true" style="width:200px;"></td>
        <td><input id="nk" class="easyui-combogrid" label="NK:" labelPosition="top" required="true" style="width:150px;"></td>

        <td><input id="tipe" class="easyui-combobox" label="Theme:" labelPosition="top" required="true" style="width:150px;" data-options="
            valueField: 'value',
            textField: 'label',
            data: [{
                label: 'default',
                value: 'default'
            },{
                label: 'gray',
                value: 'gray'
            },{
                label: 'metro',
                value: 'metro'
            },{
                label: 'black',
                value: 'black'
            },{
                label: 'bootstrap',
                value: 'bootstrap'
            },{
                label: 'material',
                value: 'material'
            }]">
        </td>
        <td><input id="full_name" class="easyui-textbox" label="Full Name:" labelPosition="top" required="true" style="width:250px;"></td>
        <td rowspan="3" style="width:30px"></td>
    </tr>

    <tr>
        <td><input id="passwd" class="easyui-passwordbox" label="Password:" labelPosition="top" required="true" style="width:200px;"></td>
        <td><input id="user_role" class="easyui-combobox" label="User Role:" labelPosition="top" required="true" style="width:150px;" data-options="
            valueField: 'value',
            textField: 'label',
            data: [{
                label: 'Admin',
                value: 'Admin'
            },{
                label: 'FinAcc',
                value: 'FinAcc'
            },{
                label: 'User',
                value: 'User'
            }]">
        </td>

        <td><input id="is_active" class="easyui-combobox" label="Active:" labelPosition="top" required="true" style="width:150px;" data-options="
            valueField: 'value',
            textField: 'label',
            data: [{
                label: 'Yes',
                value: '1'
            },{
                label: 'No',
                value: '0'
            }]">
        </td>
        <td><input id="email" class="easyui-textbox" label="Email:" labelPosition="top" required="true" style="width:250px;"></td>
    </tr>
    <tr>
        <td><input id="passwd_auth" class="easyui-passwordbox" label="Password Auth:" labelPosition="top" required="true" style="width:200px;"></td>
    </tr>
</table>

<br>


<div>
    <!-- div detail -->
    <table id="dg" class="easyui-datagrid" title="User Right Detail" style="width:80%;height:auto" data-options="
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
                <th data-options="field:'nama_menu',width:350,editor:{type:'textbox',options:{readonly:true}}">Menu Name</th>
                <th data-options="field:'lvl',width:80,align:'center',editor:{type:'textbox',options:{readonly:true}}">Level</th>
                <th data-options="field:'isbrowse',width:80,align:'center',editor:{type:'textbox',options:{readonly:false}}">Browse</th>
                <th data-options="field:'isinsert',width:80,align:'center',editor:{type:'textbox',options:{readonly:false}}">Insert</th>
                <th data-options="field:'isedit',width:80,align:'center',editor:{type:'textbox',options:{readonly:false}}">Edit</th>
                <th data-options="field:'isdelete',width:80,align:'center',editor:{type:'textbox',options:{readonly:false}}">Delete</th>
                <th data-options="field:'isprint',width:80,align:'center',editor:{type:'textbox',options:{readonly:false}}">Print</th>
                <th data-options="field:'isdetail',width:100,align:'center',editor:{type:'textbox',options:{readonly:true}}">Detail Menu</th>
                <th data-options="field:'imenu'" hidden="true">imenu</th>

            </tr>
        </thead>
    </table>
    <div id="tb" style="height:auto">
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="fetchDetailDefault()">Get Menu</a>
        <!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeit()">Remove</a>-->
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


<script src="<?php echo base_url('assets/js/accounting.min.js') ?>"></script>
<script type="text/javascript">
    var editIndex = undefined;
    var lastIndex;
    var mode = '<?= $mode ?>';
    var idx = '<?= $idx ?>';


    //-----------------------------$('#dg').datagrid-----------------------------

    $(function() {
        // $("#pkd_rekanan").hide();
        // $("#pid_qs").hide();


        $('#nk').combogrid({
            panelWidth: 400,
            url: '<?= base_url()  ?>admin/User/getRekanan',
            idField: 'kd_rekanan',
            textField: 'kd_rekanan',
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
                $('#full_name').textbox('setValue', row.nama_rekanan);
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
            $('#passwd').passwordbox('disable');
            $('#passwd_auth').passwordbox('disable');
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
            index: index
            // field: 'kd_satuan'
        });
        //row.kd_satuan = $(ed.target).combobox('getText');
        //$('#dg').datagrid('getRows')[index]['kd_satuan'] = $(ed.target).combobox('getText');
    }

    function append() {
        if (endEditing()) {
            $('#dg').datagrid('appendRow', {
                imenu: 0
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
            url: "<?= base_url(); ?>admin/User/getMasterData",
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
                $('#id_user').textbox('setValue', data[0]['vuser']);
                $('#vuser').textbox('setValue', data[0]['vuser']);
                $('#nk').combogrid('setValue', data[0]['nk']);
                $('#user_role').combobox('setValue', data[0]['user_role']);
                $('#tipe').combobox('setValue', data[0]['tipe']);
                $('#is_active').combobox('setValue', data[0]['is_active']);
                $('#passwd').passwordbox('setValue', data[0]['passwd']);
                $('#passwd_auth').passwordbox('setValue', data[0]['passwd_auth']);
                $('#full_name').textbox('setValue', data[0]['full_name']);
                $('#email').textbox('setValue', data[0]['email']);
            }
        });
    }

    function fetchDetailData(idx) {
        $.ajax({
            url: "<?= base_url(); ?>admin/User/getDetailData",
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


    function fetchDetailDefault() {
        var urole = 'tesla';
        $.ajax({
            url: "<?= base_url(); ?>admin/User/getDetailDefault",
            method: "POST",
            dataType: 'json',
            data: {
                idx: urole
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




    function saveDatax() {

        var id_user = $('#id_user').textbox('getValue');
        var vuser = $('#vuser').textbox('getValue');
        var passwd = $('#passwd').passwordbox('getValue');
        var passwd_auth = $('#passwd_auth').passwordbox('getValue');
        var nk = $('#nk').combogrid('getValue');
        var full_name = $('#full_name').textbox('getValue');
        // var lvl = $('#lvl').textbox('getValue');
        var email = $('#email').textbox('getValue');
        var tipe = $('#tipe').combobox('getValue');
        var is_active = $('#is_active').combobox('getValue');
        var user_role = $('#user_role').combobox('getValue');

        var detail = $('#dg').datagrid('getRows');

        // VALIDATION FORM --------------------------------------
        if (vuser == '') {
            $.messager.alert('Warning', 'vuser must have value', 'warning');
            return false;
        } else if (nk == '') {
            $.messager.alert('Warning', 'Nk must have value', 'warning');
            return false;
        } else if (passwd == '') {
            $.messager.alert('Warning', 'Password must have value', 'warning');
            return false;
        } else if (passwd_auth == '') {
            $.messager.alert('Warning', 'Password Auth must have value', 'warning');
            return false;
        } else if (email == '') {
            $.messager.alert('Warning', 'Email must have value', 'warning');
            return false;
        } else if (tipe == '') {
            $.messager.alert('Warning', 'Theme must have value', 'warning');
            return false;
        } else if (user_role == '') {
            $.messager.alert('Warning', 'User Role must have value', 'warning');
            return false;
        }

        // alert('masuk');
        var master = [];

        master.push({
            id_user: id_user,
            vuser: vuser,
            passwd: passwd,
            passwd_auth: passwd_auth,
            full_name: full_name,
            tipe: tipe,
            nk: nk,
            email: email,
            is_active: is_active,
            user_role: user_role,
            tuser: <?= $tuser ?>
        });


        var data = [];
        data.push({
            master: master,
            detail: detail
        });

        var uri;
        if (mode == 'edit') {
            uri = '<?= base_url(); ?>admin/User/updateUser';
        } else if (mode == 'add') {
            uri = '<?= base_url(); ?>admin/User/insertUser';
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
                window.open('<?= base_url(); ?>admin/User/index', '_self');
            }
        });
    }

    function cancelData() {
        // alert('ok');
        window.open('<?= base_url(); ?>admin/User', '_self');
    }

</script>


</body>