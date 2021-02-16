<!DOCTYPE html>
<html>

<?php $this->load->view("includes/head.php", $head) ?>

<style type="text/css">
  main{
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 4fr;
  }
  main.two{
    display: grid;
    grid-template-columns: 4fr 1fr 2fr;
  }
  main.one{
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 4fr;
  }
  main.four{
    display: grid;
    grid-template-columns: 1fr 1fr 2fr 7fr 6fr;
  }

  .cell{
    display: table-cell;
    border: 1px solid black;
    height:100px;
  }

  .wr{
    color: red;
  }
  .thick {
  font-weight: bold;
}

hr.new1 {
  border-top: 1px solid black;
}
div {
  font-size: 11px;
}
</style>

<body class="hold-transition skin-green-light sidebar-mini">
<div class="wrapper">

<?php $this->load->view("includes/navbar.php", $navbar) ?>
<?php $this->load->view("includes/sidebar.php", $sidebar) ?>

  <div class="content-wrapper">
    <section class="content-header">
      <h1>Daftar Jurnal Hutang</h1>
    </section>

    <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-primary">
              <div id="width-sensor" class="box-body">
                  <div style = "margin-bottom:5px">
                    <input id="start-date" label="Tanggal" class="easyui-datebox" required="required" style="width:200px; height: 20px;" data-options="formatter:appDateFormatter,parser:appDateParser">
                    <input id="end-date" label="s/d : " class="easyui-datebox" required="required" style="width:150px; height: 20px;" labelWidth="25px;" data-options="formatter:appDateFormatter,parser:appDateParser">
                  </div>
                  <div style = "margin-bottom:5px">
                      <select id="jenis-kriteria" class="easyui-combobox" name="dept" data-options="panelHeight:'auto'" style="width:200px;  height: 20px; margin-top: 5px; " label="Kriteria">
                          <option value="0">Semua Kriteria</option>
                          <option value="1">No Jurnal</option>
                          <option value="2">Keterangan</option>
                        </select>
                      <input id="kriteria" class="easyui-textbox" type="text" label="" style="width:300px; vertical-align: middle; height: 20px; margin-top: 0px; margin-left: 25px;">
                      <a href="#" class="easyui-linkbutton btn-cari" data-options="iconCls:'icon-filter'" style="height: 20px; margin-top: 0px;">Filter</a>
                  </div>
                  <div style = "margin-bottom:5px">
                      <select id="supplier" class="easyui-combobox" name="supplier" data-options="panelHeight:'auto'" style="width:503px;  height: 20px; margin-top: 5px; " label="Supplier">
                          <option value="">Semua Supplier</option>
                        </select>
                  </div>
                  <div style = "margin-bottom:10px">
                      <select id="data-status" class="easyui-combobox" name="data-status" data-options="panelHeight:'auto'" style="width:200px;  height: 20px; margin-top: 5px; " label="Status">
                          <option value="0">Semua</option>
                          <option value="1">Open</option>
                          <option value="2">Verified</option>
                        </select>
                  </div>
                <table id="dg" title="Daftar Jurnal Hutang" style="width:100%; min-height: 475px;"
                		toolbar="#toolbar" pagination="true" nowrap="false"
                		rownumbers="true" fitColumns="false" autoRowHeight="true"  singleSelect="true">
                </table>
                <div id="toolbar">
                    <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="tambah_jurnal_hutang()">Tambah</a>
                    <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="ubah_jurnal_hutang()">Ubah</a>
                    <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="hapus_jurnal_hutang()">Hapus</a>
                    <a href="#" class="easyui-linkbutton" iconCls="icon-document" plain="true" onclick="tampilkan_jurnal_hutang()">Tampil</a>
                    <!-- <a href="#" class="easyui-linkbutton" iconCls="icon-print" plain="true">Cetak</a> -->
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
  </div>

  <div id="window-jurnal-hutang" class="easyui-window" title="Input Jurnal Hutang" style="width:1300px;height:570px;padding:10px;">
      <input id="status-hutang" type="text" hidden>
      <main style="height: 20px;">
        <div style="margin-left: 45px; width: 80px ;text-align: right;">
          No. Hutang :
        </div>
        <div style="margin-left: 5px">
          <input id="no-hutang" class="easyui-textbox" name="name" style="width:100%;height: 20px" data-options="label:'' " readonly>
        </div>
        <div style="margin-left: 45px; width: 70px; text-align: right;">
          Tanggal : 
        </div>
        <div style="margin-left: 5px;">
           <input id="tanggal-hutang" class="easyui-datebox" data-options="formatter:appDateFormatter,parser:appDateParser" label="" labelPosition="top" style="width:100%;height: 20px"> 
        </div>
        <div style="margin-left: 10px">
          <a href="#" class="easyui-linkbutton" id="verifikasi-jurnal-hutang" plain="te" onclick="verifikasi_jurnal_hutang()"  style="height: 25px;width:100px">Verifikasi</a>
        </div>
        <div style="margin-top: 5px; " id="label-status-jurnal-hutang">
        </div>
        <div style="margin-top: 5px; text-align: left" id="isi-label-status-jurnal-hutang" class="wr">
        </div>
      </main>
      <main style="height: 20px; margin-top: 5px">
        <div style="margin-left: 45px; width: 80px ;text-align: right;">
          Jenis Hutang :
        </div>
        <div style="margin-left: 5px">
          <select id="jenis-hutang" class="easyui-combobox" data-options="panelHeight:'auto'"  name="dept" style="width:100%;height: 20px" labelwidth="100px">
            <option value="1">Obat</option>
            <option value="2">Alkes</option>
            <option value="3">Gas Medik</option>
            <option value="4">General</option>
            <option value="5">Jasa</option>
            </select>
        </div>
        <div style="margin-left: 45px; width: 70px; text-align: right;">
           Uang Muka :
        </div>
        <div style="margin-left: 5px;">
          <input type="checkbox" name="is_dp" id="is-dp" style="vertical-align: sub;"> 
        </div>
      </main>
      <main style="height: 20px; margin-top: 5px">
        <div style="margin-left: 45px; width: 80px ;text-align: right;">
          Supplier :
        </div>
        <div style="margin-left: 5px">
           <select id="supplier-window" class="easyui-combobox" data-options="panelHeight:'auto'"  name="dept" style="height: 20px; width:395px;margin-left: 4px;" >
          </select>
        </div>
      </main>
      <main style="height: 20px; margin-top: 5px">
        <div style="margin-left: 45px; width: 80px ;text-align: right;">
          No. PO :
        </div>
        <div style="margin-left: 5px">
          <input id="no-po" class="easyui-textbox"  name="name" style="width:100%;height: 20px" data-options="label:'' ">
        </div>
        <div style="margin-left: 45px; width: 70px; text-align: right;">
          Tgl. PO : 
        </div>
        <div style="margin-left: 5px;">
           <input id="tanggal-po" class="easyui-datebox" label="" data-options="formatter:appDateFormatter,parser:appDateParser" labelPosition="top" style="width:100%;height: 20px"> 
        </div>
      </main>
      <main style="height: 20px; margin-top: 5px">
        <div style="margin-left: 45px; width: 80px ;text-align: right;">
          No. Inv. Supp :
        </div>
        <div style="margin-left: 5px">
          <input id="no-invoice-supplier" class="easyui-textbox" name="name" style="width:100%;height: 20px" data-options="label:'' ">
        </div>
        <div style="margin-left: 30px; width: 85px; text-align: right;">
          Tgl. Jatuh Tempo : 
        </div>
        <div style="margin-left: 5px;">
           <input id="tanggal-jatuh-tempo" class="easyui-datebox" data-options="formatter:appDateFormatter,parser:appDateParser" label="" labelPosition="top" style="width:100%;height: 20px"> 
        </div>
      </main>
      <main style="height: 20px; margin-top: 5px">
        <div style="margin-left: 45px; width: 80px ;text-align: right;">
          No. Faktur Pajak :
        </div>
        <div style="margin-left: 5px">
          <input id="no-faktur-pajak" class="easyui-textbox" name="name" style="width:100%;height: 20px" data-options="label:'' ">
        </div>
        <div style="margin-left: 30px; width: 85px; text-align: right;">
          Tgl. Faktur Pajak : 
        </div>
        <div style="margin-left: 5px;">
          <input id="tanggal-faktur-pajak" class="easyui-datebox" data-options="formatter:appDateFormatter,parser:appDateParser" label="" labelPosition="top" style="width:100%;height: 20px"> 
        </div>
      </main>
      <main style="height: 30px; margin-top: 5px">
        <div style="margin-left: 45px; width: 80px ;text-align: right;">
          Keterangan :
        </div>
        <div style="margin-left: 5px">
          <input id="keterangan" class="easyui-textbox" labelPosition="left" multiline="true" style="width:395px;height:30px;">
        </div>
      </main>

    <!-- <div style="margin-left: 10px; ">
          <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="te"  id="open-window" style="height: 25px">Tambah BPB</a>
          <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="te" style="height: 25px" id="open-window">Hapus BPB</a>
    </div> -->
    <main class="two" style="margin-left: 10px;margin-top: 3px">
      <div style="margin-top: 10px">
        <table id="dg-jurnal-hutang" class="easyui-datagrid" style="height: 230px; margin-top: 1px;width: 1000px"
            rownumbers="false" fitColumns="true" singleSelect="true" autoRowHeight="true">
        </table>
        <div id="toolbar-detail">
          <a href="#" class="easyui-linkbutton" id="tambah-jurnal-hutang" iconCls="icon-add" plain="true" onclick="insert_hutang()">Tambah</a>
        </div>
      </div>
      <div style="margin-top: 10px">
        <div style="text-align: right;">Sub Total : </div>
        <div style="text-align: right; margin-top: 12px">Diskon : </div>
        <div style="text-align: right; margin-top: 6px">Sub Total Setelah Diskon : </div>
        <div style="text-align: right; margin-top: 4px">PPN :
          <input id="ppn" class="easyui-numberbox" value="0" style="width:40px;height: 20px;text-align:right;" data-options="min:0, max:100, precision:2, decimalSeparator:','"> %
        </div>
        <div style="text-align: right; margin-top: 9px">Jenis PPh :</div>
        <div style="text-align: right; margin-top: 9px">PPh :
            <input id="pph" class="easyui-numberbox" value="0" style="width:40px;height: 20px;text-align:right;" data-options="min:0, max:100, precision:2, decimalSeparator:','"> %
        </div>
        <div style="text-align: right; margin-top: 8px">Biaya Lain-lain : </div>
        <div style="text-align: right; margin-top: 10px">Total Hutang : </div>
      </div>
      <div style="margin-top: 5px">
        <div style="margin-left: 5px;width:120px; ">
          <input id="sub-total" class="easyui-numberbox" readonly value="0" style="width:120px;height: 20px;text-align:right;" data-options="min:0, precision:2, decimalSeparator:',', groupSeparator:'.'">
        </div>
          <div style="margin-left: 5px;margin-top: 5px;width:120px;">
          <input id="diskon" class="easyui-numberbox" value="0" style="width:120px;height: 20px;text-align:right;" data-options="min:0, precision:2, decimalSeparator:',', groupSeparator:'.'">
        </div>
          <div style="margin-left: 5px;margin-top: 5px;width:120px;">
          <input id="sub-total-setelah-diskon" class="easyui-numberbox" readonly value="0" style="width:120px;height: 20px;text-align:right;" data-options="min:0, precision:2, decimalSeparator:',', groupSeparator:'.'">
        </div>
          <div style="margin-top: 5px; margin-left: 5px;width:120px;">
          <input id="harga-ppn" class="easyui-numberbox" readonly value="0" style="width:120px;height: 20px;text-align:right;" data-options="min:0, precision:2, decimalSeparator:',', groupSeparator:'.'">
        </div>
          <div style="margin-top: 5px; margin-left: 5px;width:120px;">
              <select id="jenis-pph" class="easyui-combobox" data-options="panelHeight:'auto'"  name="dept" style="width:100%;height: 20px" labelwidth="100px">
              <option value="1">Tanpa PPh</option>
              <option value="2">PPh 21</option>
              <option value="3">PPh 23</option>
              <option value="4">PPh Pasal 4 ayat 2</option>
              </select>
        </div>
          <div style="margin-top: 5px; margin-left: 5px;width:120px;">
          <input id="harga-pph" class="easyui-numberbox" readonly value="0" style="width:120px;height: 20px;text-align:right;" data-options="min:0, precision:2, decimalSeparator:',', groupSeparator:'.'">
        </div>
        <div style="margin-top: 4px; margin-left: 5px;width:120px;">
          <input id="biaya-lain" class="easyui-numberbox" value="0" style="width:120px;height: 20px;text-align:right;" data-options="min:0, precision:2, decimalSeparator:',', groupSeparator:'.'">
        </div>
        <div style="margin-top: 2px; margin-left: 5px;width:120px;">
            <input id="total-hutang" class="easyui-numberbox" readonly value="0" style="width:120px;height: 20px;text-align:right;" data-options="min:0, precision:2, decimalSeparator:',', groupSeparator:'.'">
        </div>
      </div>
    </main>
    <div style="margin-left: 10px;margin-bottom: 20px;margin-top:20px;">
          <a href="#" class="easyui-linkbutton" iconCls="icon-save" id="simpan-jurnal-hutang" plain="te" style="height: 25px;width: 70px" onclick="simpan_jurnal_hutang()">Simpan</a>
          <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" id="batal-jurnal-hutang" plain="te" style="height: 25px; width: 70px" onclick="batal_jurnal_hutang()">Batal</a>
    </div>
  </div>

  <?php $this->load->view("includes/footer.php") ?>
  <?php $this->load->view("includes/sidebar_control.php") ?>
