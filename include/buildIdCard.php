<?php
	require_once '../include/dbconn.php';

	function buildIdCard($id) {
		$name = getName($id);
		$name_len = strlen($name["fname"])+strlen($name["lname"]);
		$len_str = (String)($name_len);
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
		else if ($color_num == 5  || $color_num == 8) {
			$color = "card_color_5";
		}
		else if ($color_num == 6  || $color_num == 9) {
			$color = "card_color_6";
		}

		echo '<li class="card_struct id">
			<button type="submit" class="' . $color . '" name="p" value="' . $id . '">
				<div class="card_content">
					<h2 class="title">' . $name["fname"] . " " . $name["lname"] . '</h2>
					<span class="subtitle">
						<h3 class="status">' . getStatus($id) . '</h3>
						<h3>' . getDept($id) . '</h3>
					</span>
				</div>
			</button>
		</li>';
	}
?>