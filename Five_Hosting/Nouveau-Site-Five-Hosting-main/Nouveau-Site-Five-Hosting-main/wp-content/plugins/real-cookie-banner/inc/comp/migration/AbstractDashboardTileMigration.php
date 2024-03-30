<?php

namespace DevOwl\RealCookieBanner\comp\migration;

use DevOwl\RealCookieBanner\Assets;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\Core;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Allow to define a list of migrations in our dashboard.
 */
abstract class AbstractDashboardTileMigration {
    use UtilsProvider;
    const OPTION_NAME_CLICKED_ACTIONS = RCB_OPT_PREFIX . '-migration-actions-clicked';
    private $id;
    /**
     * A set of actions which can be made within this migration.
     * See also `$this::addAction`.
     */
    private $actions = [];
    /**
     * C'tor. Register your actions with `$this::addAction` here!
     */
    public function __construct() {
        $this->init();
    }
    /**
     * Initialize hooks.
     */
    protected function init() {
        if (
            $this->isActive() &&
            !\DevOwl\RealCookieBanner\Core::getInstance()
                ->getConfigPage()
                ->isVisible()
        ) {
            add_filter('RCB/Menu/ConfigPage/Attention', '__return_true');
        }
        // Allow to dismiss this via action
        add_action('RCB/Migration/Dismiss/' . $this->getId(), [$this, 'dismiss']);
        // Initially create this option
        add_option(self::OPTION_NAME_CLICKED_ACTIONS, []);
    }
    /**
     * Get a unique id for this migration.
     *
     * @return string
     */
    abstract public function getId();
    /**
     * Get a headline for this migration.
     *
     * @return string
     */
    abstract public function getHeadline();
    /**
     * Get a description for this migration.
     *
     * @return string
     */
    abstract public function getDescription();
    /**
     * Check if this migration is active.
     *
     * @return boolean
     */
    abstract public function isActive();
    /**
     * Dismiss this migration.
     *
     * @return boolean
     */
    abstract public function dismiss();
    /**
     * Register a new action which can be made for this migration.
     *
     * Arguments:
     * - `[linkText] (string)` Can be `null` to disable the link
     * - `[confirmText] (string)` The user needs to confirm this migration with something like "Are you sure?"
     * - `[callback] (callback|string)` Can be `null`, a callback which is executed when clicking the link or a direct URL
     * - `[previewImage] (string)` Absolute URL to preview image
     *
     * @param string $id Unique action ID
     * @param string $title
     * @param string $description
     * @param array $args Arguments, see above
     */
    public function addAction($id, $title, $description, $args = []) {
        $args = wp_parse_args($args, [
            'linkText' => null,
            'linkDisabled' => \false,
            'confirmText' => null,
            'callback' => null,
            'previewImage' => null
        ]);
        $this->actions[$id] = \array_merge(
            [
                'id' => $id,
                'title' => $title,
                'description' => $description,
                'performed' => get_option(self::OPTION_NAME_CLICKED_ACTIONS, [])[$this->getId() . '-' . $id] ?? \false
            ],
            $args
        );
        if (\is_callable($args['callback'])) {
            add_filter('RCB/Migration/' . $this->getId() . '/' . $id, function ($result) use ($args, $id) {
                $result = $args['callback']($result);
                // Save that this action was performed by this user
                if ($result['success']) {
                    $clickedActions = get_option(self::OPTION_NAME_CLICKED_ACTIONS, []);
                    $clickedActions[$this->getId() . '-' . $id] = mysql2date('c', current_time('mysql'), \false);
                    update_option(self::OPTION_NAME_CLICKED_ACTIONS, $clickedActions);
                }
                return $result;
            });
        }
        return $this;
    }
    /**
     * Get the migration as plain array so it can be consumed in the frontend.
     *
     * @param array $array
     */
    public function revisionCurrent($array) {
        if ($this->isActive()) {
            $array['dashboardMigration'] = [
                'id' => $this->getId(),
                'headline' => $this->getHeadline(),
                'description' => $this->getDescription(),
                'actions' => $this->actions
            ];
        }
        return $array;
    }
    /**
     * Get a config URL pointing to a given route (react-router).
     *
     * @param string $route
     */
    public function getConfigUrl($route) {
        $configUrl = \DevOwl\RealCookieBanner\Core::getInstance()
            ->getConfigPage()
            ->getUrl();
        return \sprintf('%s#%s', $configUrl, $route);
    }
    /**
     * Check if a given major version was previously installed.
     *
     * @param int $majorVersion
     */
    public function hasMajorPreviouslyInstalled($majorVersion) {
        return \array_search(
            $majorVersion,
            \array_map(
                function ($v) {
                    return \intval(\explode('.', $v)[0]);
                },
                \DevOwl\RealCookieBanner\Core::getInstance()
                    ->getActivator()
                    ->getPreviousDatabaseVersions()
            ),
            \true
        ) !== \false;
    }
    /**
     * Dismiss the migration by removing a major version from the previously installed versions.
     *
     * @param int $majorVersion
     */
    public function removeMajorVersionFromPreviouslyInstalled($majorVersion) {
        \DevOwl\RealCookieBanner\Core::getInstance()
            ->getActivator()
            ->removePreviousPersistedVersions(function ($v) use ($majorVersion) {
                return \intval(\explode('.', $v)[0]) !== $majorVersion;
            });
    }
    /**
     * Dismiss a migration by ID.
     *
     * @param string $migrationId
     */
    public static function doDismiss($migrationId) {
        /**
         * Dismiss a migration by ID.
         *
         * @hook RCB/Migration/Dismiss/$migrationId
         * @since 2.0.0
         */
        do_action('RCB/Migration/Dismiss/' . $migrationId);
    }
    /**
     * Start a given migration by ID.
     *
     * @param string $migrationId
     * @param string $actionId
     */
    public static function doAction($migrationId, $actionId) {
        /**
         * Start a given migration by ID and action ID.
         *
         * You can extend the `$result` with the additional properties:
         *
         * - `redirect`: Redirect to this URL after successful migration.
         *
         * @hook RCB/Migration/$migrationId/$actionId
         * @param {array} $result
         * @return {array|WP_Error}
         * @since 2.0.0
         */
        return apply_filters('RCB/Migration/' . $migrationId . '/' . $actionId, ['success' => \false]);
    }
}
