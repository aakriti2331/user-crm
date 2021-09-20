<?php
if(isset($_REQUEST['status']) && $_REQUEST['status']!="") 
{
	$html = "";
	if($_REQUEST['status']=="Progress")
	{
		$html .='<div class="form-group row mb-4">
					<label class="col-form-label col-lg-12">Next Followup Date</label>
					<div class="col-lg-6">
						<div class="input-daterange input-group" data-provide="datepicker">
							<input type="text" class="form-control text-left" placeholder="Start Date" name="start" />
						</div>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label col-lg-12">Comment</label>
					<div class="col-lg-6">
					   <textarea name="comments" id="comments" class="form-control" rows="4" ></textarea>
					</div>
				</div>';
	}
	else
	{
		$html .='<div class="form-group row mb-4">
					<label class="col-form-label col-lg-12">Comment</label>
					<div class="col-lg-6">
					   <textarea name="comments" id="comments" class="form-control" rows="4" ></textarea>
					</div>
				</div>';
	}
	echo $html;
}
?>