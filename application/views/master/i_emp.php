<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($this->session->userdata("username"))) {
    redirect(site_url(), 'refresh');
} elseif (empty($this->session->userdata("emp"))) {
    redirect(base_url('master/Emp'), 'refresh');
};
?>

<table style="width: 100%;" cellspacing="5px" border="0">
    <tr>
        <td style="width:50%;text-align:left">
            <h2><?= $caption; ?></h2>
        </td>
        <td style="width:50%;text-align:left">
        <td><input id="id_nk" class="easyui-textbox" readonly="true" style="width:150px;"></td>
        </td>
    </tr>
</table>
<hr>
<h5><u>PERSONAL DATA</u></h5>
<table style="width: auto;" cellspacing="5px" cellpadding="5px" border="0">
    <tr>
        <td style="width:50px;"></td>
        <td><input id="nk" class="easyui-textbox" label="Employee ID:" labelPosition="top" required="true" style="width:150px;"></td>
        <td><input id="initial" class="easyui-textbox" label="Initial:" labelPosition="top" required="true" style="width:150px;"></td>
        <td><input id="full_name" class="easyui-textbox" label="Full Name:" labelPosition="top" required="true" style="width:300px;"></td>
        <td><input id="birth_place" class="easyui-textbox" label="Place Of Birth:" labelPosition="top" required="true" style="width:150px;"></td>
        <td><input id="dt_birth" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="Date Of Birth:" labelPosition="top" required="true" style="width:150px;"></td>
    </tr>

    <tr>
        <td style="width:50px;"></td>
        <td><input id="gender" class="easyui-combobox" label="Gender:" labelPosition="top" required="true" style="width:150px;" data-options="
            valueField: 'label',
            textField: 'value',
            data: [{
                label: 'Male',
                value: 'Male'
            },{
                label: 'Female',
                value: 'Female'
            }]">
        </td>
        <td><input id="religion" class="easyui-combobox" label="Religion:" labelPosition="top" required="true" style="width:150px;" data-options="
            valueField: 'label',
            textField: 'value',
            data: [{
                label: 'Moslem',
                value: 'Moslem'
            },{
                label: 'Christian',
                value: 'Christian'
            },{
                label: 'Chatolic',
                value: 'Chatolic'
            },{
                label: 'Hinduism',
                value: 'Hinduism'
            },{
                label: 'Budhist',
                value: 'Budhist'
            },{
                label: 'Konghucu',
                value: 'Konghucu'
            }]">
        </td>

        <td rowspan="2"><input id="address" class="easyui-textbox" label="Address:" labelPosition="top" required="true" multiline="true" style="width:300px;height:110px"></td>
        <td><input id="kota" class="easyui-textbox" label="City:" labelPosition="top" required="true" style="width:150px;"></td>
        <td><input id="state" class="easyui-textbox" label="Province:" labelPosition="top" required="true" style="width:150px;"></td>
    </tr>
    <tr>
         <td style="width:50px;"></td>
         <td><input id="blood_type" class="easyui-combobox" label="Blood Type:" labelPosition="top" required="true" style="width:150px;" data-options="
            valueField: 'label',
            textField: 'value',
            data: [{
                label: 'A',
                value: 'A'
            },{
                label: 'AB',
                value: 'AB'
            },{
                label: 'B',
                value: 'B'
            },{
                label: 'O',
                value: 'O'
            }]">
        </td>
        <td><input id="status_kawin" class="easyui-combobox" label="Marital Status :" labelPosition="top" required="true" style="width:150px;" data-options="
            valueField: 'value',
            textField: 'label',
            data: [{
                label: 'Married',
                value: 'Married'
            },{
                label: 'Single',
                value: 'Single'
            }]">
        </td>
        <td><input id="negara" class="easyui-textbox" label="Country:" labelPosition="top"  style="width:150px;"></td>
        <td><input id="postal_code" class="easyui-textbox" label="Postal Code:" labelPosition="top" style="width:150px;"></td>
    </tr>
        <td style="width:50px;"></td>
        <td colspan="2"><input id="nik" class="easyui-textbox" label="Identity Card Number:" required="true"  labelPosition="top"  style="width:300px;"></td>
        <td><input id="email" class="easyui-textbox" label="Email:" labelPosition="top" required="true"   style="width:300px;"></td>
        <td><input id="phone1" class="easyui-textbox" label="Phone:" labelPosition="top"  style="width:150px;"></td>
        <td><input id="cell_phone" class="easyui-textbox" label="Cell Phone:" labelPosition="top"  style="width:150px;"></td>
    <tr>
    </tr>
    </table>
    <br>
    <h5><u>JOB DATA</u></h5>
    <table style="width: auto;" cellspacing="5px" cellpadding="5px" border="0">
    <tr>
        <td style="width:50px;"></td>
        <td><input id="join_date" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="Joint Date:" labelPosition="top" required="true" style="width:150px;"></td>

        <td><input id="status_karyawan" class="easyui-combobox" label="Status:" labelPosition="top" required="true" style="width:150px;" data-options="
            valueField: 'value',
            textField: 'label',
            data: [{
                label: 'Tetap',
                value: 'Tetap'
            },{
                label: 'Kontrak',
                value: 'Kontrak'
            },{
                label: 'Proyek',
                value: 'Proyek'
            }]">
        </td>
        <td rowspan="2"><input id="kd_divisi" class="easyui-combogrid" label="Department:" labelPosition="top" required="true" multiline="true" style="width:300px;height:110px"></td>
        <td colspan="2"><input id="jabatan" class="easyui-textbox" label="Position:" labelPosition="top" required="true" style="width:300px;"></td>
        
    </tr>
        <td style="width:50px;"></td>
        <td><input id="dt_release" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="Resign Date:" labelPosition="top" style="width:150px;"></td>
        <td><input id="isactive" class="easyui-combobox" label="Is Active? :" labelPosition="top" required="true" style="width:150px;" data-options="
            valueField: 'value',
            textField: 'label',
            data: [{
                label: 'Yes',
                value: '1'
            },{
                label: 'No',
                value: '0'
            }]">
        </td>
        <td colspan="2"><input id="kd_spv" class="easyui-combogrid" label="Atasan Langsung:" labelPosition="top" style="width:300px;"></td>
        
    </tr>

    </table>


    <br>
    <h5><u>EDUCATIONAL BACKGROUND</u></h5>
    <table style="width: auto;" cellspacing="5px" cellpadding="5px" border="0">
    <tr>
        <td style="width:50px;"></td>
        <td><input id="education" class="easyui-combobox" label="Education :" labelPosition="top"  style="width:150px;" data-options="
            valueField: 'value',
            textField: 'label',
            data: [{
                label: 'SMA/SMK/Sederajat',
                value: 'SMA'
            },{
                label: 'Sarjana/ S1',
                value: 'S1'
            },{
                label: 'Pasca Sarjana/ S2',
                value: 'S2'
            },{
                label: 'Doctor/ S3',
                value: 'S3'
            }]">
        </td>
        <td rowspan="2"><input id="universitas" class="easyui-textbox" label="University/School:"  labelPosition="top" multiline="true" style="width:300px;height:110px"></td>
        <td rowspan="2"><input id="faculty" class="easyui-textbox" label="Faculty:" labelPosition="top" multiline="true" style="width:150px;height:110px"></td>
        <td rowspan="2"><input id="department" class="easyui-textbox" label="Program Study:" labelPosition="top" multiline="true" style="width:150px;height:110px"></td>
        <td rowspan="2"><input id="keahlian" class="easyui-textbox" label="Expertise:" labelPosition="top" multiline="true" style="width:150px;height:110px"></td>
    </tr>
    <tr>
    <td style="width:50px;"></td>
        <td><input id="dt_hire" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" label="Graduate Date:" labelPosition="top" style="width:150px;"></td>
    
    </tr>
