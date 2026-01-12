<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoMax Platform Architecture</title>
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
            background: linear-gradient(90deg, #58a6ff, #8b949e);
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

        .tree-view {
            font-family: var(--font-mono);
            background: var(--card-bg);
            padding: 1.5rem;
            border-radius: 8px;
            overflow-x: auto;
            border-left: 4px solid var(--accent-color);
        }

        .tree-line {
            white-space: pre;
            color: #8b949e;
            line-height: 1.5;
        }
        
        .tree-dir { color: #58a6ff; font-weight: bold; }
        .tree-comment { color: #8b949e; font-style: italic; }

        .card {
            background: var(--card-bg);
            padding: 1.5rem;
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            background: rgba(88, 166, 255, 0.15);
            color: var(--accent-color);
            margin-right: 0.5rem;
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
        }

        @media (max-width: 768px) {
            h1 { font-size: 2rem; }
            .section { padding: 1.5rem; }
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h1>GeoMax Platform Architecture</h1>
        <p>A scalable, modular, and developer-friendly architecture for multi-product SaaS.</p>
    </header>

    <!-- SECTION 1: GLOBAL OVERVIEW -->
    <div class="section">
        <h2>🔍 High-Level Overview</h2>
        <p>Each product is a <strong>fully independent Laravel application</strong> with its own authentication, permissions, and business logic. This ensures complete isolation and allows each team to move at their own pace.</p>
            <div class="tree-view">
            <div class="tree-comment"># 🚀 Independent Laravel Applications (Hosted Separately)</div>
            <div class="tree-line" style="margin-top: 0.5rem;"><span class="tree-dir">fleet-app/</span>            <span class="tree-comment">← Fleet Management Product (own auth & permissions)</span></div>
            <div class="tree-line"><span class="tree-dir">tms-app/</span>              <span class="tree-comment">← Transport Management Product (own auth & permissions)</span></div>
            <div class="tree-line"><span class="tree-dir">planner-app/</span>          <span class="tree-comment">← Route / Task Planning Product (own auth & permissions)</span></div>
        </div>


        
        <div class="highlight-box">
            <strong>Key Takeaways:</strong>
            <ul>
                <li>Each product = One distinct Laravel app with its own Auth, Permissions & Libraries</li>
                <li>No product depends directly on another code-wise</li>
                <li>Complete isolation allows independent development and deployment</li>
            </ul>
        </div>
    </div>

    <div class="grid">
        <!-- SECTION 2: PRODUCT APP STRUCTURE -->
        <div class="section">
            <h2>🚚 Product App Structure</h2>
            <p>Each app follows standard Laravel structure <strong>plus</strong> an <code>app/Modules/</code> folder for self-contained business capabilities.</p>

            <div class="tree-view">
                <div class="tree-line"><span class="tree-dir">fleet-app/</span></div>
                <div class="tree-line">├── <span class="tree-dir">app/</span></div>
                <div class="tree-line">│   ├── <span class="tree-dir">Http/</span>              <span class="tree-comment">← Shared middleware, base controllers</span></div>
                <div class="tree-line">│   ├── <span class="tree-dir">Models/</span>            <span class="tree-comment">← Shared/base models</span></div>
                <div class="tree-line">│   ├── <span class="tree-dir">Services/</span>          <span class="tree-comment">← Core services (Billing, Permissions)</span></div>
                <div class="tree-line">│   ├── <span class="tree-dir">Policies/</span></div>
                <div class="tree-line">│   ├── <span class="tree-dir">Jobs/</span></div>
                <div class="tree-line">│   ├── <span class="tree-dir">Events/</span></div>
                <div class="tree-line">│   ├── <span class="tree-dir">Listeners/</span></div>
                <div class="tree-line">│   ├── <span class="tree-dir">Providers/</span></div>
                <div class="tree-line">│   └── <span class="tree-dir">Modules/</span>           <span class="tree-comment">← Business capabilities (self-contained)</span></div>
                <div class="tree-line">├── <span class="tree-dir">routes/</span></div>
                <div class="tree-line">├── <span class="tree-dir">config/</span></div>
                <div class="tree-line">├── <span class="tree-dir">database/</span></div>
                <div class="tree-line">└── <span class="tree-dir">resources/</span></div>
            </div>
        </div>

        <!-- SECTION 3: MODULES DETAIL -->
        <div class="section">
            <h2>🧩 Inside app/Modules/</h2>
            <p>Each module is <strong>self-contained</strong> with its own Controllers, Models, Policies, and routes.</p>

            <div class="tree-view">
                <div class="tree-line"><span class="tree-dir">app/Modules/</span></div>
                <div class="tree-line">├── <span class="tree-dir">Vehicles/</span></div>
                <div class="tree-line">│   ├── <span class="tree-dir">Controllers/</span></div>
                <div class="tree-line">│   │   └── VehicleController.php</div>
                <div class="tree-line">│   ├── <span class="tree-dir">Models/</span></div>
                <div class="tree-line">│   │   └── Vehicle.php</div>
                <div class="tree-line">│   ├── <span class="tree-dir">Policies/</span></div>
                <div class="tree-line">│   ├── routes.php</div>
                <div class="tree-line">│   ├── permissions.php</div>
                <div class="tree-line">│   └── module.php</div>
                <div class="tree-line">├── <span class="tree-dir">Drivers/</span></div>
                <div class="tree-line">├── <span class="tree-dir">Trips/</span></div>
                <div class="tree-line">├── <span class="tree-dir">Reports/</span></div>
                <div class="tree-line">└── <span class="tree-dir">Dispatch/</span>            <span class="tree-comment">← Only if this app uses it</span></div>
            </div>
        </div>
    </div>

    <!-- SECTION 4: DATABASE STRATEGY -->
    <div class="section">
        <h2>🗄️ Database Strategy</h2>
        <p>Each app has its own database, but <strong>shared entities</strong> (vehicles, drivers) live in a central shared DB accessible by all apps.</p>

        <div class="grid" style="grid-template-columns: 1fr 1fr; margin-bottom: 2rem;">
            <div class="tree-view">
                <div class="tree-comment"># Databases</div>
                <div class="tree-line" style="margin-top: 0.5rem;"><span class="tree-dir">shared_db</span>        <span class="tree-comment">← vehicles, drivers, devices</span></div>
                <div class="tree-line"><span class="tree-dir">fleet_db</span>         <span class="tree-comment">← fleet-specific tables</span></div>
                <div class="tree-line"><span class="tree-dir">tms_db</span>           <span class="tree-comment">← tms-specific tables</span></div>
                <div class="tree-line"><span class="tree-dir">planner_db</span>       <span class="tree-comment">← planner-specific tables</span></div>
            </div>
            
            <div class="card">
                <h3>How It Works</h3>
                <ul style="margin-top: 1rem;">
                    <li>✔ Each app configures <strong>2 DB connections</strong> in Laravel</li>
                    <li>✔ Models specify which connection: <code>$connection = 'shared'</code></li>
                    <li>✔ No event sync needed — direct access</li>
                    <li>✔ Fast reads, single source of truth</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- SECTION 5: MODULE SYSTEM (DATABASE-DRIVEN) -->
    <div class="section">
        <h2>⚙️ Module System (Database-Driven)</h2>
        <p><strong>No static files.</strong> Everything lives in the database and is cached in Redis for fast availability checks.</p>

        <div class="grid" style="grid-template-columns: 1fr 1fr; margin-bottom: 2rem;">
            <div class="card">
                <h3>🗄️ modules (Table)</h3>
                <p style="font-size: 0.9rem; color: #8b949e; margin-bottom: 1rem;">Supports parent/sub-module hierarchy</p>
                <pre style="color: #a5d6ff; overflow-x: auto;">
- id
- parent_id        // NULL = root module
- key              // 'dispatch', 'support'
- name
- type             // core | optional
- dependencies     // JSON
- base_price</pre>
            </div>
            
            <div class="card">
                <h3>🗄️ module_options (Table)</h3>
                <p style="font-size: 0.9rem; color: #8b949e; margin-bottom: 1rem;">Tiers/levels within a module</p>
                <pre style="color: #a5d6ff; overflow-x: auto;">
- id
- module_id
- key              // 'basic', 'advanced', 'premium'
- name             // 'Basic Dispatch', 'Premium Support'
- price
- features         // JSON: capabilities included</pre>
            </div>
        </div>

        <div class="grid" style="grid-template-columns: 1fr 1fr; margin-bottom: 2rem;">
            <div class="card">
                <h3>🗄️ module_subscriptions (Table)</h3>
                <p style="font-size: 0.9rem; color: #8b949e; margin-bottom: 1rem;">Tenant activation & billing</p>
                <pre style="color: #a5d6ff; overflow-x: auto;">
- tenant_id
- module_id
- option_id        // selected tier (basic/advanced)
- activated_by     // provider | reseller
- is_paid
- auto_deactivate
- expires_at
- status</pre>
            </div>
            
            <div class="card">
                <h3>📦 Example: Module Hierarchy</h3>
                <pre style="color: #a5d6ff; overflow-x: auto; margin-top: 1rem;">
<span style="color: #7ee787;">Dispatch (parent)</span>
├── Basic Dispatch      (option)
└── Advanced Dispatch   (option)

<span style="color: #7ee787;">Support (parent)</span>
├── Basic Support       (option)
├── Medium Support      (option)
└── Premium Support     (option)</pre>
            </div>
        </div>

        <div class="card" style="margin-bottom: 2rem;">
            <h3>⚡ Redis Cache (Fast Lookups)</h3>
            <pre style="color: #a5d6ff; overflow-x: auto; margin-top: 1rem;">
// Check module availability (cached)
Module::enabled('dispatch', $tenantId);  // → true/false

// Cache key pattern
"tenant:{id}:modules" → ['dispatch', 'vehicles', 'drivers']</pre>
        </div>

        <div class="highlight-box" style="background: rgba(210, 153, 34, 0.1); border-color: #d29922; color: #e3b341;">
            <strong>Hierarchy Control:</strong>
            <ul style="margin-top: 0.5rem;">
                <li>✔ <strong>Provider</strong> can enable/disable modules for all their resellers</li>
                <li>✔ <strong>Reseller</strong> can enable/disable for their companies</li>
                <li>✔ <strong>Auto-suspend</strong> when payment fails (configurable)</li>
                <li>✔ <strong>Core modules</strong> are always available, no subscription needed</li>
            </ul>
        </div>

        <div class="highlight-box" style="background: rgba(88, 166, 255, 0.1); border-color: #58a6ff; color: #a5d6ff; margin-top: 1rem;">
            <strong>📌 Important: Each App Has Its Own Modules</strong>
            <p style="margin: 0.5rem 0 0.5rem 0;">Modules are <strong>distinct per app</strong> — even if they have the same name (e.g., "Support").</p>
            <ul style="margin-top: 0.5rem;">
                <li>✔ <strong>Independent Pricing:</strong> Fleet Support = 5€/month, TMS Support = 10€/month</li>
                <li>✔ <strong>Different Features:</strong> Same module name, but tailored capabilities per product</li>
                <li>✔ <strong>Isolated Billing:</strong> Each app's modules are invoiced separately</li>
                <li>✔ <strong>Flexible Upgrades:</strong> Customer can have Premium in Fleet, Basic in TMS</li>
            </ul>
        </div>
    </div>


    <!-- SECTION 6: KEY BENEFITS -->
    <div class="section">
        <h2>✅ Why This Architecture Works</h2>
        
        <div class="grid" style="grid-template-columns: repeat(3, 1fr);">
            <div class="card">
                <h3>🧱 Isolation</h3>
                <p>Each app can be deployed, scaled, and backed up independently.</p>
            </div>
            <div class="card">
                <h3>🔄 Reusability</h3>
                <p>Modules are portable. Same Vehicles module works in Fleet & TMS.</p>
            </div>
            <div class="card">
                <h3>💰 Monetization</h3>
                <p>Modules can be paid/optional. Billing is native, not hardcoded.</p>
            </div>
        </div>
        
        <p style="text-align: center; margin-top: 2rem; font-size: 1.2rem; font-weight: bold; color: var(--success-color);">
            Standard Laravel + Modular Business Logic = Enterprise Ready
        </p>
    </div>

</div>

</body>
</html>
