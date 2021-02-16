<!DOCTYPE html>

<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($this->session->userdata("username"))) {
    redirect(site_url(), 'refresh');
} elseif (empty($this->session->userdata("qts"))) {
    redirect(base_url('sales/Quotation'), 'refresh');
};
?>

<body>
    <table style="width: 100%;" cellspacing="0px" border="0">
        <tr>
            <td style="width:50%;text-align:left">
                <h4><?= $caption; ?></h4>
            </td>
            <td style="width:50%;text-align:right"><input id="id_qt" class="easyui-textbox" readonly="true" style="width:150px;"></td>
        </tr>
    </table>
    <hr>
    <!-- <h2><?//= $dtx;
        ?></h2>
    <h2><?//= $mode;
        ?></h2> -->
    <table style="width: auto;" cellspacing="5px" border="0">
        <tr>

            <td><input id="no_qt" class="easyui-textbox" label="Quotation #:" labelPosition="top" required="true" style="width:200px;"></td>
            <td><input id="nama_kontak" class="easyui-textbox" label="Contact Name:" labelPosition="top" required="true" style="width:300px;" data-options="
                    prompt: 'Search From Master',
                    iconWidth: 22,
                    icons: [{
                        iconCls:'icon-search',
                        handler: function(e){
                            onclick=CariCustomer();
                        }
                    }]"></td>
            <td><input id="lampiran" class="easyui-textbox" label="Attachment:" labelPosition="top" style="width:300px;"></td>
            <td><input id="id_cat_project" class="easyui-combogrid" label="Project Category:" labelPosition="top" style="width:300px;"></td>
            <td>
                <div id="pkd_rekanan">
                    <input id="kd_rekanan" class="easyui-textbox" style="width:100px;">
                </div>
            </td>
        </tr>


        <tr>
            <td><input id="revision" name="revision" class="easyui-textbox" label="Revision:" labelPosition="top" readonly="true" style="width:200px;"></td>
            <td rowspan="4"><input id="nama_rekanan" class="easyui-textbox" label="Customer Name:" labelPosition="top" multiline="true" required="true" style="width:300px;height:150px"></td>
            <td rowspan="4"><input id="proposal_description" class="easyui-textbox" label="Proposal Description:" labelPosition="top" multiline="true" required="true" style="width:300px;height:150px"></td>
            <td rowspan="4"><input id="pterm" class="easyui-textbox" label="Payment Terms: (separate line by '|')" labelPosition="top" multiline="true" style="width:300px;height:150px;"></td>
            <td>
                <div id="pid_qs">
                    <input id="id_qs" class="easyui-textbox" style="width:100px;">
                </div>
            </td>
        </tr>
        <tr>
            <td><input id="dt_qt" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="Quotation Date:" labelPosition="top" required="true" style="width:200px;"></td>
        </tr>
        <tr>
            <!--<td>-->
                <div id="pno_qs">
                <input id="no_qs" class="easyui-textbox" label="Quotsheet #:" labelPosition="top" required="false" style="width:200px;" data-options="
                        prompt: 'Search From Quotsheet',
                        iconWidth: 22,
                        icons: [{
                            iconCls:'icon-search',
                            handler: function(e){
                                onclick=cariQuotsheet();
                            }
                        }]">
                    </div>
            <!--</td> -->
            
            <td>
                <input id="margin_psn_x" class="easyui-numberbox" label="Margin[%]:" labelPosition="top" required="true" style="width:200px;">
            </td>


        </tr>
        <tr>
            <td style="width:auto;height:5px;"></td>
        </tr>

    </table>
    <br>
    <hr>

    <div>
        <table id="dg" class="easyui-datagrid" title="Quotation Detail" style="width:100%;height:auto" data-options="
                iconCls: 'icon-edit',
                singleSelect: true,
				toolbar: '#tb',
				rownumbers: true,
				showfooter: true,
                url: '',
                method: 'post',
                onClickCell: onClickCell,
                onEndEdit: onEndEditdg
            ">
            <thead>
                <tr>
                    <th data-options="field:'kd_item',width:80,editor:{type:'textbox',options:{precision:2,
					icons:[{
						iconCls:'icon-search',
						handler: function(e){
							onclick=listItemAdd();
                            
                        }
					}]}}" rowspan="2">Item ID</th>
                    <th data-options="field:'descriptions',width:400,editor:{type:'textbox',options:{readonly:true}}" rowspan="2">Descriptions</th>
                    <th data-options="field:'id_parent',width:150,
                                        formatter:function(value,row){
                                            return row.parentname;
                                        },
                                        editor:{
                                            type:'combobox',
                                            options:{
                                                valueField:'id_parent',
                                                textField:'parentname',
                                                method:'get',
                                                url:'<?= base_url(); ?>sales/Quotation/getParent',
                                                required:false
                                            }
                                        }" rowspan="2">Item Group</th>
                    <th data-options="field:'qty',width:70,align:'right',editor:{type:'numberbox',options:{precision:1,required:true,readonly:false}}" rowspan="2">Qty</th>
                    <th data-options="field:'kd_satuan',width:70,
                                        formatter:function(value,row){
                                            return row.kd_satuan;
                                        },
                                        editor:{
                                            type:'combobox',
                                            options:{
                                                valueField:'kd_satuan',
                                                textField:'kd_satuan',
                                                method:'get',
                                                url:'<?= base_url(); ?>sales/Quotation/getUnit',
                                                required:true
                                            }
                                        }" rowspan="2">Unit</th>
                    <th colspan="2">HPP</th>
                    <th colspan="3">Quot Price</th>
                    <th data-options="field:'id_qt_detail'" hidden="true" rowspan="2">id_qt_detail</th>
                </tr>
                <tr>
                    <th data-options="field:'unit_price',width:100,formatter:datagridFormatNumber,align:'right',readonly:'false',editor:{type:'numberbox',options:{precision:2,required:true,readonly:false}}">Unit Price</th>
                    <th data-options="field:'extended',width:100,formatter:datagridFormatNumber,align:'right',readonly:'true',editor:{type:'numberbox',options:{precision:2,required:true,readonly:true}}">Ammount</th>
                    <th data-options="field:'margin_psn',width:70,align:'right',editor:{type:'numberbox',options:{precision:0,required:true}}">Margin[%]</th>
                    <th data-options="field:'quot_price',width:100,formatter:datagridFormatNumber,align:'right',editor:{type:'numberbox',options:{precision:2,required:true}}">Unit Price</th>
                    <th data-options="field:'quot_extended',width:100,formatter:datagridFormatNumber,align:'right',editor:{type:'numberbox',options:{precision:2,required:true,readonly:true}}">Ammount</th>
                </tr>
            </thead>
        </table>
        <br>
        <table id="dgx" style="width:100%;height:auto" border="0">
            <tr>
                <td style="width:54%;height:30px" rowspan="4">

                </td>
                <td style="width:10%;height:30px;text-align:right">SUB TOTAL</td>
                <td style="width:13%;height:30px;text-align:right"><input id="sub_total" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
                <td style="width:20%;height:30px;text-align:right"><input id="sub_total_quot" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
                <td style="width:auto;height:30px"></td>
            </tr>
            <tr>

                <td style="width:10%;height:30px;text-align:right">VAT NUM</td>
                <td style="width:13%;height:30px;text-align:right"><input id="vat_num" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
                <td style="width:20%;height:30px;text-align:right"><input id="vat_num_quot" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
                <td style="width:auto;height:30px"></td>
            </tr>
            <tr>
                <td style="width:10%;height:30px;text-align:right">TOTAL</td>
                <td style="width:13%;height:30px;text-align:right"><input id="total" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
                <td style="width:20%;height:30px;text-align:right"><input id="total_quot" readonly class="easyui-numberbox" style="text-align: right; width: 150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
                <td style="width:auto;height:30px"></td>
            </tr>

        </table>

        <div id="tb" style="height:auto">
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="append()">Append</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeit()">Remove</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="acceptit()">Accept</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="reject()">Reject</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-folder',plain:true" onclick="newGroup()">Item Group</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-redo',plain:true" onclick="loadQuotsheet()">Load Quotsheet</a>
        </div>


 
    </div>

    <hr>
    <div >

        <!----------------------TABEL REMARKS ------------------------------------------->
        <table id="dgr">
        </table>
        <div id="tbr" style="height:auto">
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="insert()">Append</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-folder',plain:true" onclick="getDefRemarks()">Load Default</a>
        </div>
        <!--------------------------------END OF TABEL REMARKS------------------------------->    
    </div>

    <hr>
    <div >
        <!----------------------TABEL PAYMENT ------------------------------------------->
        <table id="dgp">
        </table>
        <div id="tbp" style="height:auto">
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="insert()">Append</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-folder',plain:true" onclick="getDefRemarks()">Load Default</a>
        </div>
        <!--------------------------------END OF TABEL PAYMENT------------------------------->    
    </div>    

    <hr>
        <div id="dlg-buttons" style="text-align: center;">
                <a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="saveDatax()">Save</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="cancelData()">Cancel</a>
        </div> 
    <hr>       


    <hr>
    <!-- QUOTSHEET -->
    <div id="dlgQuotsheet" class="easyui-dialog" style="width: 800px;height: 500px;" closed="true" buttons="#dlg-buttons-list-Quotsheet-add">
        <table id="grdQuotsheet" class="easyui-datagrid" style="width:auto;height:auto;" toolbar="#tbQuotsheet" fitColumns="true" sortable="true" singleSelect="true" rownumbers="true" striped="true" nowrap="false" pagination="true" pageSize="15" pageList="[15, 30, 45, 60]">
            <thead>
                <tr>
                    <th field="no_qs" width="80" align="center" sortable="true">Quotsheet #</th>
                    <th field="nama_rekanan" width="170" align="left" sortable="true">Customer</th>
                    <th field="proposal_description" width="170" align="left" sortable="true">Descriptions</th>
                    <th field="total" width="100" formatter="datagridFormatNumber" align="right" sortable="true">Value</th>
                </tr>
            </thead>
        </table>
    </div>
    <div id="dlg-buttons-list-Quotsheet-add">
        <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgQuotsheet').dialog('close');">Close</a>
    </div>
    <div id="tbQuotsheet" style="padding:10px;">
        <input id="filterValQuotsheet" onkeyup="inputKeyEnterQuotsheet(event)" style="line-height:26px;border:1px solid #ccc;">
        <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearchQuotsheet();">Cari</a>
    </div>
    <!-- END OF QUOTSHEET -->




    <!-- ITEM -->
    <div id="dlgListItemAdd" class="easyui-dialog" style="width: 800px;height: 500px;" closed="true" buttons="#dlg-buttons-list-item-add">
        <table id="grdListItemAdd" class="easyui-datagrid" style="width:auto;height:auto;" toolbar="#tbListItemAdd" fitColumns="true" sortable="true" singleSelect="true" rownumbers="true" striped="true" nowrap="false" pagination="true" pageSize="15" pageList="[15, 30, 45, 60]">
            <thead>
                <tr>
                    <th field="kd_item" width="80" align="center" sortable="true">Kode Item</th>
                    <th field="nama_item" width="170" align="left" sortable="true">Diskripsi</th>
                    <th field="kd_satuan" width="90" align="center" sortable="true">Satuan</th>
                    <th field="item_type_name" width="170" align="left" sortable="true">Type</th>
                </tr>
            </thead>
        </table>
    </div>
    <div id="dlg-buttons-list-item-add">
        <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgListItemAdd').dialog('close');">Close</a>
    </div>
    <div id="tbListItemAdd" style="padding:10px;">
        <input id="filterValLIA" onkeyup="inputKeyEnterLIA(event)" style="line-height:26px;border:1px solid #ccc;">
        <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearchLIA();">Cari</a>
    </div>
    <!-- END OF ITEM -->


    <!-- CUSTOMER -->
    <div id="dlgCariCustomer" class="easyui-dialog" style="width: 800px;height: 600px;" closed="true" buttons="#dlg-buttons-list-customer-add">
        <table id="grdCariCustomer" class="easyui-datagrid" style="width:auto;height:auto;" toolbar="#tbCariCustomer" fitColumns="true" sortable="true" singleSelect="true" rownumbers="true" striped="true" nowrap="false" pagination="true" pageSize="15" pageList="[15, 30, 45, 60]">
            <thead>
                <tr>
                    <th field="kd_rekanan" width="50" align="left" sortable="true">Customer ID</th>
                    <th field="nama_rekanan" width="170" align="left" sortable="true">Customer Name</th>
                    <th field="alamat" width="200" align="left" sortable="true">Address</th>
                    <th field="contact" width="100" align="left" sortable="true">Contact Name</th>
                </tr>
            </thead>
        </table>
    </div>
    <div id="dlg-buttons-list-customer-add">
        <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgCariCustomer').dialog('close');">Close</a>
    </div>
    <div id="tbCariCustomer" style="padding:10px;">>
        <span>Filter :</span>
        <input id="filterValCust" onkeyup="inputKeyEnterCust(event)" style="line-height:26px;border:1px solid #ccc;">
        <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearchCust();">Cari</a>
    </div>
    <!-- END OF CUSTOMER -->



    <!-- ITEM GROUP -->
    <div id="dlgGitem" class="easyui-dialog" style="width: 600px;height: 500px;" closed="true" buttons="#dlg-buttons-list-Gitem-add">
        <table id="grdGitem" class="easyui-datagrid" style="width:auto;height:auto;" toolbar="#tbGitem" fitColumns="true" sortable="true" singleSelect="true" rownumbers="true" striped="true" nowrap="false" pagination="true" pageSize="15" pageList="[15, 30, 45, 60]">
            <thead>
                <tr>
                    <th field="id_itemg" width="30" align="left" sortable="true">index</th>
                    <th field="id_parent" width="30" align="left" sortable="true">Group ID</th>
                    <th field="parentname" width="100" align="left" sortable="true">Group Name</th>
                </tr>
            </thead>
        </table>


        <!-- Modal -->
        <br>
        <div id="dlgNewGitem" class="easyui-panel" title="Item Group Data" style="width:550px;height:150px;padding:10px;" data-options="iconCls:'icon-save',closable:true,
                collapsible:true,minimizable:true,maximizable:true" closed="true">
            <form id="fm">
                <table>
                    <tr>
                        <td><input id="id_parent" class="easyui-textbox" label="Group ID:" labelPosition="top" required="true" style="width:150px;"></td>
                        <td><input id="parentname" class="easyui-textbox" label="Group Name:" labelPosition="top" required="true" style="width:250px;"></td>
                    </tr>
                </table>

                <br>

                <div class="ftitle"></div>
                <div id="dlg-buttons">
                    <a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="saveDatax()">Save</a>
                    <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgNewGitem').panel('close')">Cancel</a>
                </div>

            </form>
        </div>
        <!-- end of Modal -->


    </div>
    <div id="dlg-buttons-list-Gitem-add">
        <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgGitem').dialog('close');">Close</a>
    </div>
    <div id="tbGitem" style="padding:10px;">
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="newData();">New</a>
        <span>Filter :</span>
        <input id="filterValGitem" onkeyup="inputKeyEnterGitem(event)" style="line-height:26px;border:1px solid #ccc;">
        <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearchGitem();">Cari</a>
    </div>


    <!-- END OF ITEM GROUP -->

    <script src="<?php echo base_url('assets/js/accounting.min.js') ?>"></script>
    <script type="text/javascript">
        var editIndex = undefined;
        var lastIndex;
        var mode = '<?= $mode ?>';
        var idx = '<?= $idx; ?>';

        //-----------------------------$('#dg').datagrid-----------------------------

        $(function() {
             $("#pkd_rekanan").hide();
             $("#pid_qs").hide();
             $("#pno_qs").hide();


            // $('#no_qt').combogrid({
            //     panelWidth: 500,
            //     url: '<?= base_url()  ?>sales/Quotation/getProject',
            //     idField: 'id_cc_project',
            //     textField: 'id_cc_project',
            //     mode: 'remote',
            //     fitColumns: true,
            //     columns: [
            //         [{
            //                 field: 'id_cc_project',
            //                 title: 'ID',
            //                 width: 150,
            //                 align: 'center'
            //             },
            //             {
            //                 field: 'cc_project_name',
            //                 title: 'Project Name',
            //                 align: 'left',
            //                 width: 350
            //             }
            //         ]
            //     ]
                // ,
                // onSelect: function(index, row) {
                    //var desc = row.alamat; // the product's description
                    // $('#remarks').textbox('setValue', row.cc_project_name);
                    // $('#cust_po_number').textbox('setValue', row.po_number);
                    // $('#lokasi').textbox('setValue', row.lokasi);

                    // $('#kd_rekanan').combogrid('setValue', row.kd_rekanan);
                    // $('#id_cat_project').combogrid('setValue', row.id_cat_project);
                    // $('#manager').combogrid('setValue', row.manager);
                    // $('#id_rek_gl').combogrid('setValue', row.id_rek_gl);

                    // $('#dt_so').datebox('setValue', row.dt_order_char);
                    // $('#dt_finish').datebox('setValue', row.dt_finish_char);
                // }

            // });





            $('#id_cat_project').combogrid({
                panelWidth: 300,
                url: '<?= base_url()  ?>sales/Quotation/getCatProject',
                idField: 'id_cat_project',
                textField: 'cpdescriptions',
                mode: 'remote',
                fitColumns: true,
                columns: [
                    [{
                            field: 'id_cat_project',
                            title: 'ID',
                            width: 50,
                            align: 'center'
                        },
                        {
                            field: 'cpdescriptions',
                            title: 'Category Project',
                            align: 'left',
                            width: 250
                        }
                    ]
                ]

            });


            $('#grdListItemAdd').datagrid({
                onDblClickRow: function() {
                    var editors = $('#dg').datagrid('getEditors', editIndex);
                    var n1 = $(editors[0].target);
                    var n2 = $(editors[1].target);
                    var n4 = $(editors[4].target);
                    var row = $('#grdListItemAdd').datagrid('getSelected');
                    n1.textbox('setValue', row.kd_item);
                    n2.textbox('setValue', row.nama_item);
                    n4.textbox('setValue', row.kd_satuan);
                    $('#dlgListItemAdd').dialog('close');
                }
            });


            $('#grdCariCustomer').datagrid({
                onDblClickRow: function() {
                    var row = $('#grdCariCustomer').datagrid('getSelected');
                    $('#kd_rekanan').textbox('setValue', row.kd_rekanan);
                    $('#nama_kontak').textbox('setValue', row.contact);
                    $('#nama_rekanan').textbox('setValue', row.nama_rekanan + String.fromCharCode(13) + String.fromCharCode(10) + row.alamat);
                    $('#dlgCariCustomer').dialog('close');
                }
            });


            $('#grdQuotsheet').datagrid({
                onDblClickRow: function() {
                    var row = $('#grdQuotsheet').datagrid('getSelected');
                    $('#no_qs').textbox('setValue', row.no_qs);
                    $('#id_qs').textbox('setValue', row.id_qs);
                    $('#kd_rekanan').textbox('setValue', row.kd_rekanan);
                    $('#nama_kontak').textbox('setValue', row.nama_kontak);
                    $('#nama_rekanan').textbox('setValue', row.nama_rekanan);
                    $('#id_cat_project').combogrid('setValue', row.id_cat_project);
                    $('#proposal_description').textbox('setValue', row.proposal_description);
                    $('#dlgQuotsheet').dialog('close');
                }
            });



            $('#dg').datagrid({
                onClickRow: function(rowIndex) {
                    if (lastIndex != rowIndex) {
                        $(this).datagrid('endEdit', lastIndex);
                        $(this).datagrid('beginEdit', rowIndex);
                    }
                    lastIndex = rowIndex;
                },
                onBeginEdit: function(rowIndex) {
                    var editors = $('#dg').datagrid('getEditors', rowIndex);
                    var n1 = $(editors[3].target); //qty
                    var n2 = $(editors[5].target); //unit price
                    var n3 = $(editors[6].target); //subtotal
                    var n4 = $(editors[7].target); //margin
                    var n5 = $(editors[8].target); //quot price
                    var n6 = $(editors[9].target); //subtotal quot
                    // x1.add(x2).numberbox({
                    // 	onChange: function() {
                    // 		var c1 = x1.numberbox('getValue') * x2.numberbox('getValue');
                    // 		x3.numberbox('setValue', c1);
                    // 	}
                    // });
                    n1.add(n2).add(n4).numberbox({
                        onChange: function() {
                            var qty = parseFloat(n1.numberbox('getValue'));
                            var hrg = parseFloat(n2.numberbox('getValue'));
                            var mrg = (parseFloat(n4.numberbox('getValue')) / 100);
                            n3.numberbox('setValue', qty * hrg);
                            n5.numberbox('setValue', hrg * (1 + mrg));
                            n6.numberbox('setValue', qty * (hrg * (1 + mrg)));
                        }
                    });

                }
            });

            //-------------------------dgr remarks--------------------------------------------------------------

            $('#dgr').datagrid({
                title: 'Terms & Condition',
                iconCls: 'icon-edit',
                width: 1300,
                height: 300,
                singleSelect: true,
                rownumbers: true,
                nowrap: false,
                fitColumns: true,
                striped: true,
                toolbar: '#tbr',
                idField: 'itemid',
                url: '',
                columns: [
                    [{
                            field: 'id_qt_remarks',
                            title: 'ID',
                            hidden: true
                        },
                        {
                            field: 'nomor',
                            title: 'No.',
                            width: 80,
                            align: 'center',
                            editor: {
                                type: 'numberbox',
                                options: {
                                    precision: 0
                                }
                            }
                        },
                        {
                            field: 'descriptions',
                            title: 'Description',
                            width: 460,
                            editor: 'text'
                        },
                        {
                            field: 'action',
                            title: 'Action',
                            width: 100,
                            align: 'center',
                            formatter: function(value, row, index) {
                                if (row.editing) {
                                    var s = '<a href="javascript:void(0)" onclick="saverow(this)">Save</a> ';
                                    var c = '<a href="javascript:void(0)" onclick="cancelrow(this)">Cancel</a>';
                                    return s + c;
                                } else {
                                    var e = '<a href="javascript:void(0)" onclick="editrow(this)">Edit</a> ';
                                    var d = '<a href="javascript:void(0)" onclick="deleterow(this)">Delete</a>';
                                    return e + d;
                                }
                            }
                        }
                    ]
                ],
                onEndEdit: function(index, row) {
                    var ed = $(this).datagrid('getEditor', {
                        index: index
                        //field: 'productid'
                    });
                    //row.productname = $(ed.target).combobox('getText');
                },
                onBeforeEdit: function(index, row) {
                    row.editing = true;
                    $(this).datagrid('refreshRow', index);
                },
                onAfterEdit: function(index, row) {
                    row.editing = false;
                    $(this).datagrid('refreshRow', index);
                },
                onCancelEdit: function(index, row) {
                    row.editing = false;
                    $(this).datagrid('refreshRow', index);
                }
            });
            //-------------------------end of dgr remarks-------------------------------------------------------------------


            //-------------------------dgp payment--------------------------------------------------------------

            $('#dgp').datagrid({
                title: 'Payment Terms',
                iconCls: 'icon-edit',
                width: 1300,
                height: 300,
                singleSelect: true,
                rownumbers: true,
                nowrap: false,
                fitColumns: true,
                striped: true,
                toolbar: '#tbp',
                idField: 'itemid',
                url: '',
                columns: [
                    [{
                            field: 'id_qt_remarks',
                            title: 'ID',
                            hidden: true
                        },
                        {
                            field: 'nomor',
                            title: 'No.',
                            width: 80,
                            align: 'center',
                            editor: {
                                type: 'numberbox',
                                options: {
                                    precision: 0
                                }
                            }
                        },
                        {
                            field: 'descriptions',
                            title: 'Description',
                            width: 460,
                            editor: 'text'
                        },
                        {
                            field: 'action',
                            title: 'Action',
                            width: 100,
                            align: 'center',
                            formatter: function(value, row, index) {
                                if (row.editing) {
                                    var s = '<a href="javascript:void(0)" onclick="saverow(this)">Save</a> ';
                                    var c = '<a href="javascript:void(0)" onclick="cancelrow(this)">Cancel</a>';
                                    return s + c;
                                } else {
                                    var e = '<a href="javascript:void(0)" onclick="editrow(this)">Edit</a> ';
                                    var d = '<a href="javascript:void(0)" onclick="deleterow(this)">Delete</a>';
                                    return e + d;
                                }
                            }
                        }
                    ]
                ],
                onEndEdit: function(index, row) {
                    var ed = $(this).datagrid('getEditor', {
                        index: index
                        //field: 'productid'
                    });
                    //row.productname = $(ed.target).combobox('getText');
                },
                onBeforeEdit: function(index, row) {
                    row.editing = true;
                    $(this).datagrid('refreshRow', index);
                },
                onAfterEdit: function(index, row) {
                    row.editing = false;
                    $(this).datagrid('refreshRow', index);
                },
                onCancelEdit: function(index, row) {
                    row.editing = false;
                    $(this).datagrid('refreshRow', index);
                }
            });
            //-------------------------end of dgp payment------------------------------------------------------------------

            if (mode == 'add') {
                $('#revision').textbox('setValue', '0');
                getDefRemarks()
            } else {
                fetchMasterData(idx);
                fetchDetailData(idx);
                fetchRemarksData(idx);

            }
        });


        function fetchMasterData($idp) {
            $.ajax({
                url: "<?= base_url(); ?>sales/Quotation/getMasterData",
                method: "POST",
                dataType: 'json',
                data: {
                    idx: $idp
                },
                error: function() {
                    document.getElementById("addError").click(); // Click on the checkbox
                },
                success: function(data) {

                    var $norev = parseInt(data[0]['revision']);
                    if (mode == 'rev') {
                        $('#revision').textbox('setValue', $norev + 1);
                    } else {
                        $('#revision').textbox('setValue', $norev);
                    }

                    $('#id_qt').textbox('setValue', data[0]['id_qt']);
                    $('#dt_qt').datebox('setValue', data[0]['dt_qt']);
                    $('#no_qt').textbox('setValue', data[0]['no_qt']);
                    $('#no_qs').textbox('setValue', data[0]['no_qs']);
                    $('#id_qs').textbox('setValue', data[0]['id_qs']);

                    $('#kd_rekanan').textbox('setValue', data[0]['kd_rekanan']);
                    $('#nama_rekanan').textbox('setValue', data[0]['nama_rekanan']);
                    $('#nama_kontak').textbox('setValue', data[0]['nama_kontak']);
                    $('#lampiran').textbox('setValue', data[0]['lampiran']);
                    $('#proposal_description').textbox('setValue', data[0]['proposal_description']);
                    $('#pterm').textbox('setValue', data[0]['pterm']);
                    $('#id_cat_project').combogrid('setValue', data[0]['id_cat_project']);
                    $('#revision').textbox('setValue', data[0]['revision']);

                    $('#sub_total').numberbox('setValue', data[0]['sub_total']);
                    $('#vat_num').numberbox('setValue', data[0]['vat_num']);
                    $('#total').numberbox('setValue', data[0]['total']);
                    $('#sub_total_quot').numberbox('setValue', data[0]['sub_total_quot']);
                    $('#vat_num_quot').numberbox('setValue', data[0]['vat_num_quot']);
                    $('#total_quot').numberbox('setValue', data[0]['total_quot']);
                    $('#margin_psn_x').numberbox('setValue', data[0]['margin_psn']);

                }
            });
        }

        function fetchDetailData(idx) {
            $.ajax({
                url: "<?= base_url(); ?>sales/Quotation/getDetailData",
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

        function fetchRemarksData(idx) {
            $.ajax({
                url: "<?= base_url(); ?>sales/Quotation/getQuotRemarks",
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
                    $('#dgr').datagrid('loadData',
                        data
                    );
                }
            });

        }

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
                index: index,
                field: 'kd_satuan'
            });
            //row.kd_satuan = $(ed.target).combobox('getText');
            $('#dg').datagrid('getRows')[index]['kd_satuan'] = $(ed.target).combobox('getText');

            var ped = $(this).datagrid('getEditor', {
                index: index,
                field: 'id_parent'
            });
            //row.id_parent = $(ed2.target).combobox('getText');
            $('#dg').datagrid('getRows')[index]['parentname'] = $(ped.target).combobox('getText');
        }

        function append() {
            if (endEditing()) {
                $('#dg').datagrid('appendRow', {
                    id_qs_detail: 0
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


        function hitung_total() {
            var data = $('#dg').datagrid('getRows');
            var jml = 0;
            var jmlq = 0;
            if (data.length > 0) {
                for (i = 0; i < data.length; i++) {
                    jml += parseFloat(data[i].extended);
                    jmlq += parseFloat(data[i].quot_extended);
                }
            }

            var ppn = jml * (10 / 100);
            var ppnq = jmlq * (10 / 100);


            $('#sub_total').numberbox('setValue', jml);
            $('#vat_num').numberbox('setValue', ppn);
            $('#total').numberbox('setValue', jml + ppn);

            $('#sub_total_quot').numberbox('setValue', jmlq);
            $('#vat_num_quot').numberbox('setValue', ppnq);
            $('#total_quot').numberbox('setValue', jmlq + ppnq);
        }


        //-----------------------------END OF $('#dg').datagrid---------------------------------------------


        //-----------------------------$('#dgr').datagrid remarks--------------------------------------------


        function getRowIndex(target) {
            var tr = $(target).closest('tr.datagrid-row');
            return parseInt(tr.attr('datagrid-row-index'));
        }

        function editrow(target) {
            $('#dgr').datagrid('beginEdit', getRowIndex(target));
        }

        function deleterow(target) {
            $.messager.confirm('Confirm', 'Are you sure?', function(r) {
                if (r) {
                    $('#dgr').datagrid('deleteRow', getRowIndex(target));
                }
            });
        }

        function saverow(target) {
            $('#dgr').datagrid('endEdit', getRowIndex(target));
        }

        function cancelrow(target) {
            $('#dgr').datagrid('cancelEdit', getRowIndex(target));
        }

        function insert() {
            var row = $('#dgr').datagrid('getSelected');
            if (row) {
                var index = $('#dgr').datagrid('getRowIndex', row);
            } else {
                index = 0;
            }
            $('#dgr').datagrid('insertRow', {
                index: index,
                row: {
                    id_qs_remarks: '0'
                }
            });
            $('#dgr').datagrid('selectRow', index);
            $('#dgr').datagrid('beginEdit', index);
        }


        //------------------------------end of $('#dgr').datagrid remarks-------------------------



        function myformatter(date) {
            var y = date.getFullYear();
            var m = date.getMonth() + 1;
            var d = date.getDate();
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




        // Quotsheet
        function cariQuotsheet() {
            $('#dlgQuotsheet').dialog({
                title: 'Quotsheet Data',
                closed: false,
                cache: false,
                modal: true,
                width: $(window).width() - 400
            });
            $('#grdQuotsheet').datagrid({
                url: '<?= base_url(); ?>sales/Quotation/getQuotsheet'
            });
            $('#grdQuotsheet').datagrid('load', {
                searching: $('#filterValQuotsheet').val()
            });
        }

        function inputKeyEnterQuotsheet(e) {
            e.which = e.which || e.keyCode;
            if (e.which == 13) {
                doSearchQuotsheet();
            }
        }

        function doSearchQuotsheet() {
            $('#grdQuotsheet').datagrid('load', {
                searching: $('#filterValQuotsheet').val()
            });
        }
        //END OF Quotsheet


        // ITEM
        function listItemAdd() {
            $('#dlgListItemAdd').dialog({
                title: 'Master Item List',
                closed: false,
                cache: false,
                modal: true,
                width: $(window).width() - 400
            });
            $('#grdListItemAdd').datagrid({
                url: '<?= base_url(); ?>sales/Quotation/getItem'
            });
            $('#grdListItemAdd').datagrid('load', {
                searching: $('#filterValLIA').val() + "|" + $('#selectFilterLIA').combobox('getValue')
            });
        }

        function inputKeyEnterLIA(e) {
            e.which = e.which || e.keyCode;
            if (e.which == 13) {
                doSearchLIA();
            }
        }

        function doSearchLIA() {
            $('#grdListItemAdd').datagrid('load', {
                searching: $('#filterValLIA').val()
            });
        }
        //END OF ITEM



        // Gitem
        function newGroup() {
            $('#dlgGitem').dialog({
                title: 'Item Group List',
                closed: false,
                cache: false,
                modal: true
                //width: $(window).width() - 400
            });
            $('#grdGitem').datagrid({
                url: '<?= base_url(); ?>sales/Quotation/getGitem'
            });
            $('#grdGitem').datagrid('load', {
                searching: $('#filterValGitem').val()
            });
        }

        function inputKeyEnterGitem(e) {
            e.which = e.which || e.keyCode;
            if (e.which == 13) {
                doSearchGitem();
            }
        }

        function doSearchGitem() {
            $('#grdGitem').datagrid('load', {
                searching: $('#filterValGitem').val()
            });
        }

        function newData() {
            $("#dlgNewGitem").panel('setTitle', 'New Item Group');
            $('#dlgNewGitem').panel('open');
            $('#fm').form('clear');
        }

        function saveDatax() {

            var id_parent = $("#id_parent").val();
            var parentname = $("#parentname").val();

            url = '<?= base_url(); ?>sales/Quotation/simpanGitem';
            //alert(xurl);
            $.ajax({
                url: url,
                method: "POST",
                dataType: 'json',
                data: {
                    id_parent: id_parent,
                    parentname: parentname
                },
                error: function() {
                    $.messager.show({
                        title: 'Error',
                        msg: result.errorMsg
                    });
                },
                success: function(data) {
                    $('#grdGitem').datagrid('reload');
                    $('#dlgNewGitem').panel('close');
                }
            });
        }
        //END OF Gitem


        // CUSTOMER
        function CariCustomer() {
            $('#dlgCariCustomer').dialog({
                title: 'Master Customer List',
                closed: false,
                cache: false,
                modal: true,
                width: $(window).width() - 400
            });
            $('#grdCariCustomer').datagrid({
                url: '<?= base_url(); ?>sales/Quotation/getCustomer'
            });
            $('#grdCariCustomer').datagrid('load', {
                searching: $('#filterValCust').val()
            });
        }

        function inputKeyEnterCust(e) {
            e.which = e.which || e.keyCode;
            if (e.which == 13) {
                doSearchCust();
            }
        }

        function doSearchCust() {
            $('#grdCariCustomer').datagrid('load', {
                searching: $('#filterValCust').val()
            });
        }
        //END OF CUSTOMER

        function saveDatax() {

            var id_qt = $("#id_qt").val();
            var no_qt = $("#no_qt").val();
            var no_qs = $("#no_qs").val();
            var id_qs = $("#id_qs").val();
            var dt_qt = $("#dt_qt").val();
            var kd_rekanan = $("#kd_rekanan").val();
            var nama_kontak = $("#nama_kontak").val();
            var nama_rekanan = $("#nama_rekanan").val();
            var proposal_description = $("#proposal_description").val();
            var lampiran = $("#lampiran").val();
            var revision = $("#revision").val();
            var pterm = $("#pterm").val();
            var id_cat_project = $("#id_cat_project").val();

            var sub_total = $('#sub_total').numberbox('getValue');
            var vat_num = $('#vat_num').numberbox('getValue');
            var total = $('#total').numberbox('getValue');

            var sub_total_quot = $('#sub_total_quot').numberbox('getValue');
            var vat_num_quot = $('#vat_num_quot').numberbox('getValue');
            var total_quot = $('#total_quot').numberbox('getValue');
            var margin_psn = $('#margin_psn_x').numberbox('getValue');

            var detail = $('#dg').datagrid('getRows');

            // VALIDATION FORM --------------------------------------
            if (dt_qt == '') {
                $.messager.alert('Warning', 'Quotation Date must have value', 'warning');
                return false;
            } else if (nama_kontak == '') {
                $.messager.alert('Warning', 'Contact Name must have value', 'warning');
                return false;
            } else if (nama_rekanan == '') {
                $.messager.alert('Warning', 'Customer Name must have value', 'warning');
                return false;
            } else if (proposal_description == '') {
                $.messager.alert('Warning', 'Proposal Description must have value', 'warning');
                return false;
            } else if (pterm == '') {
                $.messager.alert('Warning', 'Payemnt Term must have value', 'warning');
                return false;
            } else if (id_cat_project == '') {
                $.messager.alert('Warning', 'Category must have value', 'warning');
                return false;
            }
            var master = [];

            master.push({
                id_qt: id_qt,
                no_qt: no_qt,
                dt_qt: dt_qt,
                no_qs: no_qs,
                id_qs: id_qs,
                kd_rekanan: kd_rekanan,
                nama_kontak: nama_kontak,
                nama_rekanan: nama_rekanan,
                proposal_description: proposal_description,
                lampiran: lampiran,
                revision: revision,
                sub_total: sub_total,
                vat_num: vat_num,
                total: total,
                sub_total_quot: sub_total_quot,
                vat_num_quot: vat_num_quot,
                total_quot: total_quot,
                margin_psn: margin_psn,
                pterm: pterm,
                id_cat_project: id_cat_project,
                idtrans: <?= $idtrans; ?>
            });


            ////-----------------------------remarks-------------------------
            var remak = [];
            var dgr = $('#dgr');

            $.map(dgr.datagrid('getRows'), function(row) {
                dgr.datagrid('endEdit', dgr.datagrid('getRowIndex', row))
            })

            $.map(dgr.datagrid('getRows'), function(row) {
                remak.push({
                    id_qt_remarks: row.id_qt_remarks,
                    nomor: row.nomor,
                    descriptions: row.descriptions,
                });
            })
            ////-----------------------------end of remarks-------------------------


            var data = [];
            data.push({
                master: master,
                detail: detail,
                dremarks: remak
            });

            var uri;
            if (mode == 'edit') {
                uri = '<?= base_url(); ?>sales/Quotation/updateQuot';
            } else if (mode == 'add') {
                uri = '<?= base_url(); ?>sales/Quotation/insertQuot';
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
                    window.open('<?= base_url(); ?>sales/Quotation', '_self');
                }
            });
        }

        function cancelData() {
            window.open('<?= base_url(); ?>sales/Quotation', '_self');
        }


        function loadQuotsheet() {
            var id_qs = $("#id_qs").val();
            var margin = $('#margin_psn_x').numberbox('getValue');

            if (id_qs == '') {
                $.messager.alert('Warning', 'Quotsheet Number must have value', 'warning');
                return false;
            } else if (margin == '') {
                $.messager.alert('Warning', 'Margin [%] must have value', 'warning');
                return false;
            } else if (margin == 0) {
                $.messager.alert('Warning', 'Margin [%] must have value', 'warning');
                return false;
            }

            var master = [];
            master.push({
                id_qs: id_qs,
                margin: margin
            });


            $.ajax({
                url: "<?= base_url(); ?>sales/Quotation/getDQuotsheet",
                method: "POST",
                dataType: 'json',
                data: {
                    info: master
                },
                error: function() {
                    document.getElementById("delError").click(); // Click on the checkbox
                },
                success: function(data) {
                    $('#dg').datagrid('loadData',
                        data
                    );
                    hitung_total();
                }
            });

        }


        function getDefRemarks() {
            // var id_qs = $("#id_qs").val();
            $.ajax({
                url: "<?= base_url(); ?>sales/Quotation/getDefaultRemarks",
                method: "POST",
                dataType: 'json',
                data: {
                    idqs: 0
                },
                error: function() {
                    document.getElementById("delError").click(); // Click on the checkbox
                },
                success: function(data) {
                    $('#dgr').datagrid('loadData',
                        data
                    );
                }
            });

        }


        ///-----------------------------------IMPORT EXCEL-----------------------
        $('#form_ticketing').on('submit', function(e) {
            e.preventDefault();
            //alert('submit');

            $.ajax({
                url: "<?php echo base_url("sales/Quotation/importExcel"); ?>",
                type: "POST",
                data: $('#form_ticketing').serialize(),
                dataType: 'json',
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                success: function(data) {
                    $.messager.alert('Success', 'Import Data Berhasil');
                    $('#dg').datagrid('loadData',
                        data['rows']
                    );
                    hitung_total();

                },
                error: function() {
                    $.messager.show({
                        title: 'Error',
                        msg: result.errorMsg
                    });
                }
            });
        });

        // END OF IMPORT EXCEL
    </script>


</body>

</html>