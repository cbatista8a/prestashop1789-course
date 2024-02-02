<?php

class CookiesNotice extends Module
{
    public function __construct($name = null, Context $context = null)
    {
        $this->name = 'cookiesnotice';
        $this->author = 'Carlos Batista';
        $this->version = '1.0';
        $this->need_instance = 1;
        $this->bootstrap = true;

        $this->ps_versions_compliancy = ['min' => '1.7.6', 'max' => '1.7.8.10'];
        $this->displayName = $this->getTranslator()->trans('Cookies Notice');
        $this->description = $this->getTranslator()->trans('My Awesome Module');
        parent::__construct($name, $context);
    }

    public function install()
    {
        return parent::install() && $this->registerHooks();
    }

    public function registerHooks()
    {
        $hook = [
            'displayFooterAfter',
        ];

        return $this->registerHook($hook);
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    public function getContent()
    {
        $this->postProcess();

        return $this->renderForm();
    }

    public function postProcess()
    {
        if (Tools::isSubmit('submitCookiesNotice')) {
            $text = [];
            foreach (Language::getIDs() as $lang_id) {
                $text[$lang_id] = Tools::getValue('COOKIES_NOTICE_TEXT_'.$lang_id);
            }
            Configuration::updateValue('COOKIES_NOTICE_TEXT', $text, false);
        }
    }

    private function renderForm()
    {
        $fields_form =
            [
                'form' => [
                    'legend' => [
                        'title' => $this->displayName,
                        'icon' => 'icon-share',
                    ],
                    'input' => [
                        [
                            'type' => 'text',
                            'label' => $this->trans('Text', [], 'Admin.Actions'),
                            'name' => 'COOKIES_NOTICE_TEXT',
                            'desc' => $this->trans(
                                'Set custom Cookies Notice',
                                [],
                                'Modules.CookiesNotice.Admin'
                            ),
                            'lang' => true,
                        ],
                    ],
                    'submit' => [
                        'title' => $this->trans('Save', [], 'Admin.Actions'),
                    ],
                ],
            ];

        $helper = new HelperForm();
        $helper->submit_action = 'submitCookiesNotice';
        $helper->allow_employee_form_lang = true;
        $helper->module = $this;
        $helper->identifier = $this->name;
        $helper->languages = Language::getLanguages();
        $helper->default_form_language = Context::getContext()->language->id;
        $helper->fields_value = [
            'COOKIES_NOTICE_TEXT' => Configuration::getConfigInMultipleLangs(
                'COOKIES_NOTICE_TEXT'
            ),
        ];

        return $helper->generateForm([$fields_form]);
    }

    public function hookDisplayFooterAfter($params)
    {
        $context = Context::getContext();
        $cookie_text = Configuration::get('COOKIES_NOTICE_TEXT', $context->language->id);
        $context->smarty->assign('cookie_text', $cookie_text);

        return $context->smarty->fetch($this->getLocalPath().'views/hook/notice.tpl');
    }
}
