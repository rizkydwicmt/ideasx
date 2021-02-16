<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($this->session->userdata("username"))) {
    redirect(site_url(), 'refresh');
} elseif (empty($this->session->userdata("cr"))) {
    redirect(base_url('accfin/Payment'), 'refresh');
} else {
    $datax = $this->session->userdata('cr');
}
?>

<body>

    <table style="width: 100%;" cellspacing="0px" border="0">
        <tr>
            <td style="width:50%;text-align:left">
                <h4><?= $datax['caption']; ?></h4>
            </td>
            <td style="width:50%;text-align:right"><input id="id_payment" class="easyui-textbox" readonly="true" style="width:150px;"></td>
        </tr>
    </table>
    <hr>

    <table style="width: auto;" cellspacing="5px" cellpadding="5px" border="0">
        <tr>

            <td><input id="no_payment" class="easyui-textbox" label="Cash Receipt #:" labelPosition="top" readonly="true" style="width:150px;"></td>
            <td><input id="kd_rekanan" class="easyui-combogrid" label="Receipt From:" labelPosition="top" required="true" style="width:250px;"></td>
            <td rowspan="2"><input id="remarks" class="easyui-textbox" label="Remarks:" labelPosition="top" multiline="true" style="width:300px;height:100px"></td>
        </tr>

        <tr>
            <td><input id="dt_payment" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="Date:" labelPosition="top" required="true" style="width:150px;"></td>
            <td><input id="id_rek_gl" class="easyui-combogrid" label="Account  [Dr]:" labelPosition="top" required="true" style="width:250px;"></td>
        </tr>

        <tr>
        </tr>


    </table>

    <br>
    <hr>

    <div>
        <!-- div detail -->
        <table id="dg" class="easyui-datagrid" title="Cash Receipt Detail" style="width:85%;height:auto" data-options="
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
                    <th data-options="field:'no_reff',width:150,editor:{type:'textbox',options:{required:true,
					icons:[{
						iconCls:'icon-search',
						handler: function(e){
							onclick=getNoReff();
                            
                        }
					}]}}">No. Reff</th>
                    <th data-options="field:'description',width:500,editor:{type:'textbox',options:{required:true,readonly:false}}">Descriptions</th>
                    <th data-options="field:'id_cc_project',width:150,
                                        formatter:function(value,row){
                                            return row.id_cc_project;
                                        },
                                        editor:{
                                            type:'combogrid',
                                            options:{
                                                panelWidth:500,
                                                url:'<?= base_url(); ?>accfin/Payment/getCcProject',
                                                required:true,
                                                idField: 'id_cc_project',
                                                textField: 'id_cc_project',
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
                                                            width: 300
                                                        },
                                                        {
                                                            field: 'jenis',
                                                            title: 'Group',
                                                            align: 'left',
                                                            width: 100
                                                        }

                                                    ]
                                                ]
                                            }
                                        }">CC/Project</th>

                    <th data-options="field:'id_rek_gl',width:150,
                                        formatter:function(value,row){
                                            return row.id_rek_gl;
                                        },
                                        editor:{
                                            type:'combogrid',
                                            options:{
                                                panelWidth:400,
                                                url:'<?= base_url(); ?>accfin/Payment/getCoaDetail',
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
                                        }">Account [Cr]</th>
                    <th data-options="field:'dibayar',width:140,align:'right',formatter:datagridFormatNumber,editor:{type:'numberbox',options:{precision:2,required:true,readonly:false}}">Nominal</th>
                    <th data-options="field:'id_payment_detail'" hidden="true">id_payment_detail</th>

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

        <table id="dgx" style="width:85%;height:auto" border="0">
            <tr>
                <td style="width:80%;height:30px;text-align:right"></td>
                <td style="width:10%;height:30px;text-align:right">TOTAL</td>
                <td style="width:13%;height:30px;text-align:right"><input id="nominal" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
            </tr>
            <tr style="height:30px;"></tr>


        </table>
        <hr>

        <div id="dlg-buttons" style="text-align: center;">
            <a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="saveDatax()">Save</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="cancelData()">Cancel</a>
        </div>

    </div> <!-- end of div detail -->


    <hr>


    <!-- Modal ITEM -->

    <div id="wi" class="easyui-window" title="Reference Data" data-options="modal:true,closed:true,iconCls:'icon-save'" style="width:900px;height:500px;padding:10px;">
        <table id="dgItem" class="easyui-datagrid" stripped="true" style="width:90%;height:400px;" singleSelect="true" pagination="true" toolbar="#toolbarItem">
            <thead>
                <tr>
                    <th field="no_doc" width="100">Reff Number</th>
                    <th field="dt_doc" width="100">Date</th>
                    <th field="remarks" width="250">Remarks</th>
                    <th field="id_rek_gl" width="100">Account #</th>
                    <th field="id_cc_project" width="100">CC/Project</th>
                    <th field="nama_transaksi" width="150">Transaction</th>
                    <th field="sisa" width="100" formatter="datagridFormatNumber" align="right">Nominal</th>
                </tr>
            </thead>
        </table>

        <div id="toolbarItem" style="padding-left: 10px">
            <span>Filter :</span>
            <input id="filterValitem" onkeyup="inputKeyEnteritem(event)" style="border:1px solid #ccc">
            <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearchitem()">Search</a>
        </div>

        <br>

        <div id="dlg-buttons">
            <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#wi').window('close')">Close</a>
        </div>
    </div>
    <!-- END item modal -->




    <script src="<?php echo base_url('assets/js/accounting.min.js') ?>"></script>
    <script type="text/javascript">
        var editIndex = undefined;
        var lastIndex;
        var mode = '<?= $datax['mode'] ?>';
        var idx = '<?= $datax['idx']; ?>';


        //-----------------------------$('#dg').datagrid-----------------------------

        $(function() {
            // $("#pkd_rekanan").hide();
            // $("#pid_qs").hide();

            $('#kd_rekanan').combogrid({
                panelWidth: 600,
                url: '<?= base_url()  ?>accfin/Payment/getRekanan',
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
                            align: 'cente r'
                        },
                        {
                            field: 'nama_rekanan',
                            title: 'Descriptions',
                            align: 'left',
                            width: 350
                        },
                        {
                            field: 'jenis',
                            title: 'Position',
                            align: 'left',
                            width: 150
                        }
                    ]
                ]

            });


            $('#id_rek_gl').combogrid({
                panelWidth: 400,
                url: '<?= base_url()  ?>accfin/Payment/getCoaMaster/KAS',
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



            $('#dg').datagrid({
                onClickRow: function(rowIndex) {
                    if (lastIndex != rowIndex) {
                        $(this).datagrid('endEdit', lastIndex);
                        $(this).datagrid('beginEdit', rowIndex);
                    }
                    lastIndex = rowIndex;
                }
            });


            if (mode == 'edit') {
                //alert(idx);
                fetchMasterData(idx);
                fetchDetailData(idx);
            } else if (mode == 'add') {
                //alert(mode);
                // $('id_curr').combobox('setValue', 'IDR');
                // $('kurs').numberbox('setValue', 1);

            }

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
                        index: index
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
                index: index,
                field: 'id_rek_gl'
            });
            $('#dg').datagrid('getRows')[index]['id_rek_gl'] = $(ed.target).combobox('getText');

            var ped = $(this).datagrid('getEditor', {
                index: index,
                field: 'id_cc_project'
            });
            $('#dg').datagrid('getRows')[index]['id_cc_project'] = $(ped.target).combogrid('getText');
        }

        function append() {
            if (endEditing()) {
                $('#dg').datagrid('appendRow', {
                    id_payment_detail: 0
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
                url: "<?= base_url(); ?>accfin/Payment/getDataMaster",
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
                    $('#id_payment').textbox('setValue', data[0]['id_payment']);
                    $('#no_payment').textbox('setValue', data[0]['no_payment']);
                    $('#dt_payment').datebox('setValue', data[0]['dt_payment']);
                    $('#kd_rekanan').combogrid('setValue', data[0]['kd_rekanan']);
                    $('#id_rek_gl').combogrid('setValue', data[0]['id_rek_gl']);
                    $('#id_cc_project').combogrid('setValue', data[0]['id_cc_project']);
                    $('#remarks').textbox('setValue', data[0]['remarks']);
                    $('#nominal').numberbox('setValue', data[0]['nominal']);
                }
            });
        }

        function fetchDetailData(idx) {
            $.ajax({
                url: "<?= base_url(); ?>accfin/Payment/getDataDetail",
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
            var data = $('#dg').datagrid('getRows');
            var jml = 0;
            if (data.length > 0) {
                for (i = 0; i < data.length; i++) {
                    jml += parseFloat(data[i].dibayar);
                }
            }
            $('#nominal').numberbox('setValue', jml);
        }



        function saveDatax() {
            var id_payment = $('#id_payment').textbox('getValue');
            var no_payment = $('#no_payment').textbox('getValue');
            var dt_payment = $('#dt_payment').datebox('getValue');
            var kd_rekanan = $('#kd_rekanan').combogrid('getValue');
            var id_rek_gl = $('#id_rek_gl').combogrid('getValue');
            var remarks = $('#remarks').textbox('getValue');
            var total = $('#nominal').numberbox('getValue');

            var detail = $('#dg').datagrid('getRows');

            // VALIDATION FORM --------------------------------------
            if (dt_payment == '') {
                $.messager.alert('Warning', 'Payment date have value', 'warning');
                return false;
            } else if (id_rek_gl == '') {
                $.messager.alert('Warning', 'Account[Cd] must have value', 'warning');
                return false;
            } else if (kd_rekanan == '') {
                $.messager.alert('Warning', 'Employee must have value', 'warning');
                return false;
            }

            //console.log(detail);
            var master = [];

            master.push({
                id_payment: id_payment,
                no_payment: no_payment,
                dt_payment: dt_payment,
                kd_rekanan: kd_rekanan,
                id_rek_gl: id_rek_gl,
                remarks: remarks,
                total: total,
                an: '',
                bank: '',
                no_cek_bg_tt: '',
                jns_ttbg: '',
                idtrans: <?= $datax['idTrans']; ?>

            });



            var data = [];
            data.push({
                master: master,
                detail: detail
            });

            var uri;
            if (mode == 'edit') {
                uri = '<?= base_url(); ?>accfin/Payment/updatePayment';
            } else if (mode == 'add') {
                uri = '<?= base_url(); ?>accfin/Payment/insertPayment';
            }

            $.ajax({
                url: uri,
                method: "POST",
                dataType: 'json',
                data: {
                    info: data
                },
                error: function() {
                    $.messager.alert('iDeas', 'Some Error Ocured', 'error');
                },
                success: function(data) {
                    window.open('<?= base_url(); ?>accfin/Payment/Index/Cr', '_self');
                }
            });
        }

        function cancelData() {
            window.open('<?= base_url(); ?>accfin/Payment/Index/Cr', '_self');
            // window.open('<?//= base_url(); ?>procurement/Pr/index/<?//= $dtx ?>', '_self');
        }



        function getNoReff() {
            var idx = $("#kd_rekanan").val();
            if (idx == '') {
                $.messager.alert('iDeas', 'Field Paid To must have value', 'warning');
                return false;
            }

            $('#dgItem').datagrid({
                url: "<?= base_url(); ?>accfin/Payment/getNoReff/" + idx
            });

            $('#wi').window('open');

            $('#dgItem').datagrid({
                onDblClickRow: function() {
                    var row = $('#dgItem').datagrid('getSelected');
                    if (row) {
                        var editors = $('#dg').datagrid('getEditors', editIndex);
                        var n0 = $(editors[0].target);
                        var n1 = $(editors[1].target);
                        var n2 = $(editors[2].target);
                        var n3 = $(editors[3].target);
                        var n4 = $(editors[4].target);
                        n0.textbox('setValue', row.no_doc);
                        n1.textbox('setValue', row.remarks);
                        n2.textbox('setValue', row.id_cc_project);
                        n3.textbox('setValue', row.id_rek_gl);
                        n4.textbox('setValue', row.sisa);
                        $('#wi').window('close'); // hide modal
                        hitung_total();
                    }
                }
            });

        };
    </script>


</body>

</html>