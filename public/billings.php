<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoMax Billing System Architecture</title>
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
            background: linear-gradient(90deg, #58a6ff, #a371f7);
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

        .flow-arrow {
            color: var(--accent-color);
            font-size: 1.5rem;
        }

        .price-tag {
            font-family: var(--font-mono);
            font-size: 1.5rem;
            color: var(--success-color);
            font-weight: 700;
        }

        .vs-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--warning-color);
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
        }

        .hierarchy-visual {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            padding: 1rem;
        }

        .hierarchy-level {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem 1rem;
            background: var(--card-bg);
            border-radius: 8px;
            margin-left: calc(var(--level, 0) * 2rem);
            border-left: 3px solid;
        }

        .level-0 { --level: 0; border-color: var(--danger-color); }
        .level-1 { --level: 1; border-color: var(--warning-color); }
        .level-2 { --level: 2; border-color: var(--accent-color); }
        .level-3 { --level: 3; border-color: var(--success-color); }

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
        <h1>💰 GeoMax Billing System</h1>
        <p>A flexible, fair, and transparent billing architecture for multi-tenant SaaS platforms.</p>
    </header>

    <!-- SECTION 1: PLATFORM HIERARCHY -->
    <div class="section">
        <h2>🏢 Platform Hierarchy</h2>
        <p>The billing system flows through a clear hierarchy, where each level can customize pricing while maintaining consistent billing rules.</p>

        <div class="hierarchy-visual">
            <div class="hierarchy-level level-0">
                <span class="badge badge-danger">Level 0</span>
                <strong>Super Admin</strong>
                <span style="color: #8b949e;">— Platform owner, defines billing rules & base prices</span>
            </div>
            <div class="hierarchy-level level-1">
                <span class="badge badge-warning">Level 1</span>
                <strong>Provider</strong>
                <span style="color: #8b949e;">— Can adjust prices for their resellers</span>
            </div>
            <div class="hierarchy-level level-2">
                <span class="badge badge-info">Level 2</span>
                <strong>Reseller</strong>
                <span style="color: #8b949e;">— Can adjust prices for their companies</span>
            </div>
            <div class="hierarchy-level level-3">
                <span class="badge badge-success">Level 3</span>
                <strong>Company</strong>
                <span style="color: #8b949e;">— Final customer, receives invoices</span>
            </div>
        </div>

        <div class="info-box">
            <strong>🔑 Key Principle:</strong> Each level can sell the same modules with <strong>its own prices</strong>, but the <strong>billing rules never change</strong>.
        </div>
    </div>

    <!-- SECTION 2: MODULE TREE STRUCTURE -->
    <div class="section">
        <h2>🌳 Module Tree Structure</h2>
        <p>Modules can have sub-modules, allowing for granular billing and feature control.</p>

        <div class="grid">
            <div class="tree-view">
                <div class="tree-comment"># Example: Camera Module Hierarchy</div>
                <div class="tree-line" style="margin-top: 0.5rem;"><span class="tree-dir">📹 Camera</span> <span class="tree-comment">← Main module</span></div>
                <div class="tree-line">├── <span class="tree-dir">Live Streaming</span></div>
                <div class="tree-line">├── <span class="tree-dir">Vehicle Cameras</span></div>
                <div class="tree-line">├── <span class="tree-dir">Video Storage (GB)</span></div>
                <div class="tree-line">└── <span class="tree-dir">AI Detection</span> <span class="tree-comment">← Premium add-on</span></div>
            </div>

            <div class="card">
                <h3>📊 Billing Types</h3>
                <p style="margin-top: 1rem;">Super Admin defines how each module is billed:</p>
                <ul style="margin-top: 1rem;">
                    <li><span class="badge badge-info">FLAT</span> Monthly base fee</li>
                    <li><span class="badge badge-warning">PER_UNIT</span> Per vehicle / user / device</li>
                    <li><span class="badge badge-purple">USAGE</span> Per GB / API call / SMS</li>
                    <li><span class="badge badge-success">TIERED</span> Volume-based pricing</li>
                </ul>
            </div>
        </div>

        <div class="highlight-box">
            <strong>✔ Billing rules are global and locked.</strong> Only the <strong>price</strong> can vary per level, not the billing type.
        </div>
    </div>

    <!-- SECTION 3: CRITICAL CONCEPT - 0€ vs FREE -->
    <div class="section">
        <h2>⚠️ Critical: 0€ vs FREE</h2>
        <p>Understanding this distinction is essential for proper billing, demos, and accounting.</p>

        <div class="grid" style="margin-top: 1.5rem;">
            <div class="card" style="border: 2px solid var(--warning-color);">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <span class="price-tag" style="color: var(--warning-color);">0€</span>
                    <h3 style="margin: 0; color: var(--warning-color);">Zero Euro</h3>
                </div>
                <ul>
                    <li>✔ Module <strong>appears</strong> on invoice</li>
                    <li>✔ Price shown as 0€</li>
                    <li>✔ Creates accounting entry</li>
                    <li>✔ Used for transparency</li>
                    <li>✔ Auditable trail maintained</li>
                </ul>
                <div class="warning-box" style="margin-top: 1rem;">
                    <strong>Use case:</strong> Promotional discount, partnership deals
                </div>
            </div>

            <div class="vs-divider">VS</div>

            <div class="card" style="border: 2px solid var(--success-color);">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <span class="price-tag">FREE</span>
                    <h3 style="margin: 0; color: var(--success-color);">Free Mode</h3>
                </div>
                <ul>
                    <li>✔ Module <strong>NOT</strong> on invoice</li>
                    <li>✔ No billing entry</li>
                    <li>✔ No accounting impact</li>
                    <li>✔ Perfect for demos/trials</li>
                    <li>✔ Full functionality enabled</li>
                </ul>
                <div class="highlight-box" style="margin-top: 1rem;">
                    <strong>Use case:</strong> Demo periods, trial accounts
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 4: DATABASE SCHEMA -->
    <div class="section">
        <h2>🗄️ Billing Database Schema</h2>
        <p>Core tables powering the billing engine.</p>

        <div class="grid" style="margin-top: 1.5rem;">
            <div class="card">
                <h3>📋 billing_plans</h3>
                <pre style="color: #a5d6ff;">
