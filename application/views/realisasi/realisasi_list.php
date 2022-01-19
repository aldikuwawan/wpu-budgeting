
        <h2 style="margin-top:0px">Realisasi List</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('realisasi/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('realisasi/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('realisasi'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">

        
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
        		<th>Fisical Year</th>
        		<th>Period</th>
        		<th>Posting Date</th>
        		<th>Dokumen Date</th>
        		<th>Cost Element</th>
        		<th>Cost Element Descr</th>
        		<th>Object Type</th>
        		<th>Wbs Element</th>
        		<th>Project Devinition</th>
        		<th>Co Object Name</th>
        		<th>Name</th>
        		<th>Co Area Curency</th>
        		<th>Val Coarea Crcy</th>
        		<th>Action</th>
            </tr><?php
            foreach ($realisasi_data as $realisasi)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $realisasi->fisical_year ?></td>
			<td><?php echo $realisasi->period ?></td>
			<td><?php echo $realisasi->posting_date ?></td>
			<td><?php echo $realisasi->dokumen_date ?></td>
			<td><?php echo $realisasi->cost_element ?></td>
			<td><?php echo $realisasi->cost_element_descr ?></td>
			<td><?php echo $realisasi->object_type ?></td>
			<td><?php echo $realisasi->wbs_element ?></td>
			<td><?php echo $realisasi->project_devinition ?></td>
			<td><?php echo $realisasi->co_object_name ?></td>
			<td><?php echo $realisasi->name ?></td>
			<td><?php echo $realisasi->co_area_curency ?></td>
			<td><?php echo $realisasi->Val_coarea_crcy ?></td>
			<td style="text-align:center; display:flex;" width="200px">
				<?php 
				echo anchor(site_url('realisasi/read/'.$realisasi->id_realisasi),'Read'); 
				echo ' | '; 
				echo anchor(site_url('realisasi/update/'.$realisasi->id_realisasi),'Update'); 
				echo ' | '; 
				echo anchor(site_url('realisasi/delete/'.$realisasi->id_realisasi),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
		</tr>
                <?php
            }
            ?>
        </table>
        </div>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
		<?php echo anchor(site_url('realisasi/excel'), 'Excel', 'class="btn btn-primary"'); ?>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>