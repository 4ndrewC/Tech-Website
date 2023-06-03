<?php
/**
* @project ApPHP WebsiteCleaner
* @copyright (c) 2015 ApPHP
* @author ApPHP <info@apphp.com>
* @license http://www.gnu.org/licenses/
*/

// Initialize the session
session_start();
// Set default timezone
@date_default_timezone_set('America/Los_Angeles');

/*
|--------------------------------------------------------------------
| Include files
|--------------------------------------------------------------------
*/
include('include/settings.inc.php');
include('include/functions.inc.php');
// Check if language file exists and include it, otherwise use English lang file 
if(file_exists('include/langs/'._CURRENT_LANGUAGE.'.inc.php')){
	include('include/langs/'._CURRENT_LANGUAGE.'.inc.php');	
}else{
	include('include/langs/en.inc.php');	
}


// Set executing time limit
set_time_limit(_PHP_TIME_LIMIT);


/*
|--------------------------------------------------------------------
| Check and set token
|--------------------------------------------------------------------
*/
$token_post = isset($_POST['token']) ? $_POST['token'] : 'post';
$token_session = isset($_SESSION['token']) ? $_SESSION['token'] : 'session';
if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    if($token_session != $token_post){
        unset($_POST['task']);
    }
}

$token = md5(uniqid(rand(), true));	
$_SESSION['token'] = $token;


/*
|--------------------------------------------------------------------
| Retrieve parameters 
|--------------------------------------------------------------------
*/
$directoryPath = isset($_POST['settings_directory_path']) ? $_POST['settings_directory_path'] : '';
if(_MODE == 'demo') $directoryPath = 'test/';
$ignoredSubDirectories = '';
$includeSubDirectories = isset($_POST['settings_include_subdirectories']) ? (bool)$_POST['settings_include_subdirectories'] : '';
$cache 		= isset($_POST['settings_cache']) ? (bool)$_POST['settings_cache'] : false;
$thumb 		= isset($_POST['settings_thumb']) ? (bool)$_POST['settings_thumb'] : false;
$errorlog 	= isset($_POST['settings_errorlog']) ? (bool)$_POST['settings_errorlog'] : false;
$infected 	= isset($_POST['settings_infected']) ? $_POST['settings_infected'] : '';
$changed 	= isset($_POST['settings_changed']) ? (bool)$_POST['settings_changed'] : false;
$task 		= isset($_POST['task']) ? $_POST['task'] : '';
$msg 		= '';
$tasksCount = 1;
$result = false;


/*
|--------------------------------------------------------------------
| Set search array
|--------------------------------------------------------------------
*/
$settings = array(
    'general'	=> array('running_time'=>'0', 'check_subdirectories'=>$includeSubDirectories, 'files_checked'=>0, 'directories_checked'=>0),
    'cache'		=> array('enabled'=>true, 'active'=>$cache, 'total_found'=>0, 'found_files'=>array(), 'file_extension'=>_CACHE_FILE_EXTENSION, 'allow_deleting'=>_CACHE_ALLOW_DELETING),
    'thumb'		=> array('enabled'=>true, 'active'=>$thumb, 'total_found'=>0, 'found_files'=>array(), 'allow_deleting'=>_THUMB_ALLOW_DELETING),
    'errorlog'	=> array('enabled'=>true, 'active'=>$errorlog, 'total_found'=>0, 'found_files'=>array(), 'file_name'=>_ERRORLOG_FILE_NAME, 'allow_deleting'=>_ERRORLOG_ALLOW_DELETING),
    'infected'	=> array('enabled'=>true, 'active'=>$infected, 'total_found'=>0, 'found_files'=>array(), 'search_string'=>_INFECTED_SEARCH_STRING, 'replace_string'=>_INFECTED_REPLACE_STRING, 'allowed_extensions'=>$_INFECTED_ALLOWED_EXTENSIONS, 'allow_deleting'=>_INFECTED_ALLOW_DELETING, 'allow_cleaning'=>_INFECTED_ALLOW_CLEANING),
    'changed'	=> array('enabled'=>true, 'active'=>$changed, 'total_found'=>0, 'found_files'=>array(), 'diff_hours'=>_CHANGED_DIFF_HOURS, 'ignore_cache_files'=>_CHANGED_IGNORE_CACHE_FILES),
);

