<?php

defined('ABSPATH') OR die('This script cannot be accessed directly.');

/**
 * Handle interactions with the http://app.schemaapp,com server
 *
 * @author Mark van Berkel
 */
class SchemaServer {

        private $options;
        private $resource;

        const API_SERVER = "https://api.hunchmanifest.com/";
        const DATA_SERVER = "https://data.schemaapp.com/";
        const EDITOR = "https://app.schemaapp.com/editor";
        const ACTIVATE = "service/activate.json";

        public function __construct($uri = "") {
                $this->options = get_option('schema_option_name');

                if (!empty($uri)) {
                        $this->resource = $uri;
                } elseif (is_front_page() && is_home() || is_front_page()) {
                        $this->resource = get_site_url() . '/';
                } elseif (is_tax() || is_post_type_archive()) {
                        $this->resource = 'http' .
                                (null !== filter_input(INPUT_SERVER, 'HTTPS') ? 's' : '') .
                                '://' .
                                filter_input(INPUT_SERVER, 'HTTP_HOST') .
                                filter_input(INPUT_SERVER, 'REQUEST_URI');
                } else {
                        $this->resource = get_permalink();
                }
        }

        /**
         * Get Resource JSON_LD content
         * 
         * @param type $uri
         * @return string
         */
        public function getResource($uri = '', $pretty = false) {

                if (empty($this->options['graph_uri'])) {
                        return '';
                }


                $resource = '';

                if (!empty($uri)) {
                        $resource = $uri;
                } elseif (!empty($this->resource)) {
                        $resource = $this->resource;
                } else {
                        return '';
                }

				// Decode accent characters
				$resource = urldecode( $resource );


                $transient_id = 'HunchSchema-Markup-' . md5($resource);
                $transient = get_transient($transient_id);

                // Check for missing, empty or 'null' transient
                if ($transient !== false && $transient !== 'null') {
                        return $transient;
                }

                $remote_response = wp_remote_get($this->readLink($resource));

                // Check for anything unexpected
                if (is_wp_error($remote_response) || wp_remote_retrieve_body($remote_response) === "" || wp_remote_retrieve_body($remote_response) === false || wp_remote_retrieve_body($remote_response) === 'null' || wp_remote_retrieve_response_code($remote_response) != 200) {
                        $schemadata = '';
                } else {
                        $schemadata = wp_remote_retrieve_body($remote_response);

                        if ($pretty && version_compare(phpversion(), '5.4.0', '>=')) {
                                $schemadata = json_encode(json_decode($schemadata), JSON_PRETTY_PRINT);
                        }
                }

                set_transient($transient_id, $schemadata, 86400);

                return $schemadata;
        }

        /**
         * Get the Link to Update a Resource that exists
         * 
         * @param type $uri
         * @return string
         */
        protected function readLink($uri = '') {
                $uri = !empty($uri) ? $uri : $this->resource;
                $graph = str_replace("http://schemaapp.com/db/", "", $this->options['graph_uri']);
                return $this::DATA_SERVER . $graph . '/' . trim(base64_encode($uri), '=');
        }

        /**
         * Get the Link to Update a Resource that exists
         * 
         * @param type $uri
         * @return string
         */
        public function updateLink() {
                $link = self::EDITOR . "?resource=" . $this->resource;
                return $link;
        }

        /**
         * Get the link to create a new resource
         * 
         * @param type $uri
         * @return string
         */
        public function createLink() {
                $link = self::EDITOR . "?create=" . $this->resource;
                return $link;
        }

        /**
         * Activate Licenses, sends license key to Hunch Servers to confirm purchase 
         * 
         * @param type $params
         */
        public function activateLicense($params) {

                $api = self::API_SERVER . self::ACTIVATE;

                // Call the custom API.
                $response = wp_remote_post($api, array(
                        'timeout' => 15,
                        'sslverify' => false,
                        'body' => $params
                ));
                $response_code = wp_remote_retrieve_response_code($response);

                // decode the license data
                $license_data = json_decode(wp_remote_retrieve_body($response));

                if (in_array($response_code, array(200, 201))) {
                        return array(true, $license_data);
                } else {
                        return array(false, $license_data);
                }
        }

}
