<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($this->session->userdata("username"))) {
    redirect(site_url(), 'refresh');
} elseif (empty($this->session->userdata("stl"))) {
    redirect(base_url('accfin/Settlement'), 'refresh');
};
?>

<table style="width: 89%;" cellspacing="0px" border="0">
    <tr>
        <td style="width:50%;text-align:left">
            <h2><?= $caption; ?></h2>
        </td>
        <td style="width:50%;text-align:right"><input id="id_settlement" class="easyui-textbox" readonly="true" style="width:150px;"></td>
    </tr>
</table>

<hr>

<table style="width: auto;" cellspacing="0px" cellpadding="5px" border="0">
    <tr>

        <td><input id="no_settlement" class="easyui-textbox" label="Settlement #:" labelPosition="top" readonly="true" style="width:150px;"> </td>
        <td><input id="kd_rekanan" class="easyui-combogrid" label="Employee:" labelPosition="top" required="true" style="width:200px;"></td>
        <td><input id="nokasbon" class="easyui-textbox" label="CA Number:" labelPosition="top" required="true" style="width:150px;" data-options="
                        label: 'Icons:',
                        labelPosition: 'top',
                        prompt: 'CA Number',
                        iconWidth: 22,
                        icons: [{
                            iconCls:'icon-search',
                            handler: function(e){
                                onclick=fetchCaData();
                            }
                        }]
                        "></td>
        <td rowspan="2"><input id="id_cc_project" class="easyui-combogrid" label="CC/Project:" labelPosition="top" multiline="true" required="true" style="width:250px;height:100px"></td>
        <td rowspan="2"><input id="kasbon_untuk" class="easyui-textbox" label="CA Purpose:" labelPosition="top" multiline="true" style="width:300px;height:100px"></td>

    </tr>

    <tr>
        <td><input id="dt_settlement" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="Date:" labelPosition="top" required="true" style="width:150px;"></td>
        <td><input id="id_rek_gl" class="easyui-combogrid" label="Account  [Cr]:" labelPosition="top" required="true" style="width:200px;"></td>
        <td><input id="dt_kasbon" class="easyui-datebox" label="CA Date:" data-options="formatter:myformatter,parser:myparser" labelPosition="top" required="true" style="width:150px;"></td>
    </tr>

    <tr>
    </tr>


</table>

<br>
<hr>

<div>
    <!-- div detail -->
    <table id="dg" class="easyui-datagrid" title="Settlement Detail" style="width:89%;height:auto" data-options="
                iconCls: 'icon-edit',
                singleSelect: true,
				toolbar: '#tb',
                rownumbers: true,
                nowrap: false,
				showfooter: true,
                url: '',
                method: 'post',
                onClickCell: onClickCell,
                onEndEdit: onEndEditdg
            ">
        <thead>
            <tr>
                <th data-options="field:'dt_biaya',width:150,
                                            editor:{
                                                type:'datebox',
                                                options:{
                                                    readonly:false,
                                                    required:true,
                                                    formatter:myformatter,
                                                    parser:myparser
                                                }
                                            }">Date</th>
                <th data-options="field:'id_rek_gl',width:150,
                                        formatter:function(value,row){
                                            return row.id_rek_gl;
                                        },
                                        editor:{
                                            type:'combogrid',
                                            options:{
                                                panelWidth:400,
                                                url:'<?= base_url(); ?>accfin/Settlement/getCoaDetail',
                                                required:true,
                                                idField: 'id_rek_gl',
                                                textField: 'id_rek_gl',
                                                mode: 'remote',
                                                fitColumns: true,
                                                nowrap: false,
                                                columns: [
                                                    [{
                                                            field: 'id_rek_gl',
                                                            title: 'ID',
                                                            width: 100,
                                                            align: 'center'
                                                        },
                                                        {
                                                            field: 'descriptions',
                                                            title: 'Descriptions',
                                                            align: 'left',
                                                            width: 300
                                                        }

                                                    ]
                                                ]
                                            }
                                        }">Account [Dr]</th>
                <th data-options="field:'no_mrir',width:150,editor:{type:'textbox'}">AP Number [If Any]</th>
                <th data-options="field:'diskripsi',width:550,editor:{type:'textbox',options:{required:true,readonly:false}}">Descriptions</th>
                <th data-options="field:'biaya',width:140,align:'right',formatter:datagridFormatNumber,editor:{type:'numberbox',options:{precision:2,required:true,readonly:false}}">Nominal</th>
                <th data-options="field:'id_settlement_detail'" hidden="true">id_settlement_detail</th>

            </tr>
        </thead>
    </table>
    <div id="tb" style="height:auto">
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="append()">Append</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeit()">Remove</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="acceptit()">Accept</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="reject()">Reject</a>
    </div>



    <br>

    <table id="dgx" style="width:89%;height:auto" border="0">
        <tr>
            <td style="width:60%;height:30px" rowspan="3"><input id="remarks" class="easyui-textbox" label="Remarks:" labelPosition="top" required="true" multiline="true" style="width:300px;height:100px"></td>
            <td style="width:10%;height:30px;text-align:right">TOTAL</td>
            <td style="width:13%;height:30px;text-align:right"><input id="vtotal" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
        </tr>
        <tr>

            <td style="width:10%;height:30px;text-align:right">CA Value</td>
            <td style="width:13%;height:30px;text-align:right"><input id="vcaval" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
        </tr>
        <tr>
            <td style="width:10%;height:30px;text-align:right">Difference</td>
            <td style="width:13%;height:30px;text-align:right"><input id="vdiff" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
        </tr>


    </table>

    <hr>
    <div id="dlg-buttons" style="text-align: center;">
        <a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="saveDatax()">Save</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="cancelData()">Cancel</a>
    </div>
    <hr>
