<?php
	function buildLongCard($title, $action) {
		echo '<li class="card_struct long">
			<button onclick="'.$action.'">
				<div class="card_content">
					<h4 class="title">'.$title.'</h4>
				</div>
			</button>
		</li>';
	}
?>