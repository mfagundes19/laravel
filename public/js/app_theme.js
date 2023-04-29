(function (JQuery) {
	"use strict";

	var treeviewMenu = $('.app-menu');

	// Toggle Sidebar
	$('[data-toggle="sidebar"]').click(function(event) {
		event.preventDefault();
		$('.app').toggleClass('sidenav-toggled');
	});

	// Activate sidebar treeview toggle
	$("[data-toggle='treeview']").click(function(event) {
		event.preventDefault();
		if(!$(this).parent().hasClass('is-expanded')) {
			treeviewMenu.find("[data-toggle='treeview']").parent().removeClass('is-expanded');
		}
		$(this).parent().toggleClass('is-expanded');
	});

	// Set initial active toggle
	$("[data-toggle='treeview.'].is-expanded").parent().toggleClass('is-expanded');

	//Activate bootstrip tooltips
	$('[data-toggle="tooltip"]').tooltip({
      trigger : 'click hover focus',
      container: 'body',
      boundary: 'window'
  });

	$('#btn-research').on('click',function(){
		if($('#box-research').css('display') == 'none') 
		{
			$('#box-research').show();
		}
		else
		{
			$('#box-research').hide();
		}
		
    });
    
    $('#sidebar-menu a').on('click', function(e){
        if(localStorage.getItem($(this).attr('data-menu-id')) == 'true')
        {
            localStorage.setItem($(this).attr('data-menu-id'), false);    
        } 
        else
        {
            localStorage.setItem($(this).attr('data-menu-id'), true);
        }
    });


    for (var i = 0; i < localStorage.length; i++) {
        var menu_item = localStorage.key(i);
        //if(menu_item.match(/menu-id/)){
        if((localStorage.key(i) !== undefined) && (localStorage.key(i).match(/menu-id/)) )
        {
            if(localStorage.getItem(localStorage.key(i)) == 'true') {
                $('#'+localStorage.key(i)).parent().addClass('menu-open');
            }
            else
            {                
                $('#'+localStorage.key(i)).parent().removeClass('menu-open');
            }
        }
    }

    var $sidebar   = $('.control-sidebar')
    var $container = $('<div />', {
      class: 'p-3 control-sidebar-content'
    });
    $sidebar.append($container)
    $container.append(
      '<h5>Custumização</h5><hr class="mb-2"/>'
    )
    
    var $text_sm_body_checkbox = $('<input />', {
      type   : 'checkbox',
      value  : 1,
      checked: $('body').hasClass('text-sm'),
      id : 'text_sm_body_checkbox',
      'class': 'mr-1'
    }).on('click', function () {
      if ($(this).is(':checked')) {
        $('body').addClass('text-sm');
        localStorage.setItem('text_sm_body_checkbox', '1');
      } else {
        $('body').removeClass('text-sm');
        localStorage.setItem('text_sm_body_checkbox', '0');
      }
    })
    var $text_sm_body_container = $('<div />', {'class': 'mb-1'}).append($text_sm_body_checkbox).append('<span>Conteúdo - Fonte Menor</span>')
    $container.append($text_sm_body_container)
    if(localStorage.getItem('text_sm_body_checkbox') == 1)
    {
        $( "#text_sm_body_checkbox" ).trigger( "click" );
    }

    var $text_sm_header_checkbox = $('<input />', {
      type   : 'checkbox',
      value  : 1,
      checked: $('.main-header').hasClass('text-sm'),
      'class': 'mr-1',
      id : 'text_sm_header_checkbox'
    }).on('click', function () {
      if ($(this).is(':checked')) {
        $('.main-header').addClass('text-sm');
        localStorage.setItem('text_sm_header_checkbox', '1');
      } else {
        $('.main-header').removeClass('text-sm');
        localStorage.setItem('text_sm_header_checkbox', '0');
      }
    })
    var $text_sm_header_container = $('<div />', {'class': 'mb-1'}).append($text_sm_header_checkbox).append('<span>Barra Topo - Fonte Menor</span>')
    $container.append($text_sm_header_container)
    if(localStorage.getItem('text_sm_header_checkbox') == 1)
    {
        $( "#text_sm_header_checkbox" ).trigger( "click" );
    }

    var $text_sm_sidebar_checkbox = $('<input />', {
      type   : 'checkbox',
      value  : 1,
      checked: $('.nav-sidebar').hasClass('text-sm'),
      'class': 'mr-1',
      id : 'text_sm_sidebar_checkbox'
    }).on('click', function () {
      if ($(this).is(':checked')) {
        $('.nav-sidebar').addClass('text-sm');
        localStorage.setItem('text_sm_sidebar_checkbox', '1');
      } else {
        $('.nav-sidebar').removeClass('text-sm');
        localStorage.setItem('text_sm_sidebar_checkbox', '0');
      }
    })
    var $text_sm_sidebar_container = $('<div />', {'class': 'mb-1'}).append($text_sm_sidebar_checkbox).append('<span>Menu - Fonte Menor</span>')
    $container.append($text_sm_sidebar_container)
    if(localStorage.getItem('text_sm_sidebar_checkbox') == 1)
    {
        $("#text_sm_sidebar_checkbox").trigger("click");
    }
  
    var $legacy_sidebar_checkbox = $('<input />', {
      type   : 'checkbox',
      value  : 1,
      checked: $('.nav-sidebar').hasClass('nav-legacy'),
      'class': 'mr-1',
      id : 'legacy_sidebar_checkbox'
    }).on('click', function () {
      if ($(this).is(':checked')) {
        $('.nav-sidebar').addClass('nav-legacy');
        localStorage.setItem('legacy_sidebar_checkbox', '1');
      } else {
        $('.nav-sidebar').removeClass('nav-legacy');
        localStorage.setItem('legacy_sidebar_checkbox', '0');
      }
    })
    var $legacy_sidebar_container = $('<div />', {'class': 'mb-1'}).append($legacy_sidebar_checkbox).append('<span>Menu Estilo Legado</span>')
    $container.append($legacy_sidebar_container)
    if(localStorage.getItem('legacy_sidebar_checkbox') == 1)
    {
        $("#legacy_sidebar_checkbox").trigger("click");
    }

    var $child_indent_sidebar_checkbox = $('<input />', {
      type   : 'checkbox',
      value  : 1,
      checked: $('.nav-sidebar').hasClass('nav-child-indent'),
      'class': 'mr-1',
      id : 'child_indent_sidebar_checkbox'
    }).on('click', function () {
      if ($(this).is(':checked')) {
        $('.nav-sidebar').addClass('nav-child-indent');
        localStorage.setItem('child_indent_sidebar_checkbox', '1');
      } else {
        $('.nav-sidebar').removeClass('nav-child-indent');
        localStorage.setItem('child_indent_sidebar_checkbox', '0');
      }
    })
    var $child_indent_sidebar_container = $('<div />', {'class': 'mb-1'}).append($child_indent_sidebar_checkbox).append('<span>Menu Recuo Secundário</span>')
    $container.append($child_indent_sidebar_container)
    if(localStorage.getItem('child_indent_sidebar_checkbox') == 1)
    {
        $("#child_indent_sidebar_checkbox").trigger("click");
    }

    var $text_sm_brand_checkbox = $('<input />', {
      type   : 'checkbox',
      value  : 1,
      checked: $('.brand-link').hasClass('text-sm'),
      'class': 'mr-1',
      id : 'text_sm_brand_checkbox'
    }).on('click', function () {
      if ($(this).is(':checked')) {
        $('.brand-link').addClass('text-sm');
        localStorage.setItem('text_sm_brand_checkbox', '1');
      } else {
        $('.brand-link').removeClass('text-sm');
        localStorage.setItem('text_sm_brand_checkbox', '0');
      }
    })
    var $text_sm_brand_container = $('<div />', {'class': 'mb-4'}).append($text_sm_brand_checkbox).append('<span>Logo Menor</span>')
    $container.append($text_sm_brand_container);
    if(localStorage.getItem('text_sm_brand_checkbox') == 1)
    {
        $("#text_sm_brand_checkbox").trigger("click");
    }
})();
