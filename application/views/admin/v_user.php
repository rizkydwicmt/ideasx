<!-- BEGIN #content -->
<div id="content" class="content">
    <!-- BEGIN breadcrumb -->
    <ul class="breadcrumb">
        <!--
        <li class="breadcrumb-item"><a href="#">LAYOUT</a></li>
        <li class="breadcrumb-item active">STARTER PAGE</li>-->
        <li class="breadcrumb-item"><a href="#">Administrator</a></li>
        <li class="breadcrumb-item active"><?= $tittle ?></li>
    </ul>
    <!-- END breadcrumb -->

    <!-- BEGIN page-header -->
    <h1 class="page-header">
        <?= $tittle ?> | <small>This form contain <?= $tittle ?> data...</small>
    </h1>
    <!-- END page-header -->

    <div class="panel-body" style="width:100%;height:50px;padding-top:10px;padding-left:10px;">
        <span>Filter :</span>
        <select id="tipe_user" name="tipe_user">
            <option value="0" selected>Template</option>
            <option value="2" selected>User</option>
        </select>
        <input id="filterVal" onkeyup="inputKeyEnter(event)" style="border:1px solid #ccc">
        <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearch()">Search</a>
    </div>


    <br>


    <table id="dgMain" class="easyui-datagrid" style="width:95%;height:420px;;" 
    url="<?= base_url(); ?>admin/User/getUser" singleSelect="true" toolbar="#toolbarFilter" 
    fitColumns="true" striped="true" nowrap="false" rownumbers="true" pagination="true">

        <thead>
            <tr>
                <th field="vuser" width="80">User ID</th>
                <th field="nk" width="80">User NK</th>
                <th field="full_name" width="250" align="left">Full Name</th>
                <th field="jabatan" width="200" align="left">User Position</th>
                <th field="email" width="150" align="left">e-mail</th>
                <th field="tipe" width="50" align="center">Theme</th>
                <th field="user_role" width="100" align="center">Role</th>
                <th field="is_active" width="50" align="center">Active</th>
            </tr>
        </thead>
    </table>
    <br>


    <div id="toolbarFilter" style="padding-left: 10px">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="newData()">New</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editData()">Edit</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onClick="removeData()">Destroy</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="javascript:$('#dgMain').datagrid('reload'); ">Refresh</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
    </div>

    <div id="tbd" style="padding:3px">
        <a id="edit" href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editDetail()">Update</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="javascript:$('#dgDetail').datagrid('reload'); ">Refresh</a>
    </div>

    <div id="detail">
        <table id="dgDetail" class="easyui-datagrid" style="width:95%;height:auto;" url="<?= base_url(); ?>admin/User/getDetail" toolbar="#tbd" singleSelect="true" title="Detail Tipe Menu" rownumbers="true" striped="true">
            <thead>
                <tr>
                    <th field="imenu" width="70">Menu ID</th>
                    <th field="nama_menu" width="350">Menu Name</th>
                    <th field="lvl" align="center">Lvl</th>
                    <th field="hbrowse" align="center" styler=cellStyler>Browse</th>
                    <th field="hinsert" align="center" styler=cellStyler>Insert</th>
                    <th field="hedit" align="center" styler=cellStyler>Edit</th>
                    <th field="hdelete" align="center" styler=cellStyler>Delete</th>
                    <th field="hprint" align="center" styler=cellStyler>Print</th>
                </tr>
            </thead>
        </table>
    </div>


    <!-- Modal -->
    <br>


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
    var mode;

    $(function() {
        $('#dgMain').datagrid({
            onDblClickRow: function() {
                var row = $('#dgMain').datagrid('getSelected');
                $('#dgDetail').datagrid('load', {
                    id: row.vuser
                });
                scrollSmoothToBottom('content')
            }
        });

        document.getElementById('tipe_user').value = <?= $tuser ?>;
        doSearch();
    });

    function inputKeyEnter(e) {
        e.which = e.which || e.keyCode;
        if (e.which == 13) {
            doSearch();
        }
    }

    function doSearch() {

        $('#dgMain').datagrid('load', {
            tipe_user: $("#tipe_user").val(),
            searching: $('#filterVal').val()
        });
    }

    function cellStyler(value, row, index) {
        if (value == 'n') {
            return 'background-color:#ffee00;color:red;';
        }
    }

    function scrollSmoothToBottom(id) {
        var div = document.getElementById(id);
        $('#' + id).animate({
            scrollTop: div.scrollHeight - div.clientHeight
        }, 500);
    }



    function newData() {
        var tu = $("#tipe_user").val();
        $.ajax({
            url: "<?= base_url(); ?>admin/User/newUser",
            method: "POST",
            dataType: 'json',
            data: {
                tu: tu
            },
            error: function() {
                document.getElementById("addError").click();
            },
            success: function(data) {
                window.open('<?= base_url(); ?>admin/User/loadUser', '_self');
            }
        });

    }

    function editData() {
        var row = $('#dgMain').datagrid('getSelected');
        var tu = $("#tipe_user").val();
        $.ajax({
            url: "<?= base_url(); ?>admin/User/editUser",
            method: "POST",
            dataType: 'json',
            data: {
                id: row.vuser,
                tu: tu
            },
            error: function() {
                document.getElementById("editError").click(); // Click on the checkbox
            },
            success: function(data) {
                //myAppendGrid.load(data);
                //document.getElementById("addSuccess").click(); // Click on the checkbox
                window.open('<?= base_url(); ?>admin/User/loadUser', '_self');
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
                    url: "<?= base_url(); ?>admin/User/destroyUser",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        id: row.vuser
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