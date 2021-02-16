<!-- BEGIN #content -->
<div id="content" class="content">
    <!-- BEGIN breadcrumb -->
    <ul class="breadcrumb">
        <!--
        <li class="breadcrumb-item"><a href="#">LAYOUT</a></li>
        <li class="breadcrumb-item active">STARTER PAGE</li>-->
        <li class="breadcrumb-item"><a href="#">Accounting</a></li>
        <li class="breadcrumb-item active"><?= $tittle ?></li>
    </ul>
    <!-- END breadcrumb -->

    <!-- BEGIN page-header -->
    <h1 class="page-header">
        <?= $notrans ?> | <?= $tittle ?> | <small>This form contain general <?= $tittle ?> data...</small>
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
        <table id="dgMain" class="easyui-datagrid" style="width:100%;height:460px;" url="<?= base_url(); ?>accfin/Ca/getCa" singleSelect="true" rownumbers="true" pagination="true" toolbar="#toolbarFilter">
            <thead>
                <tr>
                    <th field="id_kasbon" width="50">Index</th>
                    <th field="no_kasbon" width="120">Advance Number</th>
                    <th field="dt_purposed" width="100">Date</th>
                    <th field="nama_rekanan" width="250" align="left">Employee</th>
                    <th field="kasbon_untuk" width="300" align="left">CA For</th>
                    <th field="jumlah" width="100" formatter="datagridFormatNumber" align="right">Total</th>
                    <th field="id_cc_project" width=80 allign="left">CC/Project</th>
                    <th field="ispost" width="50">Posted</th>
                    <th field="iscancel" width="50" align="center">Cancel</th>
                    <th field="usr_ins" width="80" align="left">User Insert</th>
                    <th field="usr_upd" width="90" align="left">User Update</th>
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
    <div id="dlg" class="easyui-panel" title="--" style="width:100%;height:300px;padding:10px;" data-options="iconCls:'icon-save',closable:true,
                collapsible:true,minimizable:true,maximizable:true" closed="true">

        <form id="fm">

            <div class="row">
                <!-- BEGIN col-4 -->
                <div class="col-md-2">
                    <!-- BEGIN panel -->

                    <label style="width: 130px">Index #</label>
                    <input id="id_kasbon" name="id_kasbon" class="form-control m-b-10 input-sm" readonly="true" />
                    <label style="width: 130px">Cash Advance #</label>
                    <input id="no_kasbon" name="no_kasbon" class="form-control m-b-10 input-sm" readonly="true" />

                    <label style="width: 130px">Date<span class="text-danger">*</span></label>
                    <input id="dt_purposed" name="dt_purposed" class="form-control m-b-10 input-sm" />

                </div>

                <!-- BEGIN col-4 -->
                <div class="col-md-2">
                    <div class="row">
                        <div class="col-xs-6">
                            <label style="width: 130px">Currency #<span class="text-danger">*</span></label>
                            <Select id="id_curr" name="id_curr" class="form-control m-b-10 input-sm">
                                <option value="">Select Currency</option>
                                <?php
                                foreach ($Currency as $row) {
                                    echo '<option value="' . $row["id_curr"] . '">' . $row["id_curr"] . '</option>';
                                }
                                ?>
                            </Select>
                        </div>
                        <div class="col-xs-6">
                            <label style="width: 130px">Rate </label>
                            <input id="kurs" name="kurs" class="form-control m-b-10 input-sm" />
                        </div>
                    </div>
                    <label style="width: 130px">CA For<span class="text-danger">*</span></label>
                    <select id="ispersonal" name="ispersonal" class="form-control m-b-10 input-sm">
                        <option value="">Select CA Purpose</option>
                        <option value="01">Personal</option>
                        <option value="10">Operational</option>
                        <option value="11">Down Payment</option>
                    </select>

                    <label style="width: 130px">COA Account<span class="text-danger">*</span></label>
                    <Select id="id_rek_gl_debet" name="id_rek_gl_debet" class="form-control m-b-10 input-sm">
                        <option value="">Select Account</option>
                        <?php
                        foreach ($coa as $row) {
                            echo '<option value="' . $row["id_rek_gl"] . '">' . $row["descriptions"] . '</option>';
                        }
                        ?>
                    </Select>
                </div>

                <!-- BEGIN col-4 -->
                <div class="col-md-3">

                    <label>Employee<span class="text-danger">*</span></label>
                    <Select id="kd_rekanan" name="kd_rekanan" class="form-control m-b-10 input-sm">
                        <option value="-">Select Employee</option>
                        <?php
                        foreach ($vendor as $row) {
                            echo '<option value="' . $row["kd_rekanan"] . '">' . $row["nama_rekanan"] . '</option>';
                        }
                        ?>
                    </Select>

                    <div class="row">
                        <div class="col-xs-6">
                            <label>PO # (If Order)</label>
                            <input id="po_number" name="po_number" class="form-control m-b-10 input-sm" />
                        </div>
                        <div class="col-xs-6">
                            <label>Invoice # (If Order)</label>
                            <input id="lampiran" name="lampiran" class="form-control m-b-10 input-sm" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <label>Outstanding CA</label>
                            <input id="tunggakan" name="tunggakan" class="easyui-numberbox" data-options="precision:2,groupSeparator:','" style="width:120px;text-align: right;height: 30px" readonly="true" />
                        </div>
                        <div class="col-xs-6">
                            <label>Nominal CA Now<span class="text-danger">*</span></label>
                            <input id="jumlah" name="jumlah" class="easyui-numberbox" data-options="precision:2,groupSeparator:','" style="width:120px;text-align: right;height: 30px" />
                        </div>
                    </div>

                </div>

                <div class="col-md-4">
                    <label style="width: 130px">CC/Project</label>
                    <Select id="id_cc_project" name="id_cc_project" class="form-control m-b-10 input-sm">
                        <option value="">Select CC/Project</option>
                        <?php
                        foreach ($ccpro as $row) {
                            echo '<option value="' . $row["id_cc_project"] . '">' . $row["id_cc_project"] . ' | ' . $row["cc_project_name"] . '</option>';
                        }
                        ?>
                    </Select>

                    <label style="width: 130px">Remarks</label>
                    <textarea class="form-control" name="remarks" id="remarks" rows="4"></textarea>
                </div>
            </div>

            <!-- BEGIN #detail -->


            <hr>
            <div class="ftitle"></div>
            <div id="dlg-buttons">
                <a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="saveDatax()">Save</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').panel('close')">Cancel</a>
            </div>
        </form>
    </div>
    <!-- END #detail -->
    <!-- END modal -->

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

