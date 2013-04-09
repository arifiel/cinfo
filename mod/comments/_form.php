<div id="admin">

<script>
 function check_add(form) {
   if (form.review.value == ""){
    alert("Нельзя отправлять пустой комментарий");
	return false;
  }
  else
  return true;
  }
</script>

<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
<dl>
    <?php if($user['usertype'] == 2) { ?>
    <dt><label for="added_date">дата</label>
    </dt>
   	<dd><input type="text" maxlength="32" id="added_date" name="added_date" class="full datepicker" value="<?=date('Y-m-d',$data['added']);?>" /></dd>
    <dt><label for="added_time">время</label></dt>
   	<dd><input type="text" maxlength="32" id="added_time" name="added_time" class="timepicker" value="<?=date('H:i',$data['added']);?>" /></dd>
    <dt><br /></dt>
    <? } ?>
	<dd><textarea cols="25" rows="15" id="review" name="review"><?=stripslashes($data['review']);?></textarea></dd>

</dl>
<br class="clear" />
<input type="submit" value="Отправить" onClick="return check_add(this.form)"/>
</form>
</div>
<br class="clear" />