

$(function(){

    //region 首页分类导航
    $(".category_list>li").hover(function(){
        if($(this).hasClass("current")){
            return;
        }
        $(".category_list>li.current").removeClass("current");
        $(this).addClass("current");
        var height = $(this).height();
        var contentHeight = $('.sub_category_list',this).height();
        $('.sub_category_list',this).css('bottom',height-contentHeight);
    });
    $(".category_list").mouseleave(function(){
        $(".category_list>li.current").removeClass("current");
    }).each(function(){
        $(this).append("<li class='bottom'></li>");
    });
    $(".category_list ul").each(function(){
        $(this).append("<li class='bottom'></li>");
    });
    //endregion

    //控制公告的显示
    $('.announce_overflow').each(function(){
        var maxwidth = 11;
        if($(this).text().length>maxwidth)
        {
            $(this).text($(this).text().substring(0,maxwidth));
            $(this).html($(this).html()+'...');
        }
    });
    
    //region 首页推荐幻灯片
    $(".recommend").iView({
        controlNav: true,
        directionNav: false,
        pauseOnHover: true
    });
    //endregion

    //region 首页套餐推荐

    var comboTabs = $(".set_meal .labels ul li");
    function setCurrentSetMealContent(tabObj){
        if(!tabObj) return;
        var index = $(".set_meal .labels ul li").index(tabObj);
        var content = $($(".set_meal .contents>ul>li").get(index));
        if(content.hasClass("current"))return;
        $(".set_meal .contents>ul>li.current").removeClass("current").removeClass("new_box");
        content.addClass("current").addClass("new_box");
    }

    function setCurrentSetMealTab(obj){
        if($(obj).hasClass("current")) return;
        $(".set_meal .labels ul li.current").removeClass("current");
        $(obj).addClass("current");
        setCurrentSetMealContent(obj)
    }
    comboTabs.hover(function(){
        setCurrentSetMealTab(this);
    }).each(function(){
        $(this).append($("<div class='triangle_container'><div class='triangle_up'></div></div>"));
    });


    setCurrentSetMealTab(comboTabs[0]);


    $('.set_meal_list li ul').each(function(){
        var wrapper = wrapMealList(this);
        var prev = createPrevForMealList(wrapper);
        var next = createNextForMealList(wrapper);
        clearFloat(wrapper);
        $(this).carouFredSel({
             prev : prev
             ,next: next
            ,width:null
            ,height:174
            ,cookie : true
            ,scroll : {
                pauseOnHover : true
                ,duration : 1500
            }
            ,items : 4
        });
    });

    //endregion
});

function wrapMealList(MealList){
    var wrapper = $('<div class="meal_list"><div class="container"></div></div>');
    var parent = $(MealList).parent();
    $(MealList).remove();
    $('.container',wrapper).append(MealList);
    parent.append(wrapper);
    return wrapper;

}
function clearFloat(target){
    $(target).append('<div class="clear"></div>');
}
function createPrevForMealList(MealList){
    var prev = $('<div class="arrow left"><div class="left_arrow"></div></div>');
    $(MealList).prepend(prev);
    return prev;
}

function createNextForMealList(MealList){
    var next = $('<div class="arrow right"><div class="right_arrow"></div></div>');
    $(MealList).append(next);
    return next;
}
