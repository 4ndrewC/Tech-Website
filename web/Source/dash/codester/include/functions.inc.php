<?php

/**
 * Returns language constant text
 * @return long
 */
function wscLang($key = '')
{
	global $lang;
    return isset($lang[$key]) ? $lang[$key] : '';
}


/**
 * Returns formatted microtime
 * @return long
 */
function wscGetFormattedMicrotime()
{
    list($usec, $sec) = explode(' ', microtime());
    return ((float)$usec + (float)$sec);    
}

/**
 * Recursively checks the destination directory
 * @param string $dir
 * @param array &$settings
 * @param string $task
 * @param string $mode
 * @param xml $xmlData
 * @return bool
 */
function wscCheckRecursive($dir, $ignoredSubDirectories = array(), &$settings, $task = 'check', $mode = 'view', $xmlData = '') 
{ 
    if(!$dh = @opendir($dir)) return false;
	if (!is_array($ignoredSubDirectories)) {
		$ignoredSubDirectories = (array)$ignoredSubDirectories;
	}
    
    // Sets time difference in seconds
    $diff = 60 * 60 * (int)$settings['changed']['diff_hours'];
    // Prepare allowed infected extensions
    $allowedExtensions = isset($settings['infected']['allowed_extensions']) && is_array($settings['infected']['allowed_extensions']) ? $settings['infected']['allowed_extensions'] : array();
    $allowedExtensions = implode('|', $allowedExtensions);
    $infectedExtensions = str_ireplace(array('.'), '\.', $allowedExtensions);
    // Prepare allowed search string
    $searchString = str_ireplace(array('(', ')'), array('\(', '\)'), $settings['infected']['search_string']);
	
    while(false !== ($obj = readdir($dh))){
        
		if($obj == '.' || $obj == '..') continue;
		
		$path = $dir.$obj;		
        
        if($settings['general']['check_subdirectories'] && is_dir($path.'/') && !in_array(strtolower($obj), $ignoredSubDirectories)){
            $settings['general']['directories_checked']++;
            wscCheckRecursive($path.'/', $ignoredSubDirectories, $settings, $task, $mode, $xmlData);            
        }
        
		$settings['general']['files_checked']++;            

		// 1. Check for cache files
		// --------------------------------
		if($task == 'check' && $settings['cache']['active'] && preg_match('/\.'.trim($settings['cache']['file_extension'], '.').'/i', $obj)){
			$settings['cache']['found_files'][] = $path;
			$settings['cache']['total_found']++;
		}
		
		// 2. Check for thuumbs
		// --------------------------------
		if($task == 'check' && $settings['thumb']['active'] && strtolower($obj) === 'thumbs.db'){
			$settings['thumb']['found_files'][] = $path;
			$settings['thumb']['total_found']++;
		}
		
		// 3. Check for error log files
		// --------------------------------
		if($task == 'check' && $settings['errorlog']['active'] && strtolower($settings['errorlog']['file_name']) === strtolower($obj)){
			$settings['errorlog']['found_files'][] = $path;
			$settings['errorlog']['total_found']++;
		}

		// 4. Check for infected files
		// --------------------------------
		if($task == 'check' && $settings['infected']['active']){						
			if(isset($xmlData->signature)){				
				$content = @file_get_contents($path);
				$count = 0;
				foreach($xmlData->signature as $signature){					
					if(isset($signature[0]) && preg_match('/'.$signature[0].'/i', $content)){
						$attributes = $signature->attributes();						
						$settings['infected']['found_files'][] = $path;
						$settings['infected']['issue'][] = isset($attributes['title']) ? $attributes['title'] : '';
						$settings['infected']['sever'][] = isset($attributes['sever']) ? trim($attributes['sever']) : '';
						$settings['infected']['issuesnum'][] = isset($attributes['id']) ? trim($attributes['id']) : $count;
						$settings['infected']['signature'][] = str_replace('\\', '', $signature[0]);
						$settings['infected']['total_found']++;
						break;
					} 
					$count++;
				}
			}
		}

		// 5. Check for last changed files
		// --------------------------------
		if($task == 'check' && $settings['changed']['active'] && (time() - @filemtime($path)) < $diff){
			if(!is_dir($path)){
				$skip = false;
				if($settings['changed']['ignore_cache_files'] && preg_match('/\.'.trim($settings['cache']['file_extension'], '.').'/i', $obj)){
					$skip = true;
				}
				if(!$skip){
					$settings['changed']['found_files'][] = array('name'=>$path, 'date_changed'=>@filemtime($path));
					$settings['changed']['total_found']++;
				}
			}
		}
    }
	
    closedir($dh); 
    return true; 
}

/**
 * Returns shorten name of the given file
 * @param string $file
 * @param int $lengthFirst
 * @param int $lengthLast
 * @return string
 */
