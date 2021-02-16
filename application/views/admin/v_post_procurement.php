<!-- BEGIN #content -->
<div id="content" class="content">
    <!-- BEGIN breadcrumb -->
    <ul class="breadcrumb">
        <!--
        <li class="breadcrumb-item"><a href="#">LAYOUT</a></li>
        <li class="breadcrumb-item active">STARTER PAGE</li>
-->
        <li class="breadcrumb-item"><a href="#">Procurement</a></li>
        <li class="breadcrumb-item active">Posting Control</li>
    </ul>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">
        <?= $tittle ?> | <small>This form contain <?= $tittle ?> data...</small>
    </h1>
    <!-- END page-header -->
    <div class="panel-body" style="width:100%;height:50px;padding-top:10px;padding-left:10px;padding-bottom:10px;">
        <span>Date Filter :</span>
        <input id="dds" type="text">
        <span>to :</span>
        <input id="dde" type="text">
        <span>Filter :</span>
        <input id="filterVal" onkeyup="inputKeyEnter(event)" style="border:1px solid #ccc">
        <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearch()">Search</a>
    </div>

    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Purchase Requisition</a></li>
            <li><a href="#tabs-2">Purchase Order</a></li>
            <li><a href="#tabs-3">Account Payable</a></li>
        </ul>
        <div id="tabs-1">
            <table id="dg1" title="Purchase Requisition Posting Control" class="easyui-datagrid" style="width:97%;height:450px" toolbar="#tb1" pagination="true" rownumbers="true" striped="true" nowrap="false" singleSelect="false" fitColumns="true">
                <thead>
                    <tr>
                        <th field="ck" checkbox="true"></th>
                        <th field="no_pr" width="120">Requisition #</th>
                        <th field="dt_pr" width="80">Date</th>
                        <th field="requester" width="150" align=left>Requester</th>
                        <th field="remarks" width="180" align=left>Remarks</th>
                        <th field="id_cc_project" width="80">CC/Project</th>
                        <th field="ispost" width="50" align="center">Post</th>
                        <th field="iscancel" width="50" align="center">Cancel</th>
                        <th field="usr_upd" width="50" align="left">User</th>
                        <th field="usr_post" width="80" align="left">Usr Post</th>
                        <th field="dt_post" width="100" align="left">Date Post</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div id="tabs-2">
            <table id="dg2" title="Purchase Order Posting Control" class="easyui-datagrid" style="width:97%;height:450px" toolbar="#tb2" pagination="true" rownumbers="true" striped="true" nowrap="false" singleSelect="false" fitColumns="true">
                <thead>
                    <tr>
                        <th field="ck" checkbox="true"></th>
                        <th field="po_number" width="120">Order #</th>
                        <th field="po_date" width="80">Date</th>
                        <th field="nama_rekanan" width="150" align=left>Supplier</th>
                        <th field="remarks" width="150" align=left>Remarks</th>
                        <th field="id_cc_project" width="80">CC/Project</th>
                        <th field="total" width="80" align="right">Total</th>
                        <th field="ispost" width="40" align="center">Post</th>
                        <th field="iscancel" width="40" align="center">Cancel</th>
                        <th field="usr_upd" width="50" align="left">User</th>
                        <th field="usr_post" width="80" align="left">Usr Post</th>
                        <th field="dt_post" width="100" align="left">Date Post</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div id="tabs-3">
            <table id="dg3" title="Account Payable Posting Control" class="easyui-datagrid" style="width:97%;height:450px" toolbar="#tb3" pagination="true" rownumbers="true" striped="true" nowrap="false" singleSelect="false" fitColumns="true">
                <thead>
                    <tr>
                        <th field="ck" checkbox="true"></th>
                        <th field="ap_number" width="110">AP #</th>
                        <th field="invoice_no" width="110">Invoice #</th>
                        <th field="dt_ap" width="100">Date</th>
                        <th field="nama_rekanan" width="150" align="left">Employee/Supplier</th>
                        <th field="remarks" width="180" align="left">Remarks</th>
                        <th field="total" width="80" align="right">Total</th>
                        <th field="ispost" width="40" align="center">Post</th>
                        <th field="iscancel" width="40" align="center">Cancel</th>
                        <th field="usr_upd" width="50" align="left">User</th>
                        <th field="usr_post" width="80" align="left">Usr Post</th>
                        <th field="dt_post" width="100" align="left">Date Post</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- END #tab -->


</div>
<!-- END #content -->

<!-- BEGIN btn-scroll-top -->
<a href="#" data-click="scroll-top" class="btn-scroll-top fade"><i class="ti-arrow-up"></i></a>
<!-- END btn-scroll-top -->
</div>
<!-- END #page-container -->

<div id="tb1" style="padding:1px;">
    <a href="#" class="easyui-linkbutton" iconCls="icon-edit" onclick="posting1('11');">Posting</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-remove" onclick="posting1('10');">Unposting</a>
</div>

<div id="tb2" style="padding:1px;">
    <a href="#" class="easyui-linkbutton" iconCls="icon-edit" onclick="posting2('11');">Posting</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-remove" onclick="posting2('10');">Unposting</a>
