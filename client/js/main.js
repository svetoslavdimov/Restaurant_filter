$(document).ready(function() {
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },
              ],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        $('#datatable').dataTable();

        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
          ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });

        $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

        var $datatable = $('#datatable-checkbox');

        $datatable.dataTable({
          'order': [[ 1, 'asc' ]],
          'columnDefs': [
            { orderable: false, targets: [0] }
          ]
        });
        $datatable.on('draw.dt', function() {
          $('input').iCheck({
            checkboxClass: 'icheckbox_flat-green'
          });
        });

        TableManageButtons.init();
      });

/**
 * Resize function without multiple trigger
 * 
 * Usage:
 * $(window).smartresize(function(){  
 *     // code here
 * });
 */
(function($,sr){
    // debouncing function from John Hann
    // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
    var debounce = function (func, threshold, execAsap) {
      var timeout;

        return function debounced () {
            var obj = this, args = arguments;
            function delayed () {
                if (!execAsap)
                    func.apply(obj, args); 
                timeout = null; 
            }

            if (timeout)
                clearTimeout(timeout);
            else if (execAsap)
                func.apply(obj, args);

            timeout = setTimeout(delayed, threshold || 100); 
        };
    };

    // smartresize 
    jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

})(jQuery,'smartresize');
/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var CURRENT_URL = window.location.href.split('?')[0],
    $BODY = $('body'),
    $MENU_TOGGLE = $('#menu_toggle'),
    $SIDEBAR_MENU = $('#sidebar-menu'),
	$SIDEBAR_MENU_LI = $('.child_menu li', $SIDEBAR_MENU),
    $SIDEBAR_FOOTER = $('.sidebar-footer'),
    $LEFT_COL = $('.left_col'),
    $RIGHT_COL = $('.right_col'),
    $NAV_MENU = $('.nav_menu'),
    $FOOTER = $('footer');
	$LOADING = $('#loading');

// Sidebar
$(function() {
    // TODO: This is some kind of easy fix, maybe we can improve this
    var setContentHeight = function () {
        // reset height
        $RIGHT_COL.css('min-height', $(window).height());

        var bodyHeight = $BODY.outerHeight(),
            footerHeight = $BODY.hasClass('footer_fixed') ? -10 : $FOOTER.height(),
            leftColHeight = $LEFT_COL.eq(1).height() + $SIDEBAR_FOOTER.height(),
            contentHeight = bodyHeight < leftColHeight ? leftColHeight : bodyHeight;

        // normalize content
        contentHeight -= $NAV_MENU.height() + footerHeight;

        $RIGHT_COL.css('min-height', contentHeight);
		
		$LOADING.hide();
		
    };

    $SIDEBAR_MENU.find('a').on('click', function(ev) {
		
		$SIDEBAR_MENU_LI.removeClass('active active-sm current-page');
		
        var $a = $(this),
			$li = $(this).parent();

        if ($li.is('.active')) {
			
            $li.removeClass('active active-sm current-page');
			
            $('ul:first', $li).slideUp(function() {
                setContentHeight();
            });
			
        } else {
			
            if (!$li.parent().is('.child_menu')) {
                $SIDEBAR_MENU.find('li').removeClass('active active-sm current-page');
                $SIDEBAR_MENU.find('li ul').slideUp();
				$li.addClass('active');
            }
			
            $li.addClass('current-page');
			
			gogo($a.attr('href'));
			
            $('ul:first', $li).slideDown(function() {
                setContentHeight();
            });
			
        }
    });
	
	gogo(CURRENT_URL);


    $MENU_TOGGLE.on('click', function() {
        if ($BODY.hasClass('nav-md')) {
            $SIDEBAR_MENU.find('li.active ul').hide();
            $SIDEBAR_MENU.find('li.active').addClass('active-sm').removeClass('active');
        } else {
            $SIDEBAR_MENU.find('li.active-sm ul').show();
            $SIDEBAR_MENU.find('li.active-sm').addClass('active').removeClass('active-sm');
        }

        $BODY.toggleClass('nav-md nav-sm');

        setContentHeight();
    });


    $SIDEBAR_MENU.find('a[href="' + CURRENT_URL + '"]').parent('li').addClass('current-page');

    $SIDEBAR_MENU.find('a').filter(function () {
        return this.href == CURRENT_URL;
    }).parent('li').addClass('current-page').parents('ul').slideDown(function() {
        setContentHeight();
    }).parent().addClass('active');


    $(window).smartresize(function(){  
        setContentHeight();
    });

    setContentHeight();


    if ($.fn.mCustomScrollbar) {
        $('.menu_fixed').mCustomScrollbar({
            autoHideScrollbar: true,
            theme: 'minimal',
            mouseWheel:{ preventDefault: true }
        });
    }

});

