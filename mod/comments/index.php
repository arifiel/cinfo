<?php 
$output->post_check();
ob_start();
global $page, $DB, $output, $data, $cat, $mod,$sidebar;
#$skin['sidebar'] = 'default';
$output->title('Прямой эфир');
 $DB->query('SELECT users.first_name, users.last_name, comment.review, comment.user_id, comment.id, comment.added, topic.id as topic_id, topic.title,topic.count_comments, project.title as project_title, project.slug from comment
	LEFT JOIN users on users.id = comment.user_id
	LEFT JOIN topic on topic.id = comment.prefix_id
	LEFT JOIN project on topic.project_id = project.id
	WHERE comment.prefix = "topic" AND comment.active > 0
	ORDER BY comment.added DESC LIMIT 20');
		$seq=1;
		while($comm = $DB->fetch_row()) {
		?>
	<div class="comments padding-none"> 
					<div class="comment">						
						<div class="comment-topic"><a href="/topic/<?=$comm['topic_id'];?>/#comment<?=$comm['id'];?>"><?=$comm['title'];?></a> / <a href="/project/<?=$comm['slug'];?>" class="comment-blog"><?=$comm['project_title'];?></a> <a href="/topic/<?=$comm['topic_id'];?>/#comment<?=$comm['id'];?>" class="comment-total"><?=$comm['count_comments'];?></a></div>				
						<div class="content"> 
							<div class="tb"><div class="tl"><div class="tr"></div></div></div>							
							<div class="text"> 
					<?=$comm['review'];?></div>			
							<div class="bl"><div class="bb"><div class="br"></div></div></div> 
						</div>						
						<div class="info"> 
							<ul style="float:right;margin-right:50px;"> 
								<li class="date"><?=date($conf['dateformat'],$comm['added']);?></li>								
								<li><a href="/topic/<?=$comm['topic_id'];?>/#comment<?=$comm['id'];?>" class="imglink link"></a></li>								
							</ul> 
							<p>
                                                            <img src="/data/users/m/'.<?=$comm['user_id']?>.'.jpg" alt="" />
                                                            <a href="/users/<?=$comm['user_id'];?>/" class="author"><?=$comm['second_name'].' '.$comm['first_name'];?></a></p>
						</div> 
					</div> 
				</div> 
<?
		}

$page[] = ob_get_contents();
ob_end_clean();
?>