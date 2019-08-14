<?php
/**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */



class Product extends ProductCore
{

    public static function getAttributesColorList(array $products, $have_stock = true)
    {
        if (!count($products)) {
            return array();
        }

        $id_lang = Context::getContext()->language->id;

        $check_stock = !Configuration::get('PS_DISP_UNAVAILABLE_ATTR');

        if (!$res = Db::getInstance()->executeS('
SELECT pa.`id_product`, a.`color`,im.`id_image`, pac.`id_product_attribute`, '.($check_stock ? 'SUM(IF(stock.`quantity` > 0, 1, 0))' : '0').' qty, a.`id_attribute`, al.`name`, IF(color = "", a.id_attribute, color) group_by
FROM `'._DB_PREFIX_.'product_attribute` pa
'.Shop::addSqlAssociation('product_attribute', 'pa').
            ($check_stock ? Product::sqlStock('pa', 'pa') : '').'
JOIN `'._DB_PREFIX_.'product_attribute_combination` pac ON (pac.`id_product_attribute` = product_attribute_shop.`id_product_attribute`)

JOIN `'._DB_PREFIX_.'attribute` a ON (a.`id_attribute` = pac.`id_attribute`)
JOIN `'._DB_PREFIX_.'attribute_lang` al ON (a.`id_attribute` = al.`id_attribute` AND al.`id_lang` = '.(int)$id_lang.')
JOIN `'._DB_PREFIX_.'attribute_group` ag ON (a.id_attribute_group = ag.`id_attribute_group`)
LEFT JOIN `'._DB_PREFIX_.'product_attribute_image` im ON (im.id_product_attribute = pac.`id_product_attribute`)
WHERE pa.`id_product` IN ('.implode(array_map('intval', $products), ',').') AND ag.`is_color_group` = 1
GROUP BY pa.`id_product`, a.`id_attribute`, `group_by`
'.($check_stock ? 'HAVING qty > 0' : '').'
ORDER BY a.`position` ASC;'
        )
        ) {
            return false;
        }

        $colors = array();


        foreach ($res as $row) {
if(!empty($row['id_image'])) {


    $row['pimage'] = Image::getBestImageAttribute((int)Context::getContext()->shop->id, Context::getContext()->language->id, (int)$row['id_product'], (int)$row['id_product_attribute']);
    $row['pimage']['id_image'] = Context::getContext()->link->getProductLink(
        (int)$row['id_product'],
        null,
        null,
        null,
        Context::getContext()->language->id,
        null,
        (int)$row['id_product_attribute'],
        false,
        false,
        true,
        $isPreview ? array('preview' => '1') : array()
    );

    $row['pimage']['id_image'] = Context::getContext()->link->getImageLink($row['link_rewrite'], $row['pimage']['id_image'], 'home_default');
    $row['pimage']['id_image'] = Tools::getShopDomain(true) . _PS_IMG_ . 'p' . '/' . Image::getImgFolderStatic($row['id_image']) . (int)$row['id_image'].'-home_default'.'.jpg';
    $row['texture'] = '';
}else{
    $row['pimage'] = Image::getImages((int) Context::getContext()->language->id, (int)$row['id_product']);
if(is_array( $row['pimage']))
    foreach ($row['pimage'] as $res) {
        if($res['cover']=="1"){
            $row['pimage']['id_image'] =(int) $res['id_image'];
        }
    }
    $row['pimage']['id_image'] = Tools::getShopDomain(true) . _PS_IMG_ . 'p' . '/' . Image::getImgFolderStatic($row['pimage']['id_image']) . (int)$row['pimage']['id_image'] .'-home_default'. '.jpg';
}
            if (Tools::isEmpty($row['color']) && !@filemtime(_PS_COL_IMG_DIR_.$row['id_attribute'].'.jpg')) {
                continue;
            } elseif (Tools::isEmpty($row['color']) && @filemtime(_PS_COL_IMG_DIR_.$row['id_attribute'].'-home_default'.'.jpg')) {
                $row['texture'] = _THEME_COL_DIR_.$row['id_attribute'].'-home_default'.'.jpg';
            }


            $colors[(int)$row['id_product']][] = array('id_product_attribute' => (int)$row['id_product_attribute'], 'color' => $row['color'], 'id_image' => $row['pimage']['id_image'],'legend_image' => $row['pimage']['legend'], 'texture' => $row['texture'], 'id_product' => $row['id_product'], 'name' => $row['name'], 'id_attribute' => $row['id_attribute']);
        }

        return $colors
    ;
}

}