</table>


<br>
    <h5><u>FINANCIAL DATA</u></h5>
    <table style="width: auto;" cellspacing="5px" cellpadding="5px" border="0">
    <tr>
        <td style="width:50px;"></td>
        <td><input id="bank_account" class="easyui-textbox" label="Bank Account:" required="true"  labelPosition="top" style="width:150px;"></td>
        <td><input id="bank_cabang" class="easyui-textbox" label="Bank Office:" required="true"  labelPosition="top"  style="width:150px;"></td>
        <td><input id="bank" class="easyui-textbox" label="Bank Name:" required="true"  labelPosition="top"  style="width:300px;"></td>
        <td><input id="npwp" class="easyui-textbox" label="NPWP:" labelPosition="top"  style="width:150px;"></td>
        <td><input id="ptkp" class="easyui-textbox" label="PTKP:" labelPosition="top"  style="width:150px;"></td>
    </tr>
    <tr>

        <td style="width:50px;"></td>
        <td><input id="gaji_pokok" class="easyui-numberbox" label="Basic Salary:" required="true"  labelPosition="top"  style="text-align: right; width:150px;" data-options="min:0,precision:2,groupSeparator:','"></td>
    </tr>
</table>

<br>
<hr>
<div id="dlg-buttons" style="text-align: center;">
    <a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="saveDatax()">Save</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="cancelData()">Cancel</a>
</div>

<hr>

