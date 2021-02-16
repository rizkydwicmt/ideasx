<!-- BEGIN #content -->
<div id="content" class="content">
    <!-- BEGIN breadcrumb -->
    <ul class="breadcrumb">
        <!--
        <li class="breadcrumb-item"><a href="#">LAYOUT</a></li>
        <li class="breadcrumb-item active">STARTER PAGE</li>
-->
        <li class="breadcrumb-item"><a href="#">Accounting</a></li>
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
            <li><a href="#tabs-1">Settlement</a></li>
            <li><a href="#tabs-2">Reimbursement</a></li>
            <li><a href="#tabs-3">Cash Disbursement</a></li>
            <li><a href="#tabs-4">Cash Receipt</a></li>
            <li><a href="#tabs-5">Bank Disbursement</a></li>
            <li><a href="#tabs-6">Bank Receipt</a></li>
            <li><a href="#tabs-7">Memorial</a></li>
        </ul>
        <div id="tabs-1">
            <table id="dg1" title="Settlement Posting Control" class="easyui-datagrid" style="width:97%;height:450px" toolbar="#tb1" pagination="true" rownumbers="true" striped="true" nowrap="false" singleSelect="false" fitColumns="true">
                <thead>
                    <tr>
                        <th field="ck" checkbox="true"></th>
                        <th field="no_settlement" width="110">Settlement #</th>
                        <th field="dt_settlement" width="80">Date</th>
                        <th field="nama_rekanan" width="150" align=left>Employee</th>
                        <th field="remarks" width="180" align=left>Remarks</th>
                        <th field="id_cc_project" width="80">CC/Project</th>
                        <th field="total" width="80" align="right">Total</th>
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
            <table id="dg2" title="Reimbursement Posting Control" class="easyui-datagrid" style="width:97%;height:450px" toolbar="#tb2" pagination="true" rownumbers="true" striped="true" nowrap="false" singleSelect="false" fitColumns="true">
                <thead>
                    <tr>
                        <th field="ck" checkbox="true"></th>
                        <th field="no_settlement" width="110">Reimbursement #</th>
                        <th field="dt_settlement" width="80">Date</th>
                        <th field="nama_rekanan" width="150" align=left>Employee</th>
                        <th field="remarks" width="180" align=left>Remarks</th>
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
            <table id="dg3" title="Cash Disbursement Posting Control" class="easyui-datagrid" style="width:97%;height:450px" toolbar="#tb3" pagination="true" rownumbers="true" striped="true" nowrap="false" singleSelect="false" fitColumns="true">
                <thead>
                    <tr>
                        <th field="ck" checkbox="true"></th>
                        <th field="no_payment" width="110">Disbursement #</th>
                        <th field="dt_payment" width="80">Date</th>
                        <th field="nama_rekanan" width="150" align="left">Employee/Supplier</th>
                        <th field="remarks" width="180" align="left">Remarks</th>
                        <th field="nominal" width="80" align="right">Total</th>
                        <th field="ispost" width="40" align="center">Post</th>
                        <th field="iscancel" width="40" align="center">Cancel</th>
                        <th field="usr_upd" width="50" align="left">User</th>
                        <th field="usr_post" width="80" align="left">Usr Post</th>
                        <th field="dt_post" width="100" align="left">Date Post</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div id="tabs-4">
            <table id="dg4" title="Cash Receipt Posting Control" class="easyui-datagrid" style="width:97%;height:450px" toolbar="#tb4" pagination="true" rownumbers="true" striped="true" nowrap="false" singleSelect="false" fitColumns="true">
                <thead>
                    <tr>
                        <th field="ck" checkbox="true"></th>
                        <th field="no_payment" width="110">Receipt #</th>
                        <th field="dt_payment" width="80">Date</th>
                        <th field="nama_rekanan" width="150" align="left">Employee/Supplier</th>
                        <th field="remarks" width="180" align="left">Remarks</th>
                        <th field="nominal" width="80" align="right">Total</th>
                        <th field="ispost" width="40" align="center">Post</th>
                        <th field="iscancel" width="40" align="center">Cancel</th>
                        <th field="usr_upd" width="50" align="left">User</th>
                        <th field="usr_post" width="80" align="left">Usr Post</th>
                        <th field="dt_post" width="100" align="left">Date Post</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div id="tabs-5">
            <table id="dg5" title="Bank Disbursement Posting Control" class="easyui-datagrid" style="width:97%;height:450px" toolbar="#tb5" pagination="true" rownumbers="true" striped="true" nowrap="false" singleSelect="false" fitColumns="true">
                <thead>
                    <tr>
                        <th field="ck" checkbox="true"></th>
                        <th field="no_payment" width="110">Disbursement #</th>
                        <th field="dt_payment" width="80">Date</th>
                        <th field="no_cek_bg_tt" width="80">No Trans#</th>
                        <th field="jns_ttbg" width="80">Trans Type</th>
                        <th field="nama_rekanan" width="150" align="left">Employee/Supplier</th>
                        <th field="remarks" width="180" align="left">Remarks</th>
                        <th field="nominal" width="80" align="right">Total</th>
                        <th field="ispost" width="40" align="center">Post</th>
                        <th field="iscancel" width="40" align="center">Cancel</th>
                        <th field="usr_upd" width="50" align="left">User</th>
                        <th field="usr_post" width="80" align="left">Usr Post</th>
                        <th field="dt_post" width="100" align="left">Date Post</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div id="tabs-6">
            <table id="dg6" title="Bank Receipt Posting Control" class="easyui-datagrid" style="width:97%;height:450px" toolbar="#tb6" pagination="true" rownumbers="true" striped="true" nowrap="false" singleSelect="false" fitColumns="true">
                <thead>
                    <tr>
                        <th field="ck" checkbox="true"></th>
                        <th field="no_payment" width="110">Receipt #</th>
                        <th field="dt_payment" width="80">Date</th>
                        <th field="no_cek_bg_tt" width="80">No Trans#</th>
                        <th field="jns_ttbg" width="80">Trans Type</th>
                        <th field="nama_rekanan" width="150" align="left">Employee/Supplier</th>
                        <th field="remarks" width="180" align="left">Remarks</th>
                        <th field="nominal" width="80" align="right">Total</th>
                        <th field="ispost" width="40" align="center">Post</th>
                        <th field="iscancel" width="40" align="center">Cancel</th>
                        <th field="usr_upd" width="50" align="left">User</th>
                        <th field="usr_post" width="80" align="left">Usr Post</th>
                        <th field="dt_post" width="100" align="left">Date Post</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div id="tabs-7">
            <table id="dg7" title="Memorial Posting Control" class="easyui-datagrid" style="width:97%;height:450px" toolbar="#tb7" pagination="true" rownumbers="true" striped="true" nowrap="false" singleSelect="false" fitColumns="true">
                <thead>
                    <tr>
                        <th field="ck" checkbox="true"></th>
                        <th field="no_payment" width="110">Receipt #</th>
                        <th field="dt_payment" width="80">Date</th>
                        <th field="nama_rekanan" width="150" align="left">Employee/Supplier</th>
                        <th field="remarks" width="180" align="left">Remarks</th>
                        <th field="nominal" width="80" align="right">Total</th>
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
    <a href="#" class="easyui-linkbutton" iconCls="icon-edit" onclick="posting1('21');">Posting</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-remove" onclick="posting1('20');">Unposting</a>