</div>
<?php $this->load->view("includes/js.php") ?>
<script type="text/javascript">

function tambah_jurnal_hutang() {
    $("#label-status-jurnal-hutang").hide();
    $("#isi-label-status-jurnal-hutang").hide();
    $("#simpan-jurnal-hutang").show();
    $("#batal-jurnal-hutang").show();
    $("#verifikasi-jurnal-hutang").hide();
    $('#window-jurnal-hutang').window({
        title : 'Tambah Jurnal Hutang',
        collapsible : false,
        minimizable : false,
        maximizable : false,
        closable : true,
        onOpen: function(){
            $('#dg-jurnal-hutang').datagrid({
                toolbar: '#toolbar-detail',
                columns:[[
                    {
                        field : 'coa',
                        title : 'Kode Rekening',
                        width : 35,
                        halign:'center',
                        formatter : function(value, row) {
                            return row.coa || value;
                        },
                        editor : {
                            type : 'combobox',
                            options : {
                                valueField : 'coa_id',
                                textField : 'coa',
                                url : '<?php echo base_url('akuntansi/master/kode_rekening_coa/api_daftar_kode_rekening_coa') ?>',
                                required : true
                            }
                        }
                    },
                    {
                        field : 'cc',
                        title : 'Cost Center',
                        width : 35,
                        halign:'center',
                        formatter : function(value, row) {
                            return row.cc_name || value;
                        },
                        editor : {
                            type : 'combobox',
                            options : {
                                valueField : 'cc_id',
                                textField : 'cc_name',
                                url : '<?php echo base_url('akuntansi/master/kode_cost_center/api_daftar_kode_cost_center') ?>',
                                required : true
                            }
                        }
                    },
                    {
                        field : 'deskripsi',
                        title : 'Deskripsi',
                        width : 45,
                        halign:'center',
                        editor : 'textbox'
                    },
                    {
                        field : 'jumlah',
                        title : 'Jumlah',
                        width : 20,
                        halign:'center',
                        align:'right',
                        editor : {
                            'type' : 'numberbox',
                            'options' : {
                                'precision' : 2,
                                'min' : 0,
                                'groupSeparator' :'.',
                                'decimalSeparator' :','
                            }
                        },
                        formatter: datagridFormatNumber
                    },
                    {
                        field : 'action',
                        title : 'Action',
                        width : 15,
                        halign:'center',
                        align : 'center',
                        formatter : function(value, row, index) {
                            if (row.editing) {
                                var s = '<a href="javascript:void(0)" onclick="save_row(this)">Simpan</a> ';
                                var c = '<a href="javascript:void(0)" onclick="cancel_row(this)">Batal</a>';
                                return s + c;
                            } else {
                                var e = '<a href="javascript:void(0)" onclick="edit_row(this)">Ubah</a> ';
                                var d = '<a href="javascript:void(0)" onclick="delete_row(this)">Hapus</a>';
                                return e + d;
                            }
                        }
                    },
                ]],
                onDblClickRow:function(index,row){
                    $.map($('#dg-jurnal-hutang').datagrid('getRows'), function(row){
                        var index = $('#dg-jurnal-hutang').datagrid('getRowIndex', row);
                        $('#dg-jurnal-hutang').datagrid('updateRow', {
                            index: index,
                            row: {
                                status:'P'
                            }
                        });
                        $('#dg-jurnal-hutang').datagrid('selectRow',index);
                        $('#dg-jurnal-hutang').datagrid('beginEdit',index);
                    });
                },
                onEndEdit : function(index, row) {
                    var coa = $(this).datagrid('getEditor', {
                        index : index,
                        field : 'coa'
                    });
                    row.coa = $(coa.target).combobox('getText');
                    row.coa_id = $(coa.target).combobox('getValue');

                    var cc = $(this).datagrid('getEditor', {
                        index : index,
                        field : 'cc'
                    });
                    row.cc_name = $(cc.target).combobox('getText');
                    row.cc_id = $(cc.target).combobox('getValue');
                },
                onBeforeEdit : function(index, row) {
                    row.coa = row.coa_id;
                    row.cc = row.cc_id;
                    row.editing = true;
                    $(this).datagrid('refreshRow', index);
                },
                onAfterEdit : function(index, row){
                    row.editing = false;
                    $(this).datagrid('refreshRow', index);
                    hitung_sub_total($(this).datagrid('getRows'));
                },
                onCancelEdit : function(index, row){
                    row.editing = false;
                    $(this).datagrid('refreshRow', index);
                }
            });

            $("#tambah-jurnal-hutang").show();
            $('#dg-jurnal-hutang').datagrid('loadData', []);
            $('#no-hutang').textbox('setValue', '');
            $('#no-hutang').textbox('readonly', true);
            $('#tanggal-hutang').datebox('setValue', appDateFormatter(new Date()));
            $('#tanggal-hutang').datebox('readonly', false);
            $('#jenis-hutang').combobox('setValue', '');
            $('#jenis-hutang').combobox('readonly', false);
            $('#is-dp').prop('checked', false);
            $('#supplier-window').combobox('setValue', '');
            $('#supplier-window').combobox('readonly', false);
            $('#no-po').textbox('setValue', '');
            $('#no-po').textbox('readonly', false);
            $('#tanggal-po').datebox('setValue', appDateFormatter(new Date()));
            $('#tanggal-po').datebox('readonly', false);
            $('#no-invoice-supplier').textbox('setValue', '');
            $('#no-invoice-supplier').textbox('readonly', false);
            $('#no-faktur-pajak').textbox('setValue', '');
            $('#no-faktur-pajak').textbox('readonly', false);
            $('#keterangan').textbox('setValue', '');
            $('#keterangan').textbox('readonly', false);
            $('#tanggal-jatuh-tempo').datebox('setValue', appDateFormatter(new Date()));
            $('#tanggal-jatuh-tempo').datebox('readonly', false);
            // $('#tanggal-faktur-pajak').datebox('setValue', $.datepicker.formatDate('dd/mm/yy', new Date()));
            $('#tanggal-faktur-pajak').datebox('setValue', '');
            $('#tanggal-faktur-pajak').datebox('readonly', false);
            $('#sub-total').numberbox('setValue', 0);
            $('#sub-total').numberbox('readonly', true);
            $('#diskon').numberbox('setValue', 0);
            $('#diskon').numberbox('readonly', false);
            $('#sub-total-setelah-diskon').numberbox('setValue', 0);
            $('#sub-total-setelah-diskon').numberbox('readonly', true);
            $('#ppn').numberbox('setValue', 0);
            $('#ppn').numberbox('readonly', false);
            $('#harga-ppn').numberbox('setValue', 0);
            $('#harga-ppn').numberbox('readonly', true);
            $('#jenis-pph').combobox('setValue', 1);
            $('#jenis-pph').combobox('readonly', false);
            $('#pph').numberbox('setValue', 0);
            $('#pph').numberbox('readonly', false);
            $('#harga-pph').numberbox('setValue', 0);
            $('#harga-pph').numberbox('readonly', true);
            $('#biaya-lain').numberbox('setValue', 0);
            $('#biaya-lain').numberbox('readonly', false);
            $('#total-hutang').numberbox('setValue', 0);
            $('#total-hutang').numberbox('readonly', true);
        }
    });
}

