//demo file
jQuery(document).ready(function(){
    ezi_autocomplete();
    ezi_tablesorter();
    ezi_tweets();
    ezi_toggle_mode();
    ezi_tooltips();
    ezi_spinner();
    ezi_forms_checkbox_radio();
    ezi_toggle_box();
    ezi_jqueryui();
    ezi_dd_menu();
    ezi_dialogs();
    ezi_show_ctrls();
    ezi_del_rows();
    ezi_lightbox();
    ezi_forms_select();
    ezi_checkAll();
    ezi_browser_dec();
    ezi_equalHeight(jQuery(".tab-2, .tabs-ctrls-veri"));
    ezi_treeview();
    ezi_forms_upload();
    ezi_calendar();
    ezi_sorting();
    if(jQuery("#formID1").length > 0){
        jQuery("#formID1").validationEngine('attach',{
            promptPosition:"centerRight"
        });
    }
    $('.clone').click(function(){
        $(this).parents("form").find('.row:last').clone().css({
            display:'none'
        }).insertBefore(".clone-ctrls").slideDown(400);
    });
});
function ezi_sorting(){
    if(jQuery('#media-type-1').length>0){
        var $container=$('#media-type-1');
        $('#filters a').click(function(){
            var selector=$(this).attr('data-filter');
            $container.isotope({
                filter:selector
            });
            return false;
        });
        $('.filter-by-cat').find('a').click(function(){
            var $this=$(this);
            if(!$this.hasClass('selected')){
                $this.parents('.filter-by-cat').find('.selected').removeClass('selected');
                $this.addClass('selected');
            }
        });
        $(function(){
            $container.isotope({
                itemSelector:'.allmedia'
            });
        });
    }
}
function ezi_calendar(){
    if(jQuery('#calendar').length>0){
        var date=new Date();
        var d=date.getDate();
        var m=date.getMonth();
        var y=date.getFullYear();
        var calendar=$('#calendar').fullCalendar({
            header:{
                left:'prev,next today',
                center:'title',
                right:'month,agendaWeek,agendaDay'
            },
            selectable:true,
            selectHelper:true,
            select:function(start,end,allDay){
                var title=prompt('Event Title:');
                if(title){
                    calendar.fullCalendar('renderEvent',{
                        title:title,
                        start:start,
                        end:end,
                        allDay:allDay
                    },true);
                }
                calendar.fullCalendar('unselect');
            },
            editable:true,
            events:[{
                title:'All Day Event',
                start:new Date(y,m,1)
            },{
                title:'Long Event',
                start:new Date(y,m,d-5),
                end:new Date(y,m,d-2)
            },{
                id:999,
                title:'Repeating Event',
                start:new Date(y,m,d-3,16,0),
                allDay:false
            },{
                id:999,
                title:'Repeating Event',
                start:new Date(y,m,d+4,16,0),
                allDay:false
            },{
                title:'Meeting',
                start:new Date(y,m,d,10,30),
                allDay:false
            },{
                title:'Lunch',
                start:new Date(y,m,d,12,0),
                end:new Date(y,m,d,14,0),
                allDay:false
            },{
                title:'Birthday Party',
                start:new Date(y,m,d+1,19,0),
                end:new Date(y,m,d+1,22,30),
                allDay:false
            },{
                title:'Click for Google',
                start:new Date(y,m,28),
                end:new Date(y,m,29),
                url:'/google.com/'
            }]
        });
    }
}
function ezi_forms_upload(){
    $('input[type=file]').each(function(){
        var uploadbuttonlabeltext=$(this).attr('title');
        if(uploadbuttonlabeltext==''){
            var uploadbuttonlabeltext='Upload';
        }
        var uploadbutton='<input type="button" class="button_button" value="'+uploadbuttonlabeltext+'" />';
        $(this).wrap('<div class="fileinputs"></div>');
        $(this).addClass('file').css('opacity',0);
        $(this).parent().append($('<div class="fakefile" />').append($('<input type="text" />').attr('id',$(this).attr('id')+'__fake')).append(uploadbutton));
        $(this).bind('change',function(){
            $('#'+$(this).attr('id')+'__fake').val($(this).val());;
        });
        $(this).bind('mouseout',function(){
            $('#'+$(this).attr('id')+'__fake').val($(this).val());;
        });
    });
}
function ezi_treeview(){
    $("#browser").treeview();
    $("#tree").treeview({
        collapsed:true,
        animated:"fast",
        control:"#sidetreecontrol",
        prerendered:true,
        persist:"location"
    });
}
function ezi_equalHeight(group){
    tallest=0;
    group.each(function(){
        thisHeight=jQuery(this).height();
        if(thisHeight>tallest){
            tallest=thisHeight;
        }
    });
    group.height(tallest);
}
function ezi_autocomplete(){
    var availableTags=["ActionScript","AppleScript","Asp","BASIC","C","C++","Clojure","COBOL","ColdFusion","Erlang","Fortran","Groovy","Haskell","Java","JavaScript","Lisp","Perl","PHP","Python","Ruby","Scala","Scheme"];
    jQuery("#input-s").autocomplete({
        source:availableTags
    });
}
function ezi_tablesorter(){
    jQuery("#tablesorter-contact").tablesorter({
        headers:{
            0:{
                sorter:false
            },
            6:{
                sorter:false
            }
        }
    });
    jQuery("#tablesorter-tickets").tablesorter({
        headers:{
            0:{
                sorter:false
            }
        }
    });
}
function ezi_tweets(){
    jQuery("#tweets_list").tweet({
        avatar_size:32,
        count:6,
        username:"envatowebdev",
        list:"envato",
        loading_text:"loading tweets...",
        refresh_interval:60
    });
    jQuery("#tweets_user").tweet({
        avatar_size:32,
        count:5,
        username:"MarkDijkstra",
        loading_text:"loading tweets...",
        refresh_interval:60
    });
    jQuery("#tweets_user_2").tweet({
        avatar_size:32,
        count:5,
        username:"wdtuts",
        loading_text:"loading tweets...",
        refresh_interval:60
    });
    jQuery("#tweets_list_2").tweet({
        avatar_size:32,
        count:6,
        username:"@TroyHector",
        list:"design",
        loading_text:"loading tweets...",
        refresh_interval:60
    });
}
function ezi_toggle_mode(){
    jQuery(".simod-page-btn-1").click(function(){
        jQuery(".pages-admod-box-1").delay(200).fadeIn(500);
        jQuery(".pages-head-1").css({
            height:'77px'
        },function(){});
        jQuery(".admod-page-btn-1").removeClass("hide");
        jQuery(".simod-page-btn-1").addClass("hide");
    });
    jQuery(".admod-page-btn-1").click(function(){
        jQuery(".pages-admod-box-1").fadeOut(500,function(){
            jQuery(".pages-head-1").css({
                height:'36px'
            });
        });
        jQuery(".simod-page-btn-1").removeClass("hide");
        jQuery(".admod-page-btn-1").addClass("hide");
    });
}
function ezi_tooltips(){
    jQuery('.tip').tipsy({
        gravity:'s'
    });
}
function ezi_spinner(){
    jQuery(".box-header-ctrls").prepend('<span class="spin" alt=""></span>');
    jQuery(".close, .focus").click(function(){
        jQuery(this).parent(".box-header-ctrls").find("span.spin").fadeIn(400).show(600,function(){
            jQuery("span.spin").fadeOut(350);
        });
    });
}
function ezi_forms_checkbox_radio(){
    jQuery(".cb-enable").click(function(){
        var parent=jQuery(this).parents('.switch');
        jQuery('.cb-disable',parent).removeClass('selected');
        jQuery(this).addClass('selected');
        jQuery('.checkbox',parent).attr('checked',true);
    });
    jQuery(".cb-disable").click(function(){
        var parent=jQuery(this).parents('.switch');
        jQuery('.cb-enable',parent).removeClass('selected');
        jQuery(this).addClass('selected');
        jQuery('.checkbox',parent).attr('checked',false);
    });
}
function ezi_toggle_box(){
    jQuery(".togglecloseall").click(function(){
        jQuery(".box-content, .box-content-25, .box-content-50, .box-content-75").slideUp();
        jQuery(".box-header-ctrls .close").removeClass("close").addClass("open");
    });
    jQuery(".toggleopenall").click(function(){
        jQuery(".box-content, .box-content-25, .box-content-50, .box-content-75").slideDown();
        jQuery(".box-header-ctrls .open").removeClass("open").addClass("close");
    });
    jQuery(".box-header-ctrls .close").click(function(){
        jQuery(this).parents(".box-header, .box-header-25, .box-header-50, .box-header-75").next(".box-content, .box-content-25, .box-content-50, .box-content-75").slideToggle(200);
    });
    jQuery(".box-header-ctrls a.close").click(function(){
        var btnclass=jQuery(this).attr("class");
        if(btnclass=="open"){
            jQuery(this).removeClass("open").addClass("close");
        }else{
            jQuery(this).removeClass("close").addClass("open");
        }
    });
    jQuery("#toggle-menu").click(function(){
        jQuery('#submenu, #newmenu').slideToggle(400);
        var btnclass=jQuery(this).attr("class");
        if(btnclass=="open"){
            jQuery(this).removeClass("open").addClass("close");
        }else{
            jQuery(this).removeClass("close").addClass("open");
        }
    });
}
function ezi_jqueryui(){
    $(".column").sortable({
        connectWith:".column"
    });
    $(".portlet").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all").find(".portlet-header").addClass("ui-widget-header ui-corner-all").prepend("<span class='ui-icon ui-icon-minusthick'></span>").end().find(".portlet-content");
    $(".portlet-header .ui-icon").click(function(){
        $(this).toggleClass("ui-icon-minusthick").toggleClass("ui-icon-plusthick");
        $(this).parents(".portlet:first").find(".portlet-content").toggle();
    });
    $(".column").disableSelection();
    jQuery(".tabs-wrapper-hori").tabs({
        collapsible:false,
        fx:{
            duration:300,
            height:'toggle'
        }
    });
    jQuery("#datepicker, #datepicker2").datepicker({
        showOn:"button",
        buttonImage:"images/style1/calendar.png",
        buttonImageOnly:true,
        buttonText:"choose"
    });
    jQuery("#dialog-message").dialog({
        autoOpen:false,
        bgiframe:true,
        height:160,
        width:500,
        modal:true,
        buttons:{
            Ok:function(){
                jQuery(this).dialog('close');
            }
        }
    });
    jQuery('a.open-dialog-message').click(function(){
        jQuery('#dialog-message').dialog('open');
        return false;
    });
    jQuery("#dialog-confirm").dialog({
        autoOpen:false,
        resizable:false,
        height:154,
        modal:true,
        buttons:{
            'Delete all items':function(){
                jQuery(this).dialog('close');
            },
            Cancel:function(){
                jQuery(this).dialog('close');
            }
        }
    });
    jQuery('a.open-dialog-confirm').click(function(){
        jQuery('#dialog-confirm').dialog('open');
        return false;
    });
    jQuery("#add-contacts-dialog").dialog({
        autoOpen:false,
        bgiframe:false,
        height:321,
        width:400,
        modal:true,
        resizable:false
    });
    jQuery('#open-contacts-dialog-btn, #open-contacts-dialog-btn-tb').click(function(){
        jQuery('#add-contacts-dialog').dialog('open');
        return false;
    });
    jQuery("#add-comments-dialog").dialog({
        autoOpen:false,
        bgiframe:true,
        height:398,
        width:400,
        modal:true,
        resizable:false
    });
    jQuery('#open-comments-dialog-btn').click(function(){
        jQuery('#add-comments-dialog').dialog('open');
        return false;
    });
    jQuery("#add-tickets-dialog").dialog({
        autoOpen:false,
        bgiframe:true,
        height:463,
        width:400,
        modal:true,
        resizable:false
    });
    jQuery('#open-ticket-dialog-btn, #open-ticket-dialog-btn-tb').click(function(){
        jQuery('#add-tickets-dialog').dialog('open');
        return false;
    });
    jQuery('.close-dialog').click(function(){
        jQuery('.ui-dialog-content').dialog('close');
        return false;
    });
    jQuery(".progressbar-1").progressbar({
        value:0
    });
    jQuery(".progressbar-2").progressbar({
        value:0
    });
    jQuery(".progressbar-3").progressbar({
        value:0
    });
    jQuery(".progressbar-4").progressbar({
        value:0
    });
    jQuery(".progressbar-1 .ui-progressbar-value").animate({
        width:'50%'
    },2000);
    jQuery(".progressbar-2 .ui-progressbar-value").animate({
        width:'75%'
    },2000);
    jQuery(".progressbar-3 .ui-progressbar-value").animate({
        width:'90%'
    },2000);
    jQuery(".progressbar-4 .ui-progressbar-value").animate({
        width:'40%'
    },2000);
    jQuery(".ui-slider-1").slider({
        value:37,
        min:1,
        max:700,
        animate:false,
        slide:function(event,ui){
            jQuery("#amount").val('$'+ui.value);
        }
    });
    jQuery("#amount").val('$'+jQuery(".ui-slider-1").slider("value"));
    jQuery("#accordion").accordion();
}
function ezi_dd_menu(){
    jQuery("ul#menu li").hover(function(){
        jQuery(this).find('ul:first').css({
            visibility:"visible",
            display:"none"
        }).show(10);
    },function(){
        jQuery('ul:first',this).hide(0,function(){
            jQuery('ul:first',this).css('visibility','hidden');
        });
    });
    jQuery(".second").hover(function(){
        jQuery(this).parent("li").find("a").addClass("activeli");
    },function(){
        jQuery(this).parent("li").find("a").removeClass("activeli");
    });
    jQuery(".second").parent("li").find("a:first").append('<span/>');
    jQuery("#menu li a").hover(function(){
        jQuery(this).find("span").show();
    },function(){
        jQuery(this).find("span").hide();
    });
    jQuery("#menu li ul").hover(function(){
        jQuery(this).prev("a").find("span").show();
    },function(){
        jQuery(this).prev("a").find("span").hide();
    });
}
function ezi_dialogs(){
    jQuery(".delx-box").click(function(){
        jQuery(this).parent("div").fadeTo("fast",0.0).slideUp(400);
    },function(){
        jQuery(this).parent("div").remove();
    });
    jQuery(".dialog-box-succes-big, .dialog-box-warning-big, .dialog-box-error-big, .dialog-box-info-big, .dialog-box-msg-big, .dialog-box-succes-small, .dialog-box-warning-small, .dialog-box-error-small, .dialog-box-info-small, .dialog-box-msg-small").click(function(){
        jQuery(this).fadeTo("fast",0.0).slideUp(400);
    },function(){
        jQuery(this).remove();
    });
    jQuery(".dialog-box-succes-big, .dialog-box-warning-big, .dialog-box-error-big, .dialog-box-info-big, .dialog-box-msg-big, .dialog-box-succes-small, .dialog-box-warning-small, .dialog-box-error-small, .dialog-box-info-small, .dialog-box-msg-small").hover(function(){
        jQuery(this).children(".delx").show();
    },function(){
        jQuery(this).children(".delx").hide();
    });
}
function ezi_show_ctrls(){
    jQuery("ul#media-type-1 li").hover(function(){
        jQuery(this).find("span").show(10);
    },function(){
        jQuery(this).find("span").hide(10);
    });
}
function ezi_del_rows(){
    jQuery(".delete-contact").click(function(){
        jQuery(this).parents("li, tr").fadeTo("fast",0.0).slideUp(400);
    },function(){
        jQuery(this).parents("li, tr").remove();
    });
    jQuery("a.delete-media").click(function(){
        jQuery(this).parents("li").addClass("media-delete").fadeOut("slow",function(){
            jQuery(this).parents("li").remove();
        });
    });
    jQuery(".delete-comments").click(function(){
        jQuery(this).parents("li").fadeTo("fast",0.0).slideUp(400);
    },function(){
        jQuery(this).parents("li").remove();
    });
}
function ezi_lightbox(){
    jQuery().piroBox({
        my_speed:300,
        bg_alpha:0.3,
        slideShow:true,
        slideSpeed:4,
        close_all:'.piro_close, .piro_overlay'
    });
}
function ezi_scroll_top(){
    jQuery('#top').click(function(){
        jQuery('html, body').animate({
            scrollTop:0
        },'slow');
    });
}
function ezi_forms_select(){
    jQuery(".select-1, .select-2, .search-select").select_skin();
}
function ezi_checkAll(){
    jQuery('.toggle-all-cbox').click(function(){
        jQuery(this).parents('.box-content').find('input:checkbox').attr('checked',jQuery(this).attr('checked'));
    });
}
function ezi_browser_dec(){
    if(jQuery.browser.webkit){
        jQuery('input.inbox-sf-search-btn, input.inbox-sf-add-btn').css({
            'padding-top':'2px'
        });
        jQuery('div.bulk-actions input').css({
            'padding-top':'4px'
        });
        jQuery('div.box-content ul.tabs-ctrls-hori li a').css({
            'padding-top':'11px'
        });
    }
    if(jQuery.browser.opera){
        jQuery('div.box-content ul.tabs-ctrls-hori li a').css({
            'padding-top':'11px'
        });
    }
}
if(jQuery('#editor').length>0){
    new TINY.editor.edit('editor',{
        id:'editor',
        width:976,
        height:175,
        cssclass:'te',
        controlclass:'tecontrol',
        rowclass:'teheader',
        dividerclass:'tedivider',
        controls:['bold','italic','underline','strikethrough','|','subscript','superscript','|','orderedlist','unorderedlist','|','outdent','indent','|','leftalign','centeralign','rightalign','blockjustify','|','unformat','|','undo','redo','n','font','size','style','|','image','hr','link','unlink','|','cut','copy','paste','print'],
        footer:true,
        fonts:['Verdana','Arial','Georgia','Trebuchet MS'],
        xhtml:true,
        cssfile:'editor.css',
        bodyid:'editor',
        footerclass:'tefooter',
        toggle:{
            text:'source',
            activetext:'wysiwyg',
            cssclass:'toggle'
        },
        resize:{
            cssclass:'resize'
        }
    });
}
if(jQuery('#editor2').length>0){
    new TINY.editor.edit('editor2',{
        id:'editor2',
        width:696,
        height:223,
        cssclass:'te',
        controlclass:'tecontrol',
        rowclass:'teheader',
        dividerclass:'tedivider',
        controls:['bold','italic','underline','strikethrough','|','subscript','superscript','|','orderedlist','unorderedlist','|','outdent','indent','|','leftalign','centeralign','rightalign','blockjustify','|','unformat','|','undo','redo','n','font','size','style','|','image','hr','link','unlink','|','cut','copy','paste','print'],
        footer:true,
        fonts:['Verdana','Arial','Georgia','Trebuchet MS'],
        xhtml:true,
        cssfile:'editor.css',
        bodyid:'editor',
        footerclass:'tefooter',
        toggle:{
            text:'source',
            activetext:'wysiwyg',
            cssclass:'toggle'
        },
        resize:{
            cssclass:'resize'
        }
    });
}
/**
 * 通过url删除
 */
