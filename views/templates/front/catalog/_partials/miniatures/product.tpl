<article class="js-product-miniature item_in" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
	<div class="img_block">
		{block name='product_thumbnail'}
		  <a href="{$product.url}" class="thumbnail product-thumbnail">
			<img
			  src = "{$product.cover.bySize.home_default.url}"
			  alt = "{$product.cover.legend}"
			  data-full-size-image-url = "{$product.cover.large.url}"
			>
			   {hook h="rotatorImg" product=$product}
		  </a>
		{/block}
		{block name='product_variants'}
			{if $product.main_variants}
				{include file='catalog/_partials/variant-links.tpl' variants=$product.main_variants}
			{/if}
		{/block}

		{block name='product_flags'}
		  <ul class="product-flag">
			{foreach from=$product.flags item=flag}
				{if $flag.type == "discount"}
					{continue}
				{/if}
				<li class="{$flag.type}"><span>{$flag.label}</span></li>
			{/foreach}
		  </ul>
		{/block}
		<div class="block-inner">
			<ul class="add-to-links">
				<li class="cart">
					{include file='catalog/_partials/customize/button-cart.tpl' product=$product}
				</li>
				<li>
					<a href="#" class="quick-view" data-link-action="quickview" title="{l s='Quick view' d='Shop.Theme.Actions'}"><span>{l s='Quick view' d='Shop.Theme.Actions'}</span></a></li>
				<li>
					<a href="{$product.url}" class="links-details" title="{l s='Details' d='Shop.Theme.Actions'}">
					<span>{l s='Details' d='Shop.Theme.Actions'}</span></a>
				</li>
			</ul>
		</div>
	</div>
    <div class="product_desc">
		<div class="hook-reviews">
			{hook h='displayProductListReviews' product=$product}
		</div>	
      {block name='product_name'}
       <h3><a href="{$product.url}" title="{$product.name}" itemprop="name" class="product_name">{$product.name}</a></h3>
      {/block}
      {block name='product_price_and_shipping'}
        {if $product.show_price}
          <div class="product-price-and-shipping">
            {if $product.has_discount}
              {hook h='displayProductPriceBlock' product=$product type="old_price"}

              <span class="regular-price">{$product.regular_price}</span>
              {if $product.discount_type === 'percentage'}
                <span class="discount-percentage">{$product.discount_percentage}</span>
              {/if}
            {/if}

            {hook h='displayProductPriceBlock' product=$product type="before_price"}

            <span itemprop="price" class="price {if $product.has_discount} price_sale{/if}">{$product.price}</span>

            {hook h='displayProductPriceBlock' product=$product type='unit_price'}

            {hook h='displayProductPriceBlock' product=$product type='weight'}
          </div>
        {/if}
      {/block}
	  {block name='product_reviews'}
	 	
      {/block}


    </div>
</article>


<script>
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
		$(".plist_attribute_images").owlCarousel({
			items :3,
			itemsDesktop : [1199,3],
			itemsDesktopSmall : [991,3],
			itemsTablet: [767,2],
			itemsMobile : [480,2],
			autoPlay : false ,
			speed: '500',
			stopOnHover: true,
			addClassActive: true,
			scrollPerPage: false,
			navigation : true,
			pagination : false,
		});
	});

</script>