function batal_jurnal_hutang() {
    $('#no-hutang').textbox('setValue', '');
    $('#tanggal-hutang').datebox('setValue', '');
    $('#jenis-hutang').combobox('setValue', '');
    $("#is-dp").prop( "checked", false);
    $('#supplier-window').combobox('setValue', '');
    $('#no-po').textbox('setValue', '');
    $('#tanggal-po').datebox('setValue', '');
    $('#no-invoice-supplier').textbox('setValue', '');
    $('#no-faktur-pajak').textbox('setValue', '');
    $('#keterangan').textbox('setValue', '');
    $('#tanggal-jatuh-tempo').datebox('setValue', '');
    $('#tanggal-faktur-pajak').datebox('setValue', '');
    $('#sub-total').numberbox('setValue', 0);
    $('#diskon').numberbox('setValue', 0);
    $('#sub-total-setelah-diskon').numberbox('setValue', 0);
    $('#ppn').numberbox('setValue', 0);
    $('#harga-ppn').numberbox('setValue', 0);
    $('#jenis-pph').combobox('setValue', 1);
    $('#pph').numberbox('setValue', 0);
    $('#harga-pph').numberbox('setValue', 0);
    $('#biaya-lain').numberbox('setValue', 0);
    $('#total-hutang').numberbox('setValue', 0);
    $('#dg-jurnal-hutang').datagrid('loadData', []);
    $('#window-jurnal-hutang').window('close');
}

