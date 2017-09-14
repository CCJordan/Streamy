<?php
	$fName = "mediaFile.mkv";
	header('Content-Type: application/octet-stream');
	// get initial file size
	$fSize = filesize( $fName );
	$failCount = 0;

	// time to wait after a packet has been send in milliseconds
	$wait = 200;
	do {
		// look for new contents after 200 ms
		usleep( $wait * 1000 );
		// open file to get current size
		$fp = fopen($fName, 'r');
		fseek($fp, 0, SEEK_END);
		$fSizeNew = ftell($fp);

		// has the file grown?
		if ( $fSize < $fSizeNew ) {
			// seek to old file length
			fseek($fp, $fSize);
			$dataSize = $fSizeNew - $fSize;
			$data = fread($fp, $dataSize);
			// put out data
			echo $data;
			flush();
			$failCount = 0;
		} else {
			$failCount++;
		}

		// close file to prevent locks
		fclose($fp);
		// set new _old_ filesize
		$fSize = $fSizeNew;
		// end stream if the file as not grown for 5 update cycles
	} while($failCount < 5);
?>