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

            <div class="row">
                <!-- BEGIN col-4 -->
                <div class="col-md-2">
                    <!-- BEGIN panel -->

                    <label style="width: 130px">Index #</label>
                    <input id="id_jurnal" name="id_jurnal" class="form-control m-b-10 input-sm" readonly="true" />
                    <label style="width: 130px">Memorial #</label>
                    <input id="no_jurnal" name="no_jurnal" class="form-control m-b-10 input-sm" readonly="true" />
                    <label class="control-label">Date<span class="text-danger">*</span></label>
                    <input id="dt_jurnal" name="dt_jurnal" class="form-control m-b-10 input-sm" />
                </div>

                <!-- BEGIN col-4 -->
                <div class="col-md-2">
                    <label style="width: 130px">Currency #<span class="text-danger">*</span></label>
                    <Select id="id_kurs" name="id_kurs" class="form-control m-b-10 input-sm">
                        <option value="-">Select Currency</option>
                        <?php
                        foreach ($Currency as $row) {
                            echo '<option value="' . $row["id_curr"] . '">' . $row["id_curr"] . '</option>';
                        }
                        ?>
                    </Select>
                    <label style="width: 130px">Rate :</label>
                    <input id="kurs" name="kurs" class="form-control m-b-10 input-sm" />
                    <label style="width: 130px">Due Date</label>
                    <input id="dt_jth_tempo" name="dt_jth_tempo" class="form-control m-b-10 input-sm" />
                </div>

                <!-- BEGIN col-4 -->
                <div class="col-md-3">


                    <label style="width: 130px">Vendor Group :</label>
                    <select class="form-control" id="jenis" name="jenis">
                        <option value="-" selected></option>
                        <option value="SUPPLIER">SUPPLIER</option>
                        <option value="CUSTOMER">CUSTOMER</option>
                        <option value="EMPLOYEE">EMPLOYEE</option>
                    </select>

                    <label style="width: 130px">Vendor Name</label>
                    <Select id="kd_rekanan" name="kd_rekanan" class="form-control m-b-10 input-sm">
                        <option value="-">Select Vendor</option>
                        <?php
                        foreach ($vendor as $row) {
                            echo '<option value="' . $row["kd_rekanan"] . '">' . $row["nama_rekanan"] . '</option>';
                        }
                        ?>
                    </Select>
                </div>

                <div class="col-md-4">
                    <label style="width: 130px">Remarks</label>
                    <textarea class="form-control" name="remarks" id="remarks" rows="4"></textarea>
                </div>

                <!-- BEGIN #detail -->
                <!--AppendGrid table element-->
                <table id="tblAppendGrid"></table>
                <!--JS required for Bootstrap-->

                <!--AppendGrid library-->
                <script src="<?= base_url('assets/appgrid/dist/'); ?>AppendGrid.js"></script>
                <!--Script for initialize AppendGrid-->
                <script>
                    var rowIndex;
                    var myAppendGrid = new AppendGrid({
                        element: "tblAppendGrid",
                        uiFramework: "bootstrap4",
                        iconFramework: "default",
                        columns: [{
                                name: "id_rek_gl",
                                display: "Account ID",
                                ctrlAttr: {
                                    placeholder: "Click me!"
                                },
                                events: {
                                    click: function(e) {
                                        rowIndex = myAppendGrid.getRowIndex(parseInt(e.uniqueIndex));
                                        $("#myModal").modal('show'); // show modal
                                    }
                                }
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


                    function masuk(txt, data) {
                        myAppendGrid.setCtrlValue("id_rek_gl", rowIndex, data);
                        $("#myModal").modal('hide'); // hide modal
                    }
                </script>


                <!-- END #detail -->


                <br>
                <hr>
                <div class="ftitle"></div>
                <div id="dlg-buttons">
                    <a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="saveDatax()">Save</a>
                    <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').panel('close')">Cancel</a>
                </div>

        </form>
    </div>

    <!-- modal ---->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">DATA MAHASISWA</h4>
                </div>
                <div class="modal-body">

                    <table id="example" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID MHS</th>
                                <th>NAMA MHS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="data" onClick="masuk(this,'MHS001')" href="javascript:void(0)">
                                <td><a id="data" onClick="masuk(this,'MHS001')" href="javascript:void(0)">MHS001</a></td>
                                <td>Muhammad Iqbal Ramadhan</td>
                            </tr>
                            <tr id="data" onClick="masuk(this,'MHS002')" href="javascript:void(0)">
                                <td><a id="data" onClick="masuk(this,'MHS002')" href="javascript:void(0)">MHS002</a></td>
                                <td>Muhammad Ramdan Fauzi</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END modal -->

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
        document.getElementById('kd_rekanan').value = '-';
        document.getElementById('remarks').value = 'Test Jurnal Memorial';
        document.getElementById('no_jurnal').value = '';
        document.getElementById('kurs').value = '1';
        document.getElementById('dt_jurnal').value = '';
        document.getElementById('dt_jth_tempo').value = '';
        document.getElementById('jenis').value = '-';


        url = '<?= base_url(); ?>Memorial/insertMemorial';
        mode = 'add';
        scrollSmoothToBottom('content');
        //  getDetailData();
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