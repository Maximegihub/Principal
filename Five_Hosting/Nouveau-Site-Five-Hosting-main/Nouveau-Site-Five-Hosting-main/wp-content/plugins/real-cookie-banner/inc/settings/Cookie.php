<?php

namespace DevOwl\RealCookieBanner\settings;

use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\Core;
use WP_Error;
use WP_Post;
use WP_REST_Posts_Controller;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Register cookie custom post type.
 */
class Cookie {
    use UtilsProvider;
    const CPT_NAME = 'rcb-cookie';
    const META_NAME_PROVIDER = 'provider';
    const META_NAME_CONSENT_FORWARDING_UNIQUE_NAME = 'consentForwardingUniqueName';
    const META_NAME_NO_TECHNICAL_DEFINITIONS = 'noTechnicalDefinitions';
    const META_NAME_LEGAL_BASIS = 'legalBasis';
    const META_NAME_EPRIVACY_USA = 'ePrivacyUSA';
    const META_NAME_TECHNICAL_DEFINITIONS = 'technicalDefinitions';
    const META_NAME_CODE_DYNAMICS = 'codeDynamics';
    const META_NAME_PROVIDER_PRIVACY_POLICY = 'providerPrivacyPolicy';
    const META_NAME_THIS_IS_GOOGLE_TAG = 'thisIsGoogleTagManager';
    const META_NAME_GOOGLE_TAG_IN_EVENT_NAME = 'googleTagManagerInEventName';
    const META_NAME_GOOGLE_TAG_OUT_EVENT_NAME = 'googleTagManagerOutEventName';
    const META_NAME_THIS_IS_MATOMO_TAG = 'thisIsMatomoTagManager';
    const META_NAME_MATOMO_TAG_IN_EVENT_NAME = 'matomoTagManagerInEventName';
    const META_NAME_MATOMO_TAG_OUT_EVENT_NAME = 'matomoTagManagerOutEventName';
    const META_NAME_CODE_OPT_IN = 'codeOptIn';
    const META_NAME_CODE_OPT_IN_NO_GOOGLE_TAG_MANAGER = 'codeOptInNoGoogleTagManager';
    const META_NAME_CODE_OPT_IN_NO_MATOMO_TAG_MANAGER = 'codeOptInNoMatomoTagManager';
    const META_NAME_CODE_OPT_OUT = 'codeOptOut';
    const META_NAME_CODE_OPT_OUT_NO_GOOGLE_TAG_MANAGER = 'codeOptOutNoGoogleTagManager';
    const META_NAME_CODE_OPT_OUT_NO_MATOMO_TAG_MANAGER = 'codeOptOutNoMatomoTagManager';
    const META_NAME_CODE_OPT_OUT_DELETE = 'codeOptOutDelete';
    const META_NAME_CODE_ON_PAGE_LOAD = 'codeOnPageLoad';
    const SYNC_META_COPY = [
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CONSENT_FORWARDING_UNIQUE_NAME,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_NO_TECHNICAL_DEFINITIONS,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_LEGAL_BASIS,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_EPRIVACY_USA,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_TECHNICAL_DEFINITIONS,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_DYNAMICS,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_THIS_IS_GOOGLE_TAG,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_GOOGLE_TAG_IN_EVENT_NAME,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_GOOGLE_TAG_OUT_EVENT_NAME,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_THIS_IS_MATOMO_TAG,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_MATOMO_TAG_IN_EVENT_NAME,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_MATOMO_TAG_OUT_EVENT_NAME,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_OPT_IN,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_OPT_IN_NO_GOOGLE_TAG_MANAGER,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_OPT_IN_NO_MATOMO_TAG_MANAGER,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_OPT_OUT,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_OPT_OUT_NO_GOOGLE_TAG_MANAGER,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_OPT_OUT_NO_MATOMO_TAG_MANAGER,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_OPT_OUT_DELETE,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_ON_PAGE_LOAD,
        \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_PRESET_ID,
        \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_PRESET_VERSION
    ];
    const SYNC_META_COPY_ONCE = [
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_PROVIDER,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_PROVIDER_PRIVACY_POLICY
    ];
    const TECHNICAL_HANDLING_META_COLLECTION = [
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_THIS_IS_GOOGLE_TAG,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_GOOGLE_TAG_IN_EVENT_NAME,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_GOOGLE_TAG_OUT_EVENT_NAME,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_THIS_IS_MATOMO_TAG,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_MATOMO_TAG_IN_EVENT_NAME,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_MATOMO_TAG_OUT_EVENT_NAME,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_OPT_IN,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_OPT_IN_NO_GOOGLE_TAG_MANAGER,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_OPT_IN_NO_MATOMO_TAG_MANAGER,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_OPT_OUT,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_OPT_OUT_NO_GOOGLE_TAG_MANAGER,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_OPT_OUT_NO_MATOMO_TAG_MANAGER,
        // Cookie::META_NAME_CODE_OPT_OUT_DELETE,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_ON_PAGE_LOAD
    ];
    const SYNC_OPTIONS = [
        'data' => ['menu_order'],
        'taxonomies' => [\DevOwl\RealCookieBanner\settings\CookieGroup::TAXONOMY_NAME],
        'meta' => [
            'copy' => \DevOwl\RealCookieBanner\settings\Cookie::SYNC_META_COPY,
            'copy-once' => \DevOwl\RealCookieBanner\settings\Cookie::SYNC_META_COPY_ONCE
        ]
    ];
    const META_KEYS = [
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_PROVIDER,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CONSENT_FORWARDING_UNIQUE_NAME,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_NO_TECHNICAL_DEFINITIONS,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_LEGAL_BASIS,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_EPRIVACY_USA,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_TECHNICAL_DEFINITIONS,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_DYNAMICS,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_PROVIDER_PRIVACY_POLICY,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_THIS_IS_GOOGLE_TAG,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_GOOGLE_TAG_IN_EVENT_NAME,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_GOOGLE_TAG_OUT_EVENT_NAME,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_THIS_IS_MATOMO_TAG,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_MATOMO_TAG_IN_EVENT_NAME,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_MATOMO_TAG_OUT_EVENT_NAME,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_OPT_IN,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_OPT_IN_NO_GOOGLE_TAG_MANAGER,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_OPT_IN_NO_MATOMO_TAG_MANAGER,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_OPT_OUT,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_OPT_OUT_NO_GOOGLE_TAG_MANAGER,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_OPT_OUT_NO_MATOMO_TAG_MANAGER,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_OPT_OUT_DELETE,
        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_ON_PAGE_LOAD,
        \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_PRESET_ID
    ];
    const LEGAL_BASIS_CONSENT = 'consent';
    const LEGAL_BASIS_LEGITIMATE_INTEREST = 'legitimate-interest';
    /**
     * This capabilities are added to the role.
     *
     * @see https://developer.wordpress.org/reference/functions/register_post_type/#capabilities
     */
    const CAPABILITIES = [
        'edit_%s',
        'read_%s',
        'delete_%s',
        // Primitive capabilities used outside of map_meta_cap():
        'edit_%ss',
        'edit_others_%ss',
        'publish_%ss',
        'read_private_%ss',
        // Primitive capabilities used within map_meta_cap():
        'delete_%ss',
        'delete_private_%ss',
        'delete_published_%ss',
        'delete_others_%ss',
        'edit_private_%ss',
        'edit_published_%ss',
        'edit_%ss'
    ];
    /**
     * Singleton instance.
     *
     * @var Cookie
     */
    private static $me = null;
    private $cacheGetOrdered = [];
    /**
     * C'tor.
     */
    private function __construct() {
        // Silence is golden.
    }
    /**
     * Register capabilities to administrator role to allow cookie management.
     *
     * @see https://wordpress.stackexchange.com/a/290093/83335
     * @see https://wordpress.stackexchange.com/a/257401/83335
     */
    public function register_cap() {
        foreach (wp_roles()->roles as $key => $value) {
            $role = get_role($key);
            if ($role->has_cap('manage_options')) {
                foreach (self::CAPABILITIES as $cap) {
                    $role->add_cap(\sprintf($cap, self::CPT_NAME));
                }
            }
        }
    }
    /**
     * Register custom post type.
     */
    public function register() {
        $labels = ['name' => __('Cookies', RCB_TD), 'singular_name' => __('Cookie', RCB_TD)];
        $args = [
            'label' => $labels['name'],
            'labels' => $labels,
            'description' => '',
            'public' => \false,
            'publicly_queryable' => \false,
            'show_ui' => \true,
            'show_in_rest' => \true,
            'rest_base' => self::CPT_NAME,
            'rest_controller_class' => \WP_REST_Posts_Controller::class,
            'has_archive' => \false,
            'show_in_menu' => \false,
            'show_in_nav_menus' => \false,
            'delete_with_user' => \false,
            'exclude_from_search' => \true,
            'capability_type' => self::CPT_NAME,
            'map_meta_cap' => \true,
            'hierarchical' => \false,
            'rewrite' => \false,
            'query_var' => \true,
            'supports' => ['title', 'editor', 'custom-fields', 'page-attributes']
        ];
        register_post_type(self::CPT_NAME, $args);
        register_meta('post', \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_PRESET_ID, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'string',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        register_meta('post', \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_PRESET_VERSION, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'number',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        register_meta('post', self::META_NAME_PROVIDER, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'string',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        register_meta('post', self::META_NAME_CONSENT_FORWARDING_UNIQUE_NAME, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'string',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        register_meta('post', self::META_NAME_LEGAL_BASIS, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'string',
            'single' => \true,
            'default' => self::LEGAL_BASIS_CONSENT,
            'show_in_rest' => [
                'schema' => [
                    'type' => 'string',
                    'enum' => [self::LEGAL_BASIS_CONSENT, self::LEGAL_BASIS_LEGITIMATE_INTEREST]
                ]
            ]
        ]);
        register_meta('post', self::META_NAME_EPRIVACY_USA, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'boolean',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        register_meta('post', self::META_NAME_NO_TECHNICAL_DEFINITIONS, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'boolean',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        // This meta is stored as JSON (this shouldn't be done usually - 3rd normal form - but it's ok here)
        register_meta('post', self::META_NAME_TECHNICAL_DEFINITIONS, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'string',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        // This meta is stored as JSON (this shouldn't be done usually - 3rd normal form - but it's ok here)
        register_meta('post', self::META_NAME_CODE_DYNAMICS, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'string',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        register_meta('post', self::META_NAME_PROVIDER_PRIVACY_POLICY, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'string',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        register_meta('post', self::META_NAME_CODE_OPT_IN, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'string',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        register_meta('post', self::META_NAME_CODE_OPT_IN_NO_GOOGLE_TAG_MANAGER, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'boolean',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        register_meta('post', self::META_NAME_CODE_OPT_IN_NO_MATOMO_TAG_MANAGER, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'boolean',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        register_meta('post', self::META_NAME_CODE_OPT_OUT, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'string',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        register_meta('post', self::META_NAME_CODE_OPT_OUT_NO_GOOGLE_TAG_MANAGER, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'boolean',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        register_meta('post', self::META_NAME_CODE_OPT_OUT_NO_MATOMO_TAG_MANAGER, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'boolean',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        register_meta('post', self::META_NAME_CODE_OPT_OUT_DELETE, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'boolean',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        register_meta('post', self::META_NAME_CODE_ON_PAGE_LOAD, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'string',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        register_meta('post', self::META_NAME_THIS_IS_GOOGLE_TAG, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'boolean',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        register_meta('post', self::META_NAME_GOOGLE_TAG_IN_EVENT_NAME, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'string',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        register_meta('post', self::META_NAME_GOOGLE_TAG_OUT_EVENT_NAME, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'string',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        register_meta('post', self::META_NAME_THIS_IS_MATOMO_TAG, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'boolean',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        register_meta('post', self::META_NAME_MATOMO_TAG_IN_EVENT_NAME, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'string',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        register_meta('post', self::META_NAME_MATOMO_TAG_OUT_EVENT_NAME, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'string',
            'single' => \true,
            'show_in_rest' => \true
        ]);
    }
    /**
     * Get all available cookies ordered by group. You also get a `metas` property
     * in the returned WP_Post instance with all RCB-relevant metas.
     *
     * @param int $groupId
     * @param boolean $force
     * @param WP_Post[] $usePosts If set, only meta is applied to the passed posts
     * @return WP_Post[]|WP_Error
     */
    public function getOrdered($groupId, $force = \false, $usePosts = null) {
        if ($force === \false && isset($this->cacheGetOrdered[$groupId]) && $usePosts === null) {
            return $this->cacheGetOrdered[$groupId];
        }
        $posts = [];
        if ($usePosts) {
            $allPosts = $usePosts;
        } else {
            // Make 'all' cache context-depending to avoid WPML / PolyLang issues (e. g. request new consent)
            $allKey = 'all-' . \DevOwl\RealCookieBanner\settings\Revision::getInstance()->getContextVariablesString();
            if ($force === \false && isset($this->cacheGetOrdered[$allKey])) {
                $allPosts = $this->cacheGetOrdered[$allKey];
            } else {
                $allPosts = $this->cacheGetOrdered[$allKey] = get_posts(
                    \DevOwl\RealCookieBanner\Core::getInstance()->queryArguments(
                        [
                            'post_type' => self::CPT_NAME,
                            'orderby' => ['menu_order' => 'ASC', 'ID' => 'DESC'],
                            'numberposts' => -1,
                            'nopaging' => \true,
                            'post_status' => 'publish'
                        ],
                        'cookiesGetOrdered'
                    )
                );
            }
        }
        // Filter terms to only get services for this requested group
        if ($groupId !== null) {
            foreach ($allPosts as $post) {
                $terms = get_the_terms($post->ID, \DevOwl\RealCookieBanner\settings\CookieGroup::TAXONOMY_NAME);
                if (\is_array($terms) && \count($terms) > 0 && $terms[0]->term_id === $groupId) {
                    $posts[] = $post;
                }
            }
        } else {
            $posts = $allPosts;
        }
        foreach ($posts as &$post) {
            $post->metas = [];
            foreach (self::META_KEYS as $meta_key) {
                $metaValue = get_post_meta($post->ID, $meta_key, \true);
                switch ($meta_key) {
                    case self::META_NAME_TECHNICAL_DEFINITIONS:
                        $metaValue = \json_decode($metaValue, ARRAY_A);
                        foreach ($metaValue as $key => $definition) {
                            $metaValue[$key]['duration'] = \intval(
                                isset($definition['duration']) ? $definition['duration'] : 0
                            );
                        }
                        break;
                    case self::META_NAME_CODE_DYNAMICS:
                        $metaValue = \json_decode($metaValue, ARRAY_A);
                        break;
                    case self::META_NAME_NO_TECHNICAL_DEFINITIONS:
                    case self::META_NAME_EPRIVACY_USA:
                    case self::META_NAME_THIS_IS_GOOGLE_TAG:
                    case self::META_NAME_THIS_IS_MATOMO_TAG:
                    case self::META_NAME_CODE_OPT_IN_NO_GOOGLE_TAG_MANAGER:
                    case self::META_NAME_CODE_OPT_IN_NO_MATOMO_TAG_MANAGER:
                    case self::META_NAME_CODE_OPT_OUT_NO_GOOGLE_TAG_MANAGER:
                    case self::META_NAME_CODE_OPT_OUT_NO_MATOMO_TAG_MANAGER:
                    case self::META_NAME_CODE_OPT_OUT_DELETE:
                        $metaValue = \boolval($metaValue);
                        break;
                    case \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_PRESET_VERSION:
                        $metaValue = \intval($metaValue);
                        break;
                    default:
                        break;
                }
                $post->metas[$meta_key] = $metaValue;
            }
        }
        if ($usePosts === null) {
            $this->cacheGetOrdered[$groupId] = $posts;
        }
        return $posts;
    }
    /**
     * Get unassigned services (cookies without cookie group).
     */
    public function getUnassignedCookies() {
        return get_posts(
            \DevOwl\RealCookieBanner\Core::getInstance()->queryArguments(
                [
                    'post_type' => \DevOwl\RealCookieBanner\settings\Cookie::CPT_NAME,
                    'numberposts' => -1,
                    'nopaging' => \true,
                    'post_status' => ['publish', 'private', 'draft'],
                    'tax_query' => [
                        [
                            // https://wordpress.stackexchange.com/a/252102/83335
                            'taxonomy' => \DevOwl\RealCookieBanner\settings\CookieGroup::TAXONOMY_NAME,
                            'operator' => 'NOT EXISTS'
                        ]
                    ]
                ],
                'cookiesUnassigned'
            )
        );
    }
    /**
     * Get a total count of published cookies.
     *
     * @return int
     */
    public function getPublicCount() {
        return \intval(wp_count_posts(self::CPT_NAME)->publish);
    }
    /**
     * Get a total count of all cookies.
     *
     * @return int
     */
    public function getAllCount() {
        return \array_sum(\array_map('intval', \array_values((array) wp_count_posts(self::CPT_NAME))));
    }
    /**
     * Get singleton instance.
     *
     * @return Cookie
     * @codeCoverageIgnore
     */
    public static function getInstance() {
        return self::$me === null ? (self::$me = new \DevOwl\RealCookieBanner\settings\Cookie()) : self::$me;
    }
}