- id
- name             // "Starter", "Pro", "Enterprise"
- billing_cycle    // monthly | yearly | custom
- base_price
- currency
- features         // JSON: included features
- limits           // JSON: usage limits
- is_active</pre>
            </div>

            <div class="card">
                <h3>💳 subscriptions</h3>
                <pre style="color: #a5d6ff;">
- id
- tenant_id
- plan_id
- status           // active | past_due | canceled
- trial_ends_at
- current_period_start
- current_period_end
- canceled_at
- payment_method_id</pre>
            </div>

            <div class="card">
                <h3>📄 invoices</h3>
                <pre style="color: #a5d6ff;">
- id
- tenant_id
- subscription_id
- number           // INV-2026-0001
- status           // draft | sent | paid | overdue
- subtotal
- tax_amount
- total
- due_date
- paid_at
- pdf_path</pre>
            </div>

            <div class="card">
                <h3>📝 invoice_items</h3>
                <pre style="color: #a5d6ff;">
- id
- invoice_id
- module_id
- description
- quantity
- unit_price
- amount
- pricing_mode     // paid | free | zero
- billing_type     // flat | per_unit | usage</pre>
            </div>
        </div>

        <div class="card" style="margin-top: 2rem;">
            <h3>💰 module_pricing (Per-Level Pricing)</h3>
            <pre style="color: #a5d6ff;">
