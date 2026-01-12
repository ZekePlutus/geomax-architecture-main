<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoMax Module Organization Architecture</title>
    <meta name="description" content="Laravel module organization, billing rules, and authorization architecture for GeoMax SaaS platform.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #0d1117;
            --text-color: #c9d1d9;
            --accent-color: #58a6ff;
            --secondary-bg: #161b22;
            --border-color: #30363d;
            --card-bg: #21262d;
            --success-color: #2ea043;
            --warning-color: #d29922;
            --danger-color: #f85149;
            --purple-color: #a371f7;
            --cyan-color: #56d4dd;
            --font-main: 'Inter', sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-main);
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
            padding: 2rem;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        header {
            text-align: center;
            margin-bottom: 4rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--border-color);
        }

        h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(90deg, #58a6ff, #a371f7, #56d4dd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        h2 {
            font-size: 2rem;
            color: #ffffff;
            margin: 2rem 0 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        h3 {
            font-size: 1.25rem;
            color: var(--accent-color);
            margin: 1.5rem 0 0.5rem;
        }

        h4 {
            font-size: 1.1rem;
            color: var(--cyan-color);
            margin: 1rem 0 0.5rem;
        }

        p {
            margin-bottom: 1rem;
        }

        .section {
            background: var(--secondary-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            transition: transform 0.2s;
        }

        .section:hover {
            transform: translateY(-2px);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .grid-3 {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        }

        .tree-view {
            font-family: var(--font-mono);
            background: var(--card-bg);
            padding: 1.5rem;
            border-radius: 8px;
            overflow-x: auto;
            border-left: 4px solid var(--accent-color);
        }

        .tree-view.purple-border {
            border-left-color: var(--purple-color);
        }

        .tree-view.success-border {
            border-left-color: var(--success-color);
        }

        .tree-view.warning-border {
            border-left-color: var(--warning-color);
        }

        .tree-view.cyan-border {
            border-left-color: var(--cyan-color);
        }

        .tree-line {
            white-space: pre;
            color: #8b949e;
            line-height: 1.5;
        }
        
        .tree-dir { color: #58a6ff; font-weight: bold; }
        .tree-file { color: #7ee787; }
        .tree-comment { color: #8b949e; font-style: italic; }

        .card {
            background: var(--card-bg);
            padding: 1.5rem;
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        .card.featured {
            border: 2px solid var(--purple-color);
            background: linear-gradient(135deg, rgba(163, 113, 247, 0.1), var(--card-bg));
        }

        .card.core {
            border: 2px solid var(--success-color);
            background: linear-gradient(135deg, rgba(46, 160, 67, 0.1), var(--card-bg));
        }

        .card.custom {
            border: 2px solid var(--cyan-color);
            background: linear-gradient(135deg, rgba(86, 212, 221, 0.1), var(--card-bg));
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-right: 0.5rem;
        }

        .badge-success {
            background: rgba(46, 160, 67, 0.2);
            color: #7ee787;
        }

        .badge-warning {
            background: rgba(210, 153, 34, 0.2);
            color: #e3b341;
        }

        .badge-danger {
            background: rgba(248, 81, 73, 0.2);
            color: #f85149;
        }

        .badge-info {
            background: rgba(88, 166, 255, 0.15);
            color: var(--accent-color);
        }

        .badge-purple {
            background: rgba(163, 113, 247, 0.2);
            color: var(--purple-color);
        }

        .badge-cyan {
            background: rgba(86, 212, 221, 0.2);
            color: var(--cyan-color);
        }

        ul {
            list-style-position: inside;
            margin-left: 1rem;
        }

        li {
            margin-bottom: 0.5rem;
        }

        .highlight-box {
            background: rgba(46, 160, 67, 0.1);
            border: 1px solid var(--success-color);
            color: #7ee787;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
        }

        .warning-box {
            background: rgba(210, 153, 34, 0.1);
            border: 1px solid var(--warning-color);
            color: #e3b341;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
        }

        .danger-box {
            background: rgba(248, 81, 73, 0.1);
            border: 1px solid var(--danger-color);
            color: #ffa198;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
        }

        .info-box {
            background: rgba(88, 166, 255, 0.1);
            border: 1px solid var(--accent-color);
            color: #a5d6ff;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
        }

        .purple-box {
            background: rgba(163, 113, 247, 0.1);
            border: 1px solid var(--purple-color);
            color: #d2a8ff;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
        }

        .cyan-box {
            background: rgba(86, 212, 221, 0.1);
            border: 1px solid var(--cyan-color);
            color: #a5f3fc;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        
        th, td {
            text-align: left;
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }
        
        th {
            color: var(--accent-color);
            font-weight: 600;
        }

        .comparison-table {
            background: var(--card-bg);
            border-radius: 8px;
            overflow: hidden;
        }

        .comparison-table th {
            background: var(--secondary-bg);
        }

        .flow-diagram {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
            padding: 2rem;
            background: var(--card-bg);
            border-radius: 8px;
            margin-top: 1rem;
        }

        .flow-step {
            background: var(--secondary-bg);
            border: 2px solid var(--border-color);
            border-radius: 8px;
            padding: 1rem 1.5rem;
            text-align: center;
            min-width: 120px;
        }

        .flow-step.active {
            border-color: var(--success-color);
            background: rgba(46, 160, 67, 0.1);
        }

        .flow-step.warning {
            border-color: var(--warning-color);
            background: rgba(210, 153, 34, 0.1);
        }

        .flow-step.danger {
            border-color: var(--danger-color);
            background: rgba(248, 81, 73, 0.1);
        }

        .flow-arrow {
            color: var(--accent-color);
            font-size: 1.5rem;
        }

        code {
            font-family: var(--font-mono);
            background: var(--card-bg);
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.9rem;
            color: #f0883e;
        }

        pre {
            font-family: var(--font-mono);
            background: var(--card-bg);
            padding: 1rem;
            border-radius: 8px;
            overflow-x: auto;
            margin: 1rem 0;
            font-size: 0.9rem;
        }

        .golden-rule {
            background: linear-gradient(135deg, rgba(210, 153, 34, 0.15), rgba(248, 81, 73, 0.1));
            border: 2px solid var(--warning-color);
            border-radius: 12px;
            padding: 2rem;
            margin: 2rem 0;
            text-align: center;
        }

        .golden-rule h3 {
            color: var(--warning-color);
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .golden-rule p {
            font-size: 1.2rem;
            color: #e3b341;
            margin: 0;
        }

        .icon-large {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .module-type-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .module-type-icon {
            font-size: 2rem;
        }

        @media (max-width: 768px) {
            h1 { font-size: 2rem; }
            .section { padding: 1.5rem; }
            .flow-diagram { flex-direction: column; }
            .flow-arrow { transform: rotate(90deg); }
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h1>📂 Module Organization Architecture</h1>
        <p>How to organize modules & sub-modules in Laravel with authorization, permissions, and billing rules</p>
    </header>

    <!-- SECTION 1: GOLDEN RULE -->
    <div class="golden-rule">
        <h3>🔒 The Golden Billing Rule</h3>
        <p><strong>ONLY leaf modules (modules with NO sub-modules) can be billed.</strong></p>
        <p style="font-size: 1rem; margin-top: 1rem; color: #8b949e;">Folders do NOT define access. Database subscriptions define access.</p>
    </div>

    <!-- SECTION 2: FOLDER STRUCTURE -->
    <div class="section">
        <h2>📁 Laravel Folder Structure</h2>
        <p>Modules are organized in folders, but <strong>billing and permissions are database-driven, not folder-driven</strong>.</p>

        <div class="grid">
            <div class="tree-view">
                <div class="tree-comment"># Recommended Module Structure</div>
                <div class="tree-line" style="margin-top: 0.5rem;"><span class="tree-dir">app/</span></div>
                <div class="tree-line">├── <span class="tree-dir">Modules/</span></div>
                <div class="tree-line">│   ├── <span class="tree-dir">Dispatch/</span></div>
                <div class="tree-line">│   │   ├── <span class="tree-dir">Controllers/</span></div>
                <div class="tree-line">│   │   │   └── <span class="tree-file">DispatchController.php</span></div>
                <div class="tree-line">│   │   ├── <span class="tree-dir">Services/</span></div>
                <div class="tree-line">│   │   ├── <span class="tree-dir">Policies/</span></div>
                <div class="tree-line">│   │   ├── <span class="tree-file">routes.php</span></div>
                <div class="tree-line">│   │   ├── <span class="tree-file">permissions.php</span></div>
                <div class="tree-line">│   │   └── <span class="tree-file">module.json</span></div>
                <div class="tree-line">│   └── <span class="tree-dir">Support/</span></div>
                <div class="tree-line">│       ├── <span class="tree-dir">Controllers/</span></div>
                <div class="tree-line">│       └── ...</div>
                <div class="tree-line">├── <span class="tree-dir">Core/</span></div>
                <div class="tree-line">│   ├── <span class="tree-dir">Billing/</span></div>
                <div class="tree-line">│   ├── <span class="tree-dir">Permissions/</span></div>
                <div class="tree-line">│   └── <span class="tree-dir">ModuleLoader/</span></div>
                <div class="tree-line">└── <span class="tree-dir">Http/</span></div>
                <div class="tree-line">    └── <span class="tree-dir">Middleware/</span></div>
                <div class="tree-line">        ├── <span class="tree-file">CheckModuleActive.php</span></div>
                <div class="tree-line">        ├── <span class="tree-file">CheckModuleOption.php</span></div>
                <div class="tree-line">        └── <span class="tree-file">CheckModulePaid.php</span></div>
            </div>

            <div class="card">
                <h3>📌 Key Principle</h3>
                <ul style="margin-top: 1rem;">
                    <li><strong>Folders</strong> = Code organization</li>
                    <li><strong>Database</strong> = Truth for activation, billing, permissions</li>
                </ul>

                <div class="info-box">
                    <strong>Each module folder contains:</strong>
                    <ul style="margin-top: 0.5rem;">
                        <li><code>Controllers/</code> — Request handlers</li>
                        <li><code>Services/</code> — Business logic</li>
                        <li><code>Policies/</code> — Authorization rules</li>
                        <li><code>routes.php</code> — Module routes</li>
                        <li><code>permissions.php</code> — Permission definitions</li>
                        <li><code>module.json</code> — Module metadata</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 3: MODULE CLASSIFICATION -->
    <div class="section">
        <h2>🧩 Module Classification</h2>
        <p>Three distinct module types with different billing behaviors.</p>

        <div class="grid grid-3" style="margin-top: 1.5rem;">
            <!-- Core Modules -->
            <div class="card core">
                <div class="module-type-header">
                    <span class="module-type-icon">🔒</span>
                    <div>
                        <h3 style="margin: 0;">Core Modules</h3>
                        <span class="badge badge-success">Platform Foundation</span>
                    </div>
                </div>
                <p>Always included. <strong>Never billed. Never disabled.</strong></p>
                <ul>
                    <li>Required for platform operation</li>
                    <li>Always active for every tenant</li>
                    <li>No billing logic</li>
                    <li>No pricing</li>
                    <li>No demo/paid state</li>
                </ul>
                <div class="highlight-box" style="margin-top: 1rem;">
                    <strong>Examples:</strong>
                    <ul style="margin-top: 0.5rem;">
                        <li>Authentication</li>
                        <li>Users & Roles</li>
                        <li>Base Fleet Registry</li>
                        <li>Notifications Engine</li>
                        <li>Audit Logs</li>
                    </ul>
                </div>
            </div>

            <!-- Featured Modules -->
            <div class="card featured">
                <div class="module-type-header">
                    <span class="module-type-icon">⭐</span>
                    <div>
                        <h3 style="margin: 0;">Featured Modules</h3>
                        <span class="badge badge-purple">360° Billable</span>
                    </div>
                </div>
                <p>Official sellable products with <strong>full hybrid billing</strong>.</p>
                <ul>
                    <li>Can be billed in any combination</li>
                    <li>Supports PAID, ZERO, FREE, DISABLED</li>
                    <li>Full pricing inheritance</li>
                    <li>Your monetized SaaS products</li>
                </ul>
                <div class="purple-box" style="margin-top: 1rem;">
                    <strong>Examples:</strong>
                    <ul style="margin-top: 0.5rem;">
                        <li>Fleet Management</li>
                        <li>Camera System</li>
                        <li>Dispatch</li>
                        <li>Fuel Monitoring</li>
                    </ul>
                </div>
            </div>

            <!-- Custom Modules -->
            <div class="card custom">
                <div class="module-type-header">
                    <span class="module-type-icon">🔧</span>
                    <div>
                        <h3 style="margin: 0;">Custom Modules</h3>
                        <span class="badge badge-cyan">Scoped Visibility</span>
                    </div>
                </div>
                <p>Same billing power, <strong>limited visibility</strong>.</p>
                <ul>
                    <li>Created by Provider or Reseller</li>
                    <li>Visible only to their subtree</li>
                    <li>Supports full hybrid billing</li>
                    <li>Can be disabled or removed</li>
                </ul>
                <div class="cyan-box" style="margin-top: 1rem;">
                    <strong>Examples:</strong>
                    <ul style="margin-top: 0.5rem;">
                        <li>Custom ERP Connector</li>
                        <li>Local Compliance Module</li>
                        <li>Company-Specific Reports</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 4: BILLING HIERARCHY RULE -->
    <div class="section">
        <h2>🌳 Billing Hierarchy Rule</h2>
        <p>The conflict-free billing model that scales with your SaaS.</p>

        <div class="grid">
            <div class="card">
                <h3>🔒 The Locked Rule</h3>
                <pre style="color: #7ee787; margin-top: 1rem;">
MODULE BILLING HIERARCHY RULE

1. Core modules
   → never billed

2. Non-core modules
   IF has NO sub-modules
     → module MUST be billable
   IF has sub-modules
     → module NOT billable
     → ONLY sub-modules are billable</pre>

                <div class="warning-box">
                    <strong>🧠 One-Sentence Rule:</strong><br>
                    If it has children → it is NOT billable.<br>
                    If it has no children → it IS billable.
                </div>
            </div>

            <div class="card">
                <h3>✅ Valid vs ❌ Invalid</h3>
                <table style="margin-top: 1rem;">
                    <thead>
                        <tr>
                            <th>Module</th>
                            <th>Type</th>
                            <th>Has Children</th>
                            <th>Billable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Auth</td>
                            <td><span class="badge badge-success">core</span></td>
                            <td>yes</td>
                            <td>❌</td>
                        </tr>
                        <tr>
                            <td>Auth</td>
                            <td><span class="badge badge-success">core</span></td>
                            <td>no</td>
                            <td>❌</td>
                        </tr>
                        <tr>
                            <td>SSO</td>
                            <td><span class="badge badge-purple">featured</span></td>
                            <td>no</td>
                            <td>✅</td>
                        </tr>
                        <tr>
                            <td>Fleet</td>
                            <td><span class="badge badge-purple">featured</span></td>
                            <td>yes</td>
                            <td>❌</td>
                        </tr>
                        <tr>
                            <td>Vehicles</td>
                            <td><span class="badge badge-purple">featured</span></td>
                            <td>no</td>
                            <td>✅</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="highlight-box" style="margin-top: 2rem;">
            <strong>⚠️ Important Exception:</strong> Core modules MAY have non-core (featured/custom) sub-modules, and those sub-modules CAN be billed. This doesn't break the leaf-only rule.
        </div>

        <!-- Core with billable sub-modules example -->
        <div class="tree-view success-border" style="margin-top: 1.5rem;">
            <div class="tree-comment"># Example: Core → Featured Sub-Modules</div>
            <div class="tree-line" style="margin-top: 0.5rem;"><span class="tree-dir">Authentication (CORE)</span> <span class="tree-comment">❌ not billable</span></div>
            <div class="tree-line">├── <span class="tree-file">SSO Integration (FEATURED)</span> <span class="tree-comment">✅ billable</span></div>
            <div class="tree-line">├── <span class="tree-file">Advanced Security Logs (FEATURED)</span> <span class="tree-comment">✅ billable</span></div>
            <div class="tree-line">└── <span class="tree-file">Audit Export (FEATURED)</span> <span class="tree-comment">✅ billable</span></div>
        </div>
    </div>

    <!-- SECTION 5: HYBRID BILLING EXPLAINED -->
    <div class="section">
        <h2>💰 Hybrid Billing Model</h2>
        <p>Parent modules have access fees, sub-modules have variable billing.</p>

        <div class="grid">
            <div class="card">
                <h3>🏠 Parent Module = FLAT (Base Access)</h3>
                <p>The parent module represents:</p>
                <ul>
                    <li>The right to use the product</li>
                    <li>The base infrastructure cost</li>
                    <li>The minimum monthly fee</li>
                </ul>
                <pre style="color: #58a6ff; margin-top: 1rem;">
Camera (FLAT = 5€/month)

✔ Covers:
  - System availability
  - Backend processing
  - Core UI
  - Basic support</pre>
            </div>

            <div class="card">
                <h3>🔢 Sub-Modules = Variable Billing</h3>
                <p>Sub-modules scale with customer activity:</p>
                
                <h4><span class="badge badge-warning">PER_UNIT</span> Count-based</h4>
                <p style="font-size: 0.9rem; color: #8b949e;">Per vehicle, user, camera, device</p>
                
                <h4><span class="badge badge-purple">USAGE</span> Consumption-based</h4>
                <p style="font-size: 0.9rem; color: #8b949e;">Per GB, API call, SMS, minutes</p>
                
                <h4><span class="badge badge-success">TIERED</span> Volume-based</h4>
                <p style="font-size: 0.9rem; color: #8b949e;">Price changes at thresholds</p>
            </div>
        </div>

        <!-- Real Invoice Example -->
        <div class="card" style="margin-top: 2rem;">
            <h3>🧾 Real Invoice Example (Hybrid Billing)</h3>
            <pre style="color: #a5d6ff; font-size: 1rem; margin-top: 1rem;">
INV-2026-0012

Camera Module (Base)............. 5.00 €
Vehicles (10 × 2.00 €).......... 20.00 €
Storage (120 GB × 0.10 €)....... 12.00 €
AI Detection.................... 10.00 €
────────────────────────────────────────
TOTAL........................... 47.00 €</pre>
            <div class="info-box">
                ✔ One product &nbsp; ✔ Multiple billing rules &nbsp; ✔ One invoice &nbsp; ✔ Fully transparent
            </div>
        </div>
    </div>

    <!-- SECTION 5.5: BASE ACCESS PATTERN -->
    <div class="section">
        <h2>🔒 Base Access Pattern (Required Sub-Modules)</h2>
        <p>Handle <strong>base fee + optional add-ons</strong> while keeping the leaf-only billing rule.</p>

        <div class="grid">
            <div class="tree-view warning-border">
                <div class="tree-comment"># Camera Module with Base Access</div>
                <div class="tree-line" style="margin-top: 0.5rem;"><span class="tree-dir">Camera (NOT billable)</span> <span class="tree-comment">← Parent has children</span></div>
                <div class="tree-line">├── <span class="tree-file">🔒 Base Access (FLAT, 10€)</span> <span class="tree-comment">required: true</span></div>
                <div class="tree-line">├── <span class="tree-file">Live Streaming (PER_UNIT, 4€)</span> <span class="tree-comment">required: false</span></div>
                <div class="tree-line">├── <span class="tree-file">Video Storage (USAGE, 0.10€/GB)</span> <span class="tree-comment">required: false</span></div>
                <div class="tree-line">└── <span class="tree-file">AI Detection (FLAT, 15€)</span> <span class="tree-comment">required: false</span></div>
            </div>

            <div class="card">
                <h3>🗄️ modules.required Column</h3>
                <table style="margin-top: 1rem;">
                    <thead>
                        <tr>
                            <th>Value</th>
                            <th>Behavior</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>required = true</code></td>
                            <td><strong>Auto-activated</strong> when any sibling is selected</td>
                        </tr>
                        <tr>
                            <td><code>required = false</code></td>
                            <td>Optional — customer chooses to add or not</td>
                        </tr>
                    </tbody>
                </table>
                <div class="highlight-box" style="margin-top: 1rem;">
                    <strong>Result:</strong> Base fee is always charged when module is used!
                </div>
            </div>
        </div>

        <div class="grid" style="margin-top: 2rem;">
            <div class="card">
                <h3>📊 Database: modules (with required)</h3>
                <table style="margin-top: 1rem; font-size: 0.9rem;">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>parent_id</th>
                            <th>key</th>
                            <th>billing_type</th>
                            <th>required</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>NULL</td>
                            <td>camera</td>
                            <td>—</td>
                            <td>—</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>1</td>
                            <td>camera.base</td>
                            <td>FLAT</td>
                            <td><span class="badge badge-success">true</span></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>1</td>
                            <td>camera.streaming</td>
                            <td>PER_UNIT</td>
                            <td><span class="badge badge-info">false</span></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>1</td>
                            <td>camera.storage</td>
                            <td>USAGE</td>
                            <td><span class="badge badge-info">false</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card">
                <h3>🧠 Engine: Auto-Include Required</h3>
                <pre style="color: #7ee787; margin-top: 1rem;">
// When activating ANY sub-module
$parentId = $module->parent_id;

$requiredModules = Module::where('parent_id', $parentId)
    ->where('required', true)
    ->get();

foreach ($requiredModules as $required) {
    if (!tenant()->hasModule($required)) {
        tenant()->activateModule($required);
    }
}</pre>
            </div>
        </div>

        <div class="card" style="margin-top: 2rem;">
            <h3>🧾 Invoice Example: Base + Add-ons</h3>
            <pre style="color: #a5d6ff; font-size: 1rem; margin-top: 1rem;">
INV-2026-0018

Camera - Base Access (required).... 10.00 €
Live Streaming (10 × 4€)........... 40.00 €
Video Storage (50 GB × 0.10€)...... 5.00 €
──────────────────────────────────────────────
TOTAL.............................. 55.00 €</pre>
            <div class="info-box" style="margin-top: 1rem;">
                ✔ Base fee always charged &nbsp; ✔ Optional add-ons &nbsp; ✔ Leaf-only rule preserved
            </div>
        </div>

        <div class="warning-box" style="margin-top: 1.5rem;">
            <strong>📌 Key Benefits:</strong>
            <ul style="margin-top: 0.5rem;">
                <li><strong>No rule exceptions</strong> — Only leaf modules are billable</li>
                <li><strong>Clear invoices</strong> — Each line is a separate sub-module</li>
                <li><strong>Flexible pricing</strong> — Base can be 0€ for promotions</li>
                <li><strong>Consistent logic</strong> — Same billing engine everywhere</li>
            </ul>
        </div>
    </div>

    <!-- SECTION 6: AUTHORIZATION FLOW -->
    <div class="section">
        <h2>🚦 Authorization Flow</h2>
        <p>The request lifecycle with module, tier, and payment checks.</p>

        <div class="flow-diagram">
            <div class="flow-step">
                <div style="font-size: 1.5rem;">👤</div>
                <div><strong>User Request</strong></div>
                <div style="font-size: 0.8rem; color: #8b949e;">/dispatch/orders</div>
            </div>
            <div class="flow-arrow">→</div>
            <div class="flow-step warning">
                <div style="font-size: 1.5rem;">🔍</div>
                <div><strong>Module Active?</strong></div>
                <div style="font-size: 0.8rem; color: #e3b341;">CheckModuleActive</div>
            </div>
            <div class="flow-arrow">→</div>
            <div class="flow-step warning">
                <div style="font-size: 1.5rem;">⭐</div>
                <div><strong>Tier Allows?</strong></div>
                <div style="font-size: 0.8rem; color: #e3b341;">CheckModuleOption</div>
            </div>
            <div class="flow-arrow">→</div>
            <div class="flow-step warning">
                <div style="font-size: 1.5rem;">💳</div>
                <div><strong>Payment OK?</strong></div>
                <div style="font-size: 0.8rem; color: #e3b341;">CheckModulePaid</div>
            </div>
            <div class="flow-arrow">→</div>
            <div class="flow-step active">
                <div style="font-size: 1.5rem;">✅</div>
                <div><strong>Controller</strong></div>
                <div style="font-size: 0.8rem; color: #7ee787;">Execute</div>
            </div>
        </div>

        <div class="grid" style="margin-top: 2rem;">
            <!-- CheckModuleActive -->
            <div class="card">
                <h3>🔍 CheckModuleActive Middleware</h3>
                <pre style="color: #a5d6ff; margin-top: 1rem;">
public function handle($request, Closure $next, $moduleKey)
{
    $module = Module::where('key', $moduleKey)->first();

    $active = ModuleSubscription::where([
        'tenant_id' => tenant()->id,
        'module_id' => $module->id,
        'status' => 'active'
    ])->exists();

    abort_if(!$active, 403, 'Module not activated');

    return $next($request);
}</pre>
            </div>

            <!-- CheckModuleOption -->
            <div class="card">
                <h3>⭐ CheckModuleOption Middleware</h3>
                <pre style="color: #a5d6ff; margin-top: 1rem;">
public function handle($request, Closure $next, $feature)
{
    $subscription = tenant()
        ->subscriptionForModule($request->module);

    abort_if(
        !$subscription->option->features[$feature],
        403,
        'Upgrade required'
    );

    return $next($request);
}</pre>
            </div>
        </div>

        <!-- Routes Example -->
        <div class="card" style="margin-top: 2rem;">
            <h3>🛣️ Routes Per Module (Example)</h3>
            <p style="color: #8b949e; font-size: 0.9rem;">Modules/Dispatch/routes.php</p>
            <pre style="color: #7ee787; margin-top: 1rem;">
Route::middleware([
    'auth',
    'module.active:dispatch',
    'module.paid:dispatch'
])->group(function () {

    Route::get('/dispatch/orders', [DispatchController::class, 'index'])
        ->middleware('module.option:live_tracking');

});</pre>
            <div class="highlight-box">
                ✔ Clean &nbsp; ✔ Reusable &nbsp; ✔ SaaS-ready
            </div>
        </div>
    </div>

    <!-- SECTION 7: ENGINE DECISION LOGIC -->
    <div class="section">
        <h2>🧠 Billing Engine Decision Tree</h2>
        <p>The algorithm that determines billing for every module.</p>

        <div class="card">
            <pre style="color: #58a6ff; font-size: 1rem;">
IF module.type == core
  → allow access
  → skip billing

ELSE
  FOR each active module + sub-module
    IF pricing_mode == FREE
      → skip invoice item
    IF pricing_mode == ZERO
      → invoice item (0€)
    IF pricing_mode == PAID
      → calculate via billing_type</pre>
        </div>

        <div class="grid" style="margin-top: 2rem;">
            <div class="card">
                <h3>🧮 Pricing Resolution Engine</h3>
                <p>Given a tenant + module, returns the final price & mode:</p>
                <pre style="color: #a5d6ff; margin-top: 1rem;">
{
  "billing_type": "USAGE",
  "pricing_mode": "PAID",
  "unit_price": 0.10,
  "currency": "EUR"
}</pre>
                <ul style="margin-top: 1rem;">
                    <li>Walk up the hierarchy</li>
                    <li>Respect pricing_mode</li>
                    <li>Apply min/max constraints</li>
                </ul>
            </div>

            <div class="card">
                <h3>📊 Pricing Mode Behavior</h3>
                <table>
                    <tr>
                        <td><span class="badge badge-success">PAID</span></td>
                        <td>Normal billing, appears on invoice</td>
                    </tr>
                    <tr>
                        <td><span class="badge badge-warning">ZERO</span></td>
                        <td>0€ on invoice (accounting entry)</td>
                    </tr>
                    <tr>
                        <td><span class="badge badge-info">FREE</span></td>
                        <td>No invoice entry (demos)</td>
                    </tr>
                    <tr>
                        <td><span class="badge badge-danger">DISABLED</span></td>
                        <td>Module not available</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- SECTION 8: RBAC INSIDE MODULES -->
    <div class="section">
        <h2>🔐 Permissions (Database-Driven RBAC)</h2>
        <p>Granular role-based access control — <strong>fully database-driven</strong> for maximum flexibility.</p>

        <div class="grid">
            <div class="card">
                <h3>�️ permissions Table</h3>
                <pre style="color: #7ee787; margin-top: 1rem;">
- id
- module_id        // Which module owns this
- key              // 'dispatch.create'
- name             // 'Create Dispatch Orders'
- description      // Optional explanation
- is_active        // Can be disabled</pre>
                <div class="info-box" style="margin-top: 1rem;">
                    <strong>Why database?</strong> Add permissions without code deployment. Providers can create custom permissions.
                </div>
            </div>

            <div class="card">
                <h3>🗄️ role_permissions Table</h3>
                <pre style="color: #a5d6ff; margin-top: 1rem;">
- id
- role_id          // Which role has this
- permission_id    // Which permission
- tenant_id        // Scoped per tenant</pre>
                <div class="highlight-box" style="margin-top: 1rem;">
                    <strong>Tenant-scoped:</strong> Same role can have different permissions per company.
                </div>
            </div>
        </div>

        <div class="card" style="margin-top: 2rem;">
            <h3>📊 Example: Dispatch Permissions</h3>
            <table style="margin-top: 1rem;">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>module_id</th>
                        <th>key</th>
                        <th>name</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>1</td>
                        <td>dispatch.view</td>
                        <td>View Dispatch Orders</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>1</td>
                        <td>dispatch.create</td>
                        <td>Create Dispatch Orders</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>1</td>
                        <td>dispatch.assign</td>
                        <td>Assign Drivers</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>1</td>
                        <td>dispatch.delete</td>
                        <td>Delete Orders</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="warning-box" style="margin-top: 1.5rem;">
            <strong>🔑 Authorization = 3 Layers:</strong>
            <ul style="margin-top: 0.5rem;">
                <li><strong>ROLE</strong> — What can this user do? (role_permissions)</li>
                <li><strong>MODULE</strong> — Is this feature enabled? (module_subscriptions.status)</li>
                <li><strong>SUBSCRIPTION</strong> — Is this paid/active? (module_subscriptions.is_paid)</li>
            </ul>
        </div>
    </div>

    <!-- SECTION 9: WHAT EACH LEVEL CONTROLS -->
    <div class="section">
        <h2>🎮 What Each Level Controls</h2>
        <p>Clear separation of concerns across the billing hierarchy.</p>

        <div class="comparison-table">
            <table>
                <thead>
                    <tr>
                        <th>Concern</th>
                        <th>Controlled By</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Feature access</strong></td>
                        <td>module_options.features</td>
                    </tr>
                    <tr>
                        <td><strong>Activation</strong></td>
                        <td>module_subscriptions.status</td>
                    </tr>
                    <tr>
                        <td><strong>Demo vs Paid</strong></td>
                        <td>module_pricing.pricing_mode</td>
                    </tr>
                    <tr>
                        <td><strong>Price value</strong></td>
                        <td>module_pricing.price</td>
                    </tr>
                    <tr>
                        <td><strong>Invoice visibility</strong></td>
                        <td>pricing_mode</td>
                    </tr>
                    <tr>
                        <td><strong>Billing logic</strong></td>
                        <td>modules.billing_type (Super Admin only)</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="warning-box" style="margin-top: 1.5rem;">
            <strong>🔒 Non-Negotiable System Rules:</strong>
            <ul style="margin-top: 0.5rem;">
                <li><strong>Rule 1:</strong> Billing type editable ONLY by Super Admin, inherited by all levels</li>
                <li><strong>Rule 2:</strong> If price = NULL → inherit from parent level</li>
                <li><strong>Rule 3:</strong> Pricing mode precedence: DISABLED → FREE → ZERO → PAID</li>
                <li><strong>Rule 4:</strong> FREE mode = No invoice, no accounting, full features</li>
            </ul>
        </div>
    </div>

    <!-- SECTION 10: MIXED SUB-MODULE TYPES -->
    <div class="section">
        <h2>🎨 Mixed Sub-Module Types</h2>
        <p>A parent module can have sub-modules of <strong>different types</strong> and <strong>different pricing modes</strong>.</p>

        <div class="tree-view success-border" style="margin-bottom: 2rem;">
            <div class="tree-comment"># Example: Core Parent with Mixed Sub-Modules</div>
            <div class="tree-line" style="margin-top: 0.5rem;"><span class="tree-dir">Authentication (CORE)</span> <span class="tree-comment">❌ never billed</span></div>
            <div class="tree-line">├── <span class="tree-file">Login & Sessions (CORE)</span> <span class="tree-comment">❌ always included</span></div>
            <div class="tree-line">├── <span class="tree-file">Password Reset (CORE)</span> <span class="tree-comment">❌ always included</span></div>
            <div class="tree-line">├── <span class="tree-file">Two-Factor Auth (FEATURED, PAID)</span> <span class="tree-comment">✅ billable → 5€/mo</span></div>
            <div class="tree-line">├── <span class="tree-file">SSO / SAML (FEATURED, PAID)</span> <span class="tree-comment">✅ billable → 10€/mo</span></div>
            <div class="tree-line">└── <span class="tree-file">Enterprise LDAP (CUSTOM, PAID)</span> <span class="tree-comment">✅ billable → 25€/mo</span></div>
        </div>

        <div class="grid">
            <div class="card">
                <h3>🧠 Two Independent Properties</h3>
                <table style="margin-top: 1rem;">
                    <thead>
                        <tr>
                            <th>Property</th>
                            <th>Controls</th>
                            <th>Values</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Module Type</strong></td>
                            <td>What kind of module</td>
                            <td><code>core</code>, <code>featured</code>, <code>custom</code></td>
                        </tr>
                        <tr>
                            <td><strong>Pricing Mode</strong></td>
                            <td>How it's billed</td>
                            <td><code>PAID</code>, <code>FREE</code>, <code>ZERO</code>, <code>DISABLED</code></td>
                        </tr>
                    </tbody>
                </table>
                <div class="info-box">
                    <strong>These are NOT the same thing:</strong>
                    <ul style="margin-top: 0.5rem;">
                        <li>A <code>featured</code> module can have <code>pricing_mode = FREE</code> (demo)</li>
                        <li>A <code>custom</code> module can have <code>pricing_mode = PAID</code> (billable)</li>
                        <li>A <code>core</code> module always has <code>pricing_mode = N/A</code> (never billed)</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <h3>📊 Complete Possibilities Matrix</h3>
                <table style="margin-top: 1rem;">
                    <thead>
                        <tr>
                            <th>Sub-module Type</th>
                            <th>Pricing Mode</th>
                            <th>Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="badge badge-success">CORE</span></td>
                            <td>N/A</td>
                            <td>❌ Always included, never billed</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-purple">FEATURED</span></td>
                            <td>PAID</td>
                            <td>✅ Billable</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-purple">FEATURED</span></td>
                            <td>FREE</td>
                            <td>❌ Demo mode, not billed</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-purple">FEATURED</span></td>
                            <td>ZERO</td>
                            <td>❌ On invoice as 0€</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-cyan">CUSTOM</span></td>
                            <td>PAID</td>
                            <td>✅ Billable</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-cyan">CUSTOM</span></td>
                            <td>FREE</td>
                            <td>❌ Demo mode, not billed</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="highlight-box" style="margin-top: 1.5rem;">
            <strong>✅ Maximum Flexibility:</strong> This gives you complete control over which features are always free, which are paid add-ons, and which are demo/trial only!
        </div>
    </div>

    <!-- SECTION 11: FREEMIUM MODEL -->
    <div class="section">
        <h2>🆓 Freemium Model (Module Options)</h2>
        <p>Offer a free tier with limits and a paid tier with full features using <strong>module_options</strong>.</p>

        <div class="grid">
            <div class="tree-view purple-border">
                <div class="tree-comment"># Dispatch Module with Tiers</div>
                <div class="tree-line" style="margin-top: 0.5rem;"><span class="tree-dir">Dispatch (MODULE)</span></div>
                <div class="tree-line">├── <span class="tree-file">🆓 Basic (OPTION, FREE)</span></div>
                <div class="tree-line">│   └── features: { "max_stops": 100 }</div>
                <div class="tree-line">└── <span class="tree-file">💎 Advanced (OPTION, PAID)</span></div>
                <div class="tree-line">    └── features: { "max_stops": null }</div>
            </div>

            <div class="card">
                <h3>📦 Tier Comparison</h3>
                <table style="margin-top: 1rem;">
                    <thead>
                        <tr>
                            <th>Feature</th>
                            <th>🆓 Basic</th>
                            <th>💎 Advanced</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Price</strong></td>
                            <td>FREE</td>
                            <td>15€/month</td>
                        </tr>
                        <tr>
                            <td><strong>Stops/month</strong></td>
                            <td>100</td>
                            <td>Unlimited</td>
                        </tr>
                        <tr>
                            <td><strong>Route Optimization</strong></td>
                            <td>❌</td>
                            <td>✅</td>
                        </tr>
                        <tr>
                            <td><strong>Priority Support</strong></td>
                            <td>❌</td>
                            <td>✅</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid" style="margin-top: 2rem;">
            <div class="card">
                <h3>🗄️ Database: modules</h3>
                <table style="margin-top: 1rem;">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>key</th>
                            <th>name</th>
                            <th>type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>dispatch</td>
                            <td>Dispatch</td>
                            <td><span class="badge badge-purple">featured</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card">
                <h3>🗄️ Database: module_options</h3>
                <table style="margin-top: 1rem;">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>module_id</th>
                            <th>key</th>
                            <th>price</th>
                            <th>features</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>1</td>
                            <td>basic</td>
                            <td>0€</td>
                            <td><code>{"max_stops": 100}</code></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>1</td>
                            <td>advanced</td>
                            <td>15€</td>
                            <td><code>{"max_stops": null}</code></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card" style="margin-top: 2rem;">
            <h3>🧠 Feature Limit Check (Engine Logic)</h3>
            <pre style="color: #7ee787; margin-top: 1rem;">
// Check feature limit in middleware or controller
$subscription = tenant()->subscriptionFor('dispatch');
$maxStops = $subscription->option->features['max_stops'];

if ($maxStops !== null && $currentStops >= $maxStops) {
    abort(403, 'Upgrade to Advanced for unlimited stops');
}</pre>
        </div>

        <div class="warning-box" style="margin-top: 1.5rem;">
            <strong>📌 Module Options vs Sub-Modules:</strong>
            <ul style="margin-top: 0.5rem;">
                <li><strong>Module Options</strong> = Tiers that are mutually exclusive (customer picks ONE: Basic OR Advanced)</li>
                <li><strong>Sub-Modules</strong> = Features that can coexist (customer can have Basic + add Route Optimizer)</li>
            </ul>
        </div>
    </div>

    <!-- SECTION 12: TIME-LIMITED TRIALS -->
    <div class="section">
        <h2>⏱️ Time-Limited Trials</h2>
        <p>Resellers can give <strong>paid features FREE for X days</strong> as a trial period.</p>

        <div class="grid">
            <div class="card">
                <h3>🎁 Reseller Gives "Advanced Dispatch" FREE for 30 Days</h3>
                <table style="margin-top: 1rem;">
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th>Value</th>
                            <th>Meaning</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>tenant_id</code></td>
                            <td>123</td>
                            <td>Company receiving trial</td>
                        </tr>
                        <tr>
                            <td><code>module_id</code></td>
                            <td>1</td>
                            <td>Dispatch module</td>
                        </tr>
                        <tr>
                            <td><code>option_id</code></td>
                            <td>2</td>
                            <td>Advanced tier</td>
                        </tr>
                        <tr>
                            <td><code>activated_by</code></td>
                            <td>reseller</td>
                            <td>Who gave access</td>
                        </tr>
                        <tr>
                            <td><code>is_paid</code></td>
                            <td>false</td>
                            <td>No billing during trial</td>
                        </tr>
                        <tr>
                            <td><code>status</code></td>
                            <td>active</td>
                            <td>Currently working</td>
                        </tr>
                        <tr>
                            <td><code>expires_at</code></td>
                            <td>2026-02-08</td>
                            <td>Trial ends in 30 days</td>
                        </tr>
                        <tr>
                            <td><code>auto_deactivate</code></td>
                            <td>true/false</td>
                            <td>What happens at expiry</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card">
                <h3>🔄 What Happens When Trial Ends?</h3>
                <div style="margin-top: 1rem;">
                    <h4><span class="badge badge-danger">auto_deactivate = true</span></h4>
                    <ul>
                        <li>After 30 days → <code>status = 'suspended'</code></li>
                        <li>Customer loses access</li>
                        <li>Must contact reseller to upgrade</li>
                    </ul>
                </div>
                <div style="margin-top: 1.5rem;">
                    <h4><span class="badge badge-success">auto_deactivate = false</span></h4>
                    <ul>
                        <li>After 30 days → <code>pricing_mode = PAID</code></li>
                        <li>Billing starts automatically</li>
                        <li>Appears on next invoice</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="flow-diagram" style="margin-top: 2rem;">
            <div class="flow-step active">
                <div style="font-size: 1.5rem;">🎁</div>
                <div><strong>Trial Started</strong></div>
                <div style="font-size: 0.8rem; color: #7ee787;">Day 1</div>
            </div>
            <div class="flow-arrow">→</div>
            <div class="flow-step">
                <div style="font-size: 1.5rem;">⏳</div>
                <div><strong>Trial Active</strong></div>
                <div style="font-size: 0.8rem; color: #8b949e;">Days 2-29</div>
            </div>
            <div class="flow-arrow">→</div>
            <div class="flow-step warning">
                <div style="font-size: 1.5rem;">⚠️</div>
                <div><strong>Trial Ending</strong></div>
                <div style="font-size: 0.8rem; color: #e3b341;">Day 30</div>
            </div>
            <div class="flow-arrow">→</div>
            <div class="flow-step">
                <div style="font-size: 1.5rem;">💳 / 🔒</div>
                <div><strong>Convert or Suspend</strong></div>
                <div style="font-size: 0.8rem; color: #8b949e;">Day 31</div>
            </div>
        </div>

        <div class="card" style="margin-top: 2rem;">
            <h3>🧠 Trial Expiration Engine (Cron Job)</h3>
            <pre style="color: #a5d6ff; margin-top: 1rem;">
// Daily cron job checks expired trials
$expiredTrials = ModuleSubscription::where('expires_at', '<', now())
    ->where('status', 'active')
    ->where('is_paid', false)
    ->get();

foreach ($expiredTrials as $subscription) {
    if ($subscription->auto_deactivate) {
        // Option 1: Suspend access
        $subscription->status = 'suspended';
        // Send notification email...
    } else {
        // Option 2: Start billing
        $subscription->is_paid = true;
        $subscription->pricing_mode = 'paid';
        // Generate prorated invoice...
    }
    $subscription->save();
}</pre>
        </div>

        <div class="grid" style="margin-top: 2rem;">
            <div class="card">
                <h3>👁️ Reseller's Dashboard View</h3>
                <table style="margin-top: 1rem;">
                    <thead>
                        <tr>
                            <th>Company</th>
                            <th>Module</th>
                            <th>Tier</th>
                            <th>Status</th>
                            <th>Trial Ends</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>ABC Corp</td>
                            <td>Dispatch</td>
                            <td>Advanced</td>
                            <td><span class="badge badge-info">🆓 Trial</span></td>
                            <td>15 days left</td>
                        </tr>
                        <tr>
                            <td>XYZ Ltd</td>
                            <td>Dispatch</td>
                            <td>Advanced</td>
                            <td><span class="badge badge-warning">🆓 Trial</span></td>
                            <td>3 days left</td>
                        </tr>
                        <tr>
                            <td>123 Inc</td>
                            <td>Dispatch</td>
                            <td>Advanced</td>
                            <td><span class="badge badge-success">💰 Paid</span></td>
                            <td>—</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card featured">
                <h3>🎁 Marketing Offer Template</h3>
                <div style="background: var(--card-bg); border-radius: 8px; padding: 1.5rem; margin-top: 1rem; text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">🚀</div>
                    <h4 style="color: var(--purple-color); margin: 0;">Try Advanced Dispatch FREE!</h4>
                    <ul style="text-align: left; margin-top: 1rem;">
                        <li>✔ 30 days full access</li>
                        <li>✔ No credit card required</li>
                        <li>✔ Auto-converts to 15€/month</li>
                        <li>✔ Cancel anytime during trial</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="highlight-box" style="margin-top: 1.5rem;">
            <strong>🔑 Key Fields for Trials:</strong>
            <ul style="margin-top: 0.5rem;">
                <li><code>pricing_mode</code> — FREE (no invoice) vs PAID (invoice)</li>
                <li><code>is_paid</code> — Currently billing or not</li>
                <li><code>expires_at</code> — When trial/subscription ends</li>
                <li><code>auto_deactivate</code> — Suspend vs Convert when expired</li>
                <li><code>activated_by</code> — Who gave this access (reseller/provider)</li>
            </ul>
        </div>
    </div>

    <!-- SECTION 13: WHY THIS ARCHITECTURE WORKS -->
    <div class="section">
        <h2>✅ Why This Architecture Works</h2>
        
        <div class="grid" style="grid-template-columns: repeat(3, 1fr);">
            <div class="card">
                <div class="icon-large">🧩</div>
                <h3 style="margin: 0;">For Providers</h3>
                <ul style="margin-top: 1rem;">
                    <li>Sell same app to many resellers</li>
                    <li>Charge only activated modules</li>
                    <li>No code duplication</li>
                </ul>
            </div>
            <div class="card">
                <div class="icon-large">🏪</div>
                <h3 style="margin: 0;">For Resellers</h3>
                <ul style="margin-top: 1rem;">
                    <li>Give FREE working demo</li>
                    <li>Activate billing later</li>
                    <li>Customize modules per client</li>
                </ul>
            </div>
            <div class="card">
                <div class="icon-large">🏢</div>
                <h3 style="margin: 0;">For Companies</h3>
                <ul style="margin-top: 1rem;">
                    <li>Pay only what they use</li>
                    <li>Upgrade/downgrade anytime</li>
                    <li>No reinstall needed</li>
                </ul>
            </div>
        </div>

        <div class="grid" style="margin-top: 2rem; grid-template-columns: repeat(3, 1fr);">
            <div class="card">
                <h3>🚫 No Conflicts</h3>
                <p>Leaf-only billing eliminates double charging</p>
            </div>
            <div class="card">
                <h3>📄 Clean Invoices</h3>
                <p>Each line has clear meaning</p>
            </div>
            <div class="card">
                <h3>🎁 Demo-Friendly</h3>
                <p>FREE mode enables risk-free trials</p>
            </div>
        </div>
        
        <p style="text-align: center; margin-top: 2rem; font-size: 1.2rem; font-weight: bold; color: var(--success-color);">
            Database-Driven Modules + Leaf Billing = Enterprise-Ready SaaS
        </p>
    </div>

    <!-- SECTION 11: QUICK REFERENCE -->
    <div class="section">
        <h2>📌 Quick Reference</h2>
        
        <div class="grid">
            <div class="card">
                <h3>Module Types</h3>
                <table>
                    <tr>
                        <td><span class="badge badge-success">CORE</span></td>
                        <td>Never billed, always active</td>
                    </tr>
                    <tr>
                        <td><span class="badge badge-purple">FEATURED</span></td>
                        <td>Official products, full billing</td>
                    </tr>
                    <tr>
                        <td><span class="badge badge-cyan">CUSTOM</span></td>
                        <td>Provider/Reseller specific</td>
                    </tr>
                </table>
            </div>

            <div class="card">
                <h3>Billing Types</h3>
                <table>
                    <tr>
                        <td><span class="badge badge-info">FLAT</span></td>
                        <td>Monthly base fee</td>
                    </tr>
                    <tr>
                        <td><span class="badge badge-warning">PER_UNIT</span></td>
                        <td>Per vehicle / user / device</td>
                    </tr>
                    <tr>
                        <td><span class="badge badge-purple">USAGE</span></td>
                        <td>Per GB / API call / SMS</td>
                    </tr>
                    <tr>
                        <td><span class="badge badge-success">TIERED</span></td>
                        <td>Volume-based pricing</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="info-box" style="margin-top: 2rem;">
            <strong>🏆 Industry Standard:</strong> This architecture matches how Stripe, AWS, Twilio, and other serious SaaS platforms handle modular billing. Leaf-only billing is the safest, cleanest, most scalable model.
        </div>
    </div>

</div>

</body>
</html>
