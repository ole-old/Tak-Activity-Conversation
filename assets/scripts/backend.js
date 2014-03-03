var uploadify_img_types = '*.jpg;*.jpeg;*.png;*.gif;*.eps;*.psd;*.ai;*.tiff';
var uploadify_doc_types = '*.doc;*.docx;*.pdf;*.xls;*.vcf;*.vcard;*.ppt;*.pptx';

$(document).ready(function(){

	$('input.upldify').each(function(){
		var fileType = "";
		var allowedFileTypes = "";
		var folder = '/assets/files'+$(this).attr('folder');
		var params = {};
		var queue = $(this).parent().parent().parent().find('div.uploadProgress').attr('id');
		var myInpId = $(this).attr('id').replace('upldf_', '');
		var myContainer = $(this).parent().parent().parent();
		var callBack = "";
		var extrathumb = 0;

		if (typeof $(this).attr('callback') !== 'undefined' && $(this).attr('callback') !== false)
			callBack = $(this).attr('callback');
		
		if (typeof $(this).attr('extrathumb') !== 'undefined' && $(this).attr('extrathumb') !== false)
			extrathumb = $(this).attr('extrathumb');

		if($(this).hasClass('image')){
			fileType = "image";
			allowedFileTypes = uploadify_img_types;
			params = {
				fileType   : fileType,
				maxWidth   : 232,
				maxHeight  : 112,
				thumbWidth : 64,
				thumbHeight: 64,
				callBack   : callBack,
				extrathumb : extrathumb,
				folder     : folder
			};
		} else if($(this).hasClass('doc')){
			fileType = "doc";
			allowedFileTypes = uploadify_doc_types;
			params = {
				fileType   : fileType,
				folder     : folder,
				callBack   : callBack
			};
		}

		$(this).uploadify({
			'auto'      : true,
			'swf'  : '../assets/uploadify/uploadify.swf',
			'uploader'    : '/www/admin/api/api/uploadify/',
			'fileTypeExts' : allowedFileTypes,
			'buttonText'   : 'Select file',
			'checkExisting': false,
			'formData': params,
			'height'   : 30,
			'queueID'   : queue,
			'fileObjName': 'upload',
			'onUploadSuccess': function(file, data, response) {
				response = jQuery.parseJSON(data);
				if(!response.error){
					if(response.fileInfo.type == 'image')
						myContainer.find('div.thumb').html('<a href="..'+response.original_wpath+'" target="_blank"><img src="../'+response.thumb_wpath+'" /></a>');
					else
						myContainer.find('div.thumb').html('<a href="..'+response.original_wpath+'" target="_blank"><img src="../assets/images/backend/icon_'+response.fileInfo.extension+'.png" /></a>');
					myContainer.find('div.uploadifyData div.fileDetail').html(response.original);
					$('input#'+myInpId).val(response.original);
					if(response.callBack.length > 0){
						eval(callBack+"()");
					}
				} else{
					alert("An error occurred while saving the file, please try again");
				}
			}
		});

	});


	$('a.delattach').click(function(e){
		e.preventDefault();
		var delwhat = $(this).attr('id').split('_')[1];
		if(confirm("Are you sure you want to delete the attached file?")){
			$('div.upldr_'+delwhat+' input.filename').val('');
			$('div.upldr_'+delwhat+' div.thumb').html('');
			$('div.upldr_'+delwhat+' div.fileDetail').text('No file selected');
			$('div#showdel_'+delwhat).fadeOut();
		}
	});

	
});


function show_delpic_options(){
	$('div#showdel_imagename').fadeIn();
}



// Default functions for admin

