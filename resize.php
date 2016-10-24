<?php
    function imagesResize($src,$dest,$destW,$destH) {
		if (file_exists($src)  && isset($dest)) {
			//取得檔案資料
			$srcSize   = getimagesize($src);
			$srcExtension = $srcSize[2];
			$srcRatio  = $srcSize[0] / $srcSize[1];
			//依長寬比判斷長寬像素
			if($srcRatio > 1){
				$destH = $destW / $srcRatio;
			}
			else{
				$destH = $destW;
				$destW = $destw * $srcRatio;
			}
		}
		//建立影像
		$destImage = imagecreatetruecolor($destW,$destH);
		
		//跟據檔案格式
		switch ($srcExtension) {
			case 1: $srcImage = imagecreatefromgif($src); break;
			case 2: $srcImage = imagecreatefromjpeg($src); break;
			case 3: $srcImage = imagecreatefrompng($src); break;
		}
		//取樣縮圖
		imagecopyresampled($destImage, $srcImage, 0, 0, 0, 0,$destW,$destH,
		                   imagesx($srcImage), imagesy($srcImage));
						   
		//輸出圖檔
		switch ($srcExtension) {
			case 1: imagegif($destImage,$dest); break;
			case 2: imagejpeg($destImage,$dest,90); break;
			case 3: imagepng($destImage,$dest); break;
		}
		//釋放資源
		imagedestroy($destImage);
	}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
</head>

<body>
</body>
</html>