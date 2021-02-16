<!-- BEGIN #content -->
<div id="content" class="content">
    <!-- BEGIN breadcrumb -->
    <ul class="breadcrumb">
        <!--
        <li class="breadcrumb-item"><a href="#">LAYOUT</a></li>
        <li class="breadcrumb-item active">STARTER PAGE</li>-->
        <li class="breadcrumb-item"><a href="#">Master</a></li>
        <li class="breadcrumb-item active"><?= $tittle ?></li>
    </ul>
    <!-- END breadcrumb -->

    <!-- BEGIN page-header -->
    <h1 class="page-header">
        <?= $tittle ?> | <small>This form contain <?= $tittle ?> data...</small>
    </h1>
    <!-- END page-header -->

    <div id="container" class="easyui-panel" style="width:100%;height:450px;padding:10px;">
        <table id="dgMain" class="easyui-datagrid" style="width:100%;height:420px;;" 
        url="<?= base_url(); ?>master/Project/getData" singleSelect="true" rownumbers="true" 
        pagination="true" fitColumns="true" striped="true" nowrap="false" toolbar="#toolbarFilter">
            <thead>
                <tr>
                    <th field="id_cc_project" width=80>Project ID</th>
                    <th field="cc_project_name" width=300 align="left">Project Name</th>
                    <th field="manager" width="100" align="left">Manager</th>
                    <th field="nama_rekanan" width="250" align="left">Customer</th>
                    <th field="project_category" width="250" align="left">Category</th>
                    <th field="tahun" width="80" align="left">Year</th>
                    <th field="po_number" width="150" align="left">PO/Contract #</th>
                    <th field="nilai" width="100" formatter="datagridFormatNumber" align="right">Comtract Value</th>

                    <th field="isactive" width="100" align=left>Active</th>
                </tr>
            </thead>
        </table>

        <div id="toolbarFilter" style="padding-left: 10px">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="newData()">New</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editData()">Edit</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onClick="removeData()">Destroy</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="javascript:$('#dgMain').datagrid('reload'); ">Refresh</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
            <span>|</span>
            <span>Filter :</span>
            <input id="filterVal" onkeyup="inputKeyEnter(event)" style="border:1px solid #ccc">
            <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearch()">Cari</a>
        </div>




    <!-- END #content -->

    <!-- BEGIN btn-scroll-top -->
    <a href="#" data-click="scroll-top" class="btn-scroll-top fade"><i class="ti-arrow-up"></i></a>
    <!-- END btn-scroll-top -->
</div>
<!-- END #page-container -->

<div>
    <!-- Alert Simpan data baru -->
    <a hidden href="#" id='addSuccess' class="btn btn-default btn-sm" data-toggle="notification" data-icon="ti-save" data-icon-class="bg-gradient-blue-purple" data-title="Operation Success" data-content="New data added successfully!" data-autoclose="true"></a>
    <a hidden href="#" id='addError' class="btn btn-default btn-sm" data-toggle="notification" data-icon="ti-save-alt" data-icon-class="bg-gradient-blue-purple" data-title="Operation Error" data-content="Can't added New Data!" data-autoclose="true"></a>

    <!-- Alert update data baru -->
    <a hidden href="#" id='editSuccess' class="btn btn-default btn-sm" data-toggle="notification" data-icon="ti-save" data-icon-class="bg-gradient-blue-purple" data-title="Operation Success" data-content="Data update successfully" data-autoclose="true"></a>
    <a hidden href="#" id='editError' class="btn btn-default btn-sm" data-toggle="notification" data-icon="ti-save-alt" data-icon-class="bg-gradient-blue-purple" data-title="Operation Error" data-content="Can't Update Data!" data-autoclose="true"></a>

    <!-- Alert delete data  -->
    <a hidden href="#" id='delSuccess' class="btn btn-default btn-sm" data-toggle="notification" data-icon="ti-save" data-icon-class="bg-gradient-blue-purple" data-title="Operation Success" data-content="Delete data successfully" data-autoclose="true"></a>
    <a hidden href="#" id='delError' class="btn btn-default btn-sm" data-toggle="notification" data-icon="ti-save-alt" data-icon-class="bg-gradient-blue-purple" data-title="Operation Error" data-content="Can't Delete Data!" data-autoclose="true"></a>
</div>

<script src="<?php echo base_url('assets/js/accounting.min.js') ?>"></script>
<script type="text/javascript">
    //jQuery.noConflict(); // 
    var url;
    var mode;
    $(function() {
        doSearch();
    });

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



    function newData() {
       //var tu = $("#tipe_user").val();
       $.ajax({
            url: "<?= base_url(); ?>master/Project/newPro",
            method: "POST",
            dataType: 'json',
            data: {
                tu: '0'
            },
            error: function() {
                document.getElementById("addError").click();
            },
            success: function(data) {
                window.open('<?= base_url(); ?>master/Project/loadPro', '_self');
            }
        });
    }


    function editData() {
        var row = $('#dgMain').datagrid('getSelected');
        if (row) {
            var row = $('#dgMain').datagrid('getSelected');
        $.ajax({
            url: "<?= base_url(); ?>master/Project/editPro",
            method: "POST",
            dataType: 'json',
            data: {
                id: row.id_cc_project
            },
            error: function() {
                document.getElementById("editError").click(); // Click on the checkbox
            },
            success: function(data) {
                //myAppendGrid.load(data);
                //document.getElementById("addSuccess").click(); // Click on the checkbox
                window.open('<?= base_url(); ?>master/Project/loadPro', '_self');
            }
        });
        }
    }


    
    function removeData() {
        var row = $('#dgMain').datagrid('getSelected');
        if (row) {
            //alert(row.kd_rekanan);
            var result = confirm("Are you sure to delete?");
            if (result) {
                // Delete logic goes here
                //alert(row.kd_rekanan);
                $.ajax({
                    url: "<?= base_url(); ?>master/Project/destroyData",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        id: row.id_cc_project
                    },
                    error: function() {

                        document.getElementById("delError").click(); // Click on the checkbox
                    },
                    success: function(data) {
                        $('#dgMain').datagrid('reload'); // reload the user data
                        document.getElementById("delSuccess").click(); // Click on the checkbox;
                    }
                });
            }
        }
    }




    function doSearch() {
        $('#dgMain').datagrid('load', {
            searching: $('#filterVal').val()
        });
    }
</script>