</div> <!-- end of div detail -->


<hr>


<!--  easyui CA Number modal -->
<div id="wca" class="easyui-window" title="CA Data" data-options="modal:true,closed:true,iconCls:'icon-save'" style="width:850px;height:400px;padding:10px;">
    <table id="dgCa" class="easyui-datagrid" style="width:780px;height:300px;" singleSelect="true" fitcoloumn="true">
        <thead>
            <tr>
                <th field="no_kasbon" width="110">CA Number #</th>
                <th field="dt_kasbon" width="100">Date</th>
                <th field="id_cc_project" width="100">CC/Project</th>
                <th field="kasbon_untuk" width="200">Purpose</th>
                <th field="jumlah" width="130" formatter="datagridFormatNumber" align="right">Value</th>
                <th field="sisa_ca" width="130" formatter="datagridFormatNumber" align="right">Not yet Settle</th>

            </tr>
        </thead>
    </table>

    <br>

    <div id="dlg-buttons">
        <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#wca').window('close')">Close</a>
    </div>
</div>
<!-- END easyui CA Number modal -->



<!--  easyui Coa modal -->
<div id="w" class="easyui-window" title="COA Data" data-options="modal:true,closed:true,iconCls:'icon-save'" style="width:550px;height:500px;padding:10px;">
    <table id="dgCoa" class="easyui-datagrid" style="width:520px;height:400px;" singleSelect="true" pagination="true" toolbar="#toolbarCoa">
        <thead>
            <tr>
                <th field="id_rek_gl" width="100">Accouont #</th>
                <th field="descriptions" width="300">Description</th>
            </tr>
        </thead>
    </table>

    <div id="toolbarCoa" style="padding-left: 10px">
        <span>Filter :</span>
        <input id="filterValcoa" onkeyup="inputKeyEntercoa(event)" style="border:1px solid #ccc">
        <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearchcoa()">Search</a>
    </div>

    <br>

    <div id="dlg-buttons">
        <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#w').window('close')">Close</a>
    </div>
</div>
<!-- END easyui Coa modal -->


