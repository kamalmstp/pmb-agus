
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?=$title;?></h1>
		</div>
	</div><!--/.row-->
	
	<div class="panel panel-container" style="padding: 50px">
		<div class="bootstrap-table">

			<form class='form-horizontal row-border' action='<?=site_url("panitia/save_user");?>' method='post' target="_parent">
				<div class='form-group'>
					<label class='col-md-2 control-label'>Email</label>
					<div class='col-md-10'>
						<p><b><?=$pesan->email;?></b></p>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-md-2 control-label'>Subject</label>
					<div class='col-md-10'>
						<p><b><?=$pesan->subject;?></b></p>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-md-2 control-label'>Isi Pesan</label>
					<div class='col-md-10'>
						<p><?=$pesan->pesan;?></p>
					</div>
				</div>
				<center>
					<a href="<?=site_url('panitia/pesan');?>" class='btn btn-sm btn-primary' >Kembali</a>
				</center>
			</form>
		</div>
	</div>
</div>