- id
- module_id
- priceable_type   // WHO is this price FOR?
- priceable_id     // ID of that entity
- set_by_type      // WHO set this price?
- set_by_id        // ID of price setter
- pricing_mode     // paid | free | zero | disabled
- price            // NULL = inherit from parent
- min_price        // floor (can't go below)
- max_price        // ceiling (can't exceed)
- custom_rules     // JSON: special conditions</pre>
        </div>

        <div class="info-box" style="margin-top: 1.5rem;">
            <strong>🔍 Understanding Price Relationships</strong>
            <p style="margin: 0.5rem 0;">Each price record answers TWO questions:</p>
            <ul style="margin-top: 0.5rem;">
                <li><strong>priceable_type/id</strong> → WHO is this price FOR? (the buyer)</li>
                <li><strong>set_by_type/id</strong> → WHO set this price? (the seller/parent)</li>
            </ul>
        </div>

        <div class="card" style="margin-top: 1.5rem;">
            <h3>📊 Price Flow Example</h3>
            <div style="margin-top: 1rem;">
                <table>
                    <thead>
                        <tr>
                            <th>Price Set BY</th>
                            <th>Price Set FOR</th>
                            <th>Module</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="badge badge-danger">Super Admin</span></td>
                            <td><span class="badge badge-warning">Provider ABC</span></td>
                            <td>Camera</td>
                            <td>5€/mo</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-warning">Provider ABC</span></td>
                            <td><span class="badge badge-info">Reseller XYZ</span></td>
                            <td>Camera</td>
                            <td>8€/mo</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-info">Reseller XYZ</span></td>
                            <td><span class="badge badge-success">Company 123</span></td>
                            <td>Camera</td>
                            <td>12€/mo</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="warning-box" style="margin-top: 1.5rem;">
            <strong>👁️ What Each Level Sees</strong>
            <div style="margin-top: 0.5rem;">
                <p><strong>If you are a Reseller, you see:</strong></p>
                <ul>
                    <li>✔ Your <strong>cost</strong> (price your Provider set FOR you)</li>
                    <li>✔ Your <strong>sell prices</strong> (prices you set FOR your companies)</li>
                    <li>✔ Your <strong>margin</strong> = sell price - cost</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- SECTION 5: INVOICE LIFECYCLE -->
    <div class="section">
        <h2>📄 Invoice Lifecycle</h2>
        <p>Understanding the journey of an invoice from creation to payment.</p>

        <div class="flow-diagram">
            <div class="flow-step">
                <div style="font-size: 1.5rem;">📝</div>
                <div><strong>Draft</strong></div>
                <div style="font-size: 0.8rem; color: #8b949e;">Auto-generated</div>
            </div>
            <div class="flow-arrow">→</div>
            <div class="flow-step">
                <div style="font-size: 1.5rem;">📤</div>
                <div><strong>Sent</strong></div>
                <div style="font-size: 0.8rem; color: #8b949e;">Email delivered</div>
            </div>
            <div class="flow-arrow">→</div>
            <div class="flow-step">
                <div style="font-size: 1.5rem;">⏳</div>
                <div><strong>Pending</strong></div>
                <div style="font-size: 0.8rem; color: #8b949e;">Awaiting payment</div>
            </div>
            <div class="flow-arrow">→</div>
            <div class="flow-step active">
                <div style="font-size: 1.5rem;">✅</div>
                <div><strong>Paid</strong></div>
                <div style="font-size: 0.8rem; color: #7ee787;">Complete</div>
            </div>
        </div>

        <div class="grid" style="margin-top: 2rem;">
            <div class="warning-box">
                <strong>⚠️ Overdue Flow</strong>
                <div style="margin-top: 0.5rem;">
                    Pending → <strong>Overdue</strong> → Grace Period → <strong>Suspended</strong>
                </div>
                <ul style="margin-top: 0.5rem;">
                    <li>Day 1-3: Reminder emails</li>
                    <li>Day 7: Final warning</li>
                    <li>Day 14: Service suspension</li>
                </ul>
            </div>

            <div class="danger-box">
                <strong>🚫 Failed Payment Actions</strong>
                <ul style="margin-top: 0.5rem;">
                    <li>Retry payment 3x over 7 days</li>
                    <li>Notify account admin</li>
                    <li>Downgrade to limited access</li>
                    <li>Option to update payment method</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- SECTION 6: PAYMENT METHODS -->
    <div class="section">
        <h2>💳 Supported Payment Methods</h2>

        <div class="grid" style="grid-template-columns: repeat(4, 1fr);">
            <div class="card" style="text-align: center;">
                <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">💳</div>
                <h3 style="margin: 0;">Credit Card</h3>
                <p style="font-size: 0.85rem; color: #8b949e; margin-top: 0.5rem;">Visa, Mastercard, AMEX</p>
                <span class="badge badge-success">Auto-charge</span>
            </div>
            <div class="card" style="text-align: center;">
                <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">🏦</div>
                <h3 style="margin: 0;">SEPA Direct</h3>
                <p style="font-size: 0.85rem; color: #8b949e; margin-top: 0.5rem;">European bank transfer</p>
                <span class="badge badge-success">Auto-charge</span>
            </div>
            <div class="card" style="text-align: center;">
                <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">🔄</div>
                <h3 style="margin: 0;">Bank Transfer</h3>
                <p style="font-size: 0.85rem; color: #8b949e; margin-top: 0.5rem;">Manual wire transfer</p>
                <span class="badge badge-warning">Manual</span>
            </div>
            <div class="card" style="text-align: center;">
                <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">📱</div>
                <h3 style="margin: 0;">PayPal</h3>
                <p style="font-size: 0.85rem; color: #8b949e; margin-top: 0.5rem;">PayPal Business</p>
                <span class="badge badge-success">Auto-charge</span>
            </div>
        </div>
    </div>

    <!-- SECTION 7: DEMO TO PAID WORKFLOW -->
    <div class="section">
        <h2>🎯 Demo to Paid Workflow</h2>
        <p>Seamless transition from trial to paying customer.</p>

        <div class="grid">
            <div class="card">
                <h3>📦 Demo Phase</h3>
                <pre style="color: #7ee787; margin-top: 1rem;">
