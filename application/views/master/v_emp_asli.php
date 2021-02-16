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
        <table id="dgMain" class="easyui-datagrid" style="width:100%;height:420px;;" url="<?= base_url(); ?>master/Emp/getEmp" singleSelect="true" pagination="true" toolbar="#toolbarFilter" striped="true" nowrap="false">

            <thead>
                <tr>
                    <th field="nk" width="80">Employee ID</th>
                    <th field="initial" width="80">Initial</th>
                    <th field="full_name" width="150" align="left">Full Name</th>
                    <th field="department" width="200" align="left">Department</th>
                    <th field="jabatan" width="150" align="left">Position</th>
                    <th field="address" width="150" align="left">Address</th>
                    <th field="kota" width="100" align="left">City</th>
                    <th field="phone1" width="100" align="center">Cell Phone</th>
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
    <div id="dlg" class="easyui-panel" title="Supplier" style="width:100%;height:350px;padding:10px;" data-options="iconCls:'icon-save',closable:true,
                collapsible:true,minimizable:true,maximizable:true" closed="true">

        <form id="fm">
            <div class="row">
                <div class="col-md-2">
                    <label class="control-label valign-top">Employee ID<span class="text-danger">*</span></label>
                    <input class="form-control m-b-10 input-sm" name="nk" id="nk" />


                    <label style="width: 130px">Gender<span class="text-danger">*</span></label>
                    <select id="gender" name="gender" class="form-control m-b-10 input-sm">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>

                    <label style="width: 130px">Joint Date<span class="text-danger">*</span></label>
                    <input id="join_date_char" name="join_date_char" class="form-control m-b-10 input-sm" />

                    <label class="control-label valign-top">Bank Account #<span class="text-danger">*</span></label>
                    <input class="form-control m-b-10 input-sm" name="bank_account" id="bank_account" />

                </div>

                <div class="col-md-2">
                    <label class="control-label valign-top">Initial<span class="text-danger">*</span></label>
                    <input class="form-control m-b-10 input-sm" name="initial" id="initial" />

                    <label style="width: 130px">Religion<span class="text-danger">*</span></label>
                    <select id="religion" name="religion" class="form-control m-b-10 input-sm">
                        <option value="">Select Religion</option>
                        <option value="Moslem">Moslem</option>
                        <option value="Christian">Christian</option>
                        <option value="Chatolic">Chatolic</option>
                        <option value="Hinduism">Hinduism</option>
                        <option value="Budhist">Budhist</option>
                    </select>

                    <label style="width: 130px">Resign Date<span class="text-danger">*</></label>
                    <input id="dt_hire_char" name="dt_hire_char" class="form-control m-b-10 input-sm" />

                    <label class="control-label valign-top">Bank Office<span class="text-danger">*</span></label>
                    <input class="form-control m-b-10 input-sm" name="bank_cabang" id="bank_cabang" />


                </div>
                <div class="col-md-4">
                    <label class="control-label">Full Name <span class="text-danger">*</span></label>
                    <input class="form-control m-b-10 input-sm" name="full_name" id="full_name" />
                    <label class="control-label valign-center">Address<span class="text-danger">*</span></label>
                    <input class="form-control m-b-10 input-sm" name="address" id="address" />

                    <label class="control-label">Departement #<span class="text-danger">*</span></label>
                    <Select id="kd_divisi" name="kd_divisi" class="form-control m-b-10 input-sm">
                        <option value="">Select Departement</option>
                        <?php
                        foreach ($divisi as $row) {
                            echo '<option value="' . $row["kd_divisi"] . '">'  . $row["deskripsi"] . '</option>';
                        }
                        ?>
                    </Select>

                    <label class="control-label valign-top">Bank Name<span class="text-danger">*</span></label>
                    <input class="form-control m-b-10 input-sm" name="bank" id="bank" />
                </div>
                <div class="col-md-2">
                    <label style="width: 130px">Date Of Birth<span class="text-danger">*</span></label>
                    <input id="dt_birth_char" name="dt_birth_char" class="form-control m-b-10 input-sm" />
                    <label style="width: 130px">City<span class="text-danger">*</span></label>
                    <input id="kota" name="kota" class="form-control m-b-10 input-sm" />

                    <label class="control-label valign-center">Position<span class="text-danger">*</span></label>
                    <input class="form-control m-b-10 input-sm" name="jabatan" id="jabatan" />

                    <label style="width: 130px">Is Active ?<span class="text-danger">*</span></label>
                    <select id="isactive" name="isactive" class="form-control m-b-10 input-sm">
                        <option value="">Select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>

                </div>
                <div class="col-md-2">


                    <label style="width: 130px">Place Of Birth<span class="text-danger">*</span></label>
                    <input id="birth_place" name="birth_place" class="form-control m-b-10 input-sm" />
                    <label style="width: 130px">Cell Phone<span class="text-danger">*</span></label>
                    <input id="phone1" name="phone1" class="form-control m-b-10 input-sm" />


                    <label style="width: 130px">Status<span class="text-danger">*</span></label>
                    <select id="status_karyawan" name="status_karyawan" class="form-control m-b-10 input-sm">
                        <option value="">Select Status</option>
                        <option value="Tetap">Tetap</option>
                        <option value="Project">Project</option>
                        <option value="Kontrak">Kontrak</option>
                    </select>
                </div>

            </div>

            <div class="ftitle"></div>
            <br>
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
        $("#dt_birth_char").datepicker({
            changeMonth: true,
            changeYear: true,
            gotoCurrent: true
        });
        $("#dt_birth_char").datepicker("option", "dateFormat", "dd/mm/yy");

        $("#join_date_char").datepicker({
            changeMonth: true,
            changeYear: true,
            gotoCurrent: true
        });
        $("#join_date_char").datepicker("option", "dateFormat", "dd/mm/yy");

        $("#dt_hire_char").datepicker({
            changeMonth: true,
            changeYear: true,
            gotoCurrent: true
        });
        $("#dt_hire_char").datepicker("option", "dateFormat", "dd/mm/yy");
    });

    function scrollSmoothToBottom(id) {
        var div = document.getElementById(id);
        $('#' + id).animate({
            scrollTop: div.scrollHeight - div.clientHeight
        }, 500);
    }



    function newData() {
        $("#dlg").panel('setTitle', 'New Employee Data');
        $('#dlg').panel('open');
        $('#fm').form('clear');
        document.getElementById('nk').value = '';
        document.getElementById('initial').value = '';
        document.getElementById('full_name').value = '';
        document.getElementById('religion').value = '';
        document.getElementById('birth_place').value = '';
        document.getElementById('gender').value = '';
        document.getElementById('address').value = '';
        document.getElementById('kota').value = '';
        document.getElementById('phone1').value = '';


        document.getElementById('kd_divisi').value = '';
        document.getElementById('jabatan').value = '';
        document.getElementById('status_karyawan').value = '';

        document.getElementById('bank').value = '';
        document.getElementById('bank_account').value = '';
        document.getElementById('bank_cabang').value = '';
        document.getElementById('isactive').value = '1';



        document.getElementById('dt_birth_char').value = '';
        document.getElementById('join_date_char').value = '';
        document.getElementById('dt_hire_char').value = '';

        url = '<?= base_url(); ?>master/Emp/simpanEmp';
        mode = 'add';
        scrollSmoothToBottom('content')
    }

    function editData() {
        var row = $('#dgMain').datagrid('getSelected');
        if (row) {
            $("#dlg").panel('setTitle', 'Update Employee Data');
            $('#dlg').panel('open');
            //  $('#fm').form('load', row);
            document.getElementById('nk').value = row.nk;
            document.getElementById('initial').value = row.initial;
            document.getElementById('full_name').value = row.full_name;


            document.getElementById('religion').value = row.religion;
            document.getElementById('birth_place').value = row.birth_place;
            document.getElementById('gender').value = row.gender;
            document.getElementById('address').value = row.address;
            document.getElementById('kota').value = row.kota;
            document.getElementById('phone1').value = row.phone1;


            document.getElementById('kd_divisi').value = row.kd_divisi;
            document.getElementById('jabatan').value = row.jabatan;
            document.getElementById('status_karyawan').value = row.status_karyawan;

            document.getElementById('bank').value = row.bank;
            document.getElementById('bank_account').value = row.bank_account;
            document.getElementById('bank_cabang').value = row.bank_cabang;
            document.getElementById('isactive').value = row.isactive;

            document.getElementById('join_date_char').value = row.join_date_char;
            document.getElementById('dt_birth_char').value = row.dt_birth_char;
            document.getElementById('dt_hire_char').value = row.dt_hire_char;


            // alert(row.nama_rekanan);
            url = '<?= base_url(); ?>master/Emp/updateEmp/' + row.nk;
            mode = 'edit';
            //            alert(url);
            scrollSmoothToBottom('content')
        }
    }

    function saveDatax() {

        var nk = $("#nk").val();
        var initial = $("#initial").val();
        var full_name = $("#full_name").val();
        var religion = $("#religion").val();
        var birth_place = $("#birth_place").val();
        var gender = $("#gender").val();

        var address = $("#address").val();
        var kota = $("#kota").val();
        var phone1 = $("#phone1").val();
        var kd_divisi = $("#kd_divisi").val();
        var jabatan = $("#jabatan").val();
        var status_karyawan = $("#status_karyawan").val();


        var bank = $("#bank").val();
        var bank_account = $("#bank_account").val();
        var bank_cabang = $("#bank_cabang").val();
        var isactive = $("#isactive").val();

        var join_date = $("#join_date_char").val();
        var dt_birth = $("#dt_birth_char").val();
        var dt_hire = $("#dt_hire_char").val();

        var master = [];

        master.push({
            nk: nk,
            initial: initial,
            full_name: full_name,
            gender: gender,
            address: address,
            kota: kota,
            phone1: phone1,
            religion: religion,
            birth_place: birth_place,
            kd_divisi: kd_divisi,
            jabatan: jabatan,
            status_karyawan: status_karyawan,
            bank: bank,
            bank_account: bank_account,
            bank_cabang: bank_cabang,
            isactive: isactive,
            join_date: join_date,
            dt_birth: dt_birth,
            dt_hire: dt_hire
        });



        $.ajax({
            url: url,
            method: "POST",
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
                    url: "<?= base_url(); ?>master/Emp/destroyEmp",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        id: row.nk
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