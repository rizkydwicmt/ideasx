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
        <table id="dgMain" class="easyui-datagrid" style="width:100%;height:400px;;" url="<?= base_url(); ?>master/Cc_project/getData/<?= $jenis ?>" singleSelect="true" rownumbers="true" pagination="true" toolbar="#toolbarFilter">
            <thead>
                <tr>
                    <th field="id_cc_project" width="100">Cost Center ID</th>
                    <th field="cc_project_name" width="400" align=left>CC Name</th>
                    <th field="manager" width="100" align=left>Manager</th>
                    <th field="budget" width="150" formatter="datagridFormatNumber" align="right">Budget</th>
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




    </div>
    <!-- Modal -->
    <br>
    <div id="dlg" class="easyui-panel" title="Supplier" style="width:100%;height:300px;padding:10px;" data-options="iconCls:'icon-save',closable:true,
                collapsible:true,minimizable:true,maximizable:true" closed="true">
        <form id="fm">
            <div class="row" style="width: 100%">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="">Cost Center ID # :</label>
                        <input type="text" class="form-control" name="id_cc_project" id="id_cc_project">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="">Cost Center Name:</label>
                        <!-- <input type="text" name="nama_rekanan" class="easyui-textbox" required="true" style="width: 100%;"> -->
                        <input type="text" class="form-control" name="cc_project_name" id="cc_project_name" required="true" multiline="true">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Cost Center Manager :</label>
                        <Select id="manager" name="manager" class="form-control m-b-10 input-sm">
                            <option value="-">Select CCM</option>
                            <?php
                            foreach ($Employee as $row) {
                                echo '<option value="' . $row["kd_rekanan"] . '">' . $row["nama_rekanan"]  . '</option>';
                            }
                            ?>
                        </Select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Budget :</label>
                        <input class="form-control" type="number" name="budget" id="budget">
                    </div>
                </div>
            </div>


            <br>

            <div class="ftitle"></div>
            <div id="dlg-buttons">
                <a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="saveDatax()">Save</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').panel('close')">Cancel</a>
            </div>

        </form>
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
        $("#dlg").panel('setTitle', 'New Cost Center');
        $('#dlg').panel('open');
        $('#fm').form('clear');
        document.getElementById('id_cc_project').value = '';
        document.getElementById('cc_project_name').value = '';
        document.getElementById('manager').value = '';
        document.getElementById('budget').value = '';


        url = '<?= base_url(); ?>master/Cc_project/appendData/<?= $jenis ?>';
        mode = 'add';
        scrollSmoothToBottom('content')
    }

    function editData() {
        var row = $('#dgMain').datagrid('getSelected');
        if (row) {
            $("#dlg").panel('setTitle', 'Update Cost Center');
            $('#dlg').panel('open');
            //  $('#fm').form('load', row);
            document.getElementById('id_cc_project').value = row.id_cc_project;
            document.getElementById('cc_project_name').value = row.cc_project_name;
            document.getElementById('manager').value = row.manager;
            document.getElementById('budget').value = row.budget;

            // alert(row.nama_rekanan);
            url = '<?= base_url(); ?>master/Cc_project/updateData/' + row.id_cc_project;
            mode = 'edit';
            //            alert(url);
            scrollSmoothToBottom('content')
        }
    }

    function saveDatax() {

        var id_cc_project = $("#id_cc_project").val();
        var cc_project_name = $("#cc_project_name").val();
        var manager = $("#manager").val();
        var budget = $("#budget").val();

        //var xurl = '';
        //alert(xurl);
        $.ajax({
            url: url,
            method: "POST",
            dataType: 'json',
            data: {
                id_cc_project: id_cc_project,
                cc_project_name: cc_project_name,
                manager: manager,
                budget: budget

            },
            error: function() {
                if (mode == 'add') {
                    document.getElementById("addError").click(); // Click on the checkbox
                } else {
                    document.getElementById("editError").click(); // Click on the checkbox
                }
            },
            success: function(data) {
                $('#dgMain').datagrid('reload'); // reload the user data
                $('#dlg').panel('close');
                if (mode == 'add') {
                    document.getElementById("addSuccess").click(); // Click on the checkbox
                } else {
                    document.getElementById("editSuccess").click(); // Click on the checkbox
                }
            }
        });
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
                    url: "<?= base_url(); ?>master/Cc_project/destroyData",
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