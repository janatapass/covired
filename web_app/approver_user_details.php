<?php 
               //print_r($_REQUEST);
			   include_once ('web_api/include/DbHandler.php');
               $DbHandler = new DbHandler();
               $user_id = $_REQUEST['user_id'];
			   $arr_user = $DbHandler->get_user_details($user_id,false);
			   $arr_user = $arr_user['data'];
			   //print_r($arr_user);
			   $qr_code = $arr_user['qr_code'];
			   $color_code = ($arr_user['user_category_id']!=3)?$arr_user['color_code']:'black';
			   
			  // $DbHandler->generate_QR_code($qr_code,$color_code);
			  // exit;
			   ?>
			  
      
      
      <div class="card mb-3 mt-3">
            <div class="card-body passes_list">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="row">
                            <?php $DbHandler->generate_QR_code($qr_code,$color_code); ?>
                        </div>
                        <div class="row">
                            <div id="Menu2" style="display:block;">
					 <h3 class="text-center"><?= $arr_user['name'];?></h3>
					 <div class="row">
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p>Organization</p>
					 </div>
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p><?= $arr_user['name'];?></p>
					 </div>
					 </div>
					 <div class="row">
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p>Address</p>
					 </div>
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p><?= $arr_user['address'];?></p>
					 </div>
					 </div>
					 <div class="row">
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p>City</p>
					 </div>
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p><?= $arr_user['address'];?></p>
					 </div>
					 </div>
					 <div class="row">
					 <div class="col-ld-12 col-sm-12 col-12 mt-3 text-center">
					 <button class="btn btn-info2">Go to home</button>
					 </div>
					 </div>
					 </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                               
			   
					 