function deleteByUrl(aObj){
    if(window.confirm('您确定要删除吗？')){
        var url = $(aObj).attr('durl');
        $.post(url, {}, function(data){
            var pid = $(aObj).parent().parent().parent().parent().parent().attr('id');
            if($('#'+pid)){
                $.fn.yiiGridView.update(pid);
            }
        });
    }
}
/**
 * cobolox 获取代码
 */

function getid(aObj){
    var url = $(aObj).attr('surl');
    $('.boxgold').colorbox({
        inline:true,
        width:'600px',
        height:'150px',
        opacity: 0.2,
        onOpen:function(){
            $("#goldinput").val(url);
        },
        onClosed:function(){
            $("#goldinput").val(" ");
        }
    });

}


//encode seo url;
function clearString(s){ 
    var pattern = new RegExp("[^0-9a-zA-Z]", "g") 
    var str = s.replace(pattern, '-');
    str = str.replace(/(^-+)|(-+$)/g,"");
    str = str.replace(/-+/g,"-");
    return str.toLowerCase();
}

/**
 * 弹出加载窗口
 * @param popupName
 */
function popup(popupName) {
    var _scrollHeight = $(document).scrollTop(), //获取当前窗口距离页面顶部高度
        _windowHeight = $(window).height(), //获取当前窗口高度
        _windowWidth = $(window).width(), //获取当前窗口宽度
        _popupHeight = popupName.height(), //获取弹出层高度
        _popupWeight = popupName.width();//获取弹出层宽度
    _posiTop = (_windowHeight - _popupHeight) / 2 + _scrollHeight;
    _posiLeft = (_windowWidth - _popupWeight) / 2;
    popupName.css({"left": _posiLeft + "px", "top": _posiTop + "px", "display": "block"});//设置position
}
