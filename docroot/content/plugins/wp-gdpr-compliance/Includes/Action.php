<?php

namespace WPGDPRC\Includes;

use WPGDPRC\Includes\Extensions\CF7;
use WPGDPRC\Includes\Extensions\GForms;

/**
 * Class Action
 * @package WPGDPRC\Includes
 */
class Action {
    /** @var null */
    private static $instance = null;

    public function handleRedirects() {
        global $pagenow;
        if ($pagenow === 'tools.php' && isset($_REQUEST['page']) && $_REQUEST['page'] === str_replace('-', '_', WP_GDPR_C_SLUG)) {
            $type = (isset($_REQUEST['type'])) ? esc_html($_REQUEST['type']) : false;
            if ($type !== false) {
                switch ($type) {
                    case 'consents' :
                        $action = (isset($_REQUEST['action'])) ? esc_html($_REQUEST['action']) : false;
                        switch ($action) {
                            case 'manage' :
                                $id = (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) ? intval($_REQUEST['id']) : 0;
                                if (!empty($id) && !Consent::getInstance()->exists($id)) {
                                    wp_safe_redirect(Helper::getPluginAdminUrl('consents', array('notice' => 'wpgdprc-consent-not-found')));
                                    exit;
                                }
                                break;
                            case 'create' :
                                $consent = new Consent();
                                $consent->setSiteId(get_current_blog_id());
                                $id = $consent->save();
                                if (!empty($id)) {
                                    wp_safe_redirect(add_query_arg(
                                        array('notice' => 'wpgdprc-consent-added'),
                                        Consent::getActionUrl($id)
                                    ));
                                    exit;
                                }
                                break;
                            case 'delete' :
                                $id = (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) ? intval($_REQUEST['id']) : 0;
                                if (!empty($id) && Consent::getInstance()->exists($id)) {
                                    $result = Consent::getInstance()->delete($id);
                                    if ($result !== false) {
                                        wp_safe_redirect(Helper::getPluginAdminUrl('consents', array('notice' => 'wpgdprc-consent-removed')));
                                        exit;
                                    }
                                }
                                break;
                        }
                        break;
                }
            }
        }
    }

    public function showAdminNotices() {
        if (!empty($_REQUEST['notice'])) {
            Helper::showAdminNotice(esc_html($_REQUEST['notice']));
        }
    }

    /**
     * Stop WordPress from sending anything but essential data during the update check
     * @param array $query
     * @return array
     */
    public function onlySendEssentialDataDuringUpdateCheck($query = array()) {
        unset($query['php']);
        unset($query['mysql']);
        unset($query['local_package']);
        unset($query['blogs']);
        unset($query['users']);
        unset($query['multisite_enabled']);
        unset($query['initial_db_version']);
        return $query;
    }

    public function processEnableAccessRequest() {
        $enabled = Helper::isEnabled('enable_access_request', 'settings');
        if ($enabled) {
            $accessRequest = AccessRequest::databaseTableExists();
            $deleteRequest = DeleteRequest::databaseTableExists();
            if (!$accessRequest || !$deleteRequest) {
                Helper::createUserRequestDataTables();
                $result = wp_insert_post(array(
                    'post_type' => 'page',
                    'post_status' => 'private',
                    'post_title' => __('Data Access Request', WP_GDPR_C_SLUG),
                    'post_content' => '[wpgdprc_access_request_form]',
                    'meta_input' => array(
                        '_wpgdprc_access_request' => 1,
                    ),
                ), true);
                if (!is_wp_error($result)) {
                    update_option(WP_GDPR_C_PREFIX . '_settings_access_request_page', $result);
                }
            }
        }
    }

    public function processToggleAccessRequest() {
        $page = Helper::getAccessRequestPage();
        if (!empty($page)) {
            $enabled = Helper::isEnabled('enable_access_request', 'settings');
            $status = ($enabled) ? 'private' : 'draft';
            wp_update_post(array(
                'ID' => $page->ID,
                'post_status' => $status
            ));
        }
    }

    public function showNoticesRequestUserData() {
        $enabled = Helper::isEnabled('enable_access_request', 'settings');
        if ($enabled) {
            $accessRequest = AccessRequest::databaseTableExists();
            $deleteRequest = DeleteRequest::databaseTableExists();
            if (!$accessRequest || !$deleteRequest) {
                $pluginData = Helper::getPluginData();
                printf(
                    '<div class="%s"><p><strong>%s:</strong> %s %s</p></div>',
                    'notice notice-error',
                    $pluginData['Name'],
                    __('Couldn\'t create the required database tables.', WP_GDPR_C_SLUG),
                    sprintf(
                        '<a class="button" href="%s">%s</a>',
                        Helper::getPluginAdminUrl('', array('wpgdprc-action' => 'create_request_tables')),
                        __('Retry', WP_GDPR_C_SLUG)
                    )
                );
            }
        }
    }