</div>

<div id="tb3" style="padding:1px;">
    <a href="#" class="easyui-linkbutton" iconCls="icon-edit" onclick="posting3('11');">Posting</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-remove" onclick="posting3('10');">Unposting</a>
</div>


<div>
    <!-- Alert Simpan data baru -->
    <a hidden href="#" id='postSuccess' class="btn btn-default btn-sm" data-toggle="notification" data-icon="ti-save" data-icon-class="bg-gradient-blue-purple" data-title="Operation Success" data-content="Posting data successfully!" data-autoclose="true"></a>
    <a hidden href="#" id='postError' class="btn btn-default btn-sm" data-toggle="notification" data-icon="ti-save-alt" data-icon-class="bg-gradient-blue-purple" data-title="Operation Error" data-content="Can't POsting Data!" data-autoclose="true"></a>

</div>


<script>
    var url;
    var mode;
    $(function() {


        $("#dds").datepicker({
            changeMonth: true,
            changeYear: true,
            gotoCurrent: true
        });
        $("#dds").datepicker("option", "dateFormat", "dd-mm-yy");
        $("#dds").datepicker("setDate", "today");


        $("#dde").datepicker({
            changeMonth: true,
            changeYear: true,
            gotoCurrent: true
        });
        $("#dde").datepicker("option", "dateFormat", "dd-mm-yy");
        $("#dde").datepicker("setDate", "today");

        //        doSearch();
        $("#tabs").tabs();

        $('#dg1').datagrid({
            rowStyler: function(index, row) {
                if (row.ispost == '0') {
                    return 'background-color:yellow;';
                }
            }
        });

        $('#dg2').datagrid({
            rowStyler: function(index, row) {
                if (row.ispost == '0') {
                    return 'background-color:yellow;';
                }
            }
        });

        $('#dg3').datagrid({
            rowStyler: function(index, row) {
                if (row.ispost == '0') {
                    return 'background-color:yellow;';
                }
            }
        });


    });

    function doSearch() {


        var sc = $("#dds").val() + '_' + $("#dde").val() + '_' + $('#filterVal').val();
        var tb = $("#tabs .ui-tabs-panel:visible").attr("id");
        if (tb == 'tabs-1') {
            $('#dg1').datagrid({
                url: "<?= base_url(); ?>admin/Posting/getPr/" + 'Pr' + '_' + sc
            });
        } else if (tb == 'tabs-2') {
            $('#dg2').datagrid({
                url: "<?= base_url(); ?>admin/Posting/getPo/" + 'Po' + '_' + sc
            });
        } else if (tb == 'tabs-3') {
            $('#dg3').datagrid({
                url: "<?= base_url(); ?>admin/Posting/getAp/" + 'Ap' + '_' + sc
            });
        }
    }

    function posting1($i) {

        var t = $i.substring(0, 1);
        var p = $i.substring(1, 2);

        var ss = [];
        var rows = $('#dg1').datagrid('getSelections');
        for (var i = 0; i < rows.length; i++) {
            ss.push({
                no: rows[i].kd_pr
            });
        }

        $.ajax({
            url: "<?= base_url(); ?>admin/Posting/postPr/" + p,
            method: "POST",
            dataType: 'json',
            data: {
                info: ss
            },
            error: function() {
                document.getElementById("postError").click(); // Click on the checkbox
            },
            success: function(data) {
                $('#dg1').datagrid('reload'); // reload the user data
                document.getElementById("postSuccess").click(); // Click on the checkbox
            }
        });
    }

    function posting2($i) {

        var t = $i.substring(0, 1);
        var p = $i.substring(1, 2);

        var ss = [];
        var rows = $('#dg2').datagrid('getSelections');
        for (var i = 0; i < rows.length; i++) {
            ss.push({
                no: rows[i].kd_po
            });
        }

        $.ajax({
            url: "<?= base_url(); ?>admin/Posting/postPo/" + p,
            method: "POST",
            dataType: 'json',
            data: {
                info: ss
            },
            error: function() {
                document.getElementById("postError").click(); // Click on the checkbox
            },
            success: function(data) {
                $('#dg2').datagrid('reload'); // reload the user data
                document.getElementById("postSuccess").click(); // Click on the checkbox
            }
        });
    }


    function posting3($i) {

        var t = $i.substring(0, 1);
        var p = $i.substring(1, 2);

        var ss = [];
        var rows = $('#dg3').datagrid('getSelections');
        for (var i = 0; i < rows.length; i++) {
            ss.push({
                no: rows[i].kd_ap
            });
        }

        $.ajax({
            url: "<?= base_url(); ?>admin/Posting/postAp/" + p,
            method: "POST",
            dataType: 'json',
            data: {
                info: ss
            },
            error: function() {
                document.getElementById("postError").click(); // Click on the checkbox
            },
            success: function(data) {
                $('#dg3').datagrid('reload'); // reload the user data
                document.getElementById("postSuccess").click(); // Click on the checkbox
            }
        });
    }
</script>