$default_module = $('#module_');
$current_module = $default_module;

function gogo(to){

	if (!to) return;

	var
		hash = to.split('#'),
		path = hash[1] ? hash[1].split('/') : false,
		$module = path ? $('#module_' + path[0] + '_' + path[1]) : false;

	$module = $module[0] ? $module : $default_module;

	$current_module.hide();

	$module.stop().fadeIn(function(){
		$current_module = $module;
		$module.find('.focus_first').focus();
	});

}

$(function() {
    $('.collapse-link').on('click', function() {
        var $BOX_PANEL = $(this).closest('.x_panel'),
            $ICON = $(this).find('i'),
            $BOX_CONTENT = $BOX_PANEL.find('.x_content');
        
        if ($BOX_PANEL.attr('style')) {
            $BOX_CONTENT.slideToggle(200, function(){
                $BOX_PANEL.removeAttr('style');
            });
        } else {
            $BOX_CONTENT.slideToggle(200); 
            $BOX_PANEL.css('height', 'auto');  
        }

        $ICON.toggleClass('fa-chevron-up fa-chevron-down');
    });

    $('.close-link').click(function () {
        var $BOX_PANEL = $(this).closest('.x_panel');

        $BOX_PANEL.remove();
    });
});

$(function() {
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });
});

if ($(".progress .progress-bar")[0]) {
    //$('.progress .progress-bar').progressbar();
}

$(function() {
    if ($(".js-switch")[0]) {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, {
                color: '#26B99A'
            });
        });
    }
});

$(function() {
    if ($("input.flat")[0]) {
        $(document).ready(function () {
            $('input.flat').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });
        });
    }
});

$('table input').on('ifChecked', function () {
    checkState = '';
    $(this).parent().parent().parent().addClass('selected');
    countChecked();
});
$('table input').on('ifUnchecked', function () {
    checkState = '';
    $(this).parent().parent().parent().removeClass('selected');
    countChecked();
});

var checkState = '';

$('.bulk_action input').on('ifChecked', function () {
    checkState = '';
    $(this).parent().parent().parent().addClass('selected');
    countChecked();
});
$('.bulk_action input').on('ifUnchecked', function () {
    checkState = '';
    $(this).parent().parent().parent().removeClass('selected');
    countChecked();
});
$('.bulk_action input#check-all').on('ifChecked', function () {
    checkState = 'all';
    countChecked();
});
$('.bulk_action input#check-all').on('ifUnchecked', function () {
    checkState = 'none';
    countChecked();
});

function countChecked() {
    if (checkState === 'all') {
        $(".bulk_action input[name='table_records']").iCheck('check');
    }
    if (checkState === 'none') {
        $(".bulk_action input[name='table_records']").iCheck('uncheck');
    }

    var checkCount = $(".bulk_action input[name='table_records']:checked").length;

    if (checkCount) {
        $('.column-title').hide();
        $('.bulk-actions').show();
        $('.action-cnt').html(checkCount + ' Records Selected');
    } else {
        $('.column-title').show();
        $('.bulk-actions').hide();
    }
}


$(function() {
    $(".expand").on("click", function () {
        $(this).next().slideToggle(200);
        $expand = $(this).find(">:first-child");
        if ($expand.text() == "+") {
            $expand.text("-");
        } else {
            $expand.text("+");
        }
    });
});