    public function addConsentBar() {
    	$consentRequiredStatus = Action::checkAllConsentsRequired();
	    $consentBarColor = get_option(WP_GDPR_C_PREFIX . '_settings_consents_bar_color');
    	$consentBarTextColor = get_option(WP_GDPR_C_PREFIX . '_settings_consents_bar_text_color');
    	$consentBarButtonColor = get_option(WP_GDPR_C_PREFIX . '_settings_consents_bar_button_color_primary');
    	$consentBarButtonTextColor = get_option(WP_GDPR_C_PREFIX . '_settings_consents_bar_button_color_secondary');
    	$consentBarStyling = array(
    		'display: none;'
	    );
    	if (!empty($consentBarColor)) {
    		$consentBarStyling[] = 'background: ' . $consentBarColor .';';
	    }
	    $consentBarTextStyling = array();
	    if (!empty($consentBarTextColor)) {
    		$consentBarTextStyling[] = 'color: ' . $consentBarTextColor . ';';
	    }

	    $output = '<div class="wpgdprc wpgdprc-consent-bar" style="' . implode('', $consentBarStyling) . '">';
        $output .= '<div class="wpgdprc-consent-bar__container">';
	    $output .= '<div class="wpgdprc-consent-bar__content" ' .  (!empty($consentBarTextColor) ? 'style="' . implode('', $consentBarTextStyling) . '"' : '') . '>';
        $output .= '<div class="wpgdprc-consent-bar__column">';
        $output .= '<div class="wpgdprc-consent-bar__notice">';
        $output .= apply_filters('wpgdprc_the_content', Consent::getBarExplanationText());
        $output .= '</div>';
        $output .= '</div>';
        $output .= '<div class="wpgdprc-consent-bar__column">';
	    $output .= sprintf(
		    '<a class="wpgdprc-consent-bar__settings" href="javascript:void(0);" data-micromodal-trigger="wpgdprc-consent-modal" aria-expanded="false" aria-haspopup="true">%s</a>',
		    Consent::getBarMoreInformationText()
	    );
        $output .= '</div>';
        $output .= '<div class="wpgdprc-consent-bar__column">';
	    $buttonStyling = array();
	    if (!empty($consentBarButtonColor)) {
		    $buttonStyling[] = 'background: ' . $consentBarButtonColor . ';';
            $buttonStyling[] = 'border-color: ' . $consentBarButtonColor . ';';
	    }
	    if (!empty($consentBarButtonTextColor)) {
		    $buttonStyling[] = 'color: ' . $consentBarButtonTextColor . ';';
	    }
	    $output .= sprintf(
		    '<button class="wpgdprc-button wpgdprc-consent-bar__button" ' .  (!empty($buttonStyling) ? 'style="' . implode('', $buttonStyling) . '"' : '') .'>%s</button>',
		    Consent::getBarButtonText()
	    );
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
        echo apply_filters('wpgdprc_consent_bar', $output);
    }

	/**
	 * Checks if all the consents are required.
	 * @return bool
	 */
	public static function checkAllConsentsRequired() {
		$totalRequiredConsents = Consent::getInstance()->getList(array(
			'active' => array('value' => 1),
			'required' => array('value' => 1)
		));
		$totalActiveConsents = Consent::getInstance()->getList(array(
			'active' => array('value' => 1),
		));
		return sizeof($totalRequiredConsents) === sizeof($totalActiveConsents);
    }

