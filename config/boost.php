<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Boost Master Switch
    |--------------------------------------------------------------------------
    |
    | This option may be used to disable all Boost functionality - which
    | will prevent Boost's routes from being registered and will also
    | disable Boost's browser logging functionality from operating.
    |
    */

    'enabled' => env('BOOST_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Boost Browser Logs Watcher
    |--------------------------------------------------------------------------
    |
    | The following option may be used to enable or disable the browser logs
    | watcher feature within Laravel Boost. The log watcher will read any
    | errors within the browser's console to give Boost better context.
    */

    'browser_logs_watcher' => env('BOOST_BROWSER_LOGS_WATCHER', true),

    /*
    |--------------------------------------------------------------------------
    | SaaS Governance Files
    |--------------------------------------------------------------------------
    |
    | The following files are injected from the saas-governance-runtime
    | submodule to provide governance rules and capability definitions.
    |
    */

    'governance' => [
        'saas_governance' => base_path('saas-governance-runtime/governance/SaaS-Governance-v1.0.0.md'),
        'capability_registry' => base_path('saas-governance-runtime/governance/capability-registry.yaml'),
    ],

    'mcp_prompts' => [
        'governance' => base_path('saas-governance-runtime/mcp/prompt-pack-0-governance.txt'),
        'capability' => base_path('saas-governance-runtime/mcp/prompt-pack-1-capability.txt'),
        'execution' => base_path('saas-governance-runtime/mcp/prompt-pack-4-execution.txt'),
    ],

];
