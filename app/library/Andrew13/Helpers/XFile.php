<?php 

class XFile {
	public static function makeDownloadDir($directory) {
		$new_dir = "download/$directory";

		if (!file_exists($new_dir )) {
			mkdir($new_dir, 0777, true);
		}
	}
}