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

    <div id="container" class="easyui-panel" style="width:100%;height:560px;padding:10px;">
        <table id='dgMain' class='easyui-datagrid' style='width:100%;height:520px;;' url="<?= base_url(); ?>master/Item/getItem" title="Item Data" pageSize="20" pagination='true' rownumbers='true' nowrap="false" fitColumns="true" toolbar="#toolbarFilter" singleSelect="true">
            <thead frozen='true'>
                <tr>
                    <th field="kd_item" width="100" align="left">ITEM #</th>
                    <th field="nama_item" width="300" align="left">ITEM NAME</th>
                </tr>
            </thead>
            <thead>
                <tr>
                    <th field="kd_satuan" width="75" align="left">UNIT</th>
                    <th field="kd_satuan_beli" width="75" align="left">PURCHASE UNIT</th>
                    <th field="rasio" width="50" align="center">RATIO</th>
                    <th field="item_type_name" width="150" align="left">TYPE NAME</th>
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
    <div id="dlg" class="easyui-panel" title="Item" style="width:100%;height:300px;padding:10px;" data-options="iconCls:'icon-save',closable:true,
                collapsible:true,minimizable:true,maximizable:true" closed="true">
        <form id="fm">
            <div class="row">
                <!-- BEGIN col-4 -->
                <div class="col-md-3">
                    <!-- BEGIN panel -->

                    <label style="width: 130px">Item ID #</label>
                    <input id="kd_item" name="kd_item" class="form-control m-b-10 input-sm" readonly="true" />
                    <label style="width: 130px">Item Type #</label>
                    <Select id="item_type_id" name="item_type_id" class="form-control m-b-10 input-sm">
                        <option value="-">Select Type</option>
                        <?php
                        foreach ($itemType as $row) {
                            echo '<option value="' . $row["item_type_id"] . '">' . $row["item_type_name"] . '</option>';
                        }
                        ?>
                    </Select>

                </div>


                <!-- BEGIN col-4 -->
                <div class="col-md-3">

                    <label style="width: 130px">Stok/Sales Unit </label>
                    <Select id="kd_satuan" name="kd_satuan" class="form-control m-b-10 input-sm">
                        <option value="-">Select Unit</option>
                        <?php
                        foreach ($unit as $row) {
                            echo '<option value="' . $row["kd_satuan"] . '">' . $row["deskripsi"] .  '</option>';
                        }
                        ?>
                    </Select>
                    <div class="row">
                        <div class="col-xs-6">
                            <label style="width: 130px">Purchase Unit</label>
                            <Select id="kd_satuan_beli" name="kd_satuan_beli" class="form-control m-b-10 input-sm">
                                <option value="-">Select Unit</option>
                                <?php
                                foreach ($unit as $row) {
                                    echo '<option value="' . $row["kd_satuan"] . '">' . $row["deskripsi"] . '</option>';
                                }
                                ?>
                            </Select>
                        </div>
                        <div class="col-xs-6">
                            <label style="width: 130px">Ratio :</label>
                            <input id="ratio" name="ratio" class="form-control m-b-10 input-sm" />
                        </div>
                    </div>



                </div>

                <div class="col-md-4">
                    <label style="width: 130px">Item Name</label>
                    <textarea class="form-control" name="nama_item" id="nama_item" rows="4"></textarea>
                </div>
            </div>

            <br>

            <div class="ftitle"></div>
            <div id="dlg-buttons">
                <a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="saveDatax()">Save</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').panel('close')">Cancel</a>
            </div>

        </form>
    </div>
    <!-- END OF  Modal -->

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
        $("#dlg").panel('setTitle', 'New Item');
        $('#dlg').panel('open');
        $('#fm').form('clear');
        document.getElementById('kd_item').value = '';
        document.getElementById('item_type_id').value = '';
        document.getElementById('kd_satuan').value = '';
        document.getElementById('kd_satuan_beli').value = '';
        document.getElementById('ratio').value = '1';
        document.getElementById('nama_item').value = '';



        url = '<?= base_url(); ?>master/Item/simpanItem';
        mode = 'add';
        scrollSmoothToBottom('content')
    }

    function editData() {
        var row = $('#dgMain').datagrid('getSelected');
        if (row) {
            $("#dlg").panel('setTitle', 'Update Item');
            $('#dlg').panel('open');
            //  $('#fm').form('load', row);
            document.getElementById('kd_item').value = row.kd_item;
            document.getElementById('item_type_id').value = row.item_type_id;
            document.getElementById('kd_satuan').value = row.kd_satuan;
            document.getElementById('kd_satuan_beli').value = row.kd_satuan_beli;
            document.getElementById('ratio').value = row.rasio;
            document.getElementById('nama_item').value = row.nama_item;


            // alert(row.nama_rekanan);
            url = '<?= base_url(); ?>master/Item/updateItem/' + row.kd_item;
            mode = 'edit';
            //            alert(url);
            scrollSmoothToBottom('content')
        }
    }

    function saveDatax() {

        var kd_item = $("#kd_item").val();
        var item_type_id = $("#item_type_id").val();
        var kd_satuan = $("#kd_satuan").val();
        var kd_satuan_beli = $("#kd_satuan_beli").val();
        var ratio = $("#ratio").val();
        var nama_item = $("#nama_item").val();

        //var xurl = '';
        //alert(xurl);
        $.ajax({
            url: url,
            method: "POST",
            dataType: 'json',
            data: {
                kd_item: kd_item,
                item_type_id: item_type_id,
                kd_satuan: kd_satuan,
                kd_satuan_beli: kd_satuan_beli,
                ratio: ratio,
                nama_item: nama_item

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
                    url: "<?= base_url(); ?>master/Item/destroyItem",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        id: row.kd_item
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