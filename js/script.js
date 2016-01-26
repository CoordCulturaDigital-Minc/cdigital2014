jQuery( function($){

     /* ----------------------------------------------------------------------------
    *     Carrosel dos principais blogs / página inicial
    *  ---------------------------------------------------------------------------*/
    // store the slider in a local variable
    // var $window = jQuery(window),
    // flexslider;

      // store the slider in a local variable
      var $window = $(window),
          flexslider = { vars:{} };

     // $(function() {
     //    SyntaxHighlighter.all();
     //  });     

    // tiny helper function to add breakpoints
    function getGridSize() {
      return (window.innerWidth < 600) ? 1 :
       (window.innerWidth < 1150) ? 2 : 3;
    }

    // function getGridMobile() {
    //   return (window.innerWidth < 440) ? 4 :
    //    (window.innerWidth < 767) ? 7 : 10;
    // }

    $window.load(function() {
        jQuery('#principais-blogs .carousel-blogs')
          .flexslider({
            animation: "slide",
            animationLoop: false,
            itemWidth: 340.33,
            useCSS: false,
            minItems: getGridSize(),
            maxItems: getGridSize(),
            touch: true,
            controlNav: false,
            controlsContainer: ".navigation",
            // manualControls: ".pagination div", 
            namespace: ""
            
        });

        var tam = jQuery(window).width();

        if( tam < 767 ) {

            jQuery('.bp-user #item-nav .item-list-tabs')
              .flexslider({
                animation: "slide",
                selector: 'ul > li',
                itemWidth: 88,
                useCSS: false,
                minItems: 4,
                maxItems: 9,
                touch: true,
                controlNav: false,
                controlsContainer: ".navigation",
                // manualControls: ".pagination div", 
                namespace: ""
                
            });
        }
    });

    // check grid size on resize event
    $window.resize(function() {
        var gridSize = getGridSize();

        flexslider.vars.minItems = gridSize;
        flexslider.vars.maxItems = gridSize;
    });

    // corrige a altura para melhor visualização das mensagens
    jQuery(".bp-user #buddypress #item-body").css( "margin-top", jQuery("#item-header .messages #message").height()/1.5 );


    /* ----------------------------------------------------------------------------
    *    Fixar o topo quando rolar a página
    *  ---------------------------------------------------------------------------*/
    jQuery(window).scroll(function() {

        var scrollTop = jQuery(window).scrollTop();
       
        if (scrollTop > 45) {
            jQuery('body').addClass('header-fixed');
        } else {
            jQuery('body').removeClass('header-fixed');
        }
    
    });

    /* ----------------------------------------------------------------------------------------
    *   Altera algumas classes css 
    *  ---------------------------------------------------------------------------------------*/

    // Insere em todas as páginas do portal

    // Todos os menus
    jQuery('.menu-item').addClass('item');

    // menu topo
    jQuery('.menu-topo li').addClass('item');
    jQuery('.menu-topo li:has( ul )' ).addClass( 'ui dropdown item' );
    jQuery('.menu-topo li ul').addClass('menu')

    // Como não foi possível alterar o nome Perfil para Privacidade no arquivo de tradução fiz esse hack
    jQuery('#subnav a#profile').html('Privacidade');
    
    // No perfil do usuário, insere os elementos da div #item-nav na div #item-header
    // jQuery('#buddypress #item-header').append(jQuery("#buddypress #item-nav"));

    // jQuery('#buddypress-content .post-head').append(jQuery("#buddypress #item-buttons"));

    // Wordpress menu-header
    jQuery('.menu-header .menu-item-has-children').addClass('ui dropdown');
    jQuery('.menu-header .sub-menu').addClass('menu'); 


    /* ----------------------------------------------------------------------------
    *    popup
    *  ---------------------------------------------------------------------------*/     
    var 

    $botoes = jQuery('#item-buttons .generic-button a');

    $botoes
      .popup({
        on: 'hover',
        distanceAway : 10,
        position : 'top right'
        // dataOffset: 50,
      })
    ;

    /* ----------------------------------------------------------------------------
    *    Sidebar suspenso esquerdo e direito
    *  ---------------------------------------------------------------------------*/

    jQuery('.hide.item')
    .on('click', function() {
      jQuery('.sidebar')
        .removeClass('active')
      ; 
     })
    ;

    jQuery('.bt-sidebar-left')
    .on('click', function() {
      jQuery('#sidebar-mobile-left')
        .toggleClass('active')
      ;  
    })
    ;

    jQuery('.bt-sidebar-right')
    .on('click', function() {
      jQuery('#sidebar-mobile-right')
        .toggleClass('active')
      ;  
    });


    /* ----------------------------------------------------------------------------
    *    Menus do site click
    *  ---------------------------------------------------------------------------*/
    //  menu sidebar
    jQuery( 'ul.menu li:has( ul )' ).addClass( "colapsed" ).find('ul').hide();

    jQuery( 'ul.menu li a:not(:only-child )' ).click( function () {
    
        jQuery( this ).parent().parent().find('li:has( ul )').removeClass('expanded').addClass('colapsed').find('ul').slideUp('fast');
        
        jQuery( this ).next().not(':visible').slideToggle('fast', function(){
            jQuery( this ).parent().toggleClass('colapsed').toggleClass('expanded');
        });

        return false;

    } );

      // fechar ao clicar fora da área
    jQuery(document).click(function(event) { 
         // login
        if(!jQuery(event.target).closest('.menu').length )
            jQuery('ul.menu li ul').hide();

    });  

     /* ----------------------------------------------------------------------------
    *    Menus do site efeito hover
    *  ---------------------------------------------------------------------------*/

    jQuery( 'ul.menu.hover li a:not(:only-child )' ).parent().hover(
        function() { jQuery( this ).children( 'ul' ).show(100, 'swing'); },
        function() { jQuery( this ).children( 'ul' ).hide('fast'); }
    );

      
   

    /* ----------------------------------------------------------------------------
    *    Insere a classe loading quando clica em um botão submit
    *  ---------------------------------------------------------------------------*/
    jQuery('form :submit')
      .on('click', function() {
        jQuery(this).addClass("loading");
    });

    /* ----------------------------------------------------------------------------
    *    show hide loginform
    *  ---------------------------------------------------------------------------*/
    jQuery( '#loginform ' )
      .hide();

    jQuery( '.loginout .login a' ).click( function() {
        jQuery( '#loginform' ).fadeToggle('fast');
        return false;
    });

    /* ----------------------------------------------------------------------------
    *     Tabs / Sidebar
    *  ---------------------------------------------------------------------------*/

     // Widgets in tabs
    jQuery('div.tabs').each(function()
    {
        if(jQuery(this).children().hasClass('widget'))
        jQuery('<ul class="tabs"></ul>').prependTo(jQuery(this));
    });

    jQuery('div.tabs div.widget h2.widget-title').each(function(a)
    {
        jQuery('<li class="' + a + '"></li>').appendTo(jQuery(this).parents('div.tabs').find('ul.tabs'));
        jQuery('<a href="#' + jQuery(this).parent().attr('id') + '">' + jQuery(this).text() + '</a>').appendTo(jQuery(this).parents('div.tabs').find('ul.tabs li.'+a));
        jQuery(this).remove();
    });

    jQuery('div.tabs').tabs();

      /* ----------------------------------------------------------------------------
    *    // form search
    *  ---------------------------------------------------------------------------*/
    jQuery('#search-terms')
        .on('click', function() {
        jQuery('.search').addClass("active");
        jQuery('#new_activity').hide();
    });

    /* ----------------------------------------------------------------------------
    *    // form de atividades no topo
    *  ---------------------------------------------------------------------------*/
    jQuery('.nav-top #new_activity a.bt_new_activity')
     .on('click', function() {

        jQuery( "#whats-new-form" ).fadeToggle();

        return false;
    });

    /* ----------------------------------------------------------------------------
    *    // remove propagandas na busca
    *  ---------------------------------------------------------------------------*/
    jQuery("#adBlock").remove();

    jQuery("#principais-blogs").show();

});

