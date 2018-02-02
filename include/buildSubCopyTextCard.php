<?php
	function buildSubCopyTextCard($title, $subtitle) {
		echo '<li class="card_struct sub_copy_card">
			<div class="card_content text_content">
				<h2 class="text_title">'.$title.'</h2>
				<br>
				<span class="copyable"><h4>'.$subtitle.'</h4></span>
			</div>
		</li>';
	}
?>