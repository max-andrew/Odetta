<?php
	function buildTextCard($title, $subtitle) {
		echo '<li class="card_struct">
			<div class="card_content text_content">
				<h2 class="text_title">'.$title.'</h2>
				<br>
				<h4>'.$subtitle.'</h4>
			</div>
		</li>';
	}
?>