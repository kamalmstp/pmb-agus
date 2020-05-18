<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12">
		<ol class="breadcrumb">
		  <li><a href="<?=site_url('panitia');?>">Beranda</a></li>
		  <li><a href="#"><?=$title;?></a></li>
		  <li class="active"><?=$title1;?></li>
		</ol>
		<div class="row">
			<div class="col-md-6 text-left">
				<strong style="font-size:18pt;"><span class="fa fa-table"></span> Nilai Awal</strong>
			</div>
		</div>
		<br/>
		<table width="100%" class="table table-striped table-bordered">
			<thead>
				<tr>
				  <th>No</th>
				  <th>Nama</th>
				  <?php foreach($kriteria as $row): ?>
				    <th><?=$row['nama_kriteria']; ?></th>
				  <?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
				<?php $no = 1;
				foreach ($siswa as $s): ?>
				<tr>
					<td><?=$no++;?></td>
					<td><?=$s['nama'];?></td>
					<td><?php 
							$jarak = $this->db->get_where('kriteria_detail', array('id_detail' => $s['jarak_sekolah']))->row();
							echo $jarak->nama_detail;?>
					</td>
					<td>
					  	<?php 
							$nilai = $this->db->get_where('kriteria_detail', array('id_detail' => $s['nilai']))->row();
							echo $nilai->nama_detail;?>
					</td>
					<td><?php 
							$ranking = $this->db->get_where('kriteria_detail', array('id_detail' => $s['ranking']))->row();
							echo $ranking->nama_detail;?>
					</td>
				</tr>
				<?php endforeach; ?>
	    	</tbody>
		</table>

		<div class="row">
			<div class="col-md-6 text-left">
				<strong style="font-size:18pt;"><span class="fa fa-table"></span> Tabel Matriks</strong>
			</div>
		</div>
		<br/>
		<table width="100%" class="table table-striped table-bordered">
			<thead>
				<tr>
				  <th>No</th>
				  <th>Nama</th>
				  <?php foreach($kriteria as $row): ?>
				    <th><?=$row['nama_kriteria']; ?></th>
				  <?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
				<?php $no = 1;
				foreach ($peserta as $p): ?>
				<tr>
					<td><?=$no++;?></td>
					<td><?=$p['nama'];?></td>
					<?php foreach ($kriteria as $k): ?>
						<?php $matrik = $this->db->get_where('nilai_awal', array('nisn' => $p['nisn'], 'id_kriteria' => $k['id_kriteria']))->row();?>
						<td><?=$matrik->nilai;?></td>
					<?php endforeach; ?>
				</tr>
				<?php endforeach; ?>
	    	</tbody>
		</table>

		<div class="row">
			<div class="col-md-6 text-left">
				<strong style="font-size:18pt;"><span class="fa fa-table"></span> Tabel Normalisasi Matriks</strong>
			</div>
		</div>
		<br/>
		<table width="100%" class="table table-striped table-bordered">
			<thead>
				<tr>
				  <th>No</th>
				  <th>Nama</th>
				  <?php foreach($kriteria as $row): ?>
				    <th><?=$row['nama_kriteria']; ?></th>
				  <?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
				<?php $no = 1;
				foreach ($peserta as $p): ?>
				<tr>
					<td><?=$no++;?></td>
					<td><?=$p['nama'];?></td>
					<?php foreach ($kriteria as $k): ?>
						<?php $matrik = $this->db->get_where('nilai_awal', array('nisn' => $p['nisn'], 'id_kriteria' => $k['id_kriteria']))->row();
							$min = $this->db->select('*')->from('nilai_awal')->where('id_kriteria', $k['id_kriteria'])->order_by('nilai','DESC')->limit(1,1)->get()->row();
							$max = $this->db->select('*')->from('nilai_awal')->where('id_kriteria', $k['id_kriteria'])->order_by('nilai','ASC')->limit(1,1)->get()->row();
							$c = $min->nilai / $matrik->nilai;
							$b = $matrik->nilai / $max->nilai;
						?>
						<td>
							<?php 
								// echo "Max ".$k['id_kriteria']." = ".$max->nilai;
								// echo "Min ".$k['id_kriteria']." = ".$min->nilai;
								// echo $matrik->nilai." ".$b;
								if($k['atribut_kriteria'] == 'cost'){
									echo $c;
								}else if($k['atribut_kriteria'] == 'benefit'){
									echo $b;
								}else{
									echo "Error";
								}
							?>
						</td>
					<?php endforeach; ?>
				</tr>
				<?php endforeach; ?>
	    	</tbody>
		</table>

		<div class="row">
			<div class="col-md-6 text-left">
				<strong style="font-size:18pt;"><span class="fa fa-table"></span> Tabel Normalisasi Matriks Dikalikan Bobot</strong>
			</div>
		</div>
		<br/>
		<form action='<?=site_url("panitia/saw_hasil_simpan");?>' method='post'>
			<table width="100%" class="table table-striped table-bordered">
				<thead>
					<tr>
					  <th>No</th>
					  <th>Nama</th>
					  <?php foreach($kriteria as $row): ?>
					    <th><?=$row['nama_kriteria']; ?></th>
					  <?php endforeach; ?>
					  <th>Jumlah</th>
					</tr>
				</thead>
				<tbody>
					<?php $no = 1;
					foreach ($peserta as $p): ?>
					<tr>
						<td><?=$no;?></td>
						<td>
							<?=$p['nama'];?>
							<input type="hidden" name="nisn<?=$no;?>" value="<?=$p['nisn'];?>">
						</td>
						<?php 
							$hitung = 0;
							foreach ($kriteria as $k): ?>
							<?php 
								$matrik = $this->db->get_where('nilai_awal', array('nisn' => $p['nisn'], 'id_kriteria' => $k['id_kriteria']))->row();
								$min = $this->db->select('*')->from('nilai_awal')->where('id_kriteria', $k['id_kriteria'])->order_by('nilai','DESC')->limit(1,1)->get()->row();
								$max = $this->db->select('*')->from('nilai_awal')->where('id_kriteria', $k['id_kriteria'])->order_by('nilai','ASC')->limit(1,1)->get()->row();
								$c = $min->nilai / $matrik->nilai;
								$b = $matrik->nilai / $max->nilai;
							?>
							<td>
								<?php 
									// echo "Max ".$k['id_kriteria']." = ".$max->nilai;
									// echo "Min ".$k['id_kriteria']." = ".$min->nilai;
									// echo $matrik->nilai." ".$b;
									if($k['atribut_kriteria'] == 'cost'){
										$bobot = $c * $k['bobot_kriteria'];
										$jumlah = $bobot;
										echo $bobot;
									}else if($k['atribut_kriteria'] == 'benefit'){
										$bobot = $b * $k['bobot_kriteria'];
										$jumlah = $bobot;
										echo $bobot;
									}else{
										echo "Error";
									}
									$hitung = $jumlah + $hitung;
								?>
							</td>
						<?php endforeach; ?>
						<td>
							<?=$hitung;?>
							<input type="hidden" name="jumlah<?=$no;?>" value="<?=$hitung;?>">
						</td>
					</tr>
					<?php 
						$no++;
						endforeach; ?>
		    	</tbody>
			</table>
			<center>
				<input type='submit' class='btn btn-sm btn-primary' name='simpan' value='Simpan Hasil'>
			</center>
		</form>
	</div>
</div>