Module: Camera
Pricing Mode: FREE
Billing: None
Features: Full access
Duration: 14-30 days</pre>
                <div class="highlight-box">
                    ✔ Real data, real features<br>
                    ✔ No credit card required<br>
                    ✔ No invoices generated
                </div>
            </div>

            <div class="card">
                <h3>💰 Paid Phase</h3>
                <pre style="color: #58a6ff; margin-top: 1rem;">
Module: Camera
Pricing Mode: PAID
Monthly Fee: 5€
Per Vehicle: 2€
Storage: 0.10€/GB</pre>
                <div class="info-box">
                    ✔ No migration needed<br>
                    ✔ No data loss<br>
                    ✔ Billing starts immediately
                </div>
            </div>
        </div>

        <div class="flow-diagram">
            <div class="flow-step">
                <div style="font-size: 1.2rem;">🆓</div>
                <div><strong>FREE</strong></div>
            </div>
            <div class="flow-arrow">→</div>
            <div class="flow-step">
                <div style="font-size: 1.2rem;">⚙️</div>
                <div><strong>Switch Mode</strong></div>
            </div>
            <div class="flow-arrow">→</div>
            <div class="flow-step active">
                <div style="font-size: 1.2rem;">💳</div>
                <div><strong>PAID</strong></div>
            </div>
        </div>
    </div>

    <!-- SECTION 8: PRICING EXAMPLE -->
    <div class="section">
        <h2>📊 Real-World Pricing Example</h2>

        <div class="comparison-table">
            <table>
                <thead>
                    <tr>
                        <th>Module</th>
                        <th>Billing Type</th>
                        <th>Super Admin</th>
                        <th>Provider Price</th>
                        <th>Reseller Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Fleet Base</strong></td>
                        <td><span class="badge badge-info">FLAT</span></td>
                        <td>10€/mo</td>
                        <td>15€/mo</td>
                        <td>20€/mo</td>
                    </tr>
                    <tr>
                        <td><strong>Vehicles</strong></td>
                        <td><span class="badge badge-warning">PER_UNIT</span></td>
                        <td>1€/vehicle</td>
                        <td>1.50€/vehicle</td>
                        <td>2€/vehicle</td>
                    </tr>
                    <tr>
                        <td><strong>Storage</strong></td>
                        <td><span class="badge badge-purple">USAGE</span></td>
                        <td>0.05€/GB</td>
                        <td>0.08€/GB</td>
                        <td>0.10€/GB</td>
                    </tr>
                    <tr>
                        <td><strong>API Calls</strong></td>
                        <td><span class="badge badge-success">TIERED</span></td>
                        <td>Free up to 10K</td>
                        <td>Free up to 5K</td>
                        <td>0.001€/call</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="info-box" style="margin-top: 1.5rem;">
            <strong>💡 Margin Calculation:</strong> Each level adds their margin. If Super Admin charges 10€, Provider charges 15€ (50% margin), Reseller charges 20€ (33% margin on their cost).
        </div>
    </div>

    <!-- SECTION 9: PRORATION & CREDITS -->
    <div class="section">
        <h2>⚖️ Proration & Credits</h2>
        <p>Fair billing for mid-cycle changes.</p>

        <div class="grid">
            <div class="card">
                <h3>📈 Upgrade Mid-Cycle</h3>
                <ul style="margin-top: 1rem;">
                    <li>Calculate remaining days in period</li>
                    <li>Charge prorated difference immediately</li>
                    <li>New plan effective immediately</li>
                </ul>
                <pre style="color: #7ee787; margin-top: 1rem;">
