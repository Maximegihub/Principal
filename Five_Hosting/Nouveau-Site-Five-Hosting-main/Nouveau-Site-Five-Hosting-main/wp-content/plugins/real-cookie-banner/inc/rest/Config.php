<?php

namespace DevOwl\RealCookieBanner\rest;

use DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\Service;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\comp\migration\AbstractDashboardTileMigration;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\settings\Cookie;
use DevOwl\RealCookieBanner\settings\CountryBypass;
use DevOwl\RealCookieBanner\settings\ModalHints;
use DevOwl\RealCookieBanner\settings\Revision;
use DevOwl\RealCookieBanner\view\Checklist;
use DevOwl\RealCookieBanner\view\ConfigPage;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Create an config REST API.
 */
class Config {
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
        register_rest_route($namespace, '/checklist', [
            'methods' => 'GET',
            'callback' => [$this, 'routeGetChecklist'],
            'permission_callback' => [$this, 'permission_callback']
        ]);
        register_rest_route($namespace, '/checklist/(?P<id>[a-zA-Z0-9_-]+)', [
            'methods' => 'PUT',
            'callback' => [$this, 'routePutChecklist'],
            'permission_callback' => [$this, 'permission_callback'],
            'args' => ['state' => ['type' => 'boolean', 'required' => \true]]
        ]);
        register_rest_route($namespace, '/modal-hint', [
            'methods' => 'PUT',
            'callback' => [$this, 'routePutModalHintSeen'],
            'permission_callback' => [$this, 'permission_callback'],
            'args' => ['identifier' => ['type' => 'string', 'required' => \true]]
        ]);
        register_rest_route($namespace, '/revision/current', [
            'methods' => 'GET',
            'callback' => [$this, 'routeGetRevisionCurrent'],
            'permission_callback' => [$this, 'permission_callback']
        ]);
        register_rest_route($namespace, '/revision/(?P<hash>[a-zA-Z0-9_-]{32})', [
            'methods' => 'GET',
            'callback' => [$this, 'routeGetRevisionByHash'],
            'permission_callback' => [$this, 'permission_callback'],
            'args' => ['backwardsCompatibility' => ['type' => 'boolean', 'default' => \true]]
        ]);
        register_rest_route($namespace, '/revision/independent/(?P<hash>[a-zA-Z0-9_-]{32})', [
            'methods' => 'GET',
            'callback' => [$this, 'routeGetRevisionIndependentByHash'],
            'permission_callback' => [$this, 'permission_callback'],
            'args' => ['backwardsCompatibility' => ['type' => 'boolean', 'default' => \true]]
        ]);
        register_rest_route($namespace, '/revision/current', [
            'methods' => 'PUT',
            'callback' => [$this, 'routePutRevisionCurrent'],
            'permission_callback' => [$this, 'permission_callback']
        ]);
        register_rest_route($namespace, '/cookie-groups/order', [
            'methods' => 'PUT',
            'callback' => [$this, 'routeCookieGroupsOrder'],
            'permission_callback' => [$this, 'permission_callback']
        ]);
        register_rest_route($namespace, '/cookies/order', [
            'methods' => 'PUT',
            'callback' => [$this, 'routeCookiesOrder'],
            'permission_callback' => [$this, 'permission_callback']
        ]);
        register_rest_route($namespace, '/cookies/unassigned', [
            'methods' => 'GET',
            'callback' => [$this, 'routeCookiesUnassigned'],
            'permission_callback' => [$this, 'permission_callback']
        ]);
        register_rest_route($namespace, '/country-bypass/database', [
            'methods' => 'PUT',
            'callback' => [$this, 'routeCountryBypassDownload'],
            'permission_callback' => [$this, 'permission_callback']
        ]);
        register_rest_route($namespace, '/migration/(?P<migrationId>[a-zA-Z0-9_-]+)/(?P<actionId>[a-zA-Z0-9_-]+)', [
            'methods' => 'POST',
            'callback' => [$this, 'routeMigrationPost'],
            'permission_callback' => [$this, 'permission_callback']
        ]);
        register_rest_route($namespace, '/migration/(?P<migrationId>[a-zA-Z0-9_-]+)', [
            'methods' => 'DELETE',
            'callback' => [$this, 'routeMigrationDelete'],
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
     * @api {get} /real-cookie-banner/v1/checklist Get all checklist items with their state
     * @apiHeader {string} X-WP-Nonce
     * @apiName ChecklistGet
     * @apiGroup Config
     * @apiPermission manage_options
     * @apiVersion 1.0.0
     */
    public function routeGetChecklist() {
        return new \WP_REST_Response(
            \array_merge(\DevOwl\RealCookieBanner\view\Checklist::getInstance()->result(), [
                'overdue' => \DevOwl\RealCookieBanner\view\Checklist::getInstance()->isOverdue(
                    \DevOwl\RealCookieBanner\view\ConfigPage::CHECKLIST_OVERDUE
                )
            ])
        );
    }
    /**
     * See API docs.
     *
     * @param WP_REST_Request $request
     *
     * @api {put} /real-cookie-banner/v1/checklist/:id Mark a checklist item as checked / unchecked
     * @apiHeader {string} X-WP-Nonce
     * @apiHeader {boolean} state
     * @apiName ChecklistPut
     * @apiGroup Config
     * @apiPermission manage_options
     * @apiVersion 1.0.0
     */
    public function routePutChecklist($request) {
        \DevOwl\RealCookieBanner\view\Checklist::getInstance()->toggle(
            $request->get_param('id'),
            $request->get_param('state')
        );
        return new \WP_REST_Response(
            \array_merge(\DevOwl\RealCookieBanner\view\Checklist::getInstance()->result(), [
                'overdue' => \DevOwl\RealCookieBanner\view\Checklist::getInstance()->isOverdue(
                    \DevOwl\RealCookieBanner\view\ConfigPage::CHECKLIST_OVERDUE
                )
            ])
        );
    }
    /**
     * See API docs.
     *
     * @param WP_REST_Request $request
     *
     * @api {put} /real-cookie-banner/v1/modal-hint Set a modal hint as seen and never show again
     * @apiHeader {string} X-WP-Nonce
     * @apiParma {string} identifier
     * @apiName ModalHintSeenPut
     * @apiGroup Config
     * @apiPermission manage_options
     * @apiVersion 1.0.0
     */
    public function routePutModalHintSeen($request) {
        return new \WP_REST_Response([
            'success' => \DevOwl\RealCookieBanner\settings\ModalHints::getInstance()->setSeen(
                $request->get_param('identifier')
            )
        ]);
    }
    /**
     * See API docs.
     *
     * @api {get} /real-cookie-banner/v1/revision/current Get the current revision hash
     * @apiHeader {string} X-WP-Nonce
     * @apiName RevisionCurrent
     * @apiGroup Config
     * @apiPermission manage_options
     * @apiVersion 1.0.0
     */
    public function routeGetRevisionCurrent() {
        $current = \DevOwl\RealCookieBanner\settings\Revision::getInstance()->getCurrent();
        return new \WP_REST_Response(
            \array_merge(
                [
                    'needs_retrigger' => \DevOwl\RealCookieBanner\settings\Revision::getInstance()->needsRetrigger(
                        $current
                    )
                ],
                $current
            )
        );
    }
    /**
     * See API docs.
     *
     * @param WP_REST_Request $request
     *
     * @since 1.3.0
     * @api {get} /real-cookie-banner/v1/revision/:hash Get the revision by hash
     * @apiHeader {string} X-WP-Nonce
     * @apiParam {boolean} [backwardsCompatibility=true]
     * @apiName RevisionByHash
     * @apiGroup Config
     * @apiPermission manage_options
     * @apiVersion 1.0.0
     */
    public function routeGetRevisionByHash($request) {
        $result = \DevOwl\RealCookieBanner\settings\Revision::getInstance()->getByHash(
            $request->get_param('hash'),
            \false,
            $request->get_param('backwardsCompatibility')
        );
        return $result === null
            ? new \WP_Error('rest_not_found', null, ['status' => 404])
            : new \WP_REST_Response($result);
    }
    /**
     * See API docs.
     *
     * @param WP_REST_Request $request
     *
     * @since 1.3.0
     * @api {get} /real-cookie-banner/v1/revision/independent/:hash Get the independent revision by hash
     * @apiHeader {string} X-WP-Nonce
     * @apiParam {boolean} [backwardsCompatibility=true]
     * @apiName RevisionIndependentByHash
     * @apiGroup Config
     * @apiPermission manage_options
     * @apiVersion 1.0.0
     */
    public function routeGetRevisionIndependentByHash($request) {
        $result = \DevOwl\RealCookieBanner\settings\Revision::getInstance()->getByHash(
            $request->get_param('hash'),
            \true,
            $request->get_param('backwardsCompatibility')
        );
        return $result === null
            ? new \WP_Error('rest_not_found', null, ['status' => 404])
            : new \WP_REST_Response($result);
    }
    /**
     * See API docs.
     *
     * @api {put} /real-cookie-banner/v1/revision/current Update current revision hash from the latest settings
     * @apiHeader {string} X-WP-Nonce
     * @apiName RevisionCurrentPut
     * @apiGroup Config
     * @apiPermission manage_options
     * @apiVersion 1.0.0
     */
    public function routePutRevisionCurrent() {
        return new \WP_REST_Response(\DevOwl\RealCookieBanner\settings\Revision::getInstance()->getCurrent(\true));
    }
    /**
     * See API docs.
     *
     * @param WP_REST_Request $request
     *
     * @api {put} /real-cookie-banner/v1/cookie-groups/order Order the cookie groups
     * @apiHeader {string} X-WP-Nonce
     * @apiParam {number[]} ids
     * @apiName CookieGroupsOrder
     * @apiGroup Config
     * @apiPermission manage_options
     * @apiVersion 1.0.0
     */
    public function routeCookieGroupsOrder($request) {
        // Get ids array
        $ids = $request->get_param('ids');
        if (!isset($ids) || !\is_array($ids) || empty($ids)) {
            return new \WP_Error('rest_rcb_wrong_ids');
        }
        $ids = \array_map('absint', $ids);
        // Persist
        foreach ($ids as $index => $id) {
            update_term_meta($id, 'order', $index);
        }
        return new \WP_REST_Response(\true);
    }
    /**
     * See API docs.
     *
     * @param WP_REST_Request $request
     *
     * @api {put} /real-cookie-banner/v1/cookies/order Order the cookies
     * @apiHeader {string} X-WP-Nonce
     * @apiParam {number[]} ids
     * @apiName CookiesOrder
     * @apiGroup Config
     * @apiPermission manage_options
     * @apiVersion 1.0.0
     */
    public function routeCookiesOrder($request) {
        // Get ids array
        $ids = $request->get_param('ids');
        if (!isset($ids) || !\is_array($ids) || empty($ids)) {
            return new \WP_Error('rest_rcb_wrong_ids');
        }
        $ids = \array_map('absint', $ids);
        // Persist
        foreach ($ids as $index => $id) {
            wp_update_post(['ID' => $id, 'menu_order' => $index]);
        }
        return new \WP_REST_Response(\true);
    }
    /**
     * See API docs.
     *
     * @api {get} /real-cookie-banner/v1/cookies/unassigned Get unassigned services
     * @apiHeader {string} X-WP-Nonce
     * @apiName CookiesUnassigned
     * @apiGroup Config
     * @apiPermission manage_options
     * @apiVersion 1.0.0
     */
    public function routeCookiesUnassigned() {
        $posts = \DevOwl\RealCookieBanner\settings\Cookie::getInstance()->getUnassignedCookies();
        $result = [];
        foreach ($posts as $post) {
            $result[] = ['id' => $post->ID, 'title' => $post->post_title];
        }
        return new \WP_REST_Response($result);
    }
    /**
     * See API docs.
     *
     * @api {put} /real-cookie-banner/v1/country-bypass/database Download the Country Bypass IP database
     * @apiHeader {string} X-WP-Nonce
     * @apiName CountryBypassDatabaseDownload
     * @apiGroup Config
     * @apiPermission manage_options, PRO
     * @apiVersion 1.0.0
     */
    public function routeCountryBypassDownload() {
        $result = \DevOwl\RealCookieBanner\settings\CountryBypass::getInstance()->updateDatabase();
        return is_wp_error($result)
            ? $result
            : new \WP_REST_Response([
                'dbDownloadTime' => mysql2date(
                    'c',
                    \DevOwl\RealCookieBanner\settings\CountryBypass::getInstance()->getDatabaseDownloadTime(),
                    \false
                )
            ]);
    }
    /**
     * See API docs.
     *
     * @param WP_REST_Request $request
     *
     * @api {post} /real-cookie-banner/v1/migration/:migration/:action Apply a registered migration action registered via `AbstractDashboardTileMigration::addAction`
     * @apiParam {string} migration
     * @apiParam {string} action
     * @apiHeader {string} X-WP-Nonce
     * @apiName DoMigration
     * @apiGroup Config
     * @apiPermission manage_options, PRO
     * @apiVersion 1.0.0
     */
    public function routeMigrationPost($request) {
        $result = \DevOwl\RealCookieBanner\comp\migration\AbstractDashboardTileMigration::doAction(
            $request->get_param('migrationId'),
            $request->get_param('actionId')
        );
        if (is_wp_error($result)) {
            return $result;
        }
        if ($result['success'] !== \true) {
            return new \WP_Error('rcb_migration_failed');
        }
        return $result;
    }
    /**
     * See API docs.
     *
     * @param WP_REST_Request $request
     *
     * @api {post} /real-cookie-banner/v1/migration/:migration/ Dismiss a migration by migration ID
     * @apiParam {string} migration
     * @apiHeader {string} X-WP-Nonce
     * @apiName DismissMigration
     * @apiGroup Config
     * @apiPermission manage_options, PRO
     * @apiVersion 1.0.0
     */
    public function routeMigrationDelete($request) {
        \DevOwl\RealCookieBanner\comp\migration\AbstractDashboardTileMigration::doDismiss(
            $request->get_param('migrationId')
        );
        return new \WP_REST_Response(['success' => \true]);
    }
    /**
     * Check if settings got updated and `do_action`.
     *
     * @param WP_HTTP_Response $response
     * @param WP_REST_Server $server
     * @param WP_REST_Request $request
     */
    public function rest_post_dispatch($response, $server, $request) {
        if (
            $request->get_route() === '/wp/v2/settings' &&
            $request->get_method() === 'PATCH' &&
            isset($response->data) &&
            \is_array($response->data)
        ) {
            // Check if any RCB specific option was set
            foreach (\array_keys($response->data) as $key) {
                if (\strpos($key, RCB_OPT_PREFIX, 0) === 0) {
                    /**
                     * Settings got updated in the "Settings" tab.
                     *
                     * @hook RCB/Settings/Updated
                     * @param {WP_HTTP_Response} $response
                     * @param {WP_REST_Request} $request
                     * @return {WP_HTTP_Response}
                     */
                    $response = apply_filters('RCB/Settings/Updated', $response, $request);
                    break;
                }
            }
        }
        return $response;
    }
    /**
     * New instance.
     */
    public static function instance() {
        return new \DevOwl\RealCookieBanner\rest\Config();
    }
}
