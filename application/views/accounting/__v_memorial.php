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
                    <th field="nama_rekanan" width=250 align=left>Vendor</th>
                    <th field="remark" width=350 align=left>Remarks</th>
                    <th field="debet" width=100 align=right>Total</th>
                    <th field="ispost" width="50">Posted</th>
                    <th field="iscancel" width="50" align=left>Cancel</th>
                    <th field="usr_ins" width="80" align=left>User Insert</th>
                    <th field="usr_upd" width="90" align=left>User Update</th>
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
                    <td> <input id="kd_rekanan" name="kd_rekanan" class="form-control"></td>

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

            <div style=" margin-top:5px;"></div>
            <table id="dgs" title="Daftar Jurnal Memorial" style="width:100%;height:350px" rownumbers="true" fitColumns="true" toolbar="#toolbar2">


                <div id="toolbar2">
                    <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="insert()">Tambah</a>
                </div>
                <tbody>

                </tbody>
            </table>


            <script>
                $('#dgs').datagrid({
                    title: 'DataGrid',
                    iconCls: 'icon-',
                    showFooter: true,
                    singleSelect: true,
                    idField: 'itemid',

                    columns: [
                        [{
                                field: 'kode_rekening',
                                title: 'Kode Rekening',
                                width: 100,
                                editor: 'textbox'
                            },
                            {
                                field: 'cost_center',
                                title: 'Cost Center',
                                width: 100,
                                editor: 'textbox'
                            },
                            {
                                field: 'mj_det_desc',
                                title: 'Deskripsi',
                                width: 150,
                                align: 'right',
                                editor: 'textbox'
                            },
                            {
                                field: 'debit',
                                title: 'Debet',
                                width: 80,
                                align: 'right',
                                editor: {
                                    type: 'numberbox',
                                    options: {
                                        precision: 2,
                                        decimalSeparator: ',',
                                        groupSeparator: '.',
                                    }
                                }
                            },
                            {
                                field: 'credit',
                                title: 'kredit',
                                width: 80,
                                editor: {
                                    type: 'numberbox',
                                    options: {
                                        precision: 2,
                                        decimalSeparator: ',',
                                        groupSeparator: '.',
                                    }
                                }
                            },
                            {
                                field: 'action',
                                title: 'Action',
                                width: 80,
                                align: 'center',
                                formatter: function(value, row, index) {
                                    console.debug(row.editing)
                                    if (row.editing) {
                                        var s = '<a href="javascript:void(0)" onclick="saverow(this)">Save</a> ';
                                        var c = '<a href="javascript:void(0)" onclick="cancelrow(this)">Cancel</a>';
                                        return s + c;
                                    } else {
                                        var s = '<a href="javascript:void(0)" onclick="editrow(this)">Edit</a> ';
                                        var c = '<a href="javascript:void(0)" onclick="deleterow(this)">Delete</a>';
                                        return s + c;
                                    }
                                }
                            }
                        ]
                    ],
                    onBeforeEdit: function(index, row) {
                        row.editing = true;
                        $(this).datagrid('refreshRow', index);
                    },
                    onEndEdit: function(index, row) {
                        var ed_coa = $(this).datagrid('getEditor', {
                            index: index,
                            field: 'kode_rekening'
                        });
                        row.coa_name = $(ed_coa.target).combobox('getText');

                        var ed_cc = $(this).datagrid('getEditor', {
                            index: index,
                            field: 'cost_center'
                        });
                        row.cc_name = $(ed_cc.target).combobox('getText');
                    },
                    onAfterEdit: function(index, row, changes) {
                        retotalDebitKredit()

                        row.editing = false
                        $(this).datagrid('refreshRow', index)
                    },
                    onCancelEdit: function(index, row) {
                        row.editing = false
                        $(this).datagrid('refreshRow', index)
                    },
                    onDblClickRow: function(index, row) {
                        $(this).datagrid('selectRow', index);
                        $(this).datagrid('beginEdit', index);
                    }
                });


                function insert() {
                    var dgs = $('#dgs')
                    dgs.datagrid('getRows').forEach(function(row) {
                        var index = dgs.datagrid('getRowIndex', row)
                        dgs.datagrid('endEdit', index)
                            .datagrid('refreshRow', index)

                    })
                    var row = dgs.datagrid('getSelected');
                    if (row) {
                        var index = dgs.datagrid('getRowIndex', row);
                    } else {
                        index = 0;
                    }
                    $('#dgs').datagrid('insertRow', {
                        index: index,
                        row: {
                            status: 'P'
                        }
                    });
                    $('#dgs').datagrid('selectRow', index);
                    $('#dgs').datagrid('beginEdit', index);
                    mj_type = 1;
                }


                function getRowIndex(target) {
                    var tr = $(target).closest('tr.datagrid-row');
                    return parseInt(tr.attr('datagrid-row-index'));
                }

                function saverow(target) {
                    // alert('save');
                    $('#dgs').datagrid('endEdit', getRowIndex(target));
                }

                function editrow(target) {
                    $('#dgs').datagrid('beginEdit', getRowIndex(target));
                }

                function cancelrow(target) {
                    $('#dgs').datagrid('cancelEdit', getRowIndex(target));
                }

                function deleterow(target) {
                    $.messager.confirm('Confirm', 'Are you sure?', function(r) {
                        if (r) {
                            $('#dgs').datagrid('deleteRow', getRowIndex(target));
                        }
                    });

                    retotalDebitKredit()
                }


                function retotalDebitKredit() {
                    var rows = $('#dgs').datagrid('getRows')
                    var totalKredit = rows.map(function(v) {
                        return v.credit ? parseFloat(v.credit) : 0
                    }).reduce(function(v, c) {
                        return v + c
                    }, 0)
                    var totalDebit = rows.map(function(v) {
                        return v.debit ? parseFloat(v.debit) : 0
                    }).reduce(function(v, c) {
                        console.debug(v, c);
                        return v + c
                    }, 0)

                    $('#vkredit').textbox('setValue', totalKredit)
                    $('#vdebit').textbox('setValue', totalDebit)

                    return {
                        debit: totalDebit,
                        kredit: totalKredit
                    }
                }
            </script>

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
        scrollSmoothToBottom('content')
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
        var dgs = $('#dgs');

        $.map(dgs.datagrid('getRows'), function(row) {
            dgs.datagrid('endEdit', dgs.datagrid('getRowIndex', row))
        })

        $.map(dgs.datagrid('getRows'), function(row) {
            rows.push({
                coa_id: row.kode_rekening,
                cc_id: row.cost_center,
                mj_det_desc: row.mj_det_desc,
                debit: row.debit,
                credit: row.credit,
            });
        })

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
</script>