function ubah_jurnal_hutang() {
    var row = $('#dg').datagrid('getSelected');
    // if(row==null) { $.messager.alert('Peringatan','Tidak ada data yang dipilih!'); return false; }
    if (row) {
        $.ajax({
            url : "<?php echo base_url('akuntansi/hutang/jurnal_hutang/ubah_jurnal_hutang'); ?>",
            type : "POST",
            dataType : 'json',
            data : { no_hutang : row.no_hutang },
            success:function(data, textStatus, jqXHR) {
                if (data.master.status_id == 2) {
                    $.messager.alert('Warning','Data Telah Terverifikasi');
                    return false;
                }
                $('#window-jurnal-hutang').window({
                    title : 'Ubah Jurnal Hutang',
                    collapsible : false,
                    minimizable : false,
                    maximizable : false,
                    closable : true,
                    onOpen: function(){
                        $('#dg-jurnal-hutang').datagrid({
                            toolbar: '#toolbar-detail',
                            columns:[[
                                {
                                    field : 'coa',
                                    title : 'Kode Rekening',
                                    width : 35,
                                    halign:'center',
                                    formatter : function(value, row) {
                                        return row.coa || value;
                                    },
                                    editor : {
                                        type : 'combobox',
                                        options : {
                                            valueField : 'coa_id',
                                            textField : 'coa',
                                            url : '<?php echo base_url('akuntansi/master/kode_rekening_coa/api_daftar_kode_rekening_coa') ?>',
                                            required : true
                                        }
                                    }
                                },
                                {
                                    field : 'cc',
                                    title : 'Cost Center',
                                    width : 35,
                                    halign:'center',
                                    formatter : function(value, row) {
                                        return row.cc_name || value;
                                    },
                                    editor : {
                                        type : 'combobox',
                                        options : {
                                            valueField : 'cc_id',
                                            textField : 'cc_name',
                                            url : '<?php echo base_url('akuntansi/master/kode_cost_center/api_daftar_kode_cost_center') ?>',
                                            required : true
                                        }
                                    }
                                },
                                {
                                    field : 'deskripsi',
                                    title : 'Deskripsi',
                                    width : 45,
                                    halign:'center',
                                    editor : 'textbox'
                                },
                                {
                                    field : 'jumlah',
                                    title : 'Jumlah',
                                    width : 20,
                                    halign:'center',
                                    align:'right',
                                    editor : {
                                        'type' : 'numberbox',
                                        'options' : {
                                            'precision' : 2,
                                            'min' : 0,
                                            'groupSeparator' :'.',
                                            'decimalSeparator' :','
                                        }
                                    },
                                    formatter: datagridFormatNumber
                                },
                                {
                                    field : 'action',
                                    title : 'Action',
                                    width : 15,
                                    halign:'center',
                                    align : 'center',
                                    formatter : function(value, row, index) {
                                        if (row.editing) {
                                            var s = '<a href="javascript:void(0)" onclick="save_row(this)">Simpan</a> ';
                                            var c = '<a href="javascript:void(0)" onclick="cancel_row(this)">Batal</a>';
                                            return s + c;
                                        } else {
                                            var e = '<a href="javascript:void(0)" onclick="edit_row(this)">Ubah</a> ';
                                            var d = '<a href="javascript:void(0)" onclick="delete_row(this)">Hapus</a>';
                                            return e + d;
                                        }
                                    }
                                },
                            ]],
                            onDblClickRow:function(index,row){
                                $.map($('#dg-jurnal-hutang').datagrid('getRows'), function(row){
                                    var index = $('#dg-jurnal-hutang').datagrid('getRowIndex', row);
                                    $('#dg-jurnal-hutang').datagrid('updateRow', {
                                        index: index,
                                        row: {
                                            status:'P'
                                        }
                                    });
                                    $('#dg-jurnal-hutang').datagrid('selectRow',index);
                                    $('#dg-jurnal-hutang').datagrid('beginEdit',index);
                                });
                            },
                            onEndEdit : function(index, row) {
                                var coa = $(this).datagrid('getEditor', {
                                    index : index,
                                    field : 'coa'
                                });
                                row.coa = $(coa.target).combobox('getText');
                                row.coa_id = $(coa.target).combobox('getValue');

                                var cc = $(this).datagrid('getEditor', {
                                    index : index,
                                    field : 'cc'
                                });
                                row.cc_name = $(cc.target).combobox('getText');
                                row.cc_id = $(cc.target).combobox('getValue');
                            },
                            onBeforeEdit : function(index, row) {
                                row.coa = row.coa_id;
                                row.cc = row.cc_id;
                                row.editing = true;
                                $(this).datagrid('refreshRow', index);
                            },
                            onAfterEdit : function(index, row){
                                row.editing = false;
                                $(this).datagrid('refreshRow', index);
                                hitung_sub_total($(this).datagrid('getRows'));
                            },
                            onCancelEdit : function(index, row){
                                row.editing = false;
                                $(this).datagrid('refreshRow', index);
                            }
                        });

                        $("#tambah-jurnal-hutang").show();
                        $("#label-status-jurnal-hutang").hide();
                        $("#isi-label-status-jurnal-hutang").hide();
                        $("#simpan-jurnal-hutang").show();
                        $("#batal-jurnal-hutang").show();
                        $("#verifikasi-jurnal-hutang").hide();

                        $('#dg-jurnal-hutang').datagrid('loadData', data.detail);
                        $('#no-hutang').textbox('setValue', data.master.no_hutang);
                        $('#no-hutang').textbox('readonly', true);
                        $("#tanggal-hutang").datebox('setValue', data.master.tanggal_hutang);
                        $('#tanggal-hutang').datebox('readonly', false);
                        $('#jenis-hutang').combobox('setValue', data.master.jenis_hutang_id);
                        $('#jenis-hutang').combobox('readonly', false);
                        // console.log('data.master.is_dp: ');
                        // console.log(data.master.is_dp);
                        $('#is-dp').prop('checked', data.master.is_dp);
                        $('#supplier-window').combobox('setValue', data.master.sup_id);
                        $('#supplier-window').combobox('readonly', false);
                        $("#no-po").textbox('setValue', data.master.no_po);
                        $('#no-po').textbox('readonly', false);
                        $("#tanggal-po").datebox('setValue', data.master.tanggal_po);
                        $('#tanggal-po').datebox('readonly', false);
                        $("#no-invoice-supplier").textbox('setValue', data.master.no_invoice_supplier);
                        $('#no-invoice-supplier').textbox('readonly', false);
                        $("#tanggal-jatuh-tempo").datebox('setValue', data.master.tanggal_jatuh_tempo);
                        $('#tanggal-jatuh-tempo').datebox('readonly', false);
                        $("#no-faktur-pajak").textbox('setValue', data.master.no_faktur_pajak);
                        $('#no-faktur-pajak').textbox('readonly', false);
                        $("#tanggal-faktur-pajak").datebox('setValue', data.master.tanggal_faktur_pajak);
                        $('#tanggal-faktur-pajak').datebox('readonly', false);
                        $('#keterangan').textbox('setValue', data.master.keterangan );
                        $('#keterangan').textbox('readonly', false);

                        $('#sub-total').numberbox('setValue', data.master.sub_total);
                        $('#sub-total').numberbox('readonly', true);
                        $('#diskon').numberbox('setValue', data.master.diskon);
                        $('#diskon').numberbox('readonly', false);
                        $('#sub-total-setelah-diskon').numberbox('setValue', data.master.sub_total_setelah_diskon);
                        $('#sub-total-setelah-diskon').numberbox('readonly', true);
                        $('#ppn').numberbox('setValue', data.master.ppn);
                        $('#ppn').numberbox('readonly', false);
                        $('#harga-ppn').numberbox('setValue', data.master.harga_ppn);
                        $('#harga-ppn').numberbox('readonly', true);
                        $('#jenis-pph').combobox('setValue', data.master.jenis_pph_id);
                        $('#jenis-pph').combobox('readonly', false);
                        $('#pph').numberbox('setValue', data.master.pph);
                        $('#pph').numberbox('readonly', false);
                        $('#harga-pph').numberbox('setValue', data.master.harga_pph);
                        $('#harga-pph').numberbox('readonly', true);
                        $('#biaya-lain').numberbox('setValue', data.master.biaya_lain);
                        $('#biaya-lain').numberbox('readonly', false);
                        $('#total-hutang').numberbox('setValue', data.master.total_hutang);
                        $('#total-hutang').numberbox('readonly', true);
                    }
                })
            },
            error: function(jqXHR, textStatus, errorThrown){
              alert('Error, something goes wrong');
            },
        });
    }
}

