<!-- BEGIN #content -->
<div id="content" class="content p-0">
	<!-- BEGIN profile-header -->
	<div class="profile-header">
		<!-- BEGIN profile-header-cover -->
		<div class="profile-header-cover"></div>
		<!-- END profile-header-cover -->
		<!-- BEGIN profile-header-content -->
		<div class="profile-header-content">
			<!-- BEGIN profile-header-img -->
			<div class="profile-header-img">
				<img src="<?= base_url(); ?>/img_user/<?= $user['image'] ?>" alt="" />
			</div>
			<!-- END profile-header-img -->
			<!-- BEGIN profile-header-info -->
			<div class="profile-header-info">
				<h4 class="m-t-sm"><?= $mpegawai['full_name'] ?></h4>
				<p class="m-b-sm"><?= $user['user_position'] ?></p>
				<p class="m-b-sm"><?= $mpegawai['jabatan'] ?></p>
			</div>
			<!-- END profile-header-info -->
		</div>
		<!-- END profile-header-content -->
		<!-- BEGIN profile-header-tab -->

		<!-- END profile-header-tab -->
	</div>
	<!-- END profile-header -->
	<!-- BEGIN profile-container -->
	<div class="profile-container">
		<!-- BEGIN row -->
		<div class="row row-space-20">
			<!-- BEGIN col-8 -->
			<div class="col-md-8">
				<!-- BEGIN tab-content -->
				<table>
					<tr>
						<td>
							<form method="post" id="form_ticketing" style="display: inline;">
								<input class="easyui-filebox" label="File Avatar :" labelPosition="top" data-options="prompt:'Choose a file...'" style="width:470px;" name="file" id="import_file">
								<button style="text-align: center;height: 25px;width: 80px" class="easyui-linkbutton" iconCls="icon-upload" plain="false" id="upload" type="submit">Upload</button>
								<input type="hidden" name="preview" value="Preview">
							</form>
						</td>
					</tr>
				</table>
				<!-- END tab-content -->

			</div>
			<!-- END col-8 -->
			<!-- BEGIN col-4 -->
			<div class="col-md-4 hidden-xs hidden-sm">
				<!-- BEGIN profile-info-list -->
				<ul class="profile-info-list">
					<li class="title">PERSONAL INFORMATION</li>
					<li>
						<div class="field">Occupation:</div>
						<div class="value"><?= $mpegawai['jabatan'] ?></div>
					</li>
					<li>
						<div class="field">Education:</div>
						<div class="value"><?= $mpegawai['education'] . '-' . $mpegawai['department'] ?></div>
						<div class="value">Faculty Of <?= $mpegawai['faculty'] ?></div>
						<div class="value"><?= $mpegawai['universitas'] ?></div>
					</li>
					<li>
						<div class="field">Birth of Date:</div>
						<div class="value"><?= $mpegawai['dt_birth'] ?></div>
					</li>
					<li>
						<div class="field">Country:</div>
						<div class="value"><?= $mpegawai['negara'] ?></div>
					</li>
					<li>
						<div class="field">Address:</div>
						<div class="value">
							<address class="m-b-0">
								<?= $mpegawai['address'] ?><br />
								<?= $mpegawai['kota'] . ' ' . $mpegawai['state'] ?><br />
								<?= $mpegawai['state'] ?>
							</address>
						</div>
					</li>
					<li>
						<div class="field">Phone No./Cell Phone:</div>
						<div class="value">
							<?= $mpegawai['phone1'] . ' / ' . $mpegawai['cell_phone'] ?>
						</div>
					</li>

				</ul>
				<!-- END profile-info-list -->
			</div>
			<!-- END col-4 -->
		</div>
		<!-- END row -->
	</div>
	<!-- END profile-container -->
</div>
<!-- END #content -->

<!-- BEGIN btn-scroll-top -->
<a href="#" data-click="scroll-top" class="btn-scroll-top fade"><i class="ti-arrow-up"></i></a>
<!-- END btn-scroll-top -->
</div>
<!-- END #page-container -->

<div>
	<!-- Alert Simpan data baru -->
	<a hidden href="#" id='UploadSuccess' class="btn btn-default btn-sm" data-toggle="notification" data-icon="ti-save" data-icon-class="bg-gradient-blue-purple" data-title="Operation Success" data-content="Upload successfully!" data-autoclose="true"></a>
	<a hidden href="#" id='UploadError' class="btn btn-default btn-sm" data-toggle="notification" data-icon="ti-save-alt" data-icon-class="bg-gradient-blue-purple" data-title="Operation Error" data-content="Upload Error!" data-autoclose="true"></a>

</div>




<script type="text/javascript">
	///-----------------------------------IMPORT EXCEL-----------------------
	$('#form_ticketing').on('submit', function(e) {
		e.preventDefault();
		// var sox = $('#so_number').textbox('getValue');
		// if (sox == '') {
		//     $.messager.alert('Warning', 'Contract Number must have value', 'warning');
		//     return false;
		// }

		$.ajax({

			url: "<?= base_url(); ?>admin/Profile/getUpload",
			type: "POST",
			data: $('#form_ticketing').serialize(),
			dataType: 'json',
			data: new FormData(this),
			processData: false,
			contentType: false,
			cache: false,
			async: false,
			success: function(data) {
				document.getElementById("UploadSuccess").click(); // Click on the checkbox
				location.reload();
			},
			error: function() {
				document.getElementById("UploadError").click(); // Click on the checkbox
			}
		});
	});
	// END OF IMPORT EXCEL
</script>