var
	$window = $(window),
	$document = $(document);

$document
	.ajaxStart(function() {
		NProgress.start();
	})
	.ajaxStop(function() {
		NProgress.done();
	})
	.on('keydown', function(e){
		ctrl('q', logout, e);
		
	});
	

if (typeof NProgress != 'undefined') {
	$(function(){
		NProgress.start();
	})
    $window.load(function () {
        NProgress.done();
    });
}

$('#logout').click(logout);

$('#user_logout').click(logout);


function logout(){
	$.post('?action=logout', {}, function(response){
		if (response.logout === true) {
			location.reload();
		} else {
			console.log('logout error: ', response);
		}
	}, 'json');
}

function ctrl(key, callback, e){
	
	if ((e.metaKey || e.ctrlKey) && ( String.fromCharCode(e.which).toLowerCase() === key) )
		callback && callback();

}


var dhlawb = new dhl_awb();

//console.log('dhl_awb', dhlawb)


// grab a form
$.fn.grab = function(){

	var data = {}
		dummy_data = [];

	$(this).find('input, textarea').each(function(){

		var $this = $(this),
			val = $this.val(),
			is_dummy = !$this.attr('id');

		if (is_dummy) {

			dummy_data.push(val);

		} else {

			var is_checkbox = $this.is(':checkbox'),
				type = is_checkbox ? 'bool' : $this.data('type'),
				value = is_checkbox ? ( $this.prop('checked') ? 1 : 0 ) : val;
			data[$this.attr('id').split('awb-')[1]] = [type, value];

		}

	});

	return dummy_data[0] ? dummy_data : data;

}

// [].grab()
function grab(containers){

	var data = {};

	$.each(containers, function(){
		data = $.extend(data, $(this).grab());
	});

	return data;

}

// fill in a form
function fill(prefix, data, dummy, callback){

	if (dummy) {

		var
			$target = prefix,
			html = '';

		$.each(data, function(){
			html += '<input ' + dummy + ' value="' + this + '">';
		});
		
		$target.html(html);
		callback && callback();
		
	} else {
		
		$.each(data, function(target, value){
			//console.log('fill target', '#' + prefix + target, value);
			$('#' + prefix + target).val(value);
		})
		
	}
	
}

// generate components
function gen($target, type, data, callback){

	var html = '';

	switch (type) {

		case 'timeline':

			var days = ['Понеделник', 'Вторник', 'Сряда', 'Четвъртък', 'Петък', 'Събота', 'Неделя'];

			html += '<ul class="list-unstyled timeline">';

			$.each(data, function(id, e){

				var
					day = new Date(e.date),
					packs = '';

				$.each(e.pIds, function(){
					packs += '<span class="label label-success">' + this + '</span> ';
				});

				html += '\
					<li class="awb-cp">\
					  <div class="block">\
						<div class="tags">\
							<a class="tag" href="#">' + days[day.getDay()] + '</a>\
						</div>\
						<div class="block_content">\
						  <h2 class="title">' + e.location + '</h2>\
						  <div class="byline" title="' + e.date + '" data-toggle="tooltip" data-placement="right">\
							' + e.time + ' - ' + day.getDate() + '.' + day.getMonth() + '.' + day.getFullYear() + '\
						  </div>\
						  <p class="excerpt"><small>' + e.counter + '</small>.' + e.description + '</p>\
						  <div>' + packs + '</div>\
						</div>\
					  </div>\
					</li>';

			});

			html += '</ul>';

		break;

	}

	$target.html(html);

	callback && callback();

}

// push notification
function notify(title, text, type, styling){

	new PNotify({
		type: type || 'success',
		styling: styling || 'bootstrap3',
		title: title,
		text: text,
		addclass: 'stack-bottomright',
		stack: { 'dir1': 'up', 'dir2': 'left', 'firstpos1': 25, 'firstpos2': 25 }
	});

}

// set status
function status($target, html, addClass, removeClass){

	$target
		.html(html)
		.addClass(addClass)
		.removeClass(removeClass);

}