function tampilkan_jurnal_hutang() {
    var row = $('#dg').datagrid('getSelected');
    // if(row==null) { $.messager.alert('Peringatan','Tidak ada data yang dipilih!'); return false; }
    if (row) {
        $("#label-status-jurnal-hutang").show();
        $("#isi-label-status-jurnal-hutang").show();
        $("#simpan-jurnal-hutang").hide();
        $("#batal-jurnal-hutang").hide();
        $.ajax({
            url : "<?php echo base_url('akuntansi/hutang/jurnal_hutang/ubah_jurnal_hutang'); ?>",
            type : "POST",
            dataType : 'json',
            data : { no_hutang : row.no_hutang },
            success:function(data, textStatus, jqXHR) {
                $('#window-jurnal-hutang').window({
                    title : 'Tampilkan Jurnal Hutang',
                    collapsible : false,
                    minimizable : false,
                    maximizable : false,
                    closable : true,
                    onOpen: function(){
                        $('#dg-jurnal-hutang').datagrid({
                            toolbar: '#toolbar-detail',
                            columns:[[
                                {
                                    field : 'coa',
                                    title : 'Kode Rekening',
                                    width : 35,
                                    halign:'center',
                                },
                                {
                                    field : 'cc',
                                    title : 'Cost Center',
                                    width : 35,
                                    halign:'center',
                                },
                                {
                                    field : 'deskripsi',
                                    title : 'Deskripsi',
                                    width : 45,
                                    halign:'center',
                                },
                                {
                                    field : 'jumlah',
                                    title : 'Jumlah',
                                    width : 20,
                                    halign:'center',
                                    align:'right',
                                    editor : {
                                        'type' : 'numberbox',
                                        'options' : {
                                            'precision' : 4,
                                            'min' : 0,
                                            'groupSeparator' :'.',
                                            'decimalSeparator' :','
                                        }
                                    }
                                },
                            ]],
                        });

                        var user_id = '<?php echo $this->session->userdata('id') ?>';
                        var permision_id = '<?php echo ID_KABAG ?>';

                        var label = '';
                        var isi_label = '';
                        var ubah_status = 'Verifikasi';
                        if (data.master.status_id == 2) {
                            label = 'Status : ' + data.master.status_nama;
                            isi_label = data.master.user_verifikasi + ' - ' + data.master.tanggal_verifikasi;
                            ubah_status = 'Open';
                        }
                        $('#label-status-jurnal-hutang').text(label);
                        $('#isi-label-status-jurnal-hutang').text(isi_label);
                        $('#verifikasi-jurnal-hutang').linkbutton({
                            text : ubah_status
                        });

                        // if (user_id == permision_id) {
                          // sementara Hardcore, admin (1) & kabag (2) boleh verif
                        if (user_id == 1 || user_id == 2) {
                            $("#verifikasi-jurnal-hutang").show();
                        } else {
                            $("#verifikasi-jurnal-hutang").hide();
                        }

                        $("#status-hutang").val(data.master.status_id);
                        $("#tambah-jurnal-hutang").hide();
                        $('#dg-jurnal-hutang').datagrid('loadData', data.detail);
                        $('#no-hutang').textbox('setValue', data.master.no_hutang);
                        $('#no-hutang').textbox('readonly', true);
                        $("#tanggal-hutang").datebox('setValue', data.master.tanggal_hutang);
                        $("#tanggal-hutang").datebox('readonly', true);
                        $('#jenis-hutang').combobox('setValue', data.master.jenis_hutang_id);
                        $('#jenis-hutang').combobox('readonly', true);
                        $('#supplier-window').combobox('setValue', data.master.sup_id);
                        $('#supplier-window').combobox('readonly', true);
                        $("#no-po").textbox('setValue', data.master.no_po);
                        $("#no-po").textbox('readonly', true);
                        $("#tanggal-po").datebox('setValue', data.master.tanggal_po);
                        $("#tanggal-po").datebox('readonly', true);
                        $("#no-invoice-supplier").textbox('setValue', data.master.no_invoice_supplier);
                        $("#no-invoice-supplier").textbox('readonly', true);
                        $("#tanggal-jatuh-tempo").datebox('setValue', data.master.tanggal_jatuh_tempo);
                        $("#tanggal-jatuh-tempo").datebox('readonly', true);
                        $("#no-faktur-pajak").textbox('setValue', data.master.no_faktur_pajak);
                        $("#no-faktur-pajak").textbox('readonly', true);
                        $("#tanggal-faktur-pajak").datebox('setValue', data.master.tanggal_faktur_pajak);
                        $("#tanggal-faktur-pajak").datebox('readonly', true);
                        $('#keterangan').textbox('setValue', data.master.keterangan);
                        $('#keterangan').textbox('readonly', true);

                        $('#sub-total').numberbox('setValue', data.master.sub_total);
                        $('#sub-total').numberbox('readonly', true);
                        $('#diskon').numberbox('setValue', data.master.diskon);
                        $('#diskon').numberbox('readonly', true);
                        $('#sub-total-setelah-diskon').numberbox('setValue', data.master.sub_total_setelah_diskon);
                        $('#sub-total-setelah-diskon').numberbox('readonly', true);
                        $('#ppn').numberbox('setValue', data.master.ppn);
                        $('#ppn').numberbox('readonly', true);
                        $('#harga-ppn').numberbox('setValue', data.master.harga_ppn);
                        $('#harga-ppn').numberbox('readonly', true);
                        $('#jenis-pph').combobox('setValue', data.master.jenis_pph_id);
                        $('#jenis-pph').combobox('readonly', true);
                        $('#pph').numberbox('setValue', data.master.pph);
                        $('#pph').numberbox('readonly', true);
                        $('#harga-pph').numberbox('setValue', data.master.harga_pph);
                        $('#harga-pph').numberbox('readonly', true);
                        $('#biaya-lain').numberbox('setValue', data.master.biaya_lain);
                        $('#biaya-lain').numberbox('readonly', true);
                        $('#total-hutang').numberbox('setValue', data.master.total_hutang);
                        $('#total-hutang').numberbox('readonly', true);
                    }
                })
            },
            error: function(jqXHR, textStatus, errorThrown){
              alert('Error, something goes wrong');
            },
        });
    }
}

function verifikasi_jurnal_hutang() {
    var no_jurnal_hutang = $("#no-hutang").val();
    var status_id = $("#status-hutang").val();

    $.ajax({
        url : "<?php echo base_url('akuntansi/hutang/jurnal_hutang/verifikasi'); ?>",
        type : "POST",
        dataType : 'json',
        data : {
            no_jurnal_hutang : no_jurnal_hutang,
            status_id : status_id
        },
        success:function(data, textStatus, jqXHR) {
            if (data.success) {
                // $.messager.alert('Success', 'Perubahan Status Data Alokasi Biaya Berhasil');
                $.messager.alert('Success', data.message);
            } else {
                $.messager.alert('Warning', 'Perubahan Status Data Alokasi Biaya Gagal');
            }
            $('#window-jurnal-hutang').window('close');
            $('#dg').datagrid('reload');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error, something goes wrong');
        },
    });
}

