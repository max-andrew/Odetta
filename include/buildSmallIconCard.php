<?php
	function buildSmallIconCard($img_location, $title, $action) {
		echo '<li class="card_struct small">
			<button onclick="'.$action.'">
				<div class="card_content">
					<img class="icon" src="'.$img_location.'">
					<h3 class="title">'.$title.'</h3>
				</div>
			</button>
		</li>';
	}
?>