</div>

<div id="tb3" style="padding:1px;">
    <a href="#" class="easyui-linkbutton" iconCls="icon-edit" onclick="posting2('11');">Posting</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-remove" onclick="posting2('10');">Unposting</a>
</div>
<div id="tb4" style="padding:1px;">
    <a href="#" class="easyui-linkbutton" iconCls="icon-edit" onclick="posting2('21');">Posting</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-remove" onclick="posting2('20');">Unposting</a>
</div>
<div id="tb5" style="padding:1px;">
    <a href="#" class="easyui-linkbutton" iconCls="icon-edit" onclick="posting2('31');">Posting</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-remove" onclick="posting2('30');">Unposting</a>
</div>
<div id="tb6" style="padding:1px;">
    <a href="#" class="easyui-linkbutton" iconCls="icon-edit" onclick="posting2('41');">Posting</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-remove" onclick="posting2('40');">Unposting</a>
</div>
<div id="tb7" style="padding:1px;">
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
        $('#dg4').datagrid({
            rowStyler: function(index, row) {
                if (row.ispost == '0') {
                    return 'background-color:yellow;';
                }
            }
        });
        $('#dg5').datagrid({
            rowStyler: function(index, row) {
                if (row.ispost == '0') {
                    return 'background-color:yellow;';
                }
            }
        });
        $('#dg6').datagrid({
            rowStyler: function(index, row) {
                if (row.ispost == '0') {
                    return 'background-color:yellow;';
                }
            }
        });
        $('#dg7').datagrid({
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
                url: "<?= base_url(); ?>Posting/getSettlement/" + 'Settlement' + '_' + sc
            });
        } else if (tb == 'tabs-2') {
            $('#dg2').datagrid({
                url: "<?= base_url(); ?>Posting/getSettlement/" + 'Reimbursement' + '_' + sc
            });
        } else if (tb == 'tabs-3') {
            $('#dg3').datagrid({
                url: "<?= base_url(); ?>Posting/getPayment/" + 'Cd' + '_' + sc
            });
        } else if (tb == 'tabs-4') {
            $('#dg4').datagrid({
                url: "<?= base_url(); ?>Posting/getPayment/" + 'Cr' + '_' + sc
            });
        } else if (tb == 'tabs-5') {
            $('#dg5').datagrid({
                url: "<?= base_url(); ?>Posting/getPayment/" + 'Bd' + '_' + sc
            });
        } else if (tb == 'tabs-6') {
            $('#dg6').datagrid({
                url: "<?= base_url(); ?>Posting/getPayment/" + 'Br' + '_' + sc
            });
        } else if (tb == 'tabs-7') {
            $('#dg7').datagrid({
                url: "<?= base_url(); ?>Posting/getMemorial/" + 'Memorial' + '_' + sc
            });
        }
    }

    function posting1($i) {

        var t = $i.substring(0, 1);
        var p = $i.substring(1, 2);

        var ss = [];
        if (t == 1) {
            var rows = $('#dg1').datagrid('getSelections');
        } else if (t == 2) {
            var rows = $('#dg2').datagrid('getSelections');
        }

        for (var i = 0; i < rows.length; i++) {
            ss.push({
                no: rows[i].id_settlement
            });
        }

        $.ajax({
            url: "<?= base_url(); ?>Posting/postSettlement/" + p,
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
                $('#dg2').datagrid('reload'); // reload the user data
                document.getElementById("postSuccess").click(); // Click on the checkbox
            }
        });
    }

    function posting2($i) {

        var t = $i.substring(0, 1);
        var p = $i.substring(1, 2);

        var ss = [];
        if (t == 1) {
            var rows = $('#dg3').datagrid('getSelections');
        } else if (t == 2) {
            var rows = $('#dg4').datagrid('getSelections');
        } else if (t == 3) {
            var rows = $('#dg5').datagrid('getSelections');
        } else if (t == 4) {
            var rows = $('#dg6').datagrid('getSelections');
        }

        for (var i = 0; i < rows.length; i++) {
            ss.push({
                no: rows[i].id_payment
            });
        }

        $.ajax({
            url: "<?= base_url(); ?>Posting/postPayment/" + p,
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
                $('#dg4').datagrid('reload'); // reload the user data
                $('#dg5').datagrid('reload'); // reload the user data
                $('#dg6').datagrid('reload'); // reload the user data
                document.getElementById("postSuccess").click(); // Click on the checkbox
            }
        });
    }


    function posting3($i) {

        var t = $i.substring(0, 1);
        var p = $i.substring(1, 2);

        var ss = [];

        var rows = $('#dg7').datagrid('getSelections');
        for (var i = 0; i < rows.length; i++) {
            ss.push({
                no: rows[i].id_jurnal
            });
        }

        $.ajax({
            url: "<?= base_url(); ?>Posting/postMemorial/" + p,
            method: "POST",
            dataType: 'json',
            data: {
                info: ss
            },
            error: function() {
                document.getElementById("postError").click(); // Click on the checkbox
            },
            success: function(data) {
                $('#dg7').datagrid('reload'); // reload the user data
                document.getElementById("postSuccess").click(); // Click on the checkbox
            }
        });
    }
</script>