<script type="text/javascript">
    var editIndex = undefined;
    var lastIndex;
    var mode = '<?= $mode ?>';
    var idx = '<?= $idx; ?>';


    //-----------------------------$('#dg').datagrid-----------------------------

    $(function() {

        $('#kd_spv').combogrid({
            panelWidth: 400,
            url: '<?= base_url()  ?>master/Emp/getSpv',
            idField: 'nk',
            textField: 'full_name',
            mode: 'remote',
            fitColumns: true,
            nowrap: false,
            columns: [
                [{
                        field: 'nk',
                        title: 'ID',
                        width: 100,
                        align: 'center'
                    },
                    {
                        field: 'full_name',
                        title: 'Descriptions',
                        align: 'left',
                        width: 300
                    }

                ]
            ]
            // onSelect: function(index, row) {
            //     //var desc = row.alamat; // the product's description
            //     // $('#tunggakan').numberbox('setValue', 2020);
            //     getOutCa(row.kd_rekanan)
            // }

        });


        $('#kd_divisi').combogrid({
            panelWidth: 400,
            url: '<?= base_url()  ?>master/Emp/getDivisi',
            idField: 'kd_divisi',
            textField: 'deskripsi',
            mode: 'remote',
            fitColumns: true,
            nowrap: false,
            columns: [
                [{
                        field: 'kd_divisi',
                        title: 'ID',
                        width: 100,
                        align: 'center'
                    },
                    {
                        field: 'deskripsi',
                        title: 'Descriptions',
                        align: 'left',
                        width: 300
                    }

                ]
            ]

        });


        if (mode == 'edit') {
            fetchMasterData(idx);
           // alert(idx);
        };

    });



    function fetchMasterData(idx) {
        $.ajax({
            url: "<?= base_url(); ?>master/Emp/getMasterData",
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
                //alert('masuk');
                $('#id_nk').textbox('setValue', data[0]['nk']);
                $('#nk').textbox('setValue', data[0]['nk']);
                $('#full_name').textbox('setValue', data[0]['full_name']);
                $('#initial').textbox('setValue', data[0]['initial']);
                $('#email').textbox('setValue', data[0]['email']);
                $('#birth_place').textbox('setValue', data[0]['birth_place']);
                $('#cell_phone').textbox('setValue', data[0]['cell_phone']);
                $('#address').textbox('setValue', data[0]['address']);
                $('#state').textbox('setValue', data[0]['state']);
                $('#kota').textbox('setValue', data[0]['kota']);
                $('#nik').textbox('setValue', data[0]['nik']);
                $('#phone1').textbox('setValue', data[0]['phone1']);
                $('#negara').textbox('setValue', data[0]['negara']);
                $('#postal_code').textbox('setValue', data[0]['postal_code']);

                $('#dt_birth').datebox('setValue', data[0]['dt_birth_char']);
                $('#gender').combobox('setValue', data[0]['gender']);
                $('#religion').combobox('setValue', data[0]['religion']);
                $('#blood_type').combobox('setValue', data[0]['blood_type']);
                $('#status_kawin').combobox('setValue', data[0]['status_kawin']);


                $('#join_date').datebox('setValue', data[0]['join_date_char']);
                $('#status_karyawan').combobox('setValue', data[0]['status_karyawan']);
                $('#isactive').combobox('setValue', data[0]['isactive']);
                $('#kd_divisi').combogrid('setValue', data[0]['kd_divisi']);
                $('#kd_spv').combogrid('setValue', data[0]['kd_spv']);
                $('#jabatan').textbox('setValue', data[0]['jabatan']);

                $('#education').combobox('setValue', data[0]['education']);
                $('#dt_hire').datebox('setValue', data[0]['dt_hire_char']);
                $('#universitas').textbox('setValue', data[0]['universitas']);
                $('#faculty').textbox('setValue', data[0]['faculty']);
                $('#department').textbox('setValue', data[0]['department']);
                $('#keahlian').textbox('setValue', data[0]['keahlian']);

                $('#bank').textbox('setValue', data[0]['bank']);
                $('#bank_cabang').textbox('setValue', data[0]['bank_cabang']);
                $('#bank_account').textbox('setValue', data[0]['bank_account']);
                $('#npwp').textbox('setValue', data[0]['npwp']);
                $('#ptkp').textbox('setValue', data[0]['ptkp']);

                $('#gaji_pokok').numberbox('setValue', data[0]['gaji_pokok']);
            }
        });
    }



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




    function saveDatax() {
        var nk = $('#nk').textbox('getValue');
        var id_nk = $('#id_nk').textbox('getValue');
        var full_name = $('#full_name').textbox('getValue');
        var initial = $('#initial').textbox('getValue');
        var email = $('#email').textbox('getValue');
        var birth_place = $('#birth_place').textbox('getValue');
        var cell_phone = $('#cell_phone').textbox('getValue');
        var address = $('#address').textbox('getValue');
        var state = $('#state').textbox('getValue');
        var kota = $('#kota').textbox('getValue');
        var nik = $('#nik').textbox('getValue');
        var phone1 = $('#phone1').textbox('getValue');
        var negara = $('#negara').textbox('getValue');
        var postal_code = $('#postal_code').textbox('getValue');

        var dt_birth = $('#dt_birth').datebox('getValue');
        var gender = $('#gender').combobox('getValue');
        var religion = $('#religion').combobox('getValue');
        var blood_type = $('#blood_type').combobox('getValue');
        var status_kawin = $('#status_kawin').combobox('getValue');


        var join_date = $('#join_date').datebox('getValue');
        var dt_release = $('#dt_release').datebox('getValue');
        var status_karyawan = $('#status_karyawan').combobox('getValue');
        var isactive = $('#isactive').combobox('getValue');
        var kd_divisi = $('#kd_divisi').combogrid('getValue');
        var kd_spv = $('#kd_spv').combogrid('getValue');
        var jabatan = $('#jabatan').textbox('getValue');

        var education = $('#education').combobox('getValue');
        var dt_hire =  $('#dt_hire').datebox('getValue');
        var universitas = $('#universitas').textbox('getValue');
        var faculty = $('#faculty').textbox('getValue');
        var department = $('#department').textbox('getValue');
        var keahlian = $('#keahlian').textbox('getValue');

        var bank = $('#bank').textbox('getValue');
        var bank_cabang = $('#bank_cabang').textbox('getValue');
        var bank_account = $('#bank_account').textbox('getValue');
        var npwp = $('#npwp').textbox('getValue');
        var ptkp =  $('#ptkp').textbox('getValue');

        var gaji_pokok = $('#gaji_pokok').numberbox('getValue');

        // //var detail = $('#dg').datagrid('getRows');

        // VALIDATION FORM --------------------------------------
        if (nk == '') {
            $.messager.alert('Warning', 'NK must have value', 'warning');
            return false;
        } else if (initial == '') {
            $.messager.alert('Warning', 'initial must have value', 'warning');
            return false;
        } else if (full_name == '') {
            $.messager.alert('Warning', 'full name must have value', 'warning');
            return false;
        } else if (bank == '') {
            $.messager.alert('Warning', 'Bank must have value', 'warning');
            return false;
        } else if (gaji_pokok == '') {
            $.messager.alert('Warning', 'Basic Salary must have value', 'warning');
            return false;
        } else if (gaji_pokok == 0) {
            $.messager.alert('Warning', 'Basic Salary must have value', 'warning');
            return false;
        } else if (bank_account == '') {
            $.messager.alert('Warning', 'Bank Account must have value', 'warning');
            return false;
        } else if (ptkp == '') {
            $.messager.alert('Warning', 'PTKP must have value', 'warning');
            return false;
        }

        var master = [];

        master.push({
            id_nk : id_nk,
            nk : nk,
            full_name : full_name,
            initial : initial,
            email : email,
            birth_place : birth_place,
            cell_phone : cell_phone,
            address : address,
            state : state,
            kota : kota,
            nik : nik,
            phone1 : phone1,
            negara : negara,
            postal_code : postal_code,

            dt_birth : dt_birth,
            gender : gender,
            religion : religion,
            blood_type : blood_type,
            status_kawin : status_kawin,


            join_date : join_date,
            dt_release: dt_release,
            status_karyawan : status_karyawan,
            isactive : isactive,
            kd_divisi : kd_divisi,
            kd_spv : kd_spv,
            jabatan : jabatan,

            education : education,
            dt_hire :  dt_hire,
            universitas : universitas,
            faculty : faculty,
            department : department,
            keahlian : keahlian,

            bank : bank,
            bank_cabang : bank_cabang,
            bank_account : bank_account,
            npwp : npwp,
            ptkp :  ptkp,
            gaji_pokok : gaji_pokok
        });


        // alert(mode);
        var data = [];
        data.push({
            master: master
        });
        // alert(mode);

        var uri;
        if (mode == 'edit') {
            uri = '<?= base_url(); ?>master/Emp/updateEmp';
        } else if (mode == 'add') {
            uri = '<?= base_url(); ?>master/Emp/insertEmp';
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
                window.open('<?= base_url(); ?>master/Emp/index', '_self');
            }
        });
    }

    function cancelData() {
        window.open('<?= base_url(); ?>master/Emp', '_self');
        // window.open('<?//= base_url(); ?>procurement/Pr/index/', '_self');
    }
</script>


</body>