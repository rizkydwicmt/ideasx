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

    <div id="container" class="easyui-panel" style="width:100%;height:460px;padding:10px;">
        <table id="dgMain" class="easyui-datagrid" style="width:100%;height:420px;;" url="<?= base_url(); ?>master/Cba/getCba" singleSelect="true" toolbar="#toolbarFilter" striped="true" nowrap="false">

            <thead>
                <tr>
                    <th field="id_rek_gl" width="100">Account ID</th>
                    <th field="descriptions" width="250" align="left">Description</th>
                    <th field="jenis" width="150" align="center">Group</th>
                    <th field="no_acc" width="150" align="center">Account Bank #</th>
                    <th field="id" width="100" align="center">ID</th>
                </tr>
            </thead>
        </table>

        <div id="toolbarFilter" style="padding-left: 10px">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="newData()">New</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editData()">Edit</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onClick="removeData()">Destroy</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="javascript:$('#dgMain').datagrid('reload'); ">Refresh</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
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
                        <label class="control-label">Account ID :<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="id_rek_gl" id="id_rek_gl" />
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label">Account Group</label>
                        <select class="form-control" id="jenis" name="jenis">
                            <option value="KAS" selected>KAS</option>
                            <option value="BANK" selected>BANK</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label valign-top">Account Name <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="descriptions" id="descriptions" rows="2"></textarea>
                    </div>
                </div>

            </div>


            <div class="row" style="width: 100%">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label valign-top">Bank Account # </label>
                        <input type="text" class="form-control" name="no_acc" id="no_acc" />
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label valign-top">ID</label>
                        <input type="text" class="form-control" name="id" id="id" />
                    </div>
                </div>

            </div>



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


<script type="text/javascript">
    //jQuery.noConflict(); // 
    var url;
    var mode;

    function scrollSmoothToBottom(id) {
        var div = document.getElementById(id);
        $('#' + id).animate({
            scrollTop: div.scrollHeight - div.clientHeight
        }, 500);
    }



    function newData() {
        $("#dlg").panel('setTitle', 'New Cash Bank Account');
        $('#dlg').panel('open');
        $('#fm').form('clear');
        document.getElementById('id_rek_gl').value = '';
        document.getElementById('jenis').value = '';
        document.getElementById('descriptions').value = '';
        document.getElementById('no_acc').value = '';
        document.getElementById('id').value = '';

        url = '<?= base_url(); ?>master/Cba/simpanCba';
        mode = 'add';
        scrollSmoothToBottom('content')
    }

    function editData() {
        var row = $('#dgMain').datagrid('getSelected');
        if (row) {
            $("#dlg").panel('setTitle', 'Update Cash Bank Account');
            $('#dlg').panel('open');
            //  $('#fm').form('load', row);
            document.getElementById('id_rek_gl').value = row.id_rek_gl;
            document.getElementById('jenis').value = row.jenis;
            document.getElementById('descriptions').value = row.descriptions;
            document.getElementById('no_acc').value = row.no_acc;
            document.getElementById('id').value = row.id;


            // alert(row.nama_rekanan);
            url = '<?= base_url(); ?>master/Cba/updateCba/' + row.id_rek_gl;
            mode = 'edit';
            //            alert(url);
            scrollSmoothToBottom('content')
        }
    }

    function saveDatax() {

        var id_rek_gl = $("#id_rek_gl").val();
        var jenis = $("#jenis").val();
        var descriptions = $("#descriptions").val();
        var no_acc = $("#no_acc").val();
        var id = $("#id").val();
        $.ajax({
            url: url,
            method: "POST",
            dataType: 'json',
            data: {
                id_rek_gl: id_rek_gl,
                jenis: jenis,
                descriptions: descriptions,
                no_acc: no_acc,
                id: id
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
            //alert(row.id_rek_gl);
            var result = confirm("Are you sure to delete?");
            if (result) {
                // Delete logic goes here
                //alert(row.kd_rekanan);
                $.ajax({
                    url: "<?= base_url(); ?>master/Cba/destroyCba",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        id: row.id_rek_gl
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
</script>