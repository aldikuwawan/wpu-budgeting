<div class="container-fluid">
        <div class="alert-wrapper">

        </div>
        <h2 style="margin-top:0px"><span id="tindakan"></span> Pengajuan Detail</h2>

		<div class="row">
			<div class="col-7">
				<div class="row">
					<div class="col-6">
						<div class="form-group">
							<label for="nama_penginput">Nama</label>
							<input class="form-control disabled" readonly name="nama_penginput" id="nama_penginput" placeholder="Data Pengajuan" type="text" value="<?php echo $nama_penginput ?>" />
						</div>
						<div class="form-group">
							<label for="Fungsi">Fungsi</label>
							<input class="form-control disabled" readonly name="fungsi" id="fungsi" value="<?php echo $role; ?>" type="text"/>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="keterangan">Keterangan</label>
							<textarea rows="3" class="form-control" name="keterangan" <?php echo $status_kirim == 1 ? 'disabled' : ''; ?> id="keterangan"><?php echo $keterangan ?></textarea>
						</div>
						<div class="form-group">
							<label for="jenis_pengajuan">Jenis Pengajuan</label>
							<input class="form-control" name="jenis_pengajuan" id="jenis_pengajuan" type="text" <?php echo $status_kirim == 1 ? 'disabled' : ''; ?> value="<?php echo $jenis_pengajuan ?>" />
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group">
			<table class="table table-bordered" id="tabel_pengajuan">
				<thead>
					<tr>
						<th>Cost Center</th>
						<th>Cost Element Name</th>
						<th>Cost Element</th>
						<th>Work Activity</th>
						<th>Value</th>
						<th hidden>Action</th>
					</tr>
				</thead>
				<tbody id="list_data">
					<?php
					if ($data_pengajuan) {
						$dtpengj = json_decode($data_pengajuan, TRUE);

						foreach ($dtpengj as $key => $value) {
							?>
							<tr class="datany">
								<td><?php echo $value['cost_center'] ?><input type="hidden" value="<?php echo $value['cost_center'] ?>" class="cost_center" name="cost_center[]"/></td>
								<td><?php echo $value['cost_element_name'] ?><input type="hidden" value="<?php echo $value['cost_element_name'] ?>" class="cost_element_name" name="cost_element_name[]"/></td>
								<td><?php echo $value['cost_element'] ?><input type="hidden" value="<?php echo $value['cost_element'] ?>" class="cost_element" name="cost_element[]"/></td>
								<td><?php echo $value['work_activity'] ?><input type="hidden" value="<?php echo $value['work_activity'] ?>" class="work_activity" name="work_activity[]"/></td>
								<td><?php echo $value['value'] ?><input type="hidden" value="<?php echo $value['value'] ?>" class="value" name="value[]"/></td>
								<td hidden><input type="hidden" value="<?php echo $value['unique_id'] ?>" class="unique_id" name="unique_id[]"/></td>
							</tr>
							<?php
						}
					}
					?>
				</tbody>
			</table>
			<input type="hidden" id="id_pengajuan" name="id_pengajuan" value="<?php echo $id_pengajuan ?>">
		</div>
		<button type="button" class="btn btn-warning btn-save-as-draft">Simpan Sebagai Draft</button>
		<a href="<?php echo site_url('pengajuan') ?>" class="btn btn-dark">Kembali</a>

    </div>

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.4/b-2.2.2/b-html5-2.2.2/b-print-2.2.2/datatables.min.css"/>
 
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.4/b-2.2.2/b-html5-2.2.2/b-print-2.2.2/datatables.min.js"></script>

    <script>
		$('#tabel_pengajuan').DataTable({
			responsive: true,
			dom: '<"row"<"col-sm-5"B><"col-sm-7"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>',
			buttons: [
			{
				extend: 'csv', 
				className: 'btn-sm',
				title: 'Laporan Pengambilan'
			},
			{ 
				extend: 'excel', 
				className: 'btn-sm',
				title: 'Laporan Pengambilan'
			},
			{ 
				extend: 'pdf', 
				className: 'btn-sm',
				title: 'Laporan Pengambilan'
			},
			{ 
				extend: 'print', 
				className: 'btn-sm'
			}
			],
		});
    </script>