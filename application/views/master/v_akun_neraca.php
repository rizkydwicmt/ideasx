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
        <table style="width:100%;height:auto">
            <tr style="width: 100%;">
                <td style="width:50%;">
                    <table id="dgMain" class="easyui-datagrid" style="width:100%;height:420px;;" url="<?= base_url(); ?>master/Makun/getMAkunNeraca" singleSelect="true" toolbar="#toolbarFilter" striped="true" nowrap="false" rownumbers="true" pagination="false">

                        <thead>
                            <tr>
                                <th field="id_rek_neraca" width="70">Account ID</th>
                                <th field="diskripsi" width="200" align="left">Descriptions</th>
                                <th field="jenis" width="180" align="left">Category</th>
                            </tr>
                        </thead>
                    </table>
                </td>
                <td style="width: 50%;">
                    <table id="dgDetail" class="easyui-datagrid" style="width:auto;height:420px;" url="<?= base_url(); ?>master/Makun/getDAkunNeraca" toolbar="#toolbarDetil" singleSelect="true" title="Detail Account" rownumbers="true" striped="true">
                        <thead>
                            <tr>
                                <th field="id_rek_gl" width="100">Account ID</th>
                                <th field="descriptions" width="250">Description</th>
                                <th field="lvl" align="center">Lvl</th>
                                <th field="golongan" align="center" width="100">Category</th>
                            </tr>
                        </thead>
                    </table>
                </td>
            </tr>
        </table>

        <div id="toolbarFilter" style="padding-left: 10px">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="newData()">New</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editData()">Edit</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onClick="removeData()">Destroy</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="javascript:$('#dgMain').datagrid('reload'); ">Refresh</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
        </div>

        <div id="toolbarDetil" style="padding:3px">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newDetail()">New</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deleteDetail()">Destroy</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="javascript:$('#dgDetail').datagrid('reload'); ">Refresh</a>
        </div>
    </div>


    <!-- Modal -->
    <br>
    <div id="dlg2" class="easyui-panel" title="" style="width:100%;height:600px;padding:10px;" data-options="iconCls:'icon-save',closable:true,
                collapsible:true,minimizable:true,maximizable:true" closed="true">

        <form id="fm">

            <table id="dgCoa" title="Select Account" class="easyui-datagrid" style="width:100%;height:500px" idField="id_rek_gl" pagination="false" iconCls="icon-save">
                <thead>
                    <tr>
                        <th field="ck" checkbox="true"></th>
                        <th field="id_rek_gl" width="100">Account ID</th>
                        <th field="descriptions" width="300">Description</th>
                        <th field="golongan" width="100">Category</th>
                    </tr>
                </thead>
            </table>
            <div class="ftitle"></div>
            <br>
            <div id="dlg2-buttons">
                <a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="saveDatad()">Save</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg2').panel('close')">Cancel</a>
            </div>

        </form>
    </div>

    <!-- END #content -->

    <br>
    <div id="dlg" class="easyui-panel" title="" style="width:100%;height:200px;padding:10px;" data-options="iconCls:'icon-save',closable:true,
                collapsible:true,minimizable:true,maximizable:true" closed="true">

        <form id="fm">
            <div class="row" style="width: 100%">

                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label">Account ID<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="id_rek_neraca" id="id_rek_neraca" />
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label valign-top">Description<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="diskripsi" id="diskripsi" />
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label valign-top">Category <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="jenis" id="jenis" />
                    </div>
                </div>

            </div>


            <div class="ftitle">
                </>
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


<!-- Modal 2 -->

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
    var urld;
    var mode;

    $(function() {
        $('#dgMain').datagrid({
            onClickRow: function() {
                var row = $('#dgMain').datagrid('getSelected');
                $('#dgDetail').datagrid('load', {
                    id: row.id_rek_neraca
                });
            }
        });

    });


    function scrollSmoothToBottom(id) {
        var div = document.getElementById(id);
        $('#' + id).animate({
            scrollTop: div.scrollHeight - div.clientHeight
        }, 500);
    }



    function newData() {
        $("#dlg").panel('setTitle', 'New Account');
        $('#dlg').panel('open');
        $('#fm').form('clear');
        document.getElementById('id_rek_neraca').value = '';
        document.getElementById('diskripsi').value = '';
        document.getElementById('jenis').value = '';

        url = '<?= base_url(); ?>master/Makun/simpanData';
        mode = 'add';
        scrollSmoothToBottom('content')
    }

    function editData() {
        var row = $('#dgMain').datagrid('getSelected');
        if (row) {
            $("#dlg").panel('setTitle', 'Update Account');
            $('#dlg').panel('open');
            //  $('#fm').form('load', row);
            document.getElementById('id_rek_neraca').value = row.id_rek_neraca;
            document.getElementById('diskripsi').value = row.diskripsi;
            document.getElementById('jenis').value = row.jenis;


            // alert(row.nama_rekanan);
            url = '<?= base_url(); ?>master/Makun/updateData/' + row.id_rek_neraca;
            mode = 'edit';
            //            alert(url);
            scrollSmoothToBottom('content')
        }
    }

    function saveDatax() {

        var id_rek_neraca = $("#id_rek_neraca").val();
        var diskripsi = $("#diskripsi").val();
        var jenis = $("#jenis").val();


        var master = [];
        master.push({
            id_rek_neraca: id_rek_neraca,
            diskripsi: diskripsi,
            jenis: jenis
        });


        $.ajax({
            url: url,
            type: "POST",
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
                    url: "<?= base_url(); ?>master/Makun/destroyData",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        id: row.id_rek_neraca
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


    function newDetail() {
        var row = $('#dgMain').datagrid('getSelected');
        if (row) {

            $('#dgCoa').datagrid({
                url: "<?= base_url(); ?>master/Makun/getCoa/" + row.id_rek_neraca
            });

            $("#dlg2").panel('setTitle', 'Select Account' + row.diskripsi);
            $('#dlg2').panel('open');
            scrollSmoothToBottom('content');

        }
    }

    function saveDatad() {
        var row = $('#dgMain').datagrid('getSelected');
        if (row) {
            var id_neraca = row.id_rek_neraca
        }

        var ss = [];
        var rows = $('#dgCoa').datagrid('getSelections');
        for (var i = 0; i < rows.length; i++) {
            ss.push({
                id_rek_gl: rows[i].id_rek_gl,
                golongan: rows[i].golongan
            });
        }


        $.ajax({
            url: "<?= base_url(); ?>master/Makun/insertDetail/" + id_neraca,
            method: "POST",
            dataType: 'json',
            data: {
                info: ss
            },
            error: function() {
                document.getElementById("addError").click(); // Click on the checkbox
            },
            success: function(data) {
                $('#dgDetail').datagrid('reload'); // reload the user data
                $('#dlg2').panel('close');
                document.getElementById("addSuccess").click(); // Click on the checkbox
            }
        });


    }

    function deleteDetail() {
        var row = $('#dgDetail').datagrid('getSelected');
        if (row) {
            //alert(row.id_rek_gl);
            var result = confirm("Are you sure to unSelect?");
            if (result) {
                // Delete logic goes here
                //alert(row.kd_rekanan);
                $.ajax({
                    url: "<?= base_url(); ?>master/Makun/destroyDetail",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        id: row.id_rek_gl
                    },
                    error: function() {

                        document.getElementById("delError").click(); // Click on the checkbox
                    },
                    success: function(data) {
                        $('#dgDetail').datagrid('reload'); // reload the user data
                        document.getElementById("delSuccess").click(); // Click on the checkbox;
                    }
                });
            }
        }
    }
</script>