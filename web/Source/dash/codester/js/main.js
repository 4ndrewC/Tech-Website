$(document).ready(function(){

	// Initialize tooltips
    $('[data-toggle=tooltip]').tooltip();
	   
	// Select/Unselect All
	$('#resultsBreadcrumbs').css('display', 'none');	
	$('#resultsPointer').css('display', 'none');	
	$('#settingsBreadcrumbsLink').css('display', 'none');	
	
	if($('.text-info').css('display') == 'block'){
		$('#selectorAll').text(wscVocabulary._MSG['Unselect All']);
		$('#selectorAll').data('status', 'unselect');
		$('.jumbotron').css('display', 'none');
		$('#settings').css('display', 'block');
		$('#settingsBreadcrumbs').addClass('active');
		$('#resultsBreadcrumbs').css('display', 'inline');
		$('#resultsPointer').css('display', '');
		$('#settingsBreadcrumbsLink').css('display', '');	
		$('#settingsBreadcrumbs').css('display', 'none');	
	}
	
	// Show start script panel 
	$('.go_start').click(function(){
		$('.jumbotron').css('display', 'none');
		$('#settings').css('display', 'block');
	});

	$('#home_redirect').click(function(){
		$('.jumbotron').css('display', 'block');
		$('#settings').css('display', 'none');
	});
	
	$('#selectorAll').click(function(){
		//alert($(this).data('status'));
		if($(this).data('status') == 'select'){
			$(this).text(wscVocabulary._MSG['Unselect All']);
			$(this).data('status', 'unselect');
			$('.forCheck').prop('checked', true);
		}else{
			$(this).text(wscVocabulary._MSG['Select All']);
			$(this).data('status', 'select');
			$('.forCheck').prop('checked', false);
		}
	});

	/**
     * Click event for button 'Check'
     */
	$('#btnCheckNow').click(function(){        
        var directory_path = $('#frmSiteCheck input[name=settings_directory_path]').val();
        var include_subdirectories = $('#frmSiteCheck input[name=settings_include_subdirectories]').is(':checked');
        var cache = $('#frmSiteCheck input[name=settings_cache]').is(':checked');
        var thumb = $('#frmSiteCheck input[name=settings_thumb]').is(':checked');
        var infected = $('#frmSiteCheck input[name=settings_infected]').is(':checked');
        var changed = $('#frmSiteCheck input[name=settings_changed]').is(':checked');
        var errorlog = $('#frmSiteCheck input[name=settings_errorlog]').is(':checked');        
        
        if(!directory_path){
            alert(wscVocabulary._MSG['No directory path is entered!']);
            return false;            
        }else if(!cache && !thumb && !changed && !errorlog && !infected){
            alert(wscVocabulary._MSG['No options selected!']);
            return false;
        }
        
        $('#start-over-conteiner').hide();
        $('.files-container-link').hide();
        $('.files-container').hide();
        $('.text-info').hide();
        $('.text-success').hide();
        
        $(this).attr('disabled', true);
        $(this).text(wscVocabulary._MSG['Working, please wait...']);
        
        // submit form
        $('#frmSiteCheck').submit();
        return true;
    });        
	
	$('.deleteFile').click(function(data){
		var id = $(this).data('id'),
			file = $(this).data('file'),
			type = $(this).data('type'),
			token = $('#token').val(),
			isAccess = confirm(wscVocabulary._MSG['Are you really want to delete this file'] + ': ' + file + '?');
		
		if(isAccess == true){
			wscDeleteFile(id, file, type, token, '');
		}
	});
	
	$('.cleanFile').click(function(data){
		var id = $(this).data('id'),
			file = $(this).data('file'),
			type = $(this).data('type'),
			token = $('#token').val(),
			malware = $(this).data('malware'),
			isAccess = confirm(wscVocabulary._MSG['Are you really want to clean this file'] + ': ' + file + '?');
		
		if(isAccess == true){
			wscCleanFile(id, file, type, token, malware);
		}
	});
	
	$('.files-container-link').click(function(data){
		var type = $(this).data('type');	
		var show = $(this).data('show');	
		wscContainerToggle(type+'_files_conteiner', show)
	});
	
	$('.go_top').click(function(data){
		var anhor = $(this).data('anhor');	
		wscScrollTo(anhor)
	});    
});

/**
 * Toggle showing of files container
 * @param el
 * @param mode
 */
function wscContainerToggle(el, mode){
    if(mode == 'show'){
        $('#'+el+'_link_show').hide();
        $('#'+el+'_link_hide').show();
    }else{
        $('#'+el+'_link_show').show();
        $('#'+el+'_link_hide').hide();
    }
    $('#'+el).toggle();  
}

/**
 * Deletes file by AJAX call
 * @param el
 * @param file
 * @param type
 * @param token
 */
function wscDeleteFile(el, file, type, token, malware){
    ajaxCall(el, file, type, token, 'delete', '');    
}

/**
 * Cleans file by AJAX call
 * @param el
 * @param file
 * @param type
 * @param token
 */
function wscCleanFile(el, file, type, token, malware){
    ajaxCall(el, file, type, token, 'clean', malware);    
}

/**
 * Perform AJAX call
 * @param el
 * @param file
 * @param type
 * @param token
 * @param action
 */
function ajaxCall(el, file, type, token, action, malware){
    var errorMessage = '';
    var countedFiels = 0;
	
    jQuery.ajax({
        url: 'ajax/handler.ajax.php',
        global: false,
        type: 'POST',
        data: ({file: file, action: action, check_key: 'apphpwsc', token: token, malware: malware}),
        dataType: 'html',
        async: true,
        error: function(html){
            alert('AJAX: cannot connect to the server or server response error! Please try again later.');
        },
        success: function(html){
            var obj = jQuery.parseJSON(html);
            if(obj.status == '1'){
                $('#'+el).hide();
                countedFiels = $('#counted_'+type).html();
                if(countedFiels > 0) $('#counted_'+type).html(countedFiels - 1);
            }else{                
                errorMessage = (obj.error_description != '') ? obj.error_description : (action == 'clean' ? wscVocabulary._MSG['File Cleaning Error'] : wscVocabulary._MSG['File Removing Error']);
                alert(errorMessage);    
            }
        }
    });	        
}

/**
 * Scrolls page to the define place
 * @param el
 * @param time
 */
function wscScrollTo(el, time){
    $('html, body').animate({scrollTop: $('#'+el).offset().top}, time);    
}
