<?php 
if ($pulladdress['tbladdress_status']==1) { ?>
<a href="nedmin/netting/pdo-process.php?tbladdress_id=<?php echo $pulladdress['tbladdress_id'] ?>&activestatus=0&tbladdress_status=ok"><button class="btn btn-success btn-xs"><?php echo _ACTIVE; ?></button>
<?php } elseif($pulladdress['tbladdress_status']==0) {?>
<a href="nedmin/netting/pdo-process.php?tbladdress_id=<?php echo $pulladdress['tbladdress_id'] ?>&activestatus=1&tbladdress_status=ok"><button class="btn btn-danger btn-xs"><?php echo _PASSIVE; ?></button>                
<?php } ?>