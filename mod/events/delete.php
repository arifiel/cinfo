<?php

$output->post_check();
ob_start();
global $page, $output, $data, $cat, $mod,$docroot;
$title = 'Удалить концерт';
$post = $output->post_check();

if(!$output->AuthCheck())
{
	error(401);
}

if(sizeof($_POST))
{
    $post = $_POST;
}

?>

<h1>Удаление концерта</h1>

<?
	$DB->query('SELECT * FROM events WHERE id ='.$pathname[2]);
    if($DB->get_num_rows())
    {
        $event = $DB->fetch_row();
	
		
	if(isset($post) && isset($post['del']) && $post['del']==1){
    	//Удалить
		
		
			if(!unlink('data/events/covers/'.$pathname[2].'.jpg')){
			echo "<br /> Не удалён ".'data/events/covers/'.$pathname[2].'.jpg';
			}
		
			if(!unlink('data/events/m/'.$pathname[2].'.jpg')){
			echo "<br /> Не удалён ".'data/events/m/'.$pathname[2].'.jpg';
			}
		
			if(!unlink('data/events/preview/'.$pathname[2].'.jpg')){
			echo "<br /> Не удалён ".'data/events/preview/'.$pathname[2].'.jpg';
			}
		
		$DB->query('DELETE FROM events WHERE id ='.$pathname[2]);

		$output->redirect($docroot.'/');		
	}
	

?>

<form action="#" method="post" enctype="multipart/form-data">
	<p>Вы точно хотите удалить концерт из системы?</p>
	<input type="hidden" value="1" name="del" />
	<input type="submit" value="Да, безвозвратно удалить" />
	<input type="button" onclick="location.href = '<?=$docroot.'/gig/'.$pathname[2]?>'" value="Нет, не хочу" />
</form>

<script type="text/javascript">
$(document).ready(function(){
  $('#date_begin').attachDatepicker({
  	yearRange: '2011:2015',
  	firstDay: 1
  });
  
  $('#date_end').attachDatepicker({
  	yearRange: '2011:2015',
  	firstDay: 1
  });
});

$('#date_begin').change(function() {
  var $value = $(this).val();
  
  if($('#date_end').val()<$value){
  $('#date_end').val($value);
  }
});
</script>

<?
    } else {error(404);}
$page[] = ob_get_contents();
ob_end_clean();
?>
