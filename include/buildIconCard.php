<?php
	function buildIconCard($img_location, $title, $action, $tag="") {
		echo '<li class="card_struct '.$tag.'">
			<button onclick="'.$action.'">
				<div class="card_content">
					<h2 class="title">'.$title.'</h2>
					<img class="icon" src="'.$img_location.'">
				</div>
			</button>
		</li>';
	}
?>