Days remaining: 15/30
Old plan: 10€ (5€ credit)
New plan: 20€ (10€ charge)
Net charge: 5€</pre>
            </div>

            <div class="card">
                <h3>📉 Downgrade Mid-Cycle</h3>
                <ul style="margin-top: 1rem;">
                    <li>Calculate unused value</li>
                    <li>Issue credit to account</li>
                    <li>Apply to next invoice</li>
                </ul>
                <pre style="color: #e3b341; margin-top: 1rem;">
Days remaining: 15/30
Old plan: 20€ (10€ credit)
New plan: 10€
Credit balance: 5€</pre>
            </div>
        </div>
    </div>

    <!-- SECTION 10: WHY THIS WORKS -->
    <div class="section">
        <h2>✅ Why This Billing System Works</h2>
        
        <div class="grid" style="grid-template-columns: repeat(3, 1fr);">
            <div class="card">
                <h3>🎯 Simplicity</h3>
                <p>Easy to explain to customers. One rule, flexible prices.</p>
            </div>
            <div class="card">
                <h3>🔄 Flexibility</h3>
                <p>Providers & resellers set their own margins.</p>
            </div>
            <div class="card">
                <h3>📊 Transparency</h3>
                <p>Clear invoices, no hidden fees, auditable trail.</p>
            </div>
            <div class="card">
                <h3>🚀 Scalability</h3>
                <p>Add new modules without changing billing logic.</p>
            </div>
            <div class="card">
                <h3>🎁 Demo-Friendly</h3>
                <p>FREE mode enables risk-free trials.</p>
            </div>
            <div class="card">
                <h3>💰 Revenue Tracking</h3>
                <p>Complete visibility into earnings per level.</p>
            </div>
        </div>
        
        <p style="text-align: center; margin-top: 2rem; font-size: 1.2rem; font-weight: bold; color: var(--success-color);">
            Flexible Pricing + Consistent Rules = Professional SaaS Billing
        </p>
    </div>

    <!-- SECTION 11: QUICK REFERENCE -->
    <div class="section">
        <h2>📌 Quick Reference</h2>
        
        <div class="grid">
            <div class="card">
                <h3>Pricing Modes</h3>
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

            <div class="card">
                <h3>Billing Cycles</h3>
                <table>
                    <tr>
                        <td><strong>Monthly</strong></td>
                        <td>Billed on same day each month</td>
                    </tr>
                    <tr>
                        <td><strong>Yearly</strong></td>
                        <td>Annual billing (usually discounted)</td>
                    </tr>
                    <tr>
                        <td><strong>Usage</strong></td>
                        <td>Billed based on consumption</td>
                    </tr>
                    <tr>
                        <td><strong>Hybrid</strong></td>
                        <td>Base fee + usage overage</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>

</body>
</html>