if($task != ''){
    if(!$directoryPath){
        $msg = '<p class="text-warning">'.wscLang('No directory path is entered!').'</p>';    
    }else if(!$cache && !$thumb && !$changed && !$errorlog && !$infected){
        $msg = '<p class="text-warning">'.wscLang('No options selected!').'</p>';    
    }        

    if($task == 'check'){
        $directoryPath = trim($directoryPath, '/').'/';
		
		if(_IGNORED_SUB_DIRECTORIES != ''){
			$ignoredSubDirectories = explode(',', str_replace(' ', '', strtolower(_IGNORED_SUB_DIRECTORIES)));
		}
		
        $startTime = wscGetFormattedMicrotime();
		// Load XML file for template info
		$xmlData = ($settings['infected']['active']) ? simplexml_load_file('include/malware_db.xml') : '';		
        $result = wscCheckRecursive($directoryPath, $ignoredSubDirectories, $settings, 'check', 'view', $xmlData);
        $finishTime = wscGetFormattedMicrotime();
        $settings['general']['running_time'] = round((float)$finishTime - (float)$startTime, 5);
		
        if(!$result){
            $msg = '<p class="text-error">'.wscLang('Wrong destination directory path! Please re-enter.').'</p>';
        }
    }
}    

?>
<!DOCTYPE html>
<html lang="en"><head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>ApPHP WebsiteCleaner - <?php echo wscLang('Index'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="php web cleaner, php site cleaner, web malware cleaner, online site cleaner" />   
    <meta name="description" content="Powerful and easy to use website malware cleanup utility" />
    <meta name="author" content="ApPHP Company">

    <link href="bootstrap/bootstrap.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="bootstrap/bootstrap-responsive.css" rel="stylesheet">
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
		
    <!-- icons -->
    <link rel="shortcut icon" href="images/apphp.ico">
</head>
<body id="top">

    <div class="container-narrow">
        
        <div class="masthead">
            <a id="logo_title" href="index.php"><h3 class="muted">ApPHP WebsiteCleaner</h3></a>
        </div>
        <hr>
        
        <div class="jumbotron">
            <h1><?php echo wscLang('awesome cleaner'); ?></h1>
            <p class="lead">
				<?php echo wscLang('awesome cleaner description'); ?>
                <br>
				<?php echo wscLang('awesome cleaner description minutes'); ?>
            </p>
            <a class="btn btn-large btn-success go_start"><?php echo wscLang('Click to Start!'); ?></a>
            <br><br>
        </div>
		
		<div id="settings" class="row-fluid" style="display:none;">
			<ul class="breadcrumb">
				<li id="homeBreadcrumbs"><a id="home_redirect" href="#"><i class="icon-home"></i><?php echo wscLang('Start Page'); ?></a> <span class="divider"><i class="icon-chevron-right"></i></span></li>
				<li id="settingsBreadcrumbs"><i class="icon-cog"></i><?php echo wscLang('Settings'); ?> <span id="resultsPointer" class="divider"><i class="icon-chevron-right"></i></span></li>
				<li id="settingsBreadcrumbsLink"><a href="index.php"><i class="icon-cog"></i><?php echo wscLang('Settings'); ?></a> <span id="resultsPointer" class="divider"><i class="icon-chevron-right"></i></span></li>
				<li id="resultsBreadcrumbs" ><i class="icon-ok-sign"></i><?php echo wscLang('Results'); ?></li>
			</ul>
	
			<?php 
				if(!$result){
					echo ' <h2>'.wscLang('Set Configuration').'</h2>';
				}else{
					echo ' <h2>'.wscLang('Results').'</h2>';
				}			
			?>
			   
            <?php echo wscLang('Please select the required'); ?><br>
            <?php echo wscLang('Be careful when deleting'); ?>
            <br>
            <?php echo (_MODE == 'demo') ? '<p class="text-error"><strong>'.wscLang('ATTENTION').'</strong>: '.wscLang('Running in DEMO').'</p>' : '<br>'; ?>            

            <div class="span11" style="margin-left:1px;">
			<?php                
				echo $msg;
				if($result){
					echo '<p class="text-info">';
					echo wscLang('Total files checked').' '.$settings['general']['files_checked'].'<br>';
					echo wscLang('Total sub-directories').$settings['general']['directories_checked'].'<br>';
					echo wscLang('Total running time').' '.$settings['general']['running_time'].' sec.';
					echo '</p>';
				}
			?>        

			<form id="frmSiteCheck" action="index.php#settings" method="post">
				<input type="hidden" name="task" value="check" />
				<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
				
				<h5><?php echo $tasksCount++; ?>. <?php echo wscLang('Enter a path'); ?> <a  data-toggle="tooltip" title="<?php echo htmlspecialchars(wscLang('Example: ../ or modules/ or ../modules/files/'), ENT_QUOTES, "UTF-8"); ?>"><i class="icon-question-sign"></i></a></h5>
				<input type="text" name="settings_directory_path" class="input-block-level input-xxlarge" <?php echo (_MODE == 'demo') ? 'readonly="readonly"' : ''; ?> value="<?php echo htmlspecialchars($directoryPath, ENT_QUOTES, "UTF-8"); ?>" placeholder="relative/path/to/destination/directory/">
				<a id="selectorAll" data-status="select"><?php echo wscLang('select all'); ?></a>
				<label class="checkbox"><input type="checkbox"<?php echo ($includeSubDirectories ? ' checked="checked"' : ''); ?> name="settings_include_subdirectories" class="forCheck" value="1"> <?php echo wscLang('include sub-directories'); ?></label>
				
				<?php if($settings['cache']['enabled']){ ?>    
					<h5><?php echo $tasksCount++; ?>. <?php echo wscLang('Search for cache'); ?></h5>
					<label class="checkbox"><input type="checkbox"<?php echo ($cache ? ' checked="checked"' : ''); ?> name="settings_cache" class="forCheck" value="1"> <?php echo wscLang('select this option'); ?><?php echo $settings['cache']['file_extension'] ? '<code>'.$settings['cache']['file_extension'].'</code>'.wscLang('extension').' ' : '<span class="text-error">'.wscLang('no settings defined').'</span>'; ?></label>
					<?php
						if($settings['cache']['enabled'] && $cache && $result){
							echo wscDrawResult($settings, 'cache', $settings['cache']['allow_deleting']);
						};
					?>
				<?php } ?>
				
				<?php if($settings['thumb']['enabled']){ ?>
					<h5><?php echo $tasksCount++; ?>. <?php echo wscLang('Search for thumb files'); ?></h5>
					<label class="checkbox"><input type="checkbox"<?php echo ($thumb ? ' checked="checked"' : ''); ?>  name="settings_thumb" class="forCheck" value="1"><?php echo wscLang('select this option to search for thumb files'); ?> <code>thumb.db</code>)</label>
					<?php
						if($thumb && $result){
							echo wscDrawResult($settings, 'thumb', $settings['thumb']['allow_deleting']);
						};
					?>
				<?php } ?>
				
				<?php if($settings['errorlog']['enabled']){ ?>
					<h5><?php echo $tasksCount++; ?>. <?php echo wscLang('Search for error log'); ?></h5>
					<label class="checkbox"><input type="checkbox"<?php echo ($errorlog ? ' checked="checked"' : ''); ?>  name="settings_errorlog" class="forCheck" value="1"><?php echo wscLang('select this option to search for error log files'); ?>(<?php echo $settings['errorlog']['file_name'] ? wscLang('files named as').' <code>'.$settings['errorlog']['file_name'].'</code>' : '<span class="text-error">'.wscLang('no settings defined').'</span>'; ?>)</label>
					<?php                       
						if($errorlog && $result){
							echo wscDrawResult($settings, 'errorlog', $settings['errorlog']['allow_deleting']);
						};
					?>
				<?php } ?>

				<?php if($settings['infected']['enabled']){?>
					<h5><?php echo $tasksCount++; ?>. <?php echo wscLang('Search for malware files'); ?></h5>
					<label class="checkbox"><input type="checkbox"<?php echo ($infected ? ' checked="checked"' : ''); ?> name="settings_infected" class="forCheck" value="1"><?php echo wscLang('select this option to search for malware files'); ?></label>
					<?php
						if($infected !== '' && $result){
							echo wscDrawResult($settings, 'infected', $settings['infected']['allow_deleting'], $settings['infected']['allow_cleaning']);
						};
					?>
				<?php } ?>

				<?php if($settings['changed']['enabled']){?>
					<h5><?php echo $tasksCount++; ?>. <?php echo wscLang('Search for last changed files'); ?></h5>
					<label class="checkbox"><input type="checkbox"<?php echo ($changed ? ' checked="checked"' : ''); ?>  name="settings_changed" class="forCheck" value="1"><?php echo wscLang('select this option to search for files changed in last'); ?><?php echo (int)$settings['changed']['diff_hours']; ?><?php echo wscLang('hours'); ?></label>
					<?php                       
						if($changed && $result){
							echo wscDrawResult($settings, 'changed', false);
						};
					?>
				<?php } ?>
				<br><br><br>
				
				<?php                
					if($result){
						echo '<a class="btn btn-primary tn-large" id="btnCheckNow" >'.wscLang('Run Again').'</a>';					
						echo '<span id="start-over-conteiner">';
						echo '&nbsp;&nbsp; - or - &nbsp;&nbsp;<a href="index.php">'.wscLang('Start Over').' <i class="icon-refresh"></i></a>';
						echo '</span>';
					}else{
						echo '<a class="btn btn-primary tn-large" id="btnCheckNow">'.wscLang('Check Now My Website').'</a>';
					}
				?>                    
                </form>            
                <br><br><br><br>
				
            </div>
        </div>
        <hr>     

    </div> <!-- /container -->

    <div class="footer">
        <p>
			<a id="footer_about" href="https://www.apphp.com/php-website-cleaner/index.php" target="_blank" rel="noopener noreferrer" title="Opens in new window">ApPHP WebsiteCleaner <small>v1.1.6</small> &copy; ApPHP <?php echo @date('Y'); ?></a>               
            <a data-anhor="top" class="pull-right go_top"><?php echo wscLang('top'); ?> <i class="icon-circle-arrow-up"></i></a>                
        </p>            
    </div>

    <!-- javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="bootstrap/jquery.js"></script>
    <script src="bootstrap/bootstrap-transition.js"></script>
    <script src="bootstrap/bootstrap-alert.js"></script>
    <script src="bootstrap/bootstrap-modal.js"></script>
    <script src="bootstrap/bootstrap-dropdown.js"></script>
    <script src="bootstrap/bootstrap-scrollspy.js"></script>
    <script src="bootstrap/bootstrap-tab.js"></script>
    <script src="bootstrap/bootstrap-tooltip.js"></script>
    <script src="bootstrap/bootstrap-popover.js"></script>
    <script src="bootstrap/bootstrap-button.js"></script>
    <script src="bootstrap/bootstrap-collapse.js"></script>
    <script src="bootstrap/bootstrap-carousel.js"></script>
    <script src="bootstrap/bootstrap-typeahead.js"></script>
    
    <script src="js/main.js"></script>
	<script src="js/langs/<?php echo _CURRENT_LANGUAGE.'.js'; ?>"></script>	
</body>
</html>