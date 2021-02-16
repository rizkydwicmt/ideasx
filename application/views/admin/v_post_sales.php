<!-- BEGIN #content -->
<div id="content" class="content">
    <!-- BEGIN breadcrumb -->
    <ul class="breadcrumb">
        <!--
        <li class="breadcrumb-item"><a href="#">LAYOUT</a></li>
        <li class="breadcrumb-item active">STARTER PAGE</li>
-->
        <li class="breadcrumb-item"><a href="#">Accounting</a></li>
        <li class="breadcrumb-item active">Posting Control Sales</li>
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
            <li><a href="#tabs-1">Sales Invoice</a></li>
        </ul>
        <div id="tabs-1">
            <table id="dg1" title="Sales Invoice Posting Control" class="easyui-datagrid" style="width:97%;height:450px" toolbar="#tb1" pagination="true" rownumbers="true" striped="true" nowrap="false" singleSelect="false" fitColumns="true">
                <thead>
                    <tr>
                        <th field="ck" checkbox="true"></th>
                        <th field="no_sales_invoice" width="110">Ar Number#</th>
                        <th field="dt_sales_invoice" width="80">Date</th>
                        <th field="nama_rekanan" width="150" align=left>Customer</th>
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
    });

    function doSearch() {


        var sc = $("#dds").val() + '_' + $("#dde").val() + '_' + $('#filterVal').val();
        var tb = $("#tabs .ui-tabs-panel:visible").attr("id");
        if (tb == 'tabs-1') {
            $('#dg1').datagrid({
                url: "<?= base_url(); ?>Posting/getAr/" + 'Ar' + '_' + sc
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
                no: rows[i].id_sales_invoice
            });
        }

        $.ajax({
            url: "<?= base_url(); ?>Posting/postAr/" + p,
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
</script>