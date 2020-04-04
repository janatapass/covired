	<?php
	//print_r($_REQUEST);
	$share_mobile = $_REQUEST['share_mobile'];
	$share_name = $_REQUEST['share_name'];
	$pass_id = $_REQUEST['pass_id'];
	?>
	<div class="modal-header">
          <h4 class="modal-title">Leave Pass</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
	<form name="form_share" id="form_share" method="POST">
	    <input type="hidden" class="form-control" id="pass_id" name="pass_id" required value="<?= $pass_id;?>" required>
	    <input type="hidden" class="form-control" id="user_id" name="user_id" required value="<?= $user_id;?>" required>
		    <div class="form-group grey_box">
		<input type="text" class="form-control" placeholder="Enter Person Name" id="share_name" name="share_name"  value="<?= $share_name;?>" required >
		</div>
		<div class="form-group grey_box">
		<input type="text" class="form-control" placeholder="Mobile number" id="share_mobile" name="share_mobile" required value="<?= $share_mobile;?>" required>
		</div>
		<button class="btn btn-info" type="button" onclick="send_trip_sms();"> Share Trip Details </button>
		</form>
		</div>
		
<script type="text/javascript">

</script>