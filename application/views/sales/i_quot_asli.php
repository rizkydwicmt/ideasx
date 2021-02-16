<!DOCTYPE html>

<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<html>

<head>
    <meta charset="UTF-8">
    <title>iDeas | New Quotsheet</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/easyui'); ?>/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/easyui'); ?>/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/easyui'); ?>/demo/demo.css">
    <script type="text/javascript" src="<?= base_url('assets/js'); ?>/number.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/easyui'); ?>/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/easyui'); ?>/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/easyui'); ?>/jquery.edatagrid.js"></script>
</head>

<body>
    <h2>New Quotsheet [BOQ]</h2>
    <h2><?= $sqid; ?></h2>
    <table style="width: auto;" border="0">
        <tr>

            <td><input id="no_qs" name="no_qs" class="easyui-textbox" label="Quotation #:" labelPosition="top" required="true" style="width:150px;"></td>
            <td style="width:10px;"></td>
            <td><input id="nama_kontak" name="nama_kontak" class="easyui-textbox" label="Contact Name:" labelPosition="top" required="true" style="width:300px;"></td>
            <td style="width:10px;"></td>
            <td><input id="lampiran" name="lampiran" class="easyui-textbox" label="Attachment:" labelPosition="top" style="width:300px;"></td>


        </tr>


        <tr>

            <td><input id="revision" name="revision" class="easyui-textbox" label="Revision:" labelPosition="top" required="true" style="width:150px;"></td>
            <td style="width:10px;"></td>
            <td rowspan="3"><input id="nama_rekanan" name="nama_rekanan" class="easyui-textbox" label="Company Name:" labelPosition="top" multiline="true" required="true" style="width:300px;height:100px"></td>
            <td style="width:10px;"></td>
            <td rowspan="3"><input id="proposal_description" name="proposal_description" class="easyui-textbox" label="Proposal Description:" labelPosition="top" multiline="true" required="true" style="width:300px;height:100px"></td>

        </tr>
        <tr>

            <td><input id="dt_qs" name="dt_qs" class="easyui-datebox" data-options="formatter:myformatter" label="Quotation Date:" labelPosition="top" required="true" style="width:150px;"></td>
            <td style="width:10px;"></td>
        </tr>

    </table>
    <br>
    <hr>

    <table id="dg" title="" style="width:700px;height:250px" toolbar="#toolbar" pagination="true" idField="id" rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="id" width="50">id Code</th>
                <th field="kd_item" width="50" editor="{type:'validatebox',options:{required:true}}">Item Code</th>
                <th field="description" width="50" editor="{type:'validatebox',options:{required:true}}">Description</th>
                <th field="id_unit" width="50" editor="{type:'validatebox',options:{required:true}}">Unit</th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:$('#dg').edatagrid('addRow')">New</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:$('#dg').edatagrid('destroyRow')">Destroy</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:$('#dg').edatagrid('saveRow')">Save</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg').edatagrid('cancelRow')">Cancel</a>
    </div>

    <br>
    <br>
    <div class="ftitle"></div>
    <div id="dlg-buttons">
        <a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="saveDatax()">Save</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:window.close('<?= base_url(); ?>sales/Quot/insertQuot');">Cancel</a>
    </div>


    <script type="text/javascript">
        function myformatter(date) {
            var y = date.getFullYear();
            var m = date.getMonth() + 1;
            var d = date.getDate();
            return (d < 10 ? ('0' + d) : d) + '-' + (m < 10 ? ('0' + m) : m) + '-' + y;
        }

        $(function() {
            $('#dg').edatagrid({
                url: '<?= base_url(); ?>sales/Quot/getDetail/' + <?= $sqid; ?>,
                saveUrl: '<?= base_url(); ?>sales/Quot/saveDetail/' + <?= $sqid; ?>,
                updateUrl: '<?= base_url(); ?>sales/Quot/editDetail',
                destroyUrl: '<?= base_url(); ?>sales/Quot/deleteDetail'
            });
        });

        function saveDatax() {

            var dt_qs = $("#dt_qs").val();
            var nama_kontak = $("#nama_kontak").val();
            var nama_rekanan = $("#nama_rekanan").val();
            var proposal_description = $("#proposal_description").val();
            var lampiran = $("#lampiran").val();
            var revision = $("#revision").val();

            var master = [];

            master.push({
                dt_qs: dt_qs,
                nama_kontak: nama_kontak,
                nama_rekanan: nama_rekanan,
                proposal_description: proposal_description,
                lampiran: lampiran,
                revision: revision
            });

            $.ajax({
                url: '<?= base_url(); ?>sales/Quot/updateQuot/' + <?= $sqid; ?>,
                method: "POST",
                dataType: 'json',
                data: {
                    info: master
                },
                error: function() {
                    if (mode == 'add') {
                        document.getElementById("addError").click(); // Click on the checkbox
                    } else {
                        document.getElementById("editError").click(); // Click on the checkbox
                    }
                },
                success: function(data) {
                    // $('#dgMain').datagrid('reload'); // reload the user data
                    // myWindow.close();
                    //$('#dlg').panel('close');
                    window.open('<?= base_url(); ?>sales/Quot');
                    // if (mode == 'add') {
                    // 	document.getElementById("addSuccess").click(); // Click on the checkbox
                    // } else {
                    // 	document.getElementById("editSuccess").click(); // Click on the checkbox
                    // }
                }
            });
        }
    </script>

</body>

</html>