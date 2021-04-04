

<div class="row" style="background: #FFFFFF;">
	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			var $table4 = jQuery("#table-4");
			$table4.DataTable({
                "aLengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                "bStateSave": true
			});
			$table4.closest('.dataTables_wrapper').find('select').select2({
				minimumResultsForSearch: -1
			});
		});
	</script>
	<table class="table table-bordered datatable" id="table-4">
		<thead>
			<tr>
				<th>Product</th>
				<th>Options</th>
			</tr>
		</thead>
		<tbod>
            <?php print_r($products); foreach($products as $key => $fetch): ?>
			<tr>
				<td>
                    <a style="color: #333333; text-decoration: none;" href="<?php echo base_url(); ?>edit_options/<?php echo $fetch['title']; ?>/<?php echo $fetch['id']; ?>/<?php echo $shop; ?>/<?php echo $token ?>">
                        <?php echo $fetch['title']; ?>
                    </a>
				</td>
				<td>
                    <?php 
                        if ($this->db->where('shop', $shop)->where('product_id', $fetch['id'])->get('options')->num_rows() == 0):?>
                        <a href="<?php echo base_url(); ?>edit_options/<?php echo $fetch['title']; ?>/<?php echo $fetch['id']; ?>/<?php echo $shop; ?>/<?php echo $token ?>"><span class="btn btn-primary btn-sm btn-icon icon-left"> <i class="entypo-plus"></i>Create new options</span></a>
                    <?php else: 
                        $options = $this->db->where('product_id', $fetch['id'])->get('options')->row();
                        $options_arr = json_decode($options->product_options, true);

                        foreach($options_arr as $option){
                            echo '<span class="btn btn-default">'.$option['name'].'</span> ';
                        }
                        ?>
                        <a href="<?php echo base_url(); ?>edit_options/<?php echo $fetch['title']; ?>/<?php echo $fetch['id']; ?>/<?php echo $shop; ?>/<?php echo $token ?>"><span class="btn btn-info btn-sm btn-icon icon-left"> <i class="entypo-pencil"></i>Edit options</span></a>

                   <?php endif; ?>
                </td>
			</tr>
            <?php endforeach; ?>
		</tbody>
	</table>
</div>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/datatables/datatables.css" id="style-resource-1">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/select2/select2-bootstrap.css" id="style-resource-2">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/select2/select2.css" id="style-resource-3">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/daterangepicker/daterangepicker-bs3.css" id="style-resource-4">
<script src="<?php echo base_url(); ?>assets/js/datatables/datatables.js" id="script-resource-8"></script>
<script src="<?php echo base_url(); ?>assets/js/select2/select2.min.js" id="script-resource-9"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js" id="script-resource-12"></script>