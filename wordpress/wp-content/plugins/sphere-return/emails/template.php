<b>Email:</b> <?php echo $email; ?><br>
<b>Name:</b> <?php echo $name; ?><br>
<b>Order:</b> <?php echo $order ?><br>
<b>Action:</b> <?php echo $action; ?><br>
<b>Reason:</b> <?php echo $return; ?><br>
<?php if (isset($replacement)) { ?><b>Replacement:</b> <?php echo htmlspecialchars($replacement); ?><br><?php } ?>
<b>Created At:</b> <?php echo (new DateTime('America/New_York'))->format('M d, Y g:i:s A'); ?>
