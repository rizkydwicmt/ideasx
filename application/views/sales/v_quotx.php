<!-- BEGIN #content -->
<div id="content" class="content">
    <!-- BEGIN breadcrumb -->
    <ul class="breadcrumb">
        <!--
        <li class="breadcrumb-item"><a href="#">LAYOUT</a></li>
        <li class="breadcrumb-item active">STARTER PAGE</li>-->
        <li class="breadcrumb-item"><a href="#">Sales</a></li>
        <li class="breadcrumb-item active"> <?= $tittle; ?></li>
    </ul>
    <!-- END breadcrumb -->

    <!-- BEGIN page-header -->
    <h1 class="page-header">
        <?= $notrans; ?> | <?= strtoupper($tittle); ?> | <small>This form contain <?= $tittle; ?> data...</small>
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

    <div id="container" class="easyui-panel" style="width:100%;height:460px;padding:10px;">
        <table id="dgMain" class="easyui-datagrid" style="width:100%;height:420px;;" url="<?= base_url(); ?>sales/Quot/getQuot" singleSelect="true" rownumbers="true" pagination="true" toolbar="#toolbarFilter">
            <thead>
                <tr>
                    <th field="id_qs" width="70">Index</th>
                    <th field="no_qs" width="120">Quot Number</th>
                    <th field="dt_qs" width="80">Date</th>
                    <th field="nama_rekanan" width="270" align=left>Customer Name</th>
                    <th field="id_cc_project" width="80">CC/Project #</th>
                    <th field="total" width="100" formatter="datagridFormatNumber" align="right">AR Value</th>
                    <th field="usr_ins" width="50" align="left">Usr Ins</th>
                    <th field="usr_upd" width="50" align="left">Usr Upd</th>
                    <th field="ispost" width="60" align="center">Posted</th>
                    <th field="iscancel" width="60" align="center">Cancel</th>
                </tr>
            </thead>
        </table>

        <div id="toolbarFilter" style="padding-left: 10px">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="newData()">New</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editData()">Edit</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onClick="removeData()">Destroy</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="javascript:$('#dgMain').datagrid('reload'); ">Refresh</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true" onClick="printData()">Print</a>
        </div>




    </div>
    <!-- Modal -->
    <br>
    <div id="window-entry-alokasi-biaya" class="easyui-window" data-options="" style="width:800px;height:600px;padding:10px;">


    </div>


    <!-- END Modal -->


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

        $("#dt_qs").datepicker({
            changeMonth: true,
            changeYear: true,
            gotoCurrent: true
        });
        $("#dt_qs").datepicker("option", "dateFormat", "dd/mm/yy");

        doSearch();
        $('#window-entry-alokasi-biaya').window('close');
    });

    function myformatter(date) {
        var y = date.getFullYear();
        var m = date.getMonth() + 1;
        var d = date.getDate();

        return (d < 10 ? ('0' + d) : d) + '/' + (m < 10 ? ('0' + m) : m) + '/' + y;
    }

    function myparser(s) {
        if (!s) return new Date();
        var ss = (s.split('/'));
        var d = parseInt(ss[0], 10);
        var m = parseInt(ss[1], 10);
        var y = parseInt(ss[2], 10);
        if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
            return new Date(y, m - 1, d);
        } else {
            return new Date();
        }
    }


    function inputKeyEnter(e) {
        e.which = e.which || e.keyCode;
        if (e.which == 13) {
            doSearch();
        }
    }

    function doSearch() {
        $('#dgMain').datagrid('load', {
            dt_awal: $("#dds").val(),
            dt_akhir: $("#dde").val(),
            searching: $('#filterVal').val()
        });
    }



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


    function scrollSmoothToBottom(id) {
        var div = document.getElementById(id);
        $('#' + id).animate({
            scrollTop: div.scrollHeight - div.clientHeight
        }, 500);
    }

    function newData() {
        //$('#window-entry-alokasi-biaya').window('open');
        $('#window-entry-alokasi-biaya').window('refresh', '<?= base_url(); ?>sales/Quot/insertQuot');

    }

    function editData() {
        var row = $('#dgMain').datagrid('getSelected');
        if (row) {
            if (row.ispost == '1') {
                Swal.fire(
                    'Data has been Posted !!!'
                )
                return false;
            }
            $("#dlg").panel('setTitle', 'Update Quotsheet');
            $('#dlg').panel('open');
            //  $('#fm').form('load', row);
            document.getElementById('id_sales_invoice').value = row.id_sales_invoice;
            document.getElementById('no_sales_invoice').value = row.no_sales_invoice;
            document.getElementById('dt_sales_invoice').value = row.dt_sales_invoice_str;
            document.getElementById('kd_rekanan').value = row.kd_rekanan;
            document.getElementById('id_curr').value = row.id_curr;
            document.getElementById('kurs').value = row.kurs;
            document.getElementById('id_cc_project').value = row.id_cc_project;
            document.getElementById('id_rek_gl').value = row.id_rek_gl;
            document.getElementById('no_kontrak').value = row.no_kontrak;
            document.getElementById('dt_contract').value = row.dt_contract;
            document.getElementById('no_berita_acara').value = row.no_berita_acara;
            document.getElementById('dt_berita_acara').value = row.dt_berita_acara;
            document.getElementById('no_acc').value = row.no_acc;
            document.getElementById('bank_transfer').value = row.bank_transfer;
            document.getElementById('remarks').value = row.remarks;
            document.getElementById('vat_str').value = row.vat_str;
            document.getElementById('due_date').value = row.due_date;


            $('#vsubtotal').numberbox('setValue', row.sub_total);
            $('#vdisc').numberbox('setValue', row.disc);
            $('#vdpp').numberbox('setValue', row.dpp);
            $('#vvatnum').numberbox('setValue', row.vat_num);
            $('#vpph_psn').numberbox('setValue', row.pph_psn);
            $('#vpph_rp').numberbox('setValue', row.pph_rp);
            $('#vdp').numberbox('setValue', row.dp_termin);
            $('#vtotal').numberbox('setValue', row.total);

            // alert(row.nama_rekanan);
            url = '<?= base_url(); ?>sales/Quot/updateQuot/' + row.id_qs;
            mode = 'edit';
            getDetailData(row.id_qs);
            scrollSmoothToBottom('content')
        }
    }

    function saveDatax() {

        reTotalGrid();
        var kd_rekanan = $("#kd_rekanan").val();
        var dt_sales_invoice = $("#dt_sales_invoice").val();
        var id_curr = $("#id_curr").val();
        var kurs = $("#kurs").val();
        var id_cc_project = $("#id_cc_project").val();
        var id_rek_gl = $("#id_rek_gl").val();
        var no_kontrak = $("#no_kontrak").val();
        var dt_contract = $("#dt_contract").val();
        var remarks = $("#remarks").val();
        var vat_str = $("#vat_str").val();
        var due_date = $("#due_date").val();
        var no_berita_acara = $("#no_berita_acara").val();
        var dt_berita_acara = $("#dt_berita_acara").val();
        var no_acc = $("#no_acc").val();
        var bank_transfer = $("#bank_transfer").val();

        var sub_total = $('#vsubtotal').numberbox('getValue');
        var disc = $('#vdisc').numberbox('getValue');
        var dpp = $('#vdpp').numberbox('getValue');
        var vat_num = $('#vvatnum').numberbox('getValue');
        var pph_psn = $('#vpph_psn').numberbox('getValue');
        var pph_rp = $('#vpph_rp').numberbox('getValue');
        var dp_termin = $('#vdp').numberbox('getValue');
        var total = $('#vtotal').numberbox('getValue');

        // VALIDATION FORM --------------------------------------
        if (dt_sales_invoice == '') {
            Swal.fire(
                'Field Date Required.....!!!'
            )
            return false;
        } else if (kd_rekanan == '') {
            Swal.fire(
                'Field Supplier Required.....!!!'
            )
            return false;
        } else if (vat_str == '') {
            Swal.fire(
                'Field VAT Required.....!!!'
            )
            return false;
        } else if (dt_contract == '') {
            Swal.fire(
                'Field Contract Date Required.....!!!'
            )
            return false;
        } else if (id_curr == '0') {
            Swal.fire(
                'Field Currency Required.....!!!'
            )
            return false;
        } else if (id_cc_project == '') {
            Swal.fire(
                'Field CC/Project Required.....!!!'
            )
            return false;
        }


        var master = [];

        master.push({
            dt_sales_invoice: dt_sales_invoice,
            kd_rekanan: kd_rekanan,
            id_curr: id_curr,
            kurs: kurs,
            id_cc_project: id_cc_project,
            id_rek_gl: id_rek_gl,
            no_kontrak: no_kontrak,
            dt_contract: dt_contract,
            remarks: remarks,
            due_date: due_date,
            no_berita_acara: no_berita_acara,
            dt_berita_acara: dt_berita_acara,
            no_acc: no_acc,
            bank_transfer: bank_transfer,
            vat_str: vat_str,
            sub_total: sub_total,
            disc: disc,
            dpp: dpp,
            vat_num: vat_num,
            pph_psn: pph_psn,
            pph_rp: pph_rp,
            dp_termin: dp_termin,
            total: total,
            idtrans: <?= $notrans; ?>
        });


        var rows = [];

        var data = myAppendGrid.getAllValue();
        var rowCount = myAppendGrid.getRowCount();

        //cek field first
        for (var i = 0; i <= rowCount - 1; i++) {
            var rowValues = myAppendGrid.getRowValue(i);
            if (rowValues.descriptions == '') {
                Swal.fire(
                    'Field Description -> row ' + [i] + ' must have value.....!!!'
                )
                return false
            } else if (rowValues.id_cc_project == '') {
                Swal.fire(
                    'Field CC/Project # -> row ' + [i] + ' must have value.....!!!'
                )
                return false
            } else if (rowValues.qty == '') {
                Swal.fire(
                    'Field Qty -> row ' + [i] + ' must have value.....!!!'
                )
                return false
            } else if (rowValues.qty == '0') {
                Swal.fire(
                    'Field Qty -> row ' + [i] + ' must have value.....!!!'
                )
                return false
            } else if (rowValues.unit_price == '') {
                Swal.fire(
                    'Field Unit Price -> row ' + [i] + ' must have value.....!!!'
                )
                return false
            } else if (rowValues.unit_price == '0') {
                Swal.fire(
                    'Field Unit Price -> row ' + [i] + ' must have value.....!!!'
                )
                return false
            }
        };

        for (var i = 0; i <= rowCount - 1; i++) {
            if (data[i].id_rek_gl != '') {
                rows.push({
                    uid: data[i].uid,
                    id_rek_gl: data[i].id_rek_gl,
                    id_cc_project: data[i].id_cc_project,
                    remarks: data[i].remarks,
                    unit_price: data[i].unit_price,
                    qty: data[i].qty,
                    qty_unit: data[i].qty_unit,
                    id_unit: data[i].id_unit,
                    extended: data[i].extended
                });

            }
        };



        var data = [];
        data.push({
            master: master,
            detail: rows
        })

        $.ajax({
            url: url,
            method: "POST",
            dataType: 'json',
            data: {
                info: data
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
            if (row.ispost == '1') {
                Swal.fire(
                    'Data has been Posted !!!'
                )
                return false;
            }
            //alert(row.kd_rekanan);
            var result = confirm("Are you sure to delete?");
            if (result) {
                // Delete logic goes here
                //alert(row.kd_rekanan);
                $.ajax({
                    url: "<?= base_url(); ?>sales/Quot/destroyQuot",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        id: row.id_sales_invoice
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

    function printData() {
        var cetak = $("#cetak").val();
        var row = $('#dgMain').datagrid('getSelected');
        if (row) {
            if (cetak == 'SURAT') {
                window.open('<?= base_url(); ?>sales/Ar/cetakAr/S-' + row.id_sales_invoice);
            }
            if (cetak == 'INVOICE') {
                window.open('<?= base_url(); ?>sales/Ar/cetakAr/I-' + row.id_sales_invoice);
            }
            if (cetak == 'KWITANSI') {
                window.open('<?= base_url(); ?>sales/Ar/cetakAr/K-' + row.id_sales_invoice);
            }

        }
    }


    function getDetailData($idd) {

        $.ajax({
            url: "<?= base_url(); ?>sales/Ar/getArDetail",
            method: "POST",
            dataType: 'json',
            data: {
                idd: $idd
            },
            error: function() {
                document.getElementById("delError").click(); // Click on the checkbox
            },
            success: function(data) {
                myAppendGrid.load(data);
            }
        });

    }


    $(function() {
        $('#dgMain').datagrid({
            view: detailview,
            detailFormatter: function(index, row) {
                return '<div style="padding:2px"><table id="ddv-' + index + '"></table></div>';
            },
            onExpandRow: function(index, row) {
                $('#ddv-' + index).datagrid({
                    url: '<?= base_url(); ?>sales/Ar/fetchArDetail/' + row.id_sales_invoice,
                    fitColumns: true,
                    singleSelect: true,
                    height: 'auto',
                    rownumber: true,
                    //pagination: true,
                    showFooter: true,
                    columns: [
                        [{
                                field: 'remarks',
                                title: 'Description',
                                width: 300
                            },
                            {
                                field: 'id_rek_gl',
                                title: 'Account [Cr]',
                                width: 80
                            },
                            {
                                field: 'id_unit',
                                title: 'Unit',
                                width: 80
                            },
                            {
                                field: 'qty',
                                title: 'Qty [%]',
                                align: 'right',
                                width: 80
                            },
                            {
                                field: 'qty_unit',
                                title: 'Qty',
                                align: 'right',
                                width: 100
                            },
                            {
                                field: 'unit_price',
                                title: 'Unit Price',
                                align: 'right',
                                width: 100
                            },
                            {
                                field: 'sub_total',
                                title: 'Ammount',
                                align: 'right',
                                width: 100
                            }
                        ]
                    ],
                    onResize: function() {
                        $('#dgMain').datagrid('fixDetailRowHeight', index);
                    },
                    onLoadSuccess: function() {
                        setTimeout(function() {
                            $('#dgMain').datagrid('fixDetailRowHeight', index);
                        }, 0);
                    }
                });
                $('#dgMain').datagrid('fixDetailRowHeight', index);
            }
        });
    });


    function getProjectData($idp) {
        $.ajax({
            url: "<?= base_url(); ?>sales/Ar/getProjectData",
            method: "POST",
            dataType: 'json',
            data: {
                idx: $idp
            },
            error: function() {
                document.getElementById("addError").click(); // Click on the checkbox
            },
            success: function(data) {
                document.getElementById('no_kontrak').value = data[0]['po_number'];
                document.getElementById('dt_contract').value = data[0]['dt_order_char'];
                document.getElementById('ccp_nilai').value = data[0]['nilai'];
                document.getElementById('ccp_curr').value = data[0]['id_curr'];
                document.getElementById('ccp_pm').value = data[0]['manager'];
            }
        });
    }


    //--------------------coa modal ------------------
    function inputKeyEntercoa(e) {
        e.which = e.which || e.keyCode;
        if (e.which == 13) {
            doSearchcoa();
        }
    }


    function insert_alokasi_biaya() {
        var row = $('#dg-alokasi-biaya').datagrid('getSelected');
        if (row) {
            var index = $('#dg-alokasi-biaya').datagrid('getRowIndex', row);
        } else {
            index = 0;
        }
        $('#dg-alokasi-biaya').datagrid('insertRow', {
            index: index,
            row: {
                status: 'P'
            }
        });
        $('#dg-alokasi-biaya').datagrid('selectRow', index);
        $('#dg-alokasi-biaya').datagrid('beginEdit', index);
    }
</script>