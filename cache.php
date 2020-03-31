function create_cache_catalogue($folder, $prefix, $cache_text, $cache_id = false, $member_prefix = false) {
	global $config, $is_logged, $member_id, $modulcat, $mcache;

	if (!$config['allow_cache']) return false;

	$upload_dir = ENGINE_DIR . '/cache/' . $modulcat . $folder . '/';
	if (! is_dir ( $upload_dir )) {
		@mkdir ( $upload_dir, 0777 );
		@chmod ( $upload_dir, 0777 );
	} else
		@chmod ( $upload_dir, 0777 );

	if (! $cache_id)
		$filename = ENGINE_DIR . '/cache/' . $modulcat . $folder . $prefix . '.tmp';
	else {
		//$cache_id = totranslit ( $cache_id );

		/*		if ($member_prefix)
			$filename = ENGINE_DIR . "/cache/" . $modulcat . $folder . $prefix . "_" . $cache_id . "_" . $end_file . ".tmp";
		else
*/		$filename = ENGINE_DIR . "/cache/" . $modulcat . $folder . $prefix . "_" . $cache_id . ".tmp";

	}

     if (!$cache_id) {
        $key = $prefix;
    } else {
        $cache_id = md5($cache_id);
        $key = $prefix . "_" . $cache_id;
    }
	
	if ($cache_text === false) $cache_text = '';	
	
    if ($config['cache_type']) {
        if ($mcache->connection > 0) {
            $mcache->set($key, $cache_text);
			//var_dump($cache_text);
            return true;
        }
    } 

	$fp = fopen ( $filename, 'wb+' );
	fwrite ( $fp, $cache_text );
	fclose ( $fp );

	@chmod ( $filename, 0666 );

}

function dle_cache_catalogue($folder, $prefix, $cache_id = false, $member_prefix = false) {
	global $config, $is_logged, $member_id, $modulcat, $mcache;

	if (!$config['allow_cache']) return false;

	$upload_dir = ENGINE_DIR . '/cache/' . $modulcat . $folder . '/';

	if (! is_dir ( $upload_dir )) {
		@mkdir ( $upload_dir, 0777 );
		@chmod ( $upload_dir, 0777 );
	} else
		@chmod ( $upload_dir, 0777 );

	if (! $cache_id)
		$filename = ENGINE_DIR . '/cache/' . $modulcat . $folder . $prefix . '.tmp';
	else {
		//$cache_id = totranslit ( $cache_id );

		$filename = ENGINE_DIR . "/cache/" . $modulcat . $folder . $prefix . "_" . $cache_id . ".tmp";
	}
	
    if (!$cache_id) {
        $key = $prefix;
    } else {
        $cache_id = md5($cache_id);
        $key = $prefix . "_" . $cache_id;
    }	
	
	if ($config['cache_type']) {
        if ($mcache->connection > 0) {
            return $mcache->get($key);
        }
    } 

	return @file_get_contents ( $filename );
}
