/**
* 2007-2019 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2019 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/

$(document).ready(function(){
    if (typeof plp_replacement !== 'undefined') {
        var plp_replacement_parsed = JSON.parse(plp_replacement);

        $('.color_pick').each(function(element,i){
            if (typeof plp_replacement_parsed[$(this).attr('id')] !== 'undefined')
            {
                $(this).attr('style', 'width: '+plp_r_width+'px!important; height:'+plp_r_height+'px!important');
                $(this).append('<img src="'+plp_replacement_parsed[$(this).attr('id')]+'"/>');
                $(this).find('img').attr('style', 'width: '+plp_r_width+'px!important; height:'+plp_r_height+'px!important');
                $(this).closest('li').attr('style', 'width: '+(plp_r_width+4)+'px!important; height:'+(plp_r_height+4)+'px!important');
            }
        });
    }
//
//    $('.imagevariant').hover(function(){
//      var src = $(this).attr('src');
//      $(this).parents('.img_block .product-thumbnail img').attr('src', src);
//
//    }, function(){
//      var bigImg = $(this).parents('.img_block .product-thumbnail img'),
//             src = bigImg.data('full-size-image-url');
//      bigImg.attr('src', src);
//
//    });

    $('.imagevariant').mouseenter(function(){
        var src = $(this).attr('src');
        $(this).parents('.thumbnail-container').find('.product-thumbnail img').attr('src', src);
    });

    $('.imagevariant').mouseleave(function(){
        var bigImg = $(this).parents('.thumbnail-container').find('.product-thumbnail img'),
            src = bigImg.data('full-size-image-url');
        bigImg.attr('src', src);
    });
    $(".variant-links").owlCarousel({
        items :4,
        itemsDesktop : [1199,4],
        itemsDesktopSmall : [991,4],
        itemsTablet: [767,4],
        itemsMobile : [480,4],
        autoPlay : false ,
        speed: '500',
        stopOnHover: true,
        addClassActive: true,
        scrollPerPage: false,
        navigation : true,
        pagination : false,
    });
});