function simpan_jurnal_hutang() {
    var tanggal_hutang = $("#tanggal-hutang").val(); if (tanggal_hutang == "") { alert('Field Tanggal Hutang wajib diisi'); return false; }
    var jenis_hutang = $('#jenis-hutang').combobox('getValue'); if (jenis_hutang == "") { alert('Field Jenis Hutang wajib diisi'); return false; }
    var supplier = $('#supplier-window').combobox('getValue'); if (supplier == "") { alert('Field Supplier wajib diisi'); return false; }
    var no_po = $("#no-po").val(); if (no_po == "") { alert('Field No PO wajib diisi'); return false; }
    var tanggal_po = $("#tanggal-po").val(); if (tanggal_po == "") { alert('Field Tanggal PO wajib diisi'); return false; }
    var no_invoice_supplier = $("#no-invoice-supplier").val(); if (no_invoice_supplier == "") { alert('Field No Invoice Supplier wajib diisi'); return false; }
    var tanggal_jatuh_tempo = $("#tanggal-jatuh-tempo").val(); if (tanggal_jatuh_tempo == "") { alert('Field Tanggal Jatuh Tempo wajib diisi'); return false; }
    // var no_faktur_pajak = $("#no-faktur-pajak").val(); if (no_faktur_pajak == "") { alert('Field No Faktur Pajak wajib diisi'); return false; }
    // var tanggal_faktur_pajak = $("#tanggal-faktur-pajak").val(); if (tanggal_faktur_pajak == "") { alert('Field Tanggal Faktur Pajak wajib diisi'); return false; }
    var keterangan = $("#keterangan").val(); if (keterangan == "") { alert('Field Keterangan wajib diisi'); return false; }

    var dg_jurnal_hutang = $('#dg-jurnal-hutang').datagrid('getRows'); if (jQuery.isEmptyObject(dg_jurnal_hutang)==true) { alert('Detail Jurnal Hutang wajib diisi'); return false; }

    var sub_total = $("#sub-total").val(); if (sub_total == "") { alert('Tabel Hutang wajib diisi'); return false; }
    var diskon = $("#diskon").val(); if (diskon == "") { alert('Field Diskon wajib diisi'); return false; }
    var ppn = $("#ppn").val(); if (ppn == "") { alert('Field Diskon PPN wajib diisi'); return false; }
    var harga_ppn = $("#harga-ppn").val(); if (harga_ppn == "") { alert('Field Harga PPN wajib diisi'); return false; }
    var jenis_pph = $('#jenis-pph').combobox('getValue'); if (jenis_pph == "") { alert('Field Jenis PPH wajib diisi'); return false; } if (jenis_pph == 0) { alert('Field Jenis PPH tidak boleh sama dengan 0'); return false; }
    var pph = $("#pph").val(); if (pph == "") { alert('Field PPH wajib diisi'); return false; }
    var harga_pph = $("#harga-pph").val(); if (harga_pph == "") { alert('Field Harga PPH wajib diisi'); return false; }
    var biaya_lain = $("#biaya-lain").val(); if (biaya_lain == "") { alert('Field Biaya Lain wajib diisi'); return false; }
    var total_hutang = $("#total-hutang").val(); if (total_hutang == "") { alert('Field Total Hutang wajib diisi'); return false; }

    var no_hutang = $("#no-hutang").val();
    if (no_hutang == '') {
        insert_jurnal_hutang();
    } else {
        update_jurnal_hutang(no_hutang);
    }
}

function insert_jurnal_hutang() {
    var tanggal_hutang = toAPIDateFormat($("#tanggal-hutang").val());
    var jenis_hutang = $('#jenis-hutang').combobox('getValue');
    var is_dp = null;
    if($('input[name=is_dp]:checked').val()!=undefined){
      is_dp=true;
    } else{
      is_dp=false;
    }
    var supplier = $('#supplier-window').combobox('getValue');
    var no_po = $("#no-po").val();
    var tanggal_po = toAPIDateFormat($("#tanggal-po").val());
    var no_invoice_supplier = $("#no-invoice-supplier").val();
    var tanggal_jatuh_tempo = toAPIDateFormat($("#tanggal-jatuh-tempo").val());
    var no_faktur_pajak = $("#no-faktur-pajak").val();
    var tanggal_faktur_pajak = toAPIDateFormat($("#tanggal-faktur-pajak").val());
    var keterangan = $("#keterangan").val();

    var sub_total = $("#sub-total").val();
    var diskon = $("#diskon").val();
    var sub_total_setelah_diskon = $("#sub-total-setelah-diskon").val();
    var ppn = $("#ppn").val();
    var harga_ppn = $("#harga-ppn").val();
    var jenis_pph = $('#jenis-pph').combobox('getValue');
    var pph = $("#pph").val();
    var harga_pph = $("#harga-pph").val();
    var biaya_lain = $("#biaya-lain").val();
    var total_hutang = $("#total-hutang").val();

    var detail = $('#dg-jurnal-hutang').datagrid('getRows');

    $.ajax({
        url : "<?php echo base_url('akuntansi/hutang/jurnal_hutang/insert'); ?>",
        type : "POST",
        dataType : 'json',
        data : {
            tanggal_hutang : tanggal_hutang,
            jenis_hutang : jenis_hutang,
            is_dp : is_dp,
            supplier : supplier,
            no_po : no_po,
            tanggal_po : tanggal_po,
            no_invoice_supplier : no_invoice_supplier,
            tanggal_jatuh_tempo : tanggal_jatuh_tempo,
            no_faktur_pajak : no_faktur_pajak,
            tanggal_faktur_pajak : tanggal_faktur_pajak,
            keterangan : keterangan,
            sub_total : sub_total,
            diskon : diskon,
            sub_total_setelah_diskon : sub_total_setelah_diskon,
            ppn : ppn,
            harga_ppn : harga_ppn,
            jenis_pph : jenis_pph,
            pph : pph,
            harga_pph : harga_pph,
            biaya_lain : biaya_lain,
            total_hutang : total_hutang,
            detail : detail
        },
        success:function(data, textStatus, jqXHR) {
            if (data.success) {
                // $.messager.alert('Success', 'Data Berhasil Disimpan');
                $.messager.alert('Success', data.message);
            } else {
                $.messager.alert('Warning', 'Data Gagal Disimpan');
            }
            $('#window-jurnal-hutang').window('close');
            $('#dg').datagrid('reload');
            batal_jurnal_hutang();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error, something goes wrong');
        },
    });
}

