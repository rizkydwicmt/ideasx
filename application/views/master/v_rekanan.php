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
        <?= strtoupper($tittle) ?> | <small>This form contain <?= $tittle; ?> data...</small>
    </h1>
    <!-- END page-header -->

    <div id="container" class="easyui-panel" style="width:100%;height:450px;padding:10px;">
        <table id="dgMain" class="easyui-datagrid" style="width:100%;height:400px;;" 
        url="<?= base_url(); ?>master/Rekanan/getRekanan/<?= $jnsRekanan ?>" singleSelect="true" 
        rownumbers="true" fitColumns="true" nowrap="false" striped="true" pagination="true" toolbar="#toolbarFilter">
            <thead>
                <tr>
                    <th field="kd_rekanan" width=80>ID</th>
                    <th field="nama_rekanan" width=250 align=left>Name</th>
                    <th field="alamat" width=400 align=left>Address</th>
                    <th field="kota" width=100 align=left>City</th>
                    <th field="telephone" width="100">Phone</th>
                    <th field="faxcimile" width="100" align=left>Faxcimile</th>
                    <th field="contact" width="150" align=left>Contact Name</th>
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
                        <label for="">Name:</label>
                        <!-- <input type="text" name="nama_rekanan" class="easyui-textbox" required="true" style="width: 100%;"> -->
                        <input type="text" name="nama_rekanan" id="nama_rekanan" required="true" style="width: 100%;" value="">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Contact:</label>
                        <input type="text" name="contact" id="contact" required="true" style="width: 100%;">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="">Address Line:</label>
                        <input type="text" name="alamat" id="alamat" required="true" style="width: 100%;">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="">City:</label>
                        <input type="text" name="kota" id="kota" style="width: 100%">
                    </div>
                </div>
            </div>

            <div class="row" style="width: 100%">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Phone:</label>
                        <input type="text" name="telephone" id="telephone" style="width: 100%;">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Fax:</label>
                        <input type="text" name="faxcimile" id="faxcimile" style="width: 100%;">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>e-mail:</label>
                        <input type="text" name="email" id="email" style="width: 100%;">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Mobile:</label>
                        <input type="text" name="mobile_no" id="mobile_no" style="width: 100%;">
                    </div>
                </div>
            </div>
            <div class="row" style="width: 100%">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>NPWP:</label>
                        <input type="text" name="npwp" id="npwp" style="width: 100%;">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>NPPKP:</label>
                        <input type="text" name="nppkp" id="nppkp" style="width: 100%;">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Remarks:</label>
                        <input type="text" name="remarks" id="remarks" multiline="true" style="width: 100%;">
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
    $(function() {
        doSearch();
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

    function newData() {
        $("#dlg").panel('setTitle', 'New <?= $jnsRekanan ?>');
        $('#dlg').panel('open');
        $('#fm').form('clear');
        document.getElementById('nama_rekanan').value = '';
        document.getElementById('contact').value = '';
        document.getElementById('alamat').value = '';
        document.getElementById('kota').value = '';
        document.getElementById('telephone').value = '';
        document.getElementById('faxcimile').value = '';
        document.getElementById('email').value = '';
        document.getElementById('mobile_no').value = '';
        document.getElementById('npwp').value = '';
        document.getElementById('nppkp').value = '';
        document.getElementById('remarks').value = '';


        url = '<?= base_url(); ?>master/Rekanan/simpanRekanan/<?= $jnsRekanan ?>';
        mode = 'add';
        scrollSmoothToBottom('content')
    }

    function editData() {
        var row = $('#dgMain').datagrid('getSelected');
        if (row) {
            $("#dlg").panel('setTitle', 'Update <?= $jnsRekanan ?>');
            $('#dlg').panel('open');
            //  $('#fm').form('load', row);
            document.getElementById('nama_rekanan').value = row.nama_rekanan;
            document.getElementById('contact').value = row.contact;
            document.getElementById('alamat').value = row.alamat;
            document.getElementById('kota').value = row.kota;
            document.getElementById('telephone').value = row.telephone;
            document.getElementById('faxcimile').value = row.faxcimile;
            document.getElementById('email').value = row.email;
            document.getElementById('mobile_no').value = row.mobile_no;
            document.getElementById('npwp').value = row.npwp;
            document.getElementById('nppkp').value = row.nppkp;
            document.getElementById('remarks').value = row.remarks;

            // alert(row.nama_rekanan);
            url = '<?= base_url(); ?>master/Rekanan/updateRekanan/' + row.kd_rekanan;
            mode = 'edit';
            //            alert(url);
            scrollSmoothToBottom('content')
        }
    }

    function saveDatax() {

        var nama_rekanan = $("#nama_rekanan").val();
        var kontak = $("#contact").val();
        var alamat = $("#alamat").val();
        var kota = $("#kota").val();
        var telephone = $("#telephone").val();
        var faxcimile = $("#faxcimile").val();
        var email = $("#email").val();
        var mobile_no = $("#mobile_no").val();
        var npwp = $("#npwp").val();
        var nppkp = $("#nppkp").val();
        var remarks = $("#remarks").val();
        //var xurl = '';
        //alert(xurl);
        $.ajax({
            url: url,
            method: "POST",
            dataType: 'json',
            data: {
                nama_rekanan: nama_rekanan,
                kontak: kontak,
                alamat: alamat,
                kota: kota,
                telephone: telephone,
                faxcimile: faxcimile,
                email: email,
                mobile_no: mobile_no,
                npwp: npwp,
                nppkp: nppkp,
                remarks: remarks

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
                    url: "<?= base_url(); ?>master/Rekanan/destroyRekanan",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        id: row.kd_rekanan
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