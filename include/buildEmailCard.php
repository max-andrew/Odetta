<?php
	function buildEmailCard($to, $message) {
		echo '<li class="card_struct email_card">
			<div class="card_content">
				<input type="text" class="em_to" placeholder="To" value="'.$to.'"/>
				<br>
				<h2><textarea class="em_msg" placeholder="Message">'.$message.'</textarea></h2>
				<p class="em_link">Join Chat</p>
				<br>
				<button onclick="mail(); toInviteCard()">Send</button>
			</div>
		</li>';
	}
?>