// fechar ao clicar fora da área
jQuery(document).click(function(event) { 

    // Campo de busca no topo
    if(!jQuery(event.target).closest('.search').length) {
        if(jQuery('.search').is(":visible")) {
            jQuery('.search').removeClass('active');
            jQuery('#new_activity').show();
        }
    } 

    // barra lateral direta
    if(!jQuery(event.target).closest('.bt-sidebar-right,#sidebar-mobile-right').length) {
        if(jQuery('#sidebar-mobile-right').hasClass("active")) {
            jQuery('#sidebar-mobile-right').removeClass('active');
        }
    } 

     // barra lateral esquerda
    if(!jQuery(event.target).closest('.bt-sidebar-left,#sidebar-mobile-left').length) {
        if(jQuery('#sidebar-mobile-left').hasClass("active")) {
            jQuery('#sidebar-mobile-left').removeClass('active');
        }
    }

    // form  de atividades no topo
    if(!jQuery(event.target).closest('#new_activity .bt_new_activity, #new_activity #whats-new-form').length) {
        if(jQuery('#new_activity #whats-new-form').is(":visible")) {
            jQuery('#new_activity #whats-new-form').hide();
        }
    }

    // login
    if(!jQuery(event.target).closest('#loginform, .login').length )
        jQuery('#loginform ').hide();



});

   