<script src="<?php echo base_url('assets/js/accounting.min.js') ?>"></script>
<script type="text/javascript">
    var editIndex = undefined;
    var lastIndex;
    var mode = '<?= $mode ?>';
    var idx = '<?= $idx; ?>';


    //-----------------------------$('#dg').datagrid-----------------------------

    $(function() {
        // $("#pkd_rekanan").hide();
        // $("#pid_qs").hide();

        $('#id_cc_project').combogrid({
            panelWidth: 700,
            url: '<?= base_url()  ?>accfin/Settlement/getCCProject',
            idField: 'id_cc_project',
            textField: 'cc_project_name',
            mode: 'remote',
            fitColumns: true,
            nowrap: false,
            columns: [
                [{
                        field: 'id_cc_project',
                        title: 'ID',
                        width: 100,
                        align: 'center'
                    },
                    {
                        field: 'cc_project_name',
                        title: 'Descriptions',
                        align: 'left',
                        width: 250
                    },
                    {
                        field: 'jenis',
                        title: 'CC/ Project',
                        align: 'left',
                        width: 150
                    },

                ]
            ]

        });


        $('#kd_rekanan').combogrid({
            panelWidth: 350,
            url: '<?= base_url()  ?>accfin/Settlement/getRekanan',
            idField: 'kd_rekanan',
            textField: 'nama_rekanan',
            mode: 'remote',
            fitColumns: true,
            nowrap: false,
            columns: [
                [{
                        field: 'kd_rekanan',
                        title: 'ID',
                        width: 100,
                        align: 'center'
                    },
                    {
                        field: 'nama_rekanan',
                        title: 'Descriptions',
                        align: 'left',
                        width: 250
                    }

                ]
            ]

        });


        $('#id_rek_gl').combogrid({
            panelWidth: 400,
            url: '<?= base_url()  ?>accfin/Settlement/getCoa',
            idField: 'id_rek_gl',
            textField: 'descriptions',
            mode: 'remote',
            fitColumns: true,
            nowrap: false,
            columns: [
                [{
                        field: 'id_rek_gl',
                        title: 'ID',
                        width: 100,
                        align: 'center'
                    },
                    {
                        field: 'descriptions',
                        title: 'Descriptions',
                        align: 'left',
                        width: 300
                    }

                ]
            ]

        });



        if (mode == 'edit') {
            //alert(idx);
            fetchMasterData(idx);
            fetchDetailData(idx);
        } else if (mode == 'add') {
            // alert(mode);
        }

        $('#dg').datagrid({
            onClickRow: function(rowIndex) {
                if (lastIndex != rowIndex) {
                    $(this).datagrid('endEdit', lastIndex);
                    $(this).datagrid('beginEdit', rowIndex);
                }
                lastIndex = rowIndex;
            }
        });



    });


    //-----------------------------$('#dg').datagrid--------------------------------------------

    function endEditing() {
        if (editIndex == undefined) {
            return true
        }
        if ($('#dg').datagrid('validateRow', editIndex)) {
            $('#dg').datagrid('endEdit', editIndex);
            editIndex = undefined;
            return true;
        } else {
            return false;
        }
    }

    function onClickCell(index, field) {
        if (editIndex != index) {
            if (endEditing()) {
                $('#dg').datagrid('selectRow', index)
                    .datagrid('beginEdit', index);
                var ed = $('#dg').datagrid('getEditor', {
                    index: index,
                    field: field
                });
                if (ed) {
                    ($(ed.target).data('textbox') ? $(ed.target).textbox('textbox') : $(ed.target)).focus();
                }
                editIndex = index;
            } else {
                setTimeout(function() {
                    $('#dg').datagrid('selectRow', editIndex);
                }, 0);
            }
        }
    }

    function onEndEditdg(index, row) {
        var ed = $(this).datagrid('getEditor', {
            index: index
            //field: 'kd_satuan'
        });
        //row.kd_satuan = $(ed.target).combobox('getText');
        //$('#dg').datagrid('getRows')[index]['kd_satuan'] = $(ed.target).combobox('getText');
    }

    function append() {
        // idp = $('#id_cc_project').combogrid('getValue');
        // if (idp == '') {
        //     $.messager.alert('iDeas', 'CC/Project Must have value !', 'warning');
        //     return false;
        // }

        if (endEditing()) {
            $('#dg').datagrid('appendRow', {
                id_settlement_detail: 0
            });
            editIndex = $('#dg').datagrid('getRows').length - 1;
            $('#dg').datagrid('selectRow', editIndex)
                .datagrid('beginEdit', editIndex);
        }
    }

    function removeit() {
        if (editIndex == undefined) {
            return
        }
        $('#dg').datagrid('cancelEdit', editIndex)
            .datagrid('deleteRow', editIndex);
        editIndex = undefined;
        hitung_total();
    }

    function acceptit() {
        if (endEditing()) {
            $('#dg').datagrid('acceptChanges');
        }
        hitung_total();
    }

    function reject() {
        $('#dg').datagrid('rejectChanges');
        editIndex = undefined;
    }


    //------------------------------end of $('#dg').datagrid -------------------------


    function fetchMasterData(idx) {
        $.ajax({
            url: "<?= base_url(); ?>accfin/Settlement/getMasterData",
            method: "POST",
            dataType: 'json',
            data: {
                idx: idx
            },
            error: function() {
                $.messager.show({
                    title: 'Error',
                    msg: result.errorMsg
                });
            },
            success: function(data) {
                //alert(data[0]['id_rek_gl']);
                $('#id_settlement').textbox('setValue', data[0]['id_settlement']);
                $('#no_settlement').textbox('setValue', data[0]['no_settlement']);
                $('#dt_settlement').datebox('setValue', data[0]['dt_settlement']);
                $('#id_curr').combobox('setValue', data[0]['id_curr']);
                $('#kurs').numberbox('setValue', data[0]['kurs']);
                $('#kd_rekanan').combogrid('setValue', data[0]['kd_rekanan']);
                $('#id_rek_gl').combogrid('setValue', data[0]['id_rek_gl']);
                $('#kasbon_untuk').textbox('setValue', data[0]['kegiatan_1']);
                $('#id_cc_project').combogrid('setValue', data[0]['id_cc_project']);
                $('#nokasbon').textbox('setValue', data[0]['no_kasbon']);
                $('#dt_kasbon').datebox('setValue', data[0]['dt_kasbon']);
                $('#remarks').textbox('setValue', data[0]['remarks']);
                $('#vtotal').numberbox('setValue', data[0]['total']);
                $('#vcaval').numberbox('setValue', data[0]['total_kasbon']);
                $('#vdiff').numberbox('setValue', data[0]['lebih_kurang']);
            }
        });
    }

    function fetchDetailData(idx) {
        $.ajax({
            url: "<?= base_url(); ?>accfin/Settlement/getDetailData",
            method: "POST",
            dataType: 'json',
            data: {
                idx: idx
            },
            error: function() {
                $.messager.show({
                    title: 'Error',
                    msg: result.errorMsg
                });
                alert('error');
            },
            success: function(data) {
                $('#dg').datagrid('loadData',
                    data
                );
            }
        });

    }


    function myformatter(dt) {
        var y = dt.getFullYear();
        var m = dt.getMonth() + 1;
        var d = dt.getDate();
        return (d < 10 ? ('0' + d) : d) + '-' + (m < 10 ? ('0' + m) : m) + '-' + y;
    }


    function myparser(s) {
        if (!s) return new Date();
        var ss = (s.split('-'));
        var y = parseInt(ss[0], 10);
        var m = parseInt(ss[1], 10);
        var d = parseInt(ss[2], 10);
        if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
            return new Date(d, m - 1, y);
        } else {
            return new Date();
        }
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


    function hitung_total() {
        var vca = $('#vcaval').numberbox('getValue');
        var data = $('#dg').datagrid('getRows');
        var jml = 0;
        if (data.length > 0) {
            for (i = 0; i < data.length; i++) {
                jml += parseFloat(data[i].biaya);
            }
        }

        var tot = vca - jml;

        $('#vtotal').numberbox('setValue', jml);
        $('#vdiff').numberbox('setValue', tot);
    }



    function saveDatax() {

        var id_settlement = $('#id_settlement').textbox('getValue');
        // var no_settlement = $('#no_settlement').textbox('getValue');
        //alert('masuk');
        var dt_settlement = $('#dt_settlement').datebox('getValue');
        // var id_curr = $('#id_curr').combobox('getValue');
        // var kurs = $('#kurs').numberbox('getValue');
        var kd_rekanan = $('#kd_rekanan').combogrid('getValue');
        var id_cc_project = $('#id_cc_project').combogrid('getValue');
        var id_rek_gl = $('#id_rek_gl').combogrid('getValue');
        var kegiatan_1 = $('#kasbon_untuk').textbox('getValue');
        var no_kasbon = $('#nokasbon').textbox('getValue');
        var dt_kasbon = $('#dt_kasbon').datebox('getValue');
        var remarks = $('#remarks').textbox('getValue');

        var total = $('#vtotal').numberbox('getValue');
        var total_kasbon = $('#vcaval').numberbox('getValue');
        var lebih_kurang = $('#vdiff').numberbox('getValue');

        var detail = $('#dg').datagrid('getRows');

        // VALIDATION FORM --------------------------------------
        if (dt_settlement == '') {
            $.messager.alert('Warning', 'Settlement date have value', 'warning');
            return false;
        } else if (id_cc_project == '') {
            $.messager.alert('Warning', 'CC/Project must have value', 'warning');
            return false;
        } else if (kd_rekanan == '') {
            $.messager.alert('Warning', 'Employee must have value', 'warning');
            return false;
        } else if (no_kasbon == '') {
            $.messager.alert('Warning', 'CA Number must have value', 'warning');
            return false;
        }

        //console.log(detail);
        var master = [];

        master.push({
            id_settlement: id_settlement,
            // no_settlement: no_settlement,
            dt_settlement: dt_settlement,
            id_curr: 'IDR',
            kurs: 1,
            kd_rekanan: kd_rekanan,
            id_rek_gl: id_rek_gl,
            kegiatan_1: kegiatan_1,
            id_cc_project: id_cc_project,
            remarks: remarks,
            no_kasbon: no_kasbon,
            dt_kasbon: dt_kasbon,
            total: total,
            total_kasbon: total_kasbon,
            lebih_kurang: lebih_kurang,
            idtrans: <?= $idtrans; ?>

        });



        var data = [];
        data.push({
            master: master,
            detail: detail
        });

        var uri;
        if (mode == 'edit') {
            uri = '<?= base_url(); ?>accfin/Settlement/updateSettlement';
        } else if (mode == 'add') {
            uri = '<?= base_url(); ?>accfin/Settlement/insertSettlement';
        }

        $.ajax({
            url: uri,
            method: "POST",
            dataType: 'json',
            data: {
                info: data
            },
            error: function() {
                $.messager.show({
                    title: 'Error',
                    msg: result.errorMsg
                });
            },
            success: function(data) {
                window.open('<?= base_url(); ?>accfin/Settlement', '_self');
            }
        });
    }

    function cancelData() {
        window.open('<?= base_url(); ?>accfin/Settlement', '_self');
        // window.open('<?//= base_url(); ?>procurement/Pr/index/<?//= $dtx ?>', '_self');
    }


    function fetchCaData() {
        var idx = $('#kd_rekanan').combogrid('getValue');
        if (idx == '') {
            $.messager.alert('iDeas', 'Employee Must have value !', 'warning');
            return false;
        }

        $('#dgCa').datagrid({
            url: "<?= base_url(); ?>accfin/Settlement/getCaAccount/" + idx
        });

        $('#wca').window('open');

        $('#dgCa').datagrid({
            onDblClickRow: function() {
                var row = $('#dgCa').datagrid('getSelected');
                if (row) {
                    //alert('ok');
                    $('#nokasbon').textbox('setValue', row.no_kasbon);
                    $('#kasbon_untuk').textbox('setValue', row.kasbon_untuk);
                    $('#dt_kasbon').datebox('setValue', row.dt_kasbon);
                    $('#id_cc_project').combogrid('setValue', row.id_cc_project);
                    $('#id_rek_gl').combogrid('setValue', row.id_rek_gl_debet);
                    $('#vcaval').numberbox('setValue', row.sisa_ca);
                    $('#wca').window('close'); // hide modal
                }
            }
        });

    };

    function inputKeyEntercoa(e) {
        e.which = e.which || e.keyCode;
        if (e.which == 13) {
            doSearchcoa();
        }
    }

    function doSearchcoa() {
        $('#dgCoa').datagrid('load', {
            searching_coa: $('#filterValcoa').val()
        });

    }


    function fect_coa_data(irow) {
        idp = $('#id_cc_project').combogrid('getValue');
        if (idp == '') {
            $.messager.alert('iDeas', 'CC/Project Must have value !', 'warning');
            return false;
        }

        // $('#dgCoa').datagrid({
        //     url: "<?= base_url(); ?>accfin/Settlement/getCoaDetail/" + idx
        // });

        // $('#w').window('open');

        // $('#dgCoa').datagrid({
        //     onDblClickRow: function() {
        //         var row = $('#dgCoa').datagrid('getSelected');
        //         if (row) {
        //             var editors = $('#dg').datagrid('getEditors', editIndex);
        //             var n1 = $(editors[1].target);
        //             n1.textbox('setValue', row.id_rek_gl);
        //             $('#w').window('close'); // hide modal
        //         }
        //     }
        // });

    };
</script>


</body>

</html>