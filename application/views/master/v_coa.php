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
        <table id="dgMain" class="easyui-treegrid" style="width:100%;height:420px;;" url="<?= base_url(); ?>master/Coa/getCoa" singleSelect="true" toolbar="#toolbarFilter" striped="true" nowrap="false" idField="id" treeField="id_rek_gl">

            <thead>
                <tr>
                    <th field="id_rek_gl" width="150">Account ID</th>
                    <th field="nama_rekening" width="250" align="left">Description</th>
                    <th field="detail" align="center">Detail</th>
                    <th field="lvl" align="center">Level</th>
                    <th field="golongan" width="100" align="center">Group</th>
                    <th field="nama_rek_pajak" width="200" align="left">Tax ID</th>
                    <th field="nama_arus_kas" width="200" align="left">Cash Flow ID</th>
                </tr>
            </thead>
        </table>

        <div id="toolbarFilter" style="padding-left: 10px">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="newData()">New</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editData()">Edit</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onClick="removeData()">Destroy</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="javascript:$('#dgMain').treegrid('reload'); ">Refresh</a>
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
                        <label class="control-label">Parent ID <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="id_parent" id="id_parent" />

                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label">Account ID :<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="id_rek_gl" id="id_rek_gl" />
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label">Account Group</label>
                        <select class="form-control" id="golongan">
                            <option value="AKTIVA" selected>AKTIVA</option>
                            <option value="PASIVA" selected>PASIVA</option>
                            <option value="RL" selected>RUGI-LABA</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label valign-top">Account Name <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="nama_rekening" id="nama_rekening" rows="2"></textarea>
                    </div>
                </div>

            </div>


            <div class="row" style="width: 100%">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label valign-top">Tax Account ID</label>
                        <Select id="id_rek_pajak" name="id_rek_pajak" class="form-control m-b-10 input-sm">
                            <option value="">Select Tax Account</option>
                            <?php
                            foreach ($tax as $row) {
                                echo '<option value="' . $row["id_rek_pajak"] . '">'  . $row["nama_rekening"] . '</option>';
                            }
                            ?>
                        </Select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label valign-top">Cash Flow ID</label>
                        <Select id="id_arus" name="id_arus" class="form-control m-b-10 input-sm">
                            <option value="">Select Cash Flow</option>
                            <?php
                            foreach ($cflow as $row) {
                                echo '<option value="' . $row["id_arus"] . '">'  . $row["nama_arus"] . '</option>';
                            }
                            ?>
                        </Select>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label m-b-0">Detail Account</label>
                        <select class="form-control" id="isdetail">
                            <option value="0" selected>No</option>
                            <option value="1" selected>Yes</option>
                        </select>
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
        $("#dlg").panel('setTitle', 'New COA Account');
        $('#dlg').panel('open');
        $('#fm').form('clear');
        document.getElementById('id_rek_gl').value = '';
        document.getElementById('id_parent').value = '';
        document.getElementById('nama_rekening').value = '';
        document.getElementById('golongan').value = '';
        document.getElementById('isdetail').value = '0';
        document.getElementById('id_rek_pajak').value = '';
        document.getElementById('id_arus').value = '';

        url = '<?= base_url(); ?>master/Coa/simpanCoa';
        mode = 'add';
        scrollSmoothToBottom('content')
    }

    function editData() {
        var row = $('#dgMain').datagrid('getSelected');
        if (row) {
            $("#dlg").panel('setTitle', 'Update Chart Of Account');
            $('#dlg').panel('open');
            //  $('#fm').form('load', row);
            document.getElementById('id_rek_gl').value = row.id_rek_gl;
            document.getElementById('id_parent').value = row.id_parent;
            document.getElementById('nama_rekening').value = row.nama_rekening;
            document.getElementById('golongan').value = row.golongan;
            document.getElementById('id_rek_pajak').value = row.id_rek_pajak;
            document.getElementById('id_arus').value = row.id_arus;
            document.getElementById('isdetail').value = row.isdetail;


            // alert(row.nama_rekanan);
            url = '<?= base_url(); ?>master/Coa/updateCoa/' + row.id_rek_gl;
            mode = 'edit';
            //            alert(url);
            scrollSmoothToBottom('content')
        }
    }

    function saveDatax() {

        var id_rek_gl = $("#id_rek_gl").val();
        var id_parent = $("#id_parent").val();
        var golongan = $("#golongan").val();
        var nama_rekening = $("#nama_rekening").val();
        var id_rek_pajak = $("#id_rek_pajak").val();
        var id_arus = $("#id_arus").val();
        var isdetail = $("#isdetail").val();

        $.ajax({
            url: url,
            method: "POST",
            dataType: 'json',
            data: {
                id_rek_gl: id_rek_gl,
                id_parent: id_parent,
                nama_rekening: nama_rekening,
                golongan: golongan,
                id_rek_pajak: id_rek_pajak,
                id_arus: id_arus,
                isdetail: isdetail
            },
            error: function() {
                if (mode == 'add') {
                    document.getElementById("addError").click(); // Click on the checkbox
                } else {
                    document.getElementById("editError").click(); // Click on the checkbox
                }
            },
            success: function(data) {
                $('#dgMain').treegrid('reload'); // reload the user data
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
        var row = $('#dgMain').treegrid('getSelected');
        if (row) {
            //alert(row.id_rek_gl);
            var result = confirm("Are you sure to delete?");
            if (result) {
                // Delete logic goes here
                //alert(row.kd_rekanan);
                $.ajax({
                    url: "<?= base_url(); ?>master/Coa/destroyCoa",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        id: row.id_rek_gl
                    },
                    error: function() {

                        document.getElementById("delError").click(); // Click on the checkbox
                    },
                    success: function(data) {
                        $('#dgMain').treegrid('reload'); // reload the user data
                        document.getElementById("delSuccess").click(); // Click on the checkbox;
                    }
                });
            }
        }
    }
</script>