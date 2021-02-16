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
        <table id="dgMain" class="easyui-treegrid" style="width:100%;height:420px;;" url="<?= base_url(); ?>master/Divisi/getDivisi" singleSelect="true" toolbar="#toolbarFilter" striped="true" nowrap="false" idField="id" treeField="kd_divisi">

            <thead>
                <tr>
                    <th field="kd_divisi" width="150">Departement ID</th>
                    <th field="deskripsi" width="250" align="left">Description</th>
                    <th field="isdetail" align="center">Detail</th>
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
                        <label class="control-label">Group ID <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="kd_parent" id="kd_parent" />

                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label">Departement ID :<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="kd_divisi" id="kd_divisi" />
                    </div>
                </div>


            </div>


            <div class="row" style="width: 100%">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label valign-top">Departement Name <span class="text-danger">*</span></label>
                        <input class="form-control" name="deskripsi" id="deskripsi" rows="2"></input>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="control-label valign-top">Detail</label>
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
        $("#dlg").panel('setTitle', 'New Departement');
        $('#dlg').panel('open');
        $('#fm').form('clear');
        document.getElementById('kd_divisi').value = '';
        document.getElementById('kd_parent').value = '';
        document.getElementById('deskripsi').value = '';
        document.getElementById('isdetail').value = '0';

        url = '<?= base_url(); ?>master/Divisi/simpanDivisi';
        mode = 'add';
        scrollSmoothToBottom('content')
    }

    function editData() {
        var row = $('#dgMain').datagrid('getSelected');
        if (row) {
            $("#dlg").panel('setTitle', 'Update Department');
            $('#dlg').panel('open');
            //  $('#fm').form('load', row);
            document.getElementById('kd_divisi').value = row.kd_divisi;
            document.getElementById('kd_parent').value = row.kd_parent;
            document.getElementById('deskripsi').value = row.deskripsi;
            document.getElementById('isdetail').value = row.isdetail;



            // alert(row.nama_rekanan);
            url = '<?= base_url(); ?>master/Divisi/updateDivisi/' + row.kd_divisi;
            mode = 'edit';
            //            alert(url);
            scrollSmoothToBottom('content')
        }
    }

    function saveDatax() {

        var kd_divisi = $("#kd_divisi").val();
        var kd_parent = $("#kd_parent").val();
        var deskripsi = $("#deskripsi").val();
        var isdetail = $("#isdetail").val();

        if (kd_divisi == '') {
            kd_divisi = '0'
        }


        $.ajax({
            url: url,
            method: "POST",
            dataType: 'json',
            data: {
                kd_divisi: kd_divisi,
                kd_parent: kd_parent,
                deskripsi: deskripsi,
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
                    url: "<?= base_url(); ?>master/Divisi/destroyDivisi",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        id: row.kd_divisi
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