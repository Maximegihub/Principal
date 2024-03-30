<?php

namespace DevOwl\RealCookieBanner\rest;

use DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\Service;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\scanner\AutomaticScanStarter;
use DevOwl\RealCookieBanner\scanner\ScanPresets;
use DevOwl\RealCookieBanner\view\Scanner as ViewScanner;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Scanner API
 */
class Scanner {
    use UtilsProvider;
    /**
     * C'tor.
     */
    private function __construct() {
        // Silence is golden.
    }
    /**
     * Register endpoints.
     */
    public function rest_api_init() {
        $namespace = \DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\Service::getNamespace($this);
        register_rest_route($namespace, '/scanner/queue', [
            'methods' => 'POST',
            'callback' => [$this, 'routeAddQueue'],
            'permission_callback' => [$this, 'permission_callback'],
            'args' => ['purgeUnused' => ['type' => 'boolean', 'default' => \false]]
        ]);
        register_rest_route($namespace, '/scanner/result/presets', [
            'methods' => 'GET',
            'callback' => [$this, 'routeResultPresets'],
            'permission_callback' => [$this, 'permission_callback']
        ]);
        register_rest_route($namespace, '/scanner/result/externals', [
            'methods' => 'GET',
            'callback' => [$this, 'routeResultExternalUrls'],
            'permission_callback' => [$this, 'permission_callback']
        ]);
        register_rest_route($namespace, '/scanner/result/externals/(?P<host>[a-zA-Z0-9\\._-]+\\.[a-zA-Z0-9_-]+)', [
            'methods' => 'GET',
            'callback' => [$this, 'routeResultAllExternalUrlsByHost'],
            'permission_callback' => [$this, 'permission_callback']
        ]);
        register_rest_route($namespace, '/scanner/result/externals/(?P<preset>[a-zA-Z0-9_-]+)', [
            'methods' => 'GET',
            'callback' => [$this, 'routeResultAllExternalUrlsByPreset'],
            'permission_callback' => [$this, 'permission_callback']
        ]);
        register_rest_route($namespace, '/scanner/result/externals/(?P<host>[a-zA-Z0-9\\._-]+)', [
            'methods' => 'PUT',
            'callback' => [$this, 'routeResultExternalUrlPatch'],
            'permission_callback' => [$this, 'permission_callback'],
            'args' => ['ignored' => ['type' => 'boolean']]
        ]);
        register_rest_route($namespace, '/scanner/result/markup/(?P<id>\\d+)', [
            'methods' => 'GET',
            'callback' => [$this, 'routeResultMarkupById'],
            'permission_callback' => [$this, 'permission_callback']
        ]);
    }
    /**
     * Check if user is allowed to call this service requests.
     */
    public function permission_callback() {
        return current_user_can(\DevOwl\RealCookieBanner\Core::MANAGE_MIN_CAPABILITY);
    }
    /**
     * See API docs.
     *
     * @param WP_REST_Request $request
     *
     * @api {post} /real-cookie-banner/v1/scanner/queue Add URLs to the scanner queue
     * @apiHeader {string} X-WP-Nonce
     * @apiParam {string[]} urls
     * @apiParam {boolean} [purgeUnused] If `true`, the difference of the previous scanned URLs gets
     *                                   automatically purged if they do no longer exist in the URLs (pass only if you have the complete sitemap!)
     * @apiName AddQueue
     * @apiGroup Scanner
     * @apiVersion 1.0.0
     * @apiPermission manage_options
     */
    public function routeAddQueue($request) {
        $urls = $request->get_param('urls');
        if (!\is_array($urls)) {
            return new \WP_Error('rest_arg_not_string_array', null, ['status' => 422]);
        }
        // Disable automatic scanning
        update_option(
            \DevOwl\RealCookieBanner\scanner\AutomaticScanStarter::OPTION_NAME,
            \DevOwl\RealCookieBanner\scanner\AutomaticScanStarter::STATUS_STARTED
        );
        $added = \DevOwl\RealCookieBanner\Core::getInstance()
            ->getScanner()
            ->addUrlsToQueue($urls, $request->get_param('purgeUnused'));
        return new \WP_REST_Response(['added' => $added]);
    }
    /**
     * See API docs.
     *
     * @api {get} /real-cookie-banner/v1/scanner/result/presets Get predefined presets for blocker which got scanned through our scanner
     * @apiHeader {string} X-WP-Nonce
     * @apiName PresetsResult
     * @apiGroup Scanner
     * @apiVersion 1.0.0
     * @apiPermission manage_options
     */
    public function routeResultPresets() {
        $presets = new \DevOwl\RealCookieBanner\scanner\ScanPresets();
        return new \WP_REST_Response(['items' => (object) $presets->getAllFromCache()]);
    }
    /**
     * See API docs.
     *
     * @api {get} /real-cookie-banner/v1/scanner/result/externals Get external URLs which got scanned through our scanner
     * @apiHeader {string} X-WP-Nonce
     * @apiName ExternalUrlResults
     * @apiGroup Scanner
     * @apiVersion 1.0.0
     * @apiPermission manage_options
     */
    public function routeResultExternalUrls() {
        $results = \DevOwl\RealCookieBanner\Core::getInstance()
            ->getScanner()
            ->getQuery()
            ->getScannedExternalUrls();
        return new \WP_REST_Response(['items' => (object) $results]);
    }
    /**
     * See API docs.
     *
     * @param WP_REST_Request $request
     *
     * @api {get} /real-cookie-banner/v1/scanner/result/externals/:host Get all blocked URLs for a given host
     * @apiHeader {string} X-WP-Nonce
     * @apiParam {string} host
     * @apiName AllExternalUrlsByHost
     * @apiGroup Scanner
     * @apiVersion 1.0.0
     * @apiPermission manage_options
     */
    public function routeResultAllExternalUrlsByHost($request) {
        $result = \DevOwl\RealCookieBanner\Core::getInstance()
            ->getScanner()
            ->getQuery()
            ->getAllScannedExternalUrlsBy('host', $request->get_param('host'));
        return \count($result) > 0
            ? new \WP_REST_Response(['items' => $result])
            : new \WP_Error('rest_not_found', 'Host not found');
    }
    /**
     * See API docs.
     *
     * @param WP_REST_Request $request
     *
     * @api {get} /real-cookie-banner/v1/scanner/result/externals/:preset Get all blocked URLs for a given preset ID
     * @apiHeader {string} X-WP-Nonce
     * @apiParam {string} preset
     * @apiName AllExternalUrlsByPreset
     * @apiGroup Scanner
     * @apiVersion 1.0.0
     * @apiPermission manage_options
     */
    public function routeResultAllExternalUrlsByPreset($request) {
        $result = \DevOwl\RealCookieBanner\Core::getInstance()
            ->getScanner()
            ->getQuery()
            ->getAllScannedExternalUrlsBy('preset', $request->get_param('preset'));
        return \count($result) > 0
            ? new \WP_REST_Response(['items' => $result])
            : new \WP_Error('rest_not_found', 'Preset not found');
    }
    /**
     * See API docs.
     *
     * @param WP_REST_Request $request
     *
     * @api {put} /real-cookie-banner/v1/scanner/result/externals/:host Update an external URL host
     * @apiHeader {string} X-WP-Nonce
     * @apiParam {string} host
     * @apiParam {boolean} [ignored]
     * @apiName ExternalUrlIgnore
     * @apiGroup Scanner
     * @apiVersion 1.0.0
     * @apiPermission manage_options
     */
    public function routeResultExternalUrlPatch($request) {
        $ignored = $request->get_param('ignored');
        $query = \DevOwl\RealCookieBanner\Core::getInstance()
            ->getScanner()
            ->getQuery();
        $result = [];
        if ($ignored !== null) {
            $result['ignored'] = $query->ignoreBlockedUrlHosts([$request->get_param('host')], $ignored);
        }
        return new \WP_REST_Response((object) $result);
    }
    /**
     * See API docs.
     *
     * @param WP_REST_Request $request
     *
     * @api {get} /real-cookie-banner/v1/scanner/result/markup/:id Get markup by scan entry ID
     * @apiHeader {string} X-WP-Nonce
     * @apiParam {number} id
     * @apiName GetMarkup
     * @apiGroup Scanner
     * @apiVersion 1.0.0
     * @apiPermission manage_options
     */
    public function routeResultMarkupById($request) {
        $id = \intval($request->get_param('id'));
        $result = \DevOwl\RealCookieBanner\Core::getInstance()
            ->getScanner()
            ->getQuery()
            ->getMarkup($id);
        return $result !== null
            ? new \WP_REST_Response($result)
            : new \WP_Error('rest_not_found', 'Scan entry not found');
    }
    /**
     * Add live results for the scanner tab.
     *
     * @param mixed $data
     */
    public function real_queue_additional_data_list($data) {
        return [
            'presets' => $this->routeResultPresets()->get_data(),
            'externalUrls' => $this->routeResultExternalUrls()->get_data()
        ];
    }
    /**
     * Add live results for the scanner results in admin bar.
     *
     * @param mixed $data
     */
    public function real_queue_additional_data_notice($data) {
        $viewScanner = \DevOwl\RealCookieBanner\view\Scanner::instance();
        list($services, $countAll) = $viewScanner->getServicesForNotice(
            \DevOwl\RealCookieBanner\view\Scanner::MAX_FOUND_SERVICES_LIST_ITEMS
        );
        return [
            'countAll' => $countAll,
            'text' =>
                \count($services) === 0 ? null : $viewScanner->generateNoticeTextFromServices($services, $countAll)
        ];
    }
    /**
     * New instance.
     */
    public static function instance() {
        return new \DevOwl\RealCookieBanner\rest\Scanner();
    }
}
