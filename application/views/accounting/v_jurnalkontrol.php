<!-- BEGIN #content -->
<div id="content" class="content">
    <!-- BEGIN breadcrumb -->
    <ul class="breadcrumb">
        <!--
        <li class="breadcrumb-item"><a href="#">LAYOUT</a></li>
        <li class="breadcrumb-item active">STARTER PAGE</li>-->
        <li class="breadcrumb-item"><a href="#">Accounting</a></li>
        <li class="breadcrumb-item active"><?= $tittle ?></li>
    </ul>
    <!-- END breadcrumb -->

    <!-- BEGIN page-header -->
    <h1 class="page-header">
        <?= $tittle ?> | <small>This form contain <?= $tittle ?> data...</small>
    </h1>
    <!-- END page-header -->

    <div class="panel-body" style="width:100%;height:50px;padding-top:10px;padding-left:10px;">
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
            <li><a href="#tabs-1">Journal Control</a></li>
            <li><a href="#tabs-2">Unbalance Journal</a></li>
        </ul>
        <div id="tabs-1">
            <table id="dg1" class="easyui-datagrid" style="width:97%;height:500px;" toolbar="#tb1" singleSelect="true" showFooter="true" rownumbers="true" pagination="true" striped="true" nowrap="false" fitcoloumn="true">
                <thead>
                    <tr>
                        <th field="no_jurnal" width="110" sortable="true">Journal #</th>
                        <th field="no_bukti" width="110" sortable="true">Reff #</th>
                        <th field="dt_memorial" width="80" sortable="true">Date</th>
                        <th field="id_cc_project" width="80" sortable="true">CC/Project</th>
                        <th field="nama_rekening" width="150" sortable="true">Account Name</th>
                        <th field="remarks" width="200" align="left" sortable="true">Remarks</th>
                        <th field="debet" width="100" align="right" sortable="true">Debit</th>
                        <th field="kredit" width="100" align="right" sortable="true">Credit</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div id="tabs-2">
            <table id="dg2" class="easyui-datagrid" style="width:97%;height:400px;" toolbar="#tb2" rownumbers="true" singleSelect="true" showFooter="true" pagination="true" striped="true" nowrap="false" fitcoloumn="true">
                <thead>
                    <tr>
                        <th field="no_jurnal" width="100" sortable="true">Journal Number</th>
                        <th field="sdebet" width="100" sortable="true" align="right">Debit</th>
                        <th field="skredit" width="100" sortable="true" align="right">Credit</th>
                        <th field="selisih" width="100" sortable="true" align="right">Difference</th>
                    </tr>
                </thead>
            </table>


            <br>

            <table id="dg2d" class="easyui-datagrid" style="width:97%;height:400px;" rownumbers="true" singleSelect="true" showFooter="true" rownumbers="true" pagination="true" striped="true" nowrap="false" fitcoloumn="true">
                <thead>
                    <tr>
                        <th field="no_jurnal" width="110" sortable="true">Journal #</th>
                        <th field="no_bukti" width="110" sortable="true">Reff #</th>
                        <th field="dt_memorial" width="80" sortable="true">Date</th>
                        <th field="id_cc_project" width="80" sortable="true">CC/Project</th>
                        <th field="nama_rekening" width="150" sortable="true">Account Name</th>
                        <th field="remarks" width="200" align="left" sortable="true">Remarks</th>
                        <th field="debet" width="100" align="right" sortable="true">Debit</th>
                        <th field="kredit" width="100" align="right" sortable="true">Credit</th>
                    </tr>
                </thead>
            </table>

        </div>

        <!-- TOOLBAR --->
        <div id="tb1" style="padding:3px">
            <a id="print" href="#" class="easyui-linkbutton" iconCls="icon-excel" plain="false" onclick="xls1();">XLS</a>
        </div>
        <div id="tb2" style="padding:3px">
            <a id="print" href="#" class="easyui-linkbutton" iconCls="icon-excel" plain="false" onclick="xls1();">XLS</a>
        </div>

        <br>

        <!-- END po modal -->
    </div>
    <!-- END #tab -->

    <!-- BEGIN btn-scroll-top -->
    <a href="#" data-click="scroll-top" class="btn-scroll-top fade"><i class="ti-arrow-up"></i></a>
    <!-- END btn-scroll-top -->
    </d>
    <!-- END #page-container -->

    <script type="text/javascript">
        //jQuery.noConflict(); // 
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

            $("#tabs").tabs();

            $('#dg2').datagrid({
                onDblClickRow: function() {
                    var row = $('#dg2').datagrid('getSelected');
                    if (row) {
                        var idx = row.no_jurnal + '_' + $("#dds").val() + '_' + $("#dde").val() + '_' + $('#filterVal').val();
                        $('#dg2d').datagrid({
                            url: "<?= base_url(); ?>accfin/Nsaldo/getUjurnalDetail/" + idx
                        });
                        scrollSmoothToBottom('content');
                    }
                }
            });
        });

        function inputKeyEnter(e) {
            e.which = e.which || e.keyCode;
            if (e.which == 13) {
                doSearch();
            }
        }

        function scrollSmoothToBottom(id) {
            var div = document.getElementById(id);
            $('#' + id).animate({
                scrollTop: div.scrollHeight - div.clientHeight
            }, 500);
        }

        function doSearch() {
            var sc = $("#dds").val() + '_' + $("#dde").val() + '_' + $('#filterVal').val();
            var tb = $("#tabs .ui-tabs-panel:visible").attr("id");
            if (tb == 'tabs-1') {
                $('#dg1').datagrid({
                    url: "<?= base_url(); ?>accfin/Nsaldo/getJkontrol/" + sc
                });
            } else if (tb == 'tabs-2') {
                $('#dg2').datagrid({
                    url: "<?= base_url(); ?>accfin/Nsaldo/getUjurnal/" + sc
                });
            }
        }
    </script>