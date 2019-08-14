<?php
/**
 *  @author  <boughdiri.med.ali@gmail.com>

 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class Picturefeatures extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'picturefeatures';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'boughdiri.med.ali@gmail.com';
        $this->need_instance = 1;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('picture features');
        $this->description = $this->l('picture features prestashop');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        $this->rewriteFiles();



        return parent::install() &&
            $this->registerHook('displayHeader') &&
            $this->registerHook('backOfficeHeader');
    }
    public function rewriteFiles()
    {

        if (file_exists(dirname(__FILE__).'/../../override/classes/Product.php'))
        {
            @rename(dirname(__FILE__).'/../../override/override/classes/Product.php', dirname(__FILE__).'/../../override/classes/Product.bak.php');
        }

        if (file_exists(dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/variant-links.tpl'))
        {
            @rename(dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/variant-links.tpl', dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/variant-links.bak.tpl');
        }

        if (file_exists(dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/product-cover-thumbnails.tpl'))
        {
            @rename(dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/product-cover-thumbnails.tpl', dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/product-cover-thumbnails.bak.tpl');
        }

        if (file_exists(dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/product-variants.tpl'))
        {
            @rename(dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/product-variants.tpl', dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/product-variants.bak.tpl');
        }

        if (!copy(dirname(__FILE__) . '/install/classes/Product.php', dirname(__FILE__) . '/../../override/classes/Product.php'))
            return false;



        if (!copy(dirname(__FILE__) . '/views/templates/front/catalog/_partials/variant-links.tpl', dirname(__FILE__) . '/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/variant-links.tpl'))
            return false;
        if (!copy(dirname(__FILE__) . '/views/templates/front/catalog/_partials/product-cover-thumbnails.tpl', dirname(__FILE__) . '/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/product-cover-thumbnails.tpl'))
            return false;
        if (!copy(dirname(__FILE__) . '/views/templates/front/catalog/_partials/product-variants.tpl', dirname(__FILE__) . '/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/product-variants.tpl'))
            return false;



    }

    public function oldfiles()
    {

        if (file_exists(dirname(__FILE__).'/../../override/classes/Product.php'))
        {
            @rename(dirname(__FILE__).'/../../override/override/classes/Product.php', dirname(__FILE__).'/../../override/classes/Product.mod.php');
        }

        if (file_exists(dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/variant-links.tpl'))
        {
            @rename(dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/variant-links.tpl', dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/variant-links.mod.tpl');
        }
        if (file_exists(dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/variant-links.bak.tpl'))
        {
            @rename(dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/variant-links.bak.tpl', dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/variant-links.tpl');
        }

        if (file_exists(dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/product-cover-thumbnails.tpl'))
        {
            @rename(dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/product-cover-thumbnails.tpl', dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/product-cover-thumbnails.mod.tpl');
        }
        if (file_exists(dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/product-cover-thumbnails.bak.tpl'))
        {
            @rename(dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/product-cover-thumbnails.bak.tpl', dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/product-cover-thumbnails.tpl');
        }

        if (file_exists(dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/product-variants.tpl'))
        {
            @rename(dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/product-variants.tpl', dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/product-variants.mod.tpl');
        }

        if (file_exists(dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/product-variants.bak.tpl'))
        {
            @rename(dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/product-variants.bak.tpl', dirname(__FILE__).'/../../themes/' . _THEME_NAME_ . '/templates/catalog/_partials/product-variants.tpl');
        }




    }

    
    public function uninstall()
    {

        $this->oldfiles();
        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitPicturefeaturesModule')) == true) {
            $this->postProcess();
        }

        $this->context->smarty->assign('module_dir', $this->_path);

        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

        return $output.$this->renderForm();
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitPicturefeaturesModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(

            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm();
    }

    /**
     * Create the structure of your form.
     */


    /**
     * Set values for the inputs.
     */


    /**
     * Save form data.
     */
    protected function postProcess()
    {

    }

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('module_name') == $this->name) {
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookdisplayHeader($params)
    {
        $this->context->controller->addCSS($this->_path.'/views/css/owl.carousel.css');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
        $this->context->controller->addJS($this->_path.'/views/js/owl.carousel.min.js');
        $this->context->controller->addJS($this->_path.'/views/js/front.js');

    }
}
