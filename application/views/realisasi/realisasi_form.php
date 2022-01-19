
        <h2 style="margin-top:0px">Realisasi <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="int">Fisical Year <?php echo form_error('fisical_year') ?></label>
            <input type="text" class="form-control" name="fisical_year" id="fisical_year" placeholder="Fisical Year" value="<?php echo $fisical_year; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Period <?php echo form_error('period') ?></label>
            <input type="text" class="form-control" name="period" id="period" placeholder="Period" value="<?php echo $period; ?>" />
        </div>
	    <div class="form-group">
            <label for="date">Posting Date <?php echo form_error('posting_date') ?></label>
            <input type="text" class="form-control" name="posting_date" id="posting_date" placeholder="Posting Date" value="<?php echo $posting_date; ?>" />
        </div>
	    <div class="form-group">
            <label for="date">Dokumen Date <?php echo form_error('dokumen_date') ?></label>
            <input type="text" class="form-control" name="dokumen_date" id="dokumen_date" placeholder="Dokumen Date" value="<?php echo $dokumen_date; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Cost Element <?php echo form_error('cost_element') ?></label>
            <input type="text" class="form-control" name="cost_element" id="cost_element" placeholder="Cost Element" value="<?php echo $cost_element; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Cost Element Descr <?php echo form_error('cost_element_descr') ?></label>
            <input type="text" class="form-control" name="cost_element_descr" id="cost_element_descr" placeholder="Cost Element Descr" value="<?php echo $cost_element_descr; ?>" />
        </div>
	    <div class="form-group">
            <label for="object_type">Object Type <?php echo form_error('object_type') ?></label>
            <textarea class="form-control" rows="3" name="object_type" id="object_type" placeholder="Object Type"><?php echo $object_type; ?></textarea>
        </div>
	    <div class="form-group">
            <label for="varchar">Wbs Element <?php echo form_error('wbs_element') ?></label>
            <input type="text" class="form-control" name="wbs_element" id="wbs_element" placeholder="Wbs Element" value="<?php echo $wbs_element; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Project Devinition <?php echo form_error('project_devinition') ?></label>
            <input type="text" class="form-control" name="project_devinition" id="project_devinition" placeholder="Project Devinition" value="<?php echo $project_devinition; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Co Object Name <?php echo form_error('co_object_name') ?></label>
            <input type="text" class="form-control" name="co_object_name" id="co_object_name" placeholder="Co Object Name" value="<?php echo $co_object_name; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Name <?php echo form_error('name') ?></label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $name; ?>" />
        </div>
	    <div class="form-group">
            <label for="co_area_curency">Co Area Curency <?php echo form_error('co_area_curency') ?></label>
            <textarea class="form-control" rows="3" name="co_area_curency" id="co_area_curency" placeholder="Co Area Curency"><?php echo $co_area_curency; ?></textarea>
        </div>
	    <div class="form-group">
            <label for="int">Val Coarea Crcy <?php echo form_error('Val_coarea_crcy') ?></label>
            <input type="text" class="form-control" name="Val_coarea_crcy" id="Val_coarea_crcy" placeholder="Val Coarea Crcy" value="<?php echo $Val_coarea_crcy; ?>" />
        </div>
	    <input type="hidden" name="id_realisasi" value="<?php echo $id_realisasi; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('realisasi') ?>" class="btn btn-default">Cancel</a>
	</form>
    