function update_jurnal_hutang(no_hutang) {
    var tanggal_hutang = toAPIDateFormat($("#tanggal-hutang").val());
    var jenis_hutang = $('#jenis-hutang').combobox('getValue');
    var is_dp = null;
    if($('input[name=is_dp]:checked').val()!=undefined){
      is_dp=true;
    } else{
      is_dp=false;
    }
    var supplier = $('#supplier-window').combobox('getValue');
    var no_po = $("#no-po").val();
    var tanggal_po = toAPIDateFormat($("#tanggal-po").val());
    var no_invoice_supplier = $("#no-invoice-supplier").val();
    var tanggal_jatuh_tempo = toAPIDateFormat($("#tanggal-jatuh-tempo").val());
    var no_faktur_pajak = $("#no-faktur-pajak").val();
    var tanggal_faktur_pajak = toAPIDateFormat($("#tanggal-faktur-pajak").val());
    var keterangan = $("#keterangan").val();

    var sub_total = $("#sub-total").val();
    var diskon = $("#diskon").val();
    var sub_total_setelah_diskon = $("#sub-total-setelah-diskon").val();
    var ppn = $("#ppn").val();
    var harga_ppn = $("#harga-ppn").val();
    var jenis_pph = $('#jenis-pph').combobox('getValue');
    var pph = $("#pph").val();
    var harga_pph = $("#harga-pph").val();
    var biaya_lain = $("#biaya-lain").val();
    var total_hutang = $("#total-hutang").val();

    var detail = $('#dg-jurnal-hutang').datagrid('getRows');

    $.ajax({
        url : "<?php echo base_url('akuntansi/hutang/jurnal_hutang/update'); ?>",
        type : "POST",
        dataType : 'json',
        data : {
            tanggal_hutang : tanggal_hutang,
            jenis_hutang : jenis_hutang,
            is_dp : is_dp,
            supplier : supplier,
            no_po : no_po,
            tanggal_po : tanggal_po,
            no_invoice_supplier : no_invoice_supplier,
            tanggal_jatuh_tempo : tanggal_jatuh_tempo,
            no_faktur_pajak : no_faktur_pajak,
            tanggal_faktur_pajak : tanggal_faktur_pajak,
            keterangan : keterangan,
            sub_total : sub_total,
            diskon : diskon,
            sub_total_setelah_diskon : sub_total_setelah_diskon,
            ppn : ppn,
            harga_ppn : harga_ppn,
            jenis_pph : jenis_pph,
            pph : pph,
            harga_pph : harga_pph,
            biaya_lain : biaya_lain,
            total_hutang : total_hutang,
            detail : detail,
            no_hutang : no_hutang,
        },
        success:function(data, textStatus, jqXHR) {
            console.log(data);
            if (data.success) {
                $.messager.alert('Success', data.message);
            } else {
                $.messager.alert('Warning', 'Data Gagal Disimpan');
            }
            $('#window-jurnal-hutang').window('close');
            $('#dg').datagrid('reload');
            batal_jurnal_hutang();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error, something goes wrong');
        },
    });
}

function hapus_jurnal_hutang() {
    var row = $('#dg').datagrid('getSelected');

    if(row==null) { $.messager.alert('Peringatan','Tidak ada data yang dipilih!'); return false; }
    $.messager.confirm('Konfirmasi','Apakah Anda yakin akan menghapus data?', function(r) {
        if(r) {
            $.ajax({
                url : "<?php echo base_url('akuntansi/hutang/jurnal_hutang/hapus'); ?>",
                type : "POST",
                dataType : 'json',
                data : {
                    no_hutang : row.no_hutang,
                },
                success:function(data, textStatus, jqXHR) {
                    if (data.success) {
                        // $.messager.alert('Success', 'Data Berhasil Dihapus');
                        $.messager.alert('Success', data.message);
                    } else {
                        $.messager.alert('Warning', 'Data Gagal Dihapus');
                    }
                    $('#dg').datagrid('reload');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error, something goes wrong');
                },
            });
        }
    });
}

function insert_hutang() {
    var row = $('#dg-jurnal-hutang').datagrid('getSelected');
    var rows = $('#dg-jurnal-hutang').datagrid('getRows');
    var baris_insert = rows.length; //insert di baris terakhir
    if (row) {
        var index = $('#dg-jurnal-hutang').datagrid('getRowIndex', row);
    } else {
        index = 0;
    }
    $('#dg-jurnal-hutang').datagrid('insertRow', {
        // index : index,
        index: baris_insert,
        row : {
            status : 'P'
        }
    });
    $('#dg-jurnal-hutang').datagrid('selectRow',baris_insert);
    $('#dg-jurnal-hutang').datagrid('beginEdit',baris_insert);
}

function get_row_index(target){
    var tr = $(target).closest('tr.datagrid-row');

    return parseInt(tr.attr('datagrid-row-index'));
}

function save_row(target) {
    $('#dg-jurnal-hutang').datagrid('endEdit', get_row_index(target));
}

function edit_row(target) {
    $('#dg-jurnal-hutang').datagrid('beginEdit', get_row_index(target));
}

function delete_row(target) {
    $.messager.confirm('Konfirmasi','Apakah Anda yakin akan menghapus data?', function(r) {
        if(r) {
            $('#dg-jurnal-hutang').datagrid('deleteRow', get_row_index(target));
            // hitung_persentase($('#dg-jurnal-hutang').datagrid('getRows'));
            hitung_sub_total($('#dg-jurnal-hutang').datagrid('getRows'));
        }
    });
}

function cancel_row(target) {
    $('#dg-jurnal-hutang').datagrid('cancelEdit', get_row_index(target));
}

function hitung_sub_total(data) {
    var sub_total = 0;
    if(data.length > 0) {
        for(i = 0 ; i < data.length ; i++) {
            sub_total += parseFloat(data[i].jumlah);
        }
    }

    $('#sub-total').numberbox('setValue', sub_total);
}

function hitung_sub_total_setelah_diskon() {
    var sub_total = parseFloat($("#sub-total").val());
    var diskon = parseFloat($("#diskon").val());

    var sub_total_setelah_diskon = sub_total - diskon;
    $('#sub-total-setelah-diskon').numberbox('setValue', sub_total_setelah_diskon);
}

function hitung_harga_ppn() {
    var sub_total_setelah_diskon = parseFloat($("#sub-total-setelah-diskon").val());
    var ppn = parseFloat($("#ppn").val());

    var harga_ppn = sub_total_setelah_diskon * (ppn / 100.0);
    $('#harga-ppn').numberbox('setValue', harga_ppn);
    hitung_total_hutang();
}

function hitung_harga_pph() {
    var sub_total_setelah_diskon = parseFloat($("#sub-total-setelah-diskon").val());
    var pph = parseFloat($("#pph").val());

    var harga_pph = sub_total_setelah_diskon * (pph / 100.0);
    $('#harga-pph').numberbox('setValue', harga_pph);
    hitung_total_hutang();
}