$(document).ready(function(){

	$('div.pagination #anterior').on('click', function(e){
		e.preventDefault();
		if ( ! $(this).hasClass('disabled')) {
			$('form[name="filters_player"] input[name="page"]').val($(this).data('page'));
			$('form[name="filters_player"]').submit();
		}
	});
	
	
	$('div.pagination #siguiente').on('click', function(e){
		e.preventDefault();
		if ( ! $(this).hasClass('disabled')) {
			$('form[name="filters_player"] input[name="page"]').val($(this).data('page'));
			$('form[name="filters_player"]').submit();
		}
	});
	
	
	
	// logout
	$('.logout').click(function(){
		if( ! window.confirm($(this).attr('title')))
			return false;
	});
	
	// menu
	$("#menu a").each(function(i){
		var group = $(this).attr("class");
		var href = $("#submenu li."+group).eq(0).find("a").attr("href");
		$(this).attr("href", href);
	})
	.click(function(){
		var group = $(this).attr("class");
		var subitems = $("#submenu li."+group).length;
		if(subitems>1){
			$("#menu li").removeClass("selected");
			$("#menu a."+group).parent().addClass("selected");
			$("#submenu li").removeClass("visible");
			$("#submenu li."+group).addClass("visible");
			return false;
		}
	});
	
	// sort by column
	$("th.sortable").each(function(){
		$(this).attr("title", "Sort by "+$(this).text().toLowerCase());
		$(this).html("<span>" + $(this).text() + "</span>");
		if($(this).attr("abbr")==$("input[name='order_by']").val()){
			$(this).addClass($("input[name='sort']").val().toLowerCase());
		}
	});
	$("th.sortable span").click(function(){
		var sort = ($("input[name='sort']").val().toLowerCase()=="asc") ? "DESC" : "ASC";
		$("input[name='sort']").val(sort);
		$("input[name='order_by']").val($(this).parent().attr("abbr"));
		$("#filters").submit();
	});
	
	// search filters
	$("#filters button.submit").click(function(){
		$("input[name='page']").val(1);
	});
	
	// change page
	$("#pages ul a ").click(function(){
		var page = $(this).attr("href").replace("#page","");
		$("input[name='page']").val(page);
		$("#filters").submit();
		return false;
	});
	
	// select all items
	$("input[name='select_all']").click(function(){
		if($(this).is(":checked")){
			$("input[name='items[]']").attr("checked", "checked");
		} else {
			$("input[name='items[]']").attr("checked", false);
		}
	});
	
	// delete item from list
	$("td.delete a").click(function(){
		if(window.confirm("Are you sure you want to delete the selected item?")){
			$("#filters fieldset.hidden").append('<input type="hidden" name="csrf_token" value="'+$("#csrf_token").text()+'" />');
			$("#filters").get(0).setAttribute("action", $(this).attr("href"));
			$("#filters").attr("method", "post").submit();
		}
		return false;
	});
	
	// delete item from form
	$("#form a.delete").click(function(){
		if(window.confirm("Are you sure you want to delete this item?")){
			var action = $(this).attr("href") + '?id=' + $("#form input[name='id']").val();
			$("#form").get(0).setAttribute("action", action);
			$("#form").submit();
		}
		return false;
	});
	
	// delete item from modal form
	$("#modal-form").on("click", 'a.delete', function(){
		if(window.confirm("Are you sure you want to delete this item?")){
			var action = $("#modal-form").attr("action").replace("/details", "/delete");
			$("#modal-form").attr("action", action).submit();
		}
		return false;
	});
	
	// bulk actions
	$("#filters a.bulk").click(function(){
		var items_num = $("#filters input[name='items[]']:checked").length;
		if(items_num==0){
			alert("Please select at least one item");
		} else {
			if(window.confirm($(this).attr("title"))){
				$("#filters fieldset.hidden").append('<input type="hidden" name="csrf_token" value="'+$("#csrf_token").text()+'" />');
				$("#filters").get(0).setAttribute("action", $(this).attr("href"));
				$("#filters").attr("method", "post").submit();
			}
		}
		return false;
	});
	
	// cancel edit mode
	$("#form a.cancel").click(function(){
		history.back();
		return false;
	});
	
	// show/hide search filters
	$("a.filters").click(function(){
		if($("fieldset.filters").is(":hidden")){
			$(this).text("Hide search").addClass("visible");
			$("fieldset.filters").addClass("visible").show();
		} else {
			$(this).text("Show search").removeClass("visible");
			$("fieldset.filters").removeClass("visible").hide();
		}
		return false;
	});
	
	// form validation
	$("form.validate").submit(function(){
		var error = false;
		$("input.required, select.required, textarea.required").each(function(){
			if($.trim($(this).val())==""){
				alert("Please fill in this field");
				$(this).focus().addClass("error");
				error = true;
				return false;
			}
			if($(this).hasClass("email") && $.trim($(this).val())!="" && !$(this).val().isEmail()){
				alert("Please enter a valid email address");
				$(this).focus().addClass("error");
				error = true;
				return false;
			}
		});
		return !error;
	});
	$("input, select, textarea").bind("focus change keydown blur", function(){
		$(this).removeClass("error");
	});
	
	// flash messages
	$("div.warning, div.success, div.error").fadeOut().fadeIn().fadeOut().fadeIn();
	
	// date picker
//	$.datepicker.setDefaults( $.datepicker.regional[ "no" ] );
	$("input.date").datepicker({ dateFormat: "yy-mm-dd", firstDay: 1, changeMonth: true, changeYear: true, yearRange: '1940:2015' });
	
	// zebra tables
	$('table.zebra tr:even').addClass('even'); 
	
	// modal
	$("td.view a").click(function(){
		var url = $(this).attr("href");
		$("body").append('<div id="overlay"></div><div id="modal"><img src="../assets/images/backend/close.png" width="42" height="42" alt="Close" class="close"></div>');
		$("#overlay").show(function(){
			// load ajax
			$("#modal").addClass("loading").show(300, function(){
				$.get(url, function(data){
					$("#modal").removeClass("loading").append(data);
				});
			});
		});
		return false;
	});
	
	// close modal
	$(document).on("click", "img.close", function(){
		var new_token = $("#modal-form input[name='token']").val();
		$("#filters span.csrf_token").text(new_token);
		$("#modal").html("").hide(300, function(){
			$("#overlay").remove();
			$(this).remove();
		});
	});
	
	/*
	if ($("div.richtext textarea").length) {
		$("div.richtext textarea").tinymce({
			// Location of TinyMCE script
			script_url : '/assets/tiny_mce/tiny_mce.js',
			// General options
			theme : "advanced",
			language : "en",
			plugins : "imagemanager,safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,bullist,numlist,|,outdent,indent,|,link,unlink,|,image,|,cleanup,code,|,justifyleft,justifycenter,justifyright,justifyfull",
			theme_advanced_buttons2 : "tablecontrols,|,formatselect,|,forecolor,backcolor",
			theme_advanced_buttons3 : "",
			theme_advanced_buttons4 : "",
//			theme_advanced_toolbar_location : "external",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : false,
			width: 800,
			content_css : '/assets/styles/ckeditor.css'
		});
	}
*/
	// init ckeditor
	/*
	if ($("div.richtext textarea").length) {
		$("div.richtext textarea").ckeditor({
			toolbar:
			[
				[ 'Bold','Italic','Underline','Strike','Subscript','Superscript' ],
				[ 'HorizontalRule','-','Link','Unlink','-','Image' ], 
				[ 'NumberedList','BulletedList','-','Outdent','Indent','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ],
				[ 'TextColor','BGColor' ], 
				['Source']
			],
			language: 'es',
			width: 910,
			height: 400,
			filebrowserBrowseUrl : '/assets/filemanager/index.html',
		});
	}
	*/

	// modal
	$("td.inhome a").click(function(e){
		e.preventDefault();
		var url = $(this).attr("href");
		var mybtnimg = $(this).find('img');
		if(mybtnimg.attr('src').indexOf('_off')>=0){
			msg = "Are you sure you want to publish this entry to the Home page?";
			mynewimg = mybtnimg.attr('src').replace('_off.png', '.png');
		} else {
			msg = "Are you sure you want to unpublish this entry from the Home page?";
			mynewimg = mybtnimg.attr('src').replace('.png', '_off.png');
		}
		if(confirm(msg)){
			$.post(url, { upd: 1 }, function(data){
				console.log(data);
				mybtnimg.attr('src', mynewimg);
			}, 'json');
		}
	});
	
	
	$("[name=school_year_id]").change(function(){
		$("[name=asignature_id]").empty();
		$.getJSON("../materias", { school_year_id: $('[name=school_year_id]').val() },function(data){
            $("select[name=asignature_id]").append('<option value="">- Seleccione -</option>');
 			$(data).each(function(i){
                $("select[name=asignature_id]").append('<option value="'+this.id+'">'+this.asignature+'</option>');
 			});
        });
    });

});

String.prototype.isEmail = function(){
	return (this.valueOf().search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) != -1);
}