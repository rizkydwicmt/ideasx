<!-- BEGIN #content -->
<div id="content" class="content">
    <!-- BEGIN breadcrumb -->
    <ul class="breadcrumb">
        <!--
        <li class="breadcrumb-item"><a href="#">LAYOUT</a></li>
        <li class="breadcrumb-item active">STARTER PAGE</li>-->
        <li class="breadcrumb-item"><a href="#">Accounting</a></li>
        <li class="breadcrumb-item active">Memorial</li>
    </ul>
    <!-- END breadcrumb -->

    <!-- BEGIN page-header -->
    <h1 class="page-header">
        Memorial <small>This form contain general memorial data...</small>
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


    <br>

    <div id="container" class="panel-body" style="width:100%;height:500px;padding:10px;">
        <table id="dgMain" class="easyui-datagrid" style="width:100%;height:460px;;" url="<?= base_url(); ?>Memorial/getMemorial" singleSelect="true" rownumbers="true" pagination="true" toolbar="#toolbarFilter">
            <thead>
                <tr>
                    <th field="id_jurnal" width=50>Index</th>
                    <th field="no_jurnal" width=120>Memorial Number</th>
                    <th field="dt_jurnal" width=100>Date</th>
                    <th field="nama_rekanan" width=250 allign="left">Vendor</th>
                    <th field="remark" width=350 allign="left">Remarks</th>
                    <th field="debet" width=100 allign="right">Total</th>
                    <th field="ispost" width="50">Posted</th>
                    <th field="iscancel" width="50" allign="center">Cancel</th>
                    <th field="usr_ins" width="80" allign="left">User Insert</th>
                    <th field="usr_upd" width="90" allign="left">User Update</th>
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
    <div id="dlg" class="easyui-panel" title="Supplier" style="width:100%;height:600px;padding:10px;" data-options="iconCls:'icon-save',closable:true,
                collapsible:true,minimizable:true,maximizable:true" closed="true">

        <form id="fm">
            <table class="table m-b-0">

                <tr>
                    <td><label style="width: 130px">Index # :</label></td>
                    <td><input id="id_jurnal" name="id_jurnal" class="form-control" readonly="true"></td>

                    <td><label style="width: 130px">Currency :</label></td>
                    <td><input id="id_kurs" name="id_kurs" class="form-control"></td>

                    <td><label style="width: 130px">ID Vendor :</label></td>
                    <!-- <td> <input id="kd_rekanan" name="kd_rekanan" class="form-control"></td>-->
                    <td> <Select id="kd_rekanan" name="kd_rekanan" class="form-control">
                            <option value="">Select Vendor</option>
                        </Select>
                    </td>
                    <td rowspan="4"><label style="width: 130px;" allign="top">Remarks :</label></td>
                    <td rowspan="4"><input id="remarks" name="remarks" class="form-control" rows="4"></td>

                <tr>

                    <td><label style="width: 130px">Memorial # :</label></td>
                    <td><input id="no_jurnal" name="no_jurnal" class="form-control" readonly="true"></td>

                    <td><label style="width: 130px">Rate :</label></td>
                    <td><input id="kurs" name="kurs" class="form-control"> </td>


                    <td><label style="width: 130px">Vendor Name :</label></td>
                    <td><input id="nama_rekanan" name="nama_rekanan" class="form-control" readonly="true"></td>



                </tr>
                <tr>
                    <td><label class="control-label">Date <span class="text-danger">*</span></label></td>
                    <td><input id="dt_jurnal" name="dt_jurnal" class="form-control"> </td>

                    <td><label style="width: 130px">Due Date :</label></td>
                    <td><input id="dt_jth_tempo" name="dt_jth_tempo" class="form-control"></td>

                    <td><label style="width: 130px">Position :</label></td>
                    <td><input id="jenis" name="jenis" class="form-control" readonly="true"> </td>


                </tr>
            </table>
            <!-- BEGIN #detail -->
            <div class="container-fluid">
                <table id="tblAppendGrid"></table>
                <hr />
                <button id="load" type="button" class="btn btn-primary">Load Data</button>
            </div>

            <!--AppendGrid table element-->
            <table id="tblAppendGrid"></table>
            <!--JS required for Bootstrap-->

            <!--AppendGrid library-->
            <script src="<?= base_url('assets/appgrid/dist/'); ?>AppendGrid.js"></script>
            <!--Script for initialize AppendGrid-->
            <script>
                var myAppendGrid = new AppendGrid({
                    element: "tblAppendGrid",
                    uiFramework: "bootstrap4",
                    iconFramework: "default",
                    columns: [{
                            name: "id_rek_gl",
                            display: "Account ID"
                        },
                        {
                            name: "id_cc_project",
                            display: "Cost Center"
                        },
                        {
                            name: "description",
                            display: "Descriptions"
                        },

                        {
                            name: "debet",
                            display: "Debit",
                            type: "number"
                        },
                        {
                            name: "kredit",
                            display: "Credit",
                            type: "number"
                        },
                        {
                            name: "id_jurnal_detail",
                            type: "hidden",
                            value: "0"
                        }
                    ],
                    // initData: []
                    // Optional CSS classes, to make table slimmer!
                    sectionClasses: {
                        table: "table-sm",
                        control: "form-control-sm",
                        buttonGroup: "btn-group-sm"
                    }
                });

                $("#load").on("click", function() {
                    var data = myAppendGrid.getAllValue();


                    // Get the `Foo` of row 1
                    alert(" first row is " + data[0].id_rek_gl + data[0].id_cc_project);
                    // Get the `Bar` of row 2
                    alert(" second row is " + data[1].id_rek_gl);
                    var rowCount = myAppendGrid.getRowCount();
                    alert("Total " + rowCount + " row(s) in object");

                });
            </script>


            <!-- END #detail -->



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
    <a hidden href="#" id='addError' class="btn btn-default btn-sm" data-toggle="notification" data-icon="ti-save-alt" data-icon-class="bg-gradient-blue-purple" data-title="Operation Error" data-content="Can't added New Data!"></a>

    <!-- Alert update data baru -->
    <a hidden href="#" id='editSuccess' class="btn btn-default btn-sm" data-toggle="notification" data-icon="ti-save" data-icon-class="bg-gradient-blue-purple" data-title="Operation Success" data-content="Data update successfully" data-autoclose="true"></a>
    <a hidden href="#" id='editError' class="btn btn-default btn-sm" data-toggle="notification" data-icon="ti-save-alt" data-icon-class="bg-gradient-blue-purple" data-title="Operation Error" data-content="Can't Update Data!"></a>

    <!-- Alert delete data  -->
    <a hidden href="#" id='delSuccess' class="btn btn-default btn-sm" data-toggle="notification" data-icon="ti-save" data-icon-class="bg-gradient-blue-purple" data-title="Operation Success" data-content="Delete data successfully" data-autoclose="true"></a>
    <a hidden href="#" id='delError' class="btn btn-default btn-sm" data-toggle="notification" data-icon="ti-save-alt" data-icon-class="bg-gradient-blue-purple" data-title="Operation Error" data-content="Can't Delete Data!"></a>