    public function addConsentModal() {
    	$consentRequiredStatus = Action::checkAllConsentsRequired();
	    $consentModalButtonColor = get_option(WP_GDPR_C_PREFIX . '_settings_consents_bar_button_color_primary');
	    $consentModalButtonTextColor = get_option(WP_GDPR_C_PREFIX . '_settings_consents_bar_button_color_secondary');
        $consentIds = (array)Helper::getConsentIdsByCookie();
        $consents = Consent::getInstance()->getList(array(
            'active' => array('value' => 1)
        ));
	    $text = ($consentRequiredStatus) ? Consent::getBarButtonText() : __('Save my settings', WP_GDPR_C_SLUG);
        $output = '<div class="wpgdprc wpgdprc-consent-modal" id="wpgdprc-consent-modal" aria-hidden="true">';
        $output .= '<div class="wpgdprc-consent-modal__overlay" tabindex="-1" data-micromodal-close>';
        $output .= '<div class="wpgdprc-consent-modal__container" role="dialog" aria-modal="true">';
        if (!empty($consents)) {
            $output .= '<nav class="wpgdprc-consent-modal__navigation">';
            $output .= sprintf(
                '<a class="wpgdprc-button wpgdprc-button--active" href="javascript:void(0);" data-target="description">%s</a>',
                Consent::getModalTitle()
            );
            /** @var Consent $consent */
            foreach ($consents as $consent) {
                $title = $consent->getTitle();
                $output .= sprintf(
                    '<a class="wpgdprc-button" href="javascript:void(0);" data-target="%d">%s</a>',
                    $consent->getId(),
                    ((!empty($title)) ? $title : __('(no title)', WP_GDPR_C_SLUG))
                );
            }
            $output .= '</nav>'; // .wpgdprc-consent-modal__navigation
            $output .= '<div class="wpgdprc-consent-modal__information">';
            $output .= '<div class="wpgdprc-consent-modal__description" data-target="description">';
            $output .= sprintf(
                '<p class="wpgdprc-consent-modal__title">%s</p>',
                Consent::getModalTitle()
            );
            $output .= apply_filters('wpgdprc_the_content', Consent::getModalExplanationText());
            $output .= apply_filters('wpgdprc_the_content', sprintf(
                '<strong>%s:</strong> %s',
                strtoupper(__('Note', WP_GDPR_C_SLUG)),
                __('These settings will only apply to the browser and device you are currently using.', WP_GDPR_C_SLUG)
            ));
            $output .= '</div>'; // .wpgdprc-consent-modal__description
            /** @var Consent $consent */
            foreach ($consents as $consent) {
                $output .= sprintf(
                    '<div class="wpgdprc-consent-modal__description" style="display: none;" data-target="%d">',
                    $consent->getId()
                );
                $output .= sprintf('<p class="wpgdprc-consent-modal__title">%s</p>', $consent->getTitle());
                $output .= apply_filters('wpgdprc_the_content', $consent->getDescription());
                if (!$consent->getRequired()) {
                    $output .= '<div class="wpgdprc-checkbox">';
                    $output .= '<label>';
                    $output .= sprintf(
                        '<input type="checkbox" value="%d" %s />',
                        $consent->getId(),
                        checked(true, in_array($consent->getId(), $consentIds), false)
                    );
                    $output .= '<span class="wpgdprc-switch" aria-hidden="true">';
                    $output .= '<span class="wpgdprc-switch-label">';
                    $output .= '<span class="wpgdprc-switch-inner"></span>';
                    $output .= '<span class="wpgdprc-switch-switch"></span>';
                    $output .= '</span>';
                    $output .= '</span>';
                    $output .= __('Enable', WP_GDPR_C_SLUG);
                    $output .= '</label>';
                    $output .= '</div>';
                }
                $output .= '</div>'; // .wpgdprc-consent-modal__description
            }
            $output .= '<footer class="wpgdprc-consent-modal__footer">';
	        $buttonStyling = array();
	        if (!empty($consentModalButtonColor)) {
		        $buttonStyling[] = 'background: ' . $consentModalButtonColor . ';';
                $buttonStyling[] = 'border-color: ' . $consentModalButtonColor . ';';
	        }
	        if (!empty($consentModalButtonTextColor)) {
		        $buttonStyling[] = 'color: ' . $consentModalButtonTextColor . ';';
	        }
	        $output .= sprintf(
		        '<a class="wpgdprc-button wpgdprc-button--secondary" href="javascript:void(0);" %s>%s</a>',
		        (!empty($buttonStyling) ? 'style="' . implode('', $buttonStyling) . '"' : ''),
		        $text
	        );
            $output .= '</footer>'; // .wpgdprc-consent-modal__footer
            $output .= '</div>'; // .wpgdprc-consent-modal__information
        }
        $output .= sprintf(
            '<button class="wpgdprc-consent-modal__close" aria-label="%s" data-micromodal-close>&#x2715;</button>',
            esc_attr__('Close modal', WP_GDPR_C_SLUG)
        );
        $output .= '</div>'; // .wpgdprc-consent-modal__container
        $output .= '</div>'; // .wpgdprc-consent-modal__overlay
        $output .= '</div>'; // #wpgdprc-consent-modal
        echo $output;
    }

    public function addTagsToFields() {
        // Contact Form 7
        if (Helper::isEnabled(CF7::ID)) {
            CF7::getInstance()->addFormTagToForms();
            CF7::getInstance()->addAcceptedDateToForms();
        }

        // Gravity Forms
        if (Helper::isEnabled(GForms::ID)) {
            foreach (GForms::getInstance()->getForms() as $form) {
                if (in_array($form['id'], GForms::getInstance()->getEnabledForms())) {
                    GForms::getInstance()->addField($form);
                }
            }
        }
    }

    public function removeTagsFromFields() {
        // Contact Form 7
        if (Helper::isEnabled(CF7::ID)) {
            CF7::getInstance()->removeFormTagFromForms();
            CF7::getInstance()->removeAcceptedDateFromForms();
        }

        // Gravity Forms
        if (Helper::isEnabled(GForms::ID)) {
            foreach (GForms::getInstance()->getForms() as $form) {
                if (in_array($form['id'], GForms::getInstance()->getEnabledForms())) {
                    GForms::getInstance()->removeField($form);
                }
            }
        }
    }

    /**
     * @return null|Action
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