<script src="<?php echo base_url('assets/js/accounting.min.js') ?>"></script>
<script type="text/javascript">
    //jQuery.noConflict(); // 
    var url;
    var mode;
    var mj_no;
    $(function() {


        $("#dds").datepicker({
            changeMonth: true,
            changeYear: true,
            gotoCurrent: true
        });
        $("#dds").datepicker("option", "dateFormat", "dd/mm/yy");
        $("#dds").datepicker("setDate", "today");


        $("#dde").datepicker({
            changeMonth: true,
            changeYear: true,
            gotoCurrent: true
        });
        $("#dde").datepicker("option", "dateFormat", "dd/mm/yy");
        $("#dde").datepicker("setDate", "today");

        $("#dt_purposed").datepicker({
            changeMonth: true,
            changeYear: true,
            gotoCurrent: true
        });
        $("#dt_purposed").datepicker("option", "dateFormat", "dd/mm/yy");
        $("#dt_purposed").datepicker("setDate", "today");

        $('#kd_rekanan').on('change', function() {
            // alert(this.value);
            getOutCa(this.value);
        });


        doSearch();
    });



    // Number Format
    accounting.settings = {
        currency: {
            symbol: "Rp", // default currency symbol is '$'
            format: "%s %v", // controls output: %s = symbol, %v = value/number (can be object: see below)
            decimal: ",", // decimal point separator
            thousand: ".", // thousands separator
            precision: 2 // decimal places
        },
        number: {
            precision: 2,
            thousand: ".",
            decimal: ","
        }
    }

    // Data Grid Number Format
    function datagridFormatNumber(val, row) {
        return accounting.formatNumber(val);
    }



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
        $("#dlg").panel('setTitle', 'New Cash Advance');
        $('#dlg').panel('open');
        //   $('#fm').form('clear');

        document.getElementById('id_kasbon').value = '';
        document.getElementById('no_kasbon').value = '';
        $("#dt_purposed").datepicker("setDate", "today");
        document.getElementById('id_curr').value = 'IDR';
        document.getElementById('kurs').value = '1';
        document.getElementById('kd_rekanan').value = '-';
        document.getElementById('ispersonal').value = '';
        document.getElementById('remarks').value = '';

        document.getElementById('po_number').value = '';
        document.getElementById('lampiran').value = '';
        document.getElementById('id_rek_gl_debet').value = '';
        document.getElementById('id_cc_project').value = '';


        $('#tunggakan').numberbox('setValue', 0);
        $('#jumlah').numberbox('setValue', 0);

        url = '<?= base_url(); ?>accfin/Ca/insertCa';
        mode = 'add';
        scrollSmoothToBottom('content');

    }

    function editData() {
        var row = $('#dgMain').datagrid('getSelected');
        if (row) {
            $("#dlg").panel('setTitle', 'Update Cash Advance');
            $('#dlg').panel('open');
            //  $('#fm').form('load', row);
            document.getElementById('id_kasbon').value = row.id_kasbon;
            document.getElementById('no_kasbon').value = row.no_kasbon;
            document.getElementById('id_curr').value = row.id_curr;
            document.getElementById('kurs').value = row.kurs;
            document.getElementById('kd_rekanan').value = row.kd_rekanan;
            document.getElementById('remarks').value = row.remarks;
            document.getElementById('dt_purposed').value = row.dt_purposed_char;
            document.getElementById('ispersonal').value = row.ispersonal;

            document.getElementById('po_number').value = row.po_number;
            document.getElementById('lampiran').value = row.lampiran;
            document.getElementById('id_rek_gl_debet').value = row.id_rek_gl_debet;
            document.getElementById('id_cc_project').value = row.id_cc_project;

            $('#tunggakan').numberbox('setValue', row.tunggakan);
            $('#jumlah').numberbox('setValue', row.jumlah);

            // alert(row.nama_rekanan);
            url = '<?= base_url(); ?>accfin/Ca/updateCa/' + row.id_kasbon;
            mode = 'edit';
            scrollSmoothToBottom('content');
        }
    }

    function saveDatax() {


        var dt_purposed = $("#dt_purposed").val();
        var id_curr = $("#id_curr").val();
        var kurs = $("#kurs").val();
        var kd_rekanan = $("#kd_rekanan").val();
        var ispersonal = $("#ispersonal").val();
        var remarks = $("#remarks").val();
        var po_number = $("#po_number").val();
        var lampiran = $("#lampiran").val();
        var id_rek_gl_debet = $("#id_rek_gl_debet").val();
        var id_cc_project = $("#id_cc_project").val();

        var tunggakan = $('#tunggakan').numberbox('getValue');
        var jumlah = $('#jumlah').numberbox('getValue');
        var no_trans = <?= $notrans ?>;


        // if (totalkredit == 0 || totaldebit == 0 || totalkredit != totaldebit) {
        //     alert('Jurnal belum balance', 'Jurnal belum balance')
        //     return false;
        // }

        var master = [];

        //die;

        if (dt_purposed == '') {
            alert('Tanggal Harus Diisi', 'Form Harus Di isi');
            return false;
        }


        master.push({
            dt_purposed: dt_purposed,
            id_curr: id_curr,
            kurs: kurs,
            kd_rekanan: kd_rekanan,
            ispersonal: ispersonal,
            remarks: remarks,
            po_number: po_number,
            lampiran: lampiran,
            id_rek_gl_debet: id_rek_gl_debet,
            id_cc_project: id_cc_project,
            notrans: no_trans,
            tunggakan: parseFloat(tunggakan || 0),
            jumlah: parseFloat(jumlah || 0)
        });

        //alert(master);

        var data = [];
        data.push({
            master: master
        })


        $.ajax({
            url: url,
            type: "POST",
            dataType: 'json',
            data: {
                info: data
            },
            success: function(data) {
                if (mode == 'add') {
                    document.getElementById("addSuccess").click(); // Click on the checkbox; 
                } else if (mode == 'edit') {
                    document.getElementById("editSuccess").click(); // Click on the checkbox; 
                }
                $('#dgMain').datagrid('reload')
                $('#dlg').panel('close');
            },
            error: function() {
                if (mode == 'add') {
                    document.getElementById("addError").click(); // Click on the checkbox
                } else if (mode == 'edit') {
                    document.getElementById("editError").click(); // Click on the checkbox 
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
                    url: "<?= base_url(); ?>accfin/Ca/destroyCa",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        id: row.id_kasbon
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
            dt_awal: $("#dds").val(),
            dt_akhir: $("#dde").val(),
            searching: $('#filterVal').val()
        });

    }


    function getOutCa($idc) {
        $.ajax({
            url: "<?= base_url(); ?>accfin/Ca/getOustandCa",
            method: "POST",
            dataType: 'json',
            data: {
                idx: $idc
            },
            error: function() {
                document.getElementById("addError").click(); // Click on the checkbox
            },
            success: function(data) {
                $('#tunggakan').numberbox('setValue', data)
            }
        });
    }
</script>