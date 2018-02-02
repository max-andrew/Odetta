<?php
	require_once '../include/dbconn.php';

	function buildRoomCard($node, $pId) {
		$name = getRoomName($node);
		$time = getRoomTime($node);
		$len_str = (String)($time);
		// truncate to tenths
		$color_num = $len_str[strlen($len_str)-1];
		$color = "card_color_0";

		if ($color_num == 0) {
			$color = "card_color_0";
		}
		else if ($color_num == 1) {
			$color = "card_color_1";
		}
		else if ($color_num == 2) {
			$color = "card_color_2";
		}
		else if ($color_num == 3) {
			$color = "card_color_3";
		}
		else if ($color_num == 4 || $color_num == 7) {
			$color = "card_color_4";
		}
		else if ($color_num == 5 || $color_num == 8) {
			$color = "card_color_5";
		}
		else if ($color_num == 6  || $color_num == 9) {
			$color = "card_color_6";
		}

		echo '<form action="../chat">
			<li class="card_struct id">
				<button type="submit" class="'.$color.'">
					<input type="hidden" name="c" value="'.$node.'">
					<input type="hidden" name="p" value="'.$pId.'">
					<div class="card_content">
						<h2 class="title">'.$name.'</h2>
						<span class="subtitle">
							<h3>'.$time.'</h3>
						</span>
					</div>
				</button>
			</li>
		</form>';
	}
?>