function hitung_total_hutang() {
    var sub_total_setelah_diskon = parseFloat($("#sub-total-setelah-diskon").val());
    var harga_ppn = parseFloat($("#harga-ppn").val());
    var harga_pph = parseFloat($("#harga-pph").val());
    var biaya_lain = parseFloat($("#biaya-lain").val());

    var total_hutang = sub_total_setelah_diskon + harga_ppn - harga_pph + biaya_lain;
    $('#total-hutang').numberbox('setValue', total_hutang);
}
</script>
<script type="text/javascript">
// $(document).ready(function(){
//     $('#diskon').keyup(function(){
//         hitung_sub_total_setelah_diskon();
//     });
// });
// </script>
<script type="text/javascript">
$(function(){
    $('#start-date').datebox('setValue', appDateFormatter(new Date()));
    $('#end-date').datebox('setValue', appDateFormatter(new Date()));

    $('#window-jurnal-hutang').window('close');

    $('#dg').datagrid({
        url:'<?php echo base_url('akuntansi/hutang/jurnal_hutang/daftar_jurnal_hutang') ?>',
        columns:[[
            {field:'no_hutang',title:'No Hutang',width:100, halign:'center', align:'center'},
            {field:'tgl_hutang',title:'Tanggal Hutang',width:125, halign:'center', align:'center'},
            {field:'jenis_hutang',title:'Jenis Hutang',width:100, halign:'center', align:'center'},
            {field:'supplier',title:'Supplier',width:200, halign:'center', align:'left'},
            {field:'no_po',title:'No PO',width:100, halign:'center', align:'center'},
            {field:'no_invoice_supplier',title:'No Invoice Supplier',width:100, halign:'center', align:'center'},
            {field:'tgl_jatuh_tempo',title:'Tanggal Jatuh Tempo',width:125, halign:'center', align:'center'},
            {field:'jumlah_hutang',title:'Jumlah Hutang',width:125, halign:'center', align:'right'},
            {field:'dibayar',title:'Dibayar',width:125, halign:'center', align:'right'},
            {field:'sisa_hutang',title:'Sisa Hutang',width:125, halign:'center', align:'right'},
            {field:'keterangan',title:'Keterangan',width:400, halign:'center', align:'left'},
            {field:'status',title:'Status',width:100, halign:'center', align:'center'},
            {field:'user_input',title:'User Input',width:150, halign:'center', align:'center'},
            {field:'tgl_input',title:'Tanggal Input',width:150, halign:'center', align:'center'},
            {field:'user_verifikasi',title:'User Verifikasi',width:150, halign:'center', align:'center'},
            {field:'tgl_verifikasi',title:'Tanggal Verifikasi',width:150, halign:'center', align:'center'},
        ]]
    });

    // $('#dg-jurnal-hutang').datagrid({
    //     onDblClickRow:function(index,row){
    //         $.map($('#dg-jurnal-hutang').datagrid('getRows'), function(row){
    //             var index = $('#dg-jurnal-hutang').datagrid('getRowIndex', row);
    //             $('#dg-jurnal-hutang').datagrid('updateRow', {
    //                 index: index,
    //                 row: {
    //                     status:'P'
    //                 }
    //             });
    //             $('#dg-jurnal-hutang').datagrid('selectRow',index);
    //             $('#dg-jurnal-hutang').datagrid('beginEdit',index);
    //         });
    //     },
    //     columns:[[
    //         {
    //             field : 'coa',
    //             title : 'Kode Rekening',
    //             width : 35,
    //             formatter : function(value, row) {
    //                 return row.coa || value;
    //             },
    //             editor : {
    //                 type : 'combobox',
    //                 options : {
    //                     valueField : 'coa_id',
    //                     textField : 'coa',
    //                     url : '<?php echo base_url('akuntansi/master/kode_rekening_coa/api_daftar_kode_rekening_coa') ?>',
    //                     required : true
    //                 }
    //             }
    //         },
    //         {
    //             field : 'cc',
    //             title : 'Cost Center',
    //             width : 35,
    //             formatter : function(value, row) {
    //                 return row.cc_name || value;
    //             },
    //             editor : {
    //                 type : 'combobox',
    //                 options : {
    //                     valueField : 'cc_id',
    //                     textField : 'cc_name',
    //                     url : '<?php echo base_url('akuntansi/master/kode_cost_center/api_daftar_kode_cost_center') ?>',
    //                     required : true
    //                 }
    //             }
    //         },
    //         {
    //             field : 'deskripsi',
    //             title : 'Deskripsi',
    //             width : 45,
    //             editor : 'textbox'
    //         },
    //         {
    //             field : 'jumlah',
    //             title : 'Jumlah',
    //             width : 20,
    //             editor : {
    //                 'type' : 'numberbox',
    //                 'options' : {
    //                     'precision' : 4,
    //                     'min' : 0,
    //                     'groupSeparator' :'.',
    //                     'decimalSeparator' :','
    //                 }
    //             }
    //         },
    //         {
    //             field : 'action',
    //             title : 'Action',
    //             width : 15,
    //             align : 'center',
    //             formatter : function(value, row, index) {
    //                 if (row.editing) {
    //                     var s = '<a href="javascript:void(0)" onclick="save_row(this)">Simpan</a> ';
    //                     var c = '<a href="javascript:void(0)" onclick="cancel_row(this)">Batal</a>';
    //                     return s + c;
    //                 } else {
    //                     var e = '<a href="javascript:void(0)" onclick="edit_row(this)">Ubah</a> ';
    //                     var d = '<a href="javascript:void(0)" onclick="delete_row(this)">Hapus</a>';
    //                     return e + d;
    //                 }
    //             }
    //         },
    //     ]],
    //     onEndEdit : function(index, row) {
    //         var coa = $(this).datagrid('getEditor', {
    //             index : index,
    //             field : 'coa'
    //         });
    //         row.coa = $(coa.target).combobox('getText');
    //         row.coa_id = $(coa.target).combobox('getValue');
    //
    //         var cc = $(this).datagrid('getEditor', {
    //             index : index,
    //             field : 'cc'
    //         });
    //         row.cc_name = $(cc.target).combobox('getText');
    //         row.cc_id = $(cc.target).combobox('getValue');
    //     },
    //     onBeforeEdit : function(index, row) {
    //         row.coa = row.coa_id;
    //         row.cc = row.cc_id;
    //         row.editing = true;
    //         $(this).datagrid('refreshRow', index);
    //     },
    //     onAfterEdit : function(index, row){
    //         row.editing = false;
    //         $(this).datagrid('refreshRow', index);
    //         hitung_sub_total($(this).datagrid('getRows'));
    //     },
    //     onCancelEdit : function(index, row){
    //         row.editing = false;
    //         $(this).datagrid('refreshRow', index);
    //     }
    // });

    $('#sub-total').numberbox({
        onChange: function(value){
            hitung_sub_total_setelah_diskon();
        }
    });

    $('#diskon').numberbox({
        onChange: function(value){
            hitung_sub_total_setelah_diskon();
        }
    });

    $('#sub-total-setelah-diskon').numberbox({
        onChange: function(value){
            hitung_total_hutang();
        }
    });

    $('#ppn').numberbox({
        onChange: function(value){
            hitung_harga_ppn();
        }
    });

    $('#pph').numberbox({
        onChange: function(value){
            var jenis_pph = parseInt($('#jenis-pph').combobox('getValue'));
            // console.log(jenis_pph);
            if (jenis_pph != 1) {
                hitung_harga_pph();
            }
        }
    });

    $('#jenis-pph').combobox({
        onChange: function(value){
            if (parseInt(value) == 1) {
                $('#pph').numberbox('setValue', 0);
                $('#harga-pph').numberbox('setValue', 0);
            } else {
                hitung_harga_pph();
            }
        }
    });

    $('#harga-ppn').numberbox({
        onChange: function(value){
            hitung_total_hutang();
        }
    });

    $('#harga-pph').numberbox({
        onChange: function(value){
            hitung_total_hutang();
        }
    });

    $('#biaya-lain').numberbox({
        onChange: function(value){
            hitung_total_hutang();
        }
    });

    $('#supplier-window').combobox({
        url:'<?php echo base_url('akuntansi/hutang/jurnal_hutang/api_add_supplier') ?>',
        valueField:'sup_id',
        textField:'sup_name'
    });

    $('#supplier').combobox({
        url:'<?php echo base_url('akuntansi/hutang/jurnal_hutang/api_daftar_supplier') ?>',
        valueField:'sup_id',
        textField:'sup_name'
    });
});

$('body').on('click', '.btn-cari', function () {
    var start_date = document.getElementById("start-date").value;
    var end_date = document.getElementById("end-date").value;
    var jenis_kriteria = document.getElementById("jenis-kriteria").value;
    var kriteria = document.getElementById("kriteria").value;
    var supplier = $('#supplier').combobox('getValue');
    var data_status = document.getElementById("data-status").value;

    if (start_date && end_date) {
        $('#dg').datagrid('load', {
            start_date: start_date,
            end_date: end_date,
            jenis_kriteria : jenis_kriteria,
            kriteria : kriteria,
            supplier : supplier,
            data_status : data_status
        });
        $('#dg').datagrid('reload');
    } else {
        alert('Mohon untuk mengisi field Periode yang disediakan');
    }
});
</script>
</body>
</html>
