	<?php 
		if($this->session->flashdata('success')){
	?>
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<?php echo $this->session->flashdata('success')?>
		</div>
    <?php 
    	}
    ?>
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-hover table-condensed" id="dataTables-dcs_user">
							<thead>
								<tr>
									<th width="5%">No.</th>
									<th>Nama</th>
									<th>ID</th>
									<th>Kata Sandi</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
							<?php 
								$no = 1;
								if($users_list != NULL){
									foreach ($users_list as $row){
							?>
								<tr>
									<td><?php echo $no?></td>
									<td>
										<?php echo $row->name?>
										<input type="hidden" id="name_<?php echo $row->user_id?>" value="<?php echo $row->name?>">
									</td>
									<td><?php echo $row->user_id?></td>
									<td>
										<?php echo $row->password?>
										<input type="hidden" id="password_<?php echo $row->user_id?>" value="<?php echo $row->password?>">
									</td>
									<td>
										<a href="#" class="btn btn-default edit" data-toggle="modal" data-target="#modal_add" id="<?php echo $row->user_id?>">
										<i class="fa fa-edit"></i> Ubah</a>
										<a href="#" class="btn btn-danger delete" id="<?php echo $row->user_id?>" data-toggle="modal" data-target="#modal_confirm"><i class="fa fa-trash-o"></i> Hapus</a>
									</td>
								</tr>
							<?php 
									$no++;
									}
								}
							?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="panel-footer clearfix">
					<button class="btn btn-primary pull-right add" data-toggle="modal" data-target="#modal_add">Tambah User Baru</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form role="form" method="post" action="<?php echo base_url()?>users/insert" id="user_form">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Form Pengguna</h4>
				</div>
				<div class="modal-body">
					<?php
						if($this->session->flashdata('error')){
							$form_data = $this->session->flashdata('error');
					?>
					<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<?php echo $form_data[3]?>
					</div>
					<?php
						}
					?>
					<div class="form-group">
						<label>ID</label>
						<input class="form-control" placeholder="ID" type="text" name="id" id="id" value="<?php echo isset($form_data[0]) ? $form_data[0] : ''?>" readonly>
					</div>
					<div class="form-group">
						<label>Nama</label>
						<input class="form-control" placeholder="Nama" type="text" name="name" id="name" required value="<?php echo isset($form_data[1]) ? $form_data[1] : ''?>">
					</div>
					<div class="form-group">
						<label>Kata Sandi</label>
						<input class="form-control" placeholder="Kata Sandi" type="text" name="password" id="password" required value="<?php echo isset($form_data[2]) ? $form_data[2] : ''?>">
						<p class="help-block">Maksimal 5 karakter</p>
						<p class="help-block">Harus berupa angka 0-9</p>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary" id="add">Tambah Pengguna Baru</button>
					<button type="submit" class="btn btn-primary" id="update">Perbaharui Pengguna</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="modal_confirm" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-left">Konfirmasi</h4>
            </div>
            <div class="modal-body">
                <p id="confirm_str"></p>
            </div>
            <div class="modal-footer">
            	<?php echo form_open(base_url()."users/delete")?>
	            	<input type="hidden" name="user_id" id="user_id">
	                <button type="submit" class="btn btn-success" id="yes">Ya</button>
	                <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url()?>assets/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url()?>assets/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script>
	$(document).ready(function(){
		<?php
			if($this->session->flashdata('error')){
				$error = $this->session->flashdata('error')
		?>
			$('#modal_add').modal('show');
			<?php 
				if($error[4] == 'insert'){
			?>
					$('#user_form').attr('action', '<?php echo base_url()?>users/insert');
					$('#add').show();
					$('#update').hide();
			<?php 
				}else{
			?>
					$('#user_form').attr('action', '<?php echo base_url()?>users/update');
					$('#add').hide();
					$('#update').show();
			<?php 
				}
			?>
		<?php
			}
		?>
		$('#dataTables-dcs_user').dataTable( {
			"fnDrawCallback": function ( oSettings ) {
				if ( oSettings.bSorted || oSettings.bFiltered )
				{
					for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
					{
						$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
					}
				}
			},
			"oLanguage": {
				"sLengthMenu": "Tampilkan _MENU_ data per halaman",
				"sInfo": "Menampilkan _START_ ke _END_ dari _TOTAL_ records",
				"sInfoEmpty": "Menampilkan 0 ke 0 dari 0 baris",
				"sZeroRecords": "Belum ada data",
				"sSearch": "Pencarian",
				"oPaginate" : {
					"sNext" : "Berikut",
					"sPrevious" : "Sebelum",
					"sFirst": "Halaman Pertama",
					"sLast": "Halaman Terakhir",
					
				}
			},
			"aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ 0,3,4 ] }
			],
			"aaSorting": [[ 2, 'asc' ]]
		});

		$('body').delegate('.add', 'click', function () {
			$('#user_form').attr('action', '<?php echo base_url()?>users/insert');
			$('#add').show();
			$('#update').hide();
			$('#id').val("<?php echo $form_data[0]?>");
			$('#name').val("");
			$('#password').val("");
		});

		$('body').delegate('.edit', 'click', function () {
			$('#user_form').attr('action', '<?php echo base_url()?>users/update');
			$('#add').hide();
			$('#update').show();
			$('#id').val(this.id);
			$('#name').val($('#name_'+this.id).val());
			$('#password').val($('#password_'+this.id).val());
		});

		$('body').delegate('.delete', 'click', function () {
			var name = $('#name_'+this.id).val();
			$("#user_id").val(this.id);
			$("#confirm_str").html('Apakah Anda yakin ingin menghapus <b>'+name+'</b>?');
		});
	});
</script>