</div>


<script type="text/javascript">
    //jQuery.noConflict(); // 
    var url;
    var mode;
    var mj_no;
    $(function() {
        doSearch();

        $("#dds").datepicker({
            changeMonth: true,
            changeYear: true
        });
        $("#dds").datepicker("option", "dateFormat", "dd/mm/yy");

        $("#dde").datepicker({
            changeMonth: true,
            changeYear: true
        });
        $("#dde").datepicker("option", "dateFormat", "dd/mm/yy");

        $("#dt_jurnal").datepicker({
            changeMonth: true,
            changeYear: true
        });
        $("#dt_jurnal").datepicker("option", "dateFormat", "dd/mm/yy");

        $("#dt_jth_tempo").datepicker({
            changeMonth: true,
            changeYear: true
        });
        $("#dt_jth_tempo").datepicker("option", "dateFormat", "dd/mm/yy");
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
        $("#dlg").panel('setTitle', 'New Memorial');
        $('#dlg').panel('open');
        //   $('#fm').form('clear');

        document.getElementById('id_jurnal').value = '';
        document.getElementById('id_kurs').value = 'IDR';
        document.getElementById('kd_rekanan').value = 'IDE-1801';
        document.getElementById('remarks').value = 'Test Jurnal Memorial';
        document.getElementById('no_jurnal').value = '';
        document.getElementById('kurs').value = '1';
        document.getElementById('nama_rekanan').value = 'XXX';
        document.getElementById('dt_jurnal').value = '';
        document.getElementById('dt_jth_tempo').value = '';
        document.getElementById('jenis').value = 'SUPPLIER';


        url = '<?= base_url(); ?>Memorial/insertMemorial';
        mode = 'add';
        scrollSmoothToBottom('content');
        getDetailData();
    }

    function editData() {
        var row = $('#dgMain').datagrid('getSelected');
        if (row) {
            $("#dlg").panel('setTitle', 'Update Memorial');
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
            url = '<?= base_url(); ?>Memorial/updateMemorial/' + row.kd_rekanan;
            mode = 'edit';
            //            alert(url);
            scrollSmoothToBottom('content')
        }
    }
    /*
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
    */
    function saveDatax() {

        var remarks = $("#remarks").val();
        var dt_jurnal = $("#dt_jurnal").val();
        var kd_rekanan = $("#kd_rekanan").val();

        var master = [];

        //die;

        if (dt_jurnal == '') {
            alert('Warning', 'Form Harus Di isi');
            return false;
        }


        master.push({
            user_id: "sa",
            mj_date: dt_jurnal,
            mj_desc: remarks,
            mj_type: kd_rekanan,

        });

        //alert(master);

        var rows = [];
        //  var dgs = $('#dgs');
        /*
        $.map(dgs.datagrid('getRows'), function(row) {
            dgs.datagrid('endEdit', dgs.datagrid('getRowIndex', row))
        })
        */
        var data = myAppendGrid.getAllValue();
        var rowCount = myAppendGrid.getRowCount();

        for (var i = 0; i <= rowCount - 1; i++) {
            rows.push({
                coa_id: data[i].id_rek_gl,
                cc_id: data[i].id_cc_project,
                mj_det_desc: data[i].description,
                debit: data[i].debet,
                credit: data[i].kredit,
            });
        };


        var data = [];
        data.push({
            master: master,
            detail: rows
        })

        /*
        var total = retotalDebitKredit();

        if (total.kredit == 0 || total.debit == 0 || total.kredit != total.debit) {
            alert('Error', 'Jurnal belum balance')
            return false;
        }
        */

        $.ajax({
            url: url,
            type: "POST",
            dataType: 'json',
            data: {
                info: data
            },
            success: function(data) {
                alert('Sukses');
                $('#dgMain').datagrid('reload')
                $('#dlg').panel('close');
            },
            error: function() {
                alert('Error,something goes wrong');
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
                    url: "<?= base_url(); ?>Memorial/destroyMemorial",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        id: row.id_jurnal
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

    //--------------------------------------------------DETAIL -------------------------------------------------

    function getDetailData() {
        //xdata = ;
        //alert(xdata);
        //myAppendGrid.load(JSON.parse(xdata));
        $.ajax({
            dataType: "json",
            url: "<?= base_url(); ?>Memorial/getMemorialDetail",
            id: 4,
            error: function() {
                document.getElementById("delError").click(); // Click on the checkbox
            },
            success: function(data) {
                myAppendGrid.load(data);
            }
        });
    }
</script>