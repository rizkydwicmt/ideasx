<html>

<head>
    <title>Daftar Kode Induk</title>
    <style>
        body,
        table,
        input {
            font-size: 12px
        }
    </style>

    <!-- ================== BEGIN EASYUI ================== -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/easyui'); ?>/themes/Default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/easyui'); ?>/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url('assets/easyui/jquery.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/easyui/jquery.easyui.min.js') ?>"></script>
    <!-- ================== END EASYUI ================== -->

</head>

<body>

    <table id="dgParent" class="easyui-datagrid" style="width:550px;height:600px; padding-left:10px" url="<?= base_url(); ?>Coa/getParentSql" singleSelect="true" rownumbers="true" pagination="false" toolbar="#toolbarFilter">
        <thead>
            <tr>
                <th field="id_rek_gl" width=80>Account ID</th>
                <th field="descriptions" width=350 align=left>Account Name</th>
                <th field="lvl" width=50 align=center>Level</th>
            </tr>
        </thead>
    </table>

    <div id="toolbarFilter" style="padding-left: 10px">
        <span>Filter :</span>
        <input id="filterVal" onkeyup="inputKeyEnter(event)" style="border:1px solid #ccc">
        <a href="#" class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearch()">Cari</a>
        <span>|</span>
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="pilihData()">Choose</a>
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

        function doSearch() {
            $('#dgParent').datagrid('load', {
                searching: $('#filterVal').val()
            });
        }

        function pilihData() {
            var row = $('#dgParent').datagrid('getSelected');
            opener.document.fm.id_parent.value = row.id_rek_gl;
            self.close();
        }
    </script>

</body>

</html>