function wscCreateShortenName($file, $lengthFirst = 50, $lengthLast = 20)
{
    return preg_replace("/(?<=.{{$lengthFirst}})(.+)(?=.{{$lengthLast}})/", '...', $file);  
}

/**
 * Draws search result on the screen
 * @param array &$settings
 * @param string $type
 * @param bool $deleteLink
 * @param bool $cleanLink
 * @return text/html
 */
function wscDrawResult(&$settings, $type = '', $deleteLink = false, $cleanLink = false)
{
    $token = isset($_SESSION['token']) ? $_SESSION['token'] : '';
	$severity = array('c'=>'<span class="text-error">critical</span>', 'w'=>'<span class="text-warning">warning</span>', 'i'=>'<span class="text-info">info</span>');
	
	if($settings[$type]['total_found'] > 0){
		$output = '<p class="text-issues">';
	}else{
		$output = '<p class="text-ok">';
	}
    
	$output .= '<span style="color:#333;">'.wscLang('check_is_done').'</span><br>';
    $output .= 'Found: <span id="counted_'.$type.'">'. $settings[$type]['total_found'].'</span> files';        
    if($settings[$type]['total_found'] > 0){
        $output .= ' <span class="separator">/</span> <a id="'.$type.'_files_conteiner_link_show" class="files-container-link" data-show="show" data-type='.$type.' >Show<i class="icon-folder-close"></i></a>';
        $output .= ' <a id="'.$type.'_files_conteiner_link_hide" class="files-container-link" data-type='.$type.' data-show="hide" style="display:none;">Hide<i class="icon-folder-open"></i></a>';
        $output .= '<div id="'.$type.'_files_conteiner" class="files-container" style="display:none;">';
        if(is_array($settings[$type]['found_files'])){
            $count = 0;
            foreach($settings[$type]['found_files'] as $file){
                $id = $type.'_file_'.$count;
                $output .= '<div id="'.$id.'">';

                if($deleteLink){
                    $output .= '<a class="deleteFile" data-id="'.$id.'" data-file="'.$file.'" data-type="'.$type.'">';
                    $output .= '<i class="icon-trash"></i>Delete</a> ';
                }

                if($cleanLink){
					if($type == 'infected'){
						$output .= '<a class="cleanFile" data-id="'.$id.'" data-file="'.$file.'" data-type="'.$type.'" data-malware="'.$settings['infected']['issuesnum'][$count].'">';
					}else{
						$output .= '<a class="cleanFile" data-id="'.$id.'" data-file="'.$file.'" data-type="'.$type.'" data-malware="">';
					}                    
                    $output .= '<i class="icon-wrench"></i>Clean</a> ';                    
                }

                if(is_array($file)){
                    $shortenName = wscCreateShortenName($file['name']);					
                    $title = (!is_array($file) && $file['name'] !== $shortenName) ? htmlentities($file) : '';                    
                }else{
                    $shortenName = wscCreateShortenName($file);
                    $title = ($file !== $shortenName) ? htmlentities($file) : '';
                }

                if($type == 'changed'){
                    $output .= @date('Y-m-d H:i:s', $file['date_changed']).' <span title="'.$title.'">'.$shortenName.'</span>';
                }else if($type == 'infected'){
					$alertKey = $settings['infected']['sever'][$count];
					$signatureCode = $settings['infected']['signature'][$count];
					$output .= '<span title="'.$title.'" style="display:inline-block;min-width:120px;">'.$shortenName.'</span> ('.$severity[$alertKey].' - '.$settings['infected']['issue'][$count].' - <code>'.htmlspecialchars($signatureCode).'</code>)';
				}else{
					$output .= '<span title="'.$title.'">'.$shortenName.'</span>';
                }

                $output .= '</div>';
                $output .= "\r\n";
				$count++;
            }                                    
        }
        $output .= '</div>';        
    }
    $output .= '</p>';
    
    return $output;    
}

/**
 *	Returns malware signature by key
 *	@param int $key
 */
function wscFindSignature($key = 0){

	$settings = array();

	$xmlData = simplexml_load_file('../include/malware_db.xml');	
	if(isset($xmlData->signature)){
		foreach($xmlData->signature as $k => $signature){
			
			$attributes = $signature->attributes();				
			$issuesnum = isset($attributes['id']) ? trim($attributes['id']) : 0;

			if($key == $issuesnum){
				$settings['issue'] = isset($attributes['title']) ? $attributes['title'] : '';
				$settings['sever'] = isset($attributes['sever']) ? trim($attributes['sever']) : '';
				$settings['issuesnum'] = $issuesnum;
				$settings['signature'] = (string)$signature[0];
				break;
			} 
		}
	}
	
	return $settings;	
}