<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoMax Devices Module Architecture</title>
    <meta name="description" content="Architecture documentation for the Devices Core Module in GeoMax SaaS.">
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

        .badge-success { background: rgba(46, 160, 67, 0.2); color: #7ee787; }
        .badge-warning { background: rgba(210, 153, 34, 0.2); color: #e3b341; }
        .badge-danger { background: rgba(248, 81, 73, 0.2); color: #f85149; }
        .badge-info { background: rgba(88, 166, 255, 0.15); color: var(--accent-color); }
        .badge-purple { background: rgba(163, 113, 247, 0.2); color: var(--purple-color); }

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

        pre {
            font-family: var(--font-mono);
            background: var(--card-bg);
            padding: 1rem;
            border-radius: 8px;
            overflow-x: auto;
            margin: 1rem 0;
            font-size: 0.9rem;
            color: #a5d6ff;
        }

        .sql-code {
            color: #f0883e;
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

        .responsibility-table td:first-child {
            font-weight: bold;
            color: var(--accent-color);
        }

        .device-flow {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin: 2rem 0;
            flex-wrap: wrap;
        }

        .device-node {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
            min-width: 120px;
        }
        
        .device-node.primary {
            border-color: var(--success-color);
            box-shadow: 0 0 10px rgba(46, 160, 67, 0.2);
        }

        .device-node.server {
            border-color: var(--purple-color);
            background: rgba(163, 113, 247, 0.1);
        }

        .arrow {
            font-size: 1.5rem;
            color: var(--accent-color);
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h1>📡 Devices Module Architecture</h1>
        <p>Production-grade, modular, SaaS-ready design for Devices Core</p>
    </header>

    <!-- SECTION 1: CORE PRINCIPLES -->
    <div class="golden-rule">
        <h3>🔑 Core Principles (Golden Rules)</h3>
        <p><strong>Device ≠ Vehicle</strong></p>
        <p><strong>Device ≠ Protocol</strong></p>
        <p><strong>Consumer ≠ Producer</strong></p>
        <p style="font-size: 1rem; margin-top: 1rem; color: #ffa198;">
            A device is just a <strong>message producer</strong>.<br>
            Devices can be <strong>Gateways</strong> (GPS) or <strong>Peripherals</strong> (Cameras).
        </p>
    </div>

    <!-- SECTION 2: DOMAIN BOUNDARIES -->
    <div class="section">
        <h2>🛡️ Device Domain Boundaries (Clean Architecture)</h2>
        <div class="card">
            <table class="responsibility-table">
                <thead>
                    <tr>
                        <th>Responsibility</th>
                        <th>Included</th>
                        <th>Explanation</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Device Identity</td>
                        <td><span class="badge badge-success">✅</span></td>
                        <td>"Who is this device?" (ID, IMEI, Name, Tenant)</td>
                    </tr>
                    <tr>
                        <td>Gateway vs Peripheral</td>
                        <td><span class="badge badge-success">✅</span></td>
                        <td>Managing hierarchy (Camera → GPS → Server)</td>
                    </tr>
                    <tr>
                        <td>Device ↔ flespi sync</td>
                        <td><span class="badge badge-success">✅</span></td>
                        <td>"Does it exist?" (Strict consistency with flespi)</td>
                    </tr>
                    <tr>
                        <td>Capabilities</td>
                        <td><span class="badge badge-success">✅</span></td>
                        <td>"What can it do?" (GPS, Ignition, Video, etc.)</td>
                    </tr>
                    <tr>
                        <td>Raw Telemetry Ref</td>
                        <td><span class="badge badge-success">✅</span></td>
                        <td>"Where is the data?" (Channel ID, Topic)</td>
                    </tr>
                    <tr>
                        <td>Business Logic</td>
                        <td><span class="badge badge-danger">❌</span></td>
                        <td>Trips, alerts, reports must consume normalized data.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ADDED: GATEWAY VS PERIPHERAL LOGIC -->
    <div class="section">
        <h2>🔗 Gateways & Peripherals (The Professional Loop)</h2>
        <p>In telematics, not every device talks to the internet directly.</p>
        
        <div class="device-flow">
            <div class="device-node">
                <strong>📸 Peripheral</strong><br>
                <span class="badge badge-info">Camera</span>
            </div>
            <div class="arrow">→</div>
            <div class="device-node primary">
                <strong>📡 Gateway</strong><br>
                <span class="badge badge-success">GPS Tracker</span>
            </div>
            <div class="arrow">→</div>
            <div class="device-node">
                <strong>☁️ Protocol</strong><br>
                <span class="badge badge-warning">MQTT / TCP</span>
            </div>
            <div class="arrow">→</div>
            <div class="device-node server">
                <strong>�️ GeoMax Server</strong><br>
                <span class="badge badge-purple">Backend</span>
            </div>
        </div>

        <div class="info-box">
             <strong>💡 Real World Truth:</strong><br>
             The Camera does not send data to the server. The Camera sends data to the GPS (via RS232, BLE, etc.), and the GPS forwards it to the server.<br>
             The server receives the message <strong>tagged with the GPS IMEI</strong>. We must resolve the peripherals via <code>device_links</code>.
        </div>
    </div>

    <!-- SECTION 2.5: CAN-ONLY DEVICES -->
    <div class="section">
        <h2>🚚 CAN-Only Devices (Special Case)</h2>
        <p>A "CAN-only" device reads internal vehicle data (fuel, RPM, weight) without GPS. But <strong>is it a Gateway or a Peripheral?</strong></p>

        <div class="grid">
            <div class="card">
                <h3>❓ What is it?</h3>
                <ul>
                    <li>❌ No GPS</li>
                    <li>❌ No OBD</li>
                    <li>✅ Direct CAN bus reading</li>
                    <li>✅ Provides: Fuel, RPM, PTO, Weight</li>
                </ul>
            </div>

            <div class="card">
                <h3>🌍 Where does it exist?</h3>
                <ul>
                    <li><strong>Heavy / Industrial Vehicles:</strong> Trucks, Buses, Tractors.</li>
                    <li><strong>Legacy Fleets:</strong> Adding CAN reading to existing old GPS.</li>
                    <li><strong>OEM Systems:</strong> Native vehicle computers.</li>
                </ul>
            </div>
        </div>

        <h3 style="margin-top: 2rem;">🧠 How to Model It?</h3>
        <p>It depends on how it talks to the server.</p>

        <div class="card" style="margin-top: 1rem; overflow: hidden;">
            <table>
                <thead>
                    <tr>
                        <th>Scenario</th>
                        <th>Frequency</th>
                        <th>Model</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>As a Peripheral</strong></td>
                        <td><span class="badge badge-success">🔥 95%</span></td>
                        <td>
                            <code>category = can</code><br>
                            <code>is_primary = false</code>
                        </td>
                        <td>Connected to a GPS Gateway. The GPS sends the data.</td>
                    </tr>
                    <tr>
                        <td><strong>As a Gateway</strong></td>
                        <td><span class="badge badge-warning">⚠️ 5%</span></td>
                        <td>
                            <code>category = gateway</code><br>
                            <code>is_primary = true</code>
                        </td>
                        <td>Sends data directly to the server (no GPS coordinates).</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="warning-box">
             <strong>💡 Key Takeaway:</strong> CAN is a <strong>data source</strong>, not necessarily a gateway. Always ask: "Does it send data to the server itself?"
        </div>
    </div>

    <!-- SECTION 2.6: CATEGORY vs CAPABILITY RULES -->
    <div class="section">
        <h2>🧠 The "Category vs Capability" Rules (Summary)</h2>
        <p>Specific rules for Flespi-based architecture, Tachographs, OBD, and CAN.</p>

        <div class="grid">
            <div class="card">
                <h3>1. The Flespi Rule</h3>
                <p>Since Flespi devices are Gateways:</p>
                <ul>
                    <li><strong>OBD & CAN</strong> = Capabilities (inside payload)</li>
                    <li><strong>GPS Tracker</strong> = Category <code>gateway</code></li>
                </ul>
                <div class="info-box">
                    If it's inside the Flespi payload, it's a <strong>Capability</strong>. If it has its own Flespi ID, it's a <strong>Category</strong>.
                </div>
            </div>

            <div class="card">
                <h3>2. The Hardware Rule</h3>
                <p>When to create a <code>Category</code>:</p>
                <ul>
                    <li>✅ Distinct physical device</li>
                    <li>✅ Separate installation/maintenance</li>
                    <li>✅ Specific billing needed</li>
                </ul>
                <div class="highlight-box">
                    <strong>Tachograph:</strong> CAN be a category if you manage the physical hardware separately (compliance, install).
                </div>
            </div>
        </div>

        <div class="card" style="margin-top: 1rem;">
             <h3>🚀 Final Checklist: Category or Capability?</h3>
             <table style="margin-top: 0.5rem;">
                <tr>
                    <td><strong>OBD port on GPS Tracker</strong></td>
                    <td><span class="badge badge-info">Capability</span></td>
                    <td>It's just a feature of the tracker.</td>
                </tr>
                 <tr>
                    <td><strong>Separate CAN Reader</strong> connected to GPS</td>
                    <td><span class="badge badge-warning">Category (Peripheral)</span></td>
                    <td>It's a separate box you buy and install.</td>
                </tr>
                 <tr>
                    <td><strong>Tachograph</strong> (Data only)</td>
                    <td><span class="badge badge-info">Capability</span></td>
                    <td>Just decoding ddd files from tracker.</td>
                </tr>
                <tr>
                    <td><strong>Tachograph</strong> (Hardware Mgmt)</td>
                    <td><span class="badge badge-warning">Category (Peripheral)</span></td>
                    <td>You manage the physical unit's lifecycle.</td>
                </tr>
             </table>
        </div>
    </div>

    <!-- SECTION 2.8: CLARIFICATION GATEWAY VS PRIMARY -->
    <div class="section">
        <h2>🧠 Clarification: Gateway vs Primary</h2>
        <p>Understanding the distinction between hardware role and business logic role.</p>

        <div class="grid">
            <div class="card">
                <h3>📡 Why "Gateway"?</h3>
                <p><strong>Gateway = Hardware/Network Role</strong></p>
                <ul>
                    <li>Receives data from other devices</li>
                    <li>Aggregates data (GPS, OBD, CAN, Sensors)</li>
                    <li>Sends data to the server</li>
                    <li>Represents the communication pipe</li>
                </ul>
                <div class="highlight-box">
                    👉 Any device talking directly to backend is a <strong>Gateway</strong>.
                </div>
            </div>

            <div class="card">
                <h3>🔑 Why "is_primary"?</h3>
                <p><strong>is_primary = Business Logic Role</strong></p>
                <ul>
                    <li>Single entry point for a Vehicle</li>
                    <li>Main identity (IMEI / Token)</li>
                    <li>Billing basis</li>
                    <li>Reference for alerts & security</li>
                </ul>
                <div class="highlight-box">
                    👉 <strong>1 Vehicle = 1 Primary</strong> (99% of cases).
                </div>
            </div>
        </div>

        <div class="card" style="margin-top: 2rem;">
            <h3>🔗 The Relation: Primary = Gateway</h3>
            <p>Because a peripheral <strong>depends</strong> on another device and cannot represent a vehicle alone:</p>
            <pre class="sql-code" style="text-align: center; font-weight: bold; color: #7ee787;">
Primary → always a Gateway
Gateway → sometimes Primary</pre>
            
            <div class="success-box" style="margin-top: 1rem; text-align: center; font-size: 1.2rem;">
                <strong>Gateway = Who talks to the Server</strong><br>
                <strong>Primary = Who represents the Vehicle</strong>
            </div>
        </div>
    </div>

    <!-- SECTION 2.9: WHY GATEWAY AND NOT GPS -->
    <div class="section">
        <h2>❌ Why NOT call it "GPS"? (Important)</h2>
        <p>A final reminder on naming conventions to avoid future technical debt.</p>

        <div class="grid">
            <div class="card">
                <h3>🚫 Why "GPS" is wrong</h3>
                <p>"GPS" describes a <strong>function</strong>, not a role.</p>
                <ul>
                    <li>Modern devices don't just do GPS</li>
                    <li>They aggregate Video, CAN, OBD, Sensors</li>
                    <li>Some gateways don't even have GPS (Indoor, CAN-only)</li>
                </ul>
                <div class="danger-box">
                    If you call it <code>gps</code>, you lie to the model.
                </div>
            </div>

            <div class="card">
                <h3>✅ Why "Gateway" is right</h3>
                <p>"Gateway" describes the <strong>responsibility</strong>.</p>
                <ul>
                    <li>🔁 <strong>Receives</strong> data</li>
                    <li>📦 <strong>Aggregates</strong> data</li>
                    <li>🌐 <strong>Sends</strong> data to server</li>
                    <li>🔗 <strong>Central point</strong> of communication</li>
                </ul>
                <div class="success-box">
                    Gateway = A role (Passageway to SaaS)
                </div>
            </div>
        </div>

        <div class="card" style="margin-top: 2rem;">
            <h3>🔮 Future Proofing</h3>
            <p>If tomorrow you add:</p>
            <ul>
                <li>Satellite Gateway (Starlink)</li>
                <li>Indoor Gateway (Bluetooth/WiFi)</li>
                <li>Video AI Gateway</li>
            </ul>
            <p>👉 Your model <strong>doesn't change</strong>. It's still a <code>gateway</code>.</p>
            
            <div class="highlight-box" style="text-align: center; font-size: 1.2rem; margin-top: 1rem;">
                <strong>GPS = A Capability (Data)</strong><br>
                <strong>Gateway = A Role (Device)</strong>
            </div>
        </div>
    </div>

    <!-- SECTION 3: DATABASE SCHEMA -->
    <div class="section">
        <h2>🗄️ Professional Database Schema</h2>
        
        <div class="grid">
            <!-- Table: device_types -->
            <div class="card">
                <h3>3.1 device_types (UPDATED)</h3>
                <pre class="sql-code">
device_types
------------
id (uuid, pk)
name (varchar)
brand (varchar)
model (varchar)
category ENUM(
  gateway,    -- GPS Tracker (Primary)
  camera,     -- Peripheral
  sensor,     -- Peripheral
  obd,
  can
)
is_primary (boolean)  -- true for GPS, false for Camera
created_at</pre>
                <div class="success-box" style="margin-top: 0.5rem; color: #7ee787;">
                    ✔ GPS → <code>gateway + is_primary = true</code><br>
                    ✔ Camera → <code>is_primary = false</code>
                </div>
            </div>

            <!-- Table: device_capabilities -->
            <div class="card">
                <h3>3.2 device_capabilities</h3>
                <pre class="sql-code">
device_capabilities
-------------------
id (uuid, pk)
device_type_id (uuid, fk)
capability ENUM(
  gps, ignition, fuel,
  can_bus, obd, video,
  audio, driver_id
)</pre>
                <ul>
                    <li>No more schema hell (e.g. <code>supports_can</code> column)</li>
                    <li>Cleanly declare what each hardware model supports</li>
                </ul>
            </div>

            <!-- Table: device_links -->
            <div class="card" style="border-color: var(--accent-color);">
                <h3>3.3 device_links (NEW - CRITICAL)</h3>
                <pre class="sql-code">
device_links
------------
id (uuid, pk)
parent_device_id (uuid, fk)   -- The GPS Gateway
child_device_id (uuid, fk)    -- The Camera / Sensor
link_type ENUM(
  usb,
  rs232,
  bluetooth,
  ethernet,
  wire
)
created_at</pre>
                <div class="info-box">
                    <strong>Why this exists:</strong><br>
                     • One GPS can trigger multiple cameras<br>
                     • Swap cameras without re-configuring GPS<br>
                     • Visual UI Tree (GPS → Peripherals)
                </div>
            </div>

            <!-- Table: devices -->
            <div class="card">
                <h3>3.4 devices</h3>
                <pre class="sql-code">
devices
-------
id (uuid, pk)
tenant_id (uuid, fk)
flespi_device_id (bigint, unique)
imei (varchar, unique)
name (varchar)
status (enum: active, suspended)
device_type_id (uuid, fk)
vehicle_id (uuid, nullable)
created_at
updated_at</pre>
            </div>
        </div>
    </div>

    <!-- SECTION 4: REAL WORLD SCENARIOS -->
    <div class="section">
        <h2>🌍 Real World Scenarios & Table Workflow</h2>
        <p>How different installation types look in the database.</p>

        <div class="grid">
            <!-- Scenario 1: Simple -->
            <div class="card">
                <h3>1️⃣ Standard GPS Tracker</h3>
                <p>Auto, Van, Simple Truck</p>
                <pre class="sql-code">
<strong>Table: devices</strong>
- id: 101
- name: "Van 12"
- type: FMC130 (Gateway)
- is_primary: true
- vehicle_id: 55</pre>
                <div class="info-box">
                    Simple 1-to-1 mapping. No links needed.
                </div>
            </div>

            <!-- Scenario 2: Video + GPS -->
            <div class="card">
                <h3>2️⃣ Video Telematics</h3>
                <p>GPS Tracker + Dashcam (wired)</p>
                <pre class="sql-code">
<strong>Table: devices</strong>
A. { id: 201, type: Gateway, is_primary: true }   <span style="color:var(--success-color)">← Primary</span>
B. { id: 202, type: Camera,  is_primary: false }

<strong>Table: device_links</strong>
- parent_id: 201 (GPS)
- child_id: 202 (Cam)
- type: rs232</pre>
                <div class="success-box">
                    GPS manages the Camera data stream.
                </div>
            </div>

            <!-- Scenario 3: Cold Chain -->
            <div class="card">
                <h3>3️⃣ Cold Chain (BLE)</h3>
                <p>GPS Tracker + 3 Temp Sensors</p>
                <pre class="sql-code">
<strong>Table: devices</strong>
A. { id: 301, type: Gateway, is_primary: true }   <span style="color:var(--success-color)">← Primary</span>
B. { id: 302, type: Sensor,  is_primary: false }
C. { id: 303, type: Sensor,  is_primary: false }

<strong>Table: device_links</strong>
- { parent: 301, child: 302, type: ble }
- { parent: 301, child: 303, type: ble }</pre>
            </div>

            <!-- Scenario 4: Tachograph -->
            <div class="card">
                <h3>4️⃣ Tachograph Compliance</h3>
                <p>GPS Tracker + Physical Tacho</p>
                <pre class="sql-code">
<strong>Table: devices</strong>
A. { id: 401, type: Gateway, is_primary: true }   <span style="color:var(--success-color)">← Primary</span>
B. { id: 402, type: Tacho,   is_primary: false }

<strong>Table: device_links</strong>
- { parent: 401, child: 402, type: can }

<strong>Capabilities</strong>
- GPS has: [gps, can_bus]
- Tacho has: [driver_id, work_time]</pre>
            </div>
        </div>
    </div>
    <div class="section">
        <h2>� Why this "Gateway Model" is Better</h2>
        <div class="card">
            <table class="responsibility-table">
                <thead>
                    <tr>
                        <th>Advantage</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Scalability</td>
                        <td>Easily add new peripheral types (ADAS, Breathalyzer) without changing the core.</td>
                    </tr>
                    <tr>
                        <td>Multi-Camera</td>
                        <td>One GPS can handle Front, Rear, and Driver cameras via <code>device_links</code>.</td>
                    </tr>
                    <tr>
                        <td>Vendor Agnostic</td>
                        <td>Mix Teltonika GPS with Third-party Cameras seamlessly.</td>
                    </tr>
                    <tr>
                        <td>Clean UI</td>
                        <td>Show a proper tree view: <strong>Truck 101</strong> has <strong>GPS A</strong> which has <strong>Camera B</strong>.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- SECTION 5: CRUD FLOW -->
    <div class="section">
        <h2>� CRUD Flow with flespi (MANDATORY)</h2>
        <div class="highlight-box">
            <h4>Example: Create Device</h4>
            <pre style="background: transparent; padding: 0; color: #1f6feb;">
BEGIN TRANSACTION
  → Create device in flespi
  → Store flespi_device_id
  → Insert device record
  → Insert capabilities
  → IF HAS PERIPHERALS:
      → Create peripheral devices
      → Insert device_links (GPS → Peripheral)
  → COMMIT</pre>
        </div>
    </div>

    <!-- SECTION 6: CAPABILITIES AS DRIVERS -->
    <div class="section">
        <h2>🧠 Capabilities: The Feature Engine</h2>
        <p>This is the secret sauce. We don't build features for "Teltonika" or "Queclink". We build features for <strong>Capabilities</strong>.</p>

        <div class="golden-rule" style="text-align: left; padding: 1.5rem;">
            <strong style="color: var(--warning-color);">THE LOGIC:</strong><br>
            1. Devices & Peripherals provide <strong>Hardware</strong>.<br>
            2. Hardware maps to <strong>Capabilities</strong>.<br>
            3. Capabilities unlock <strong>Features</strong> (Reports, Alerts, Analytics).
        </div>

        <!-- SCENARIO ENGINE -->
        <h3 style="margin-top: 2rem; margin-bottom: 1rem;">🧩 Feature Logic Scenarios</h3>
        
        <div class="grid">
            <!-- Scenario A: Basic -->
            <div class="card">
                <h3>Scenario A: The Delivery Van</h3>
                <p><strong>Hardware:</strong> Simple GPS Tracker (OBD dongle)</p>
                <div class="highlight-box">
                    <strong>Capabilities:</strong><br>
                    <code>gps</code>, <code>ignition</code>, <code>speed</code>
                </div>
                <ul style="margin-top: 1rem; font-size: 0.9rem;">
                    <li>✅ <strong>Reports:</strong> Trips, Parking, Mileage</li>
                    <li>✅ <strong>Alerts:</strong> Speeding, Geofence, Unplugged</li>
                    <li>❌ <strong>No:</strong> Fuel level, Driver ID, Temp</li>
                </ul>
            </div>

            <!-- Scenario B: Heavy Truck -->
            <div class="card" style="border-color: var(--success-color);">
                <h3>Scenario B: The Heavy Truck</h3>
                <p><strong>Hardware:</strong> GPS Gateway + CAN Adapter</p>
                <div class="highlight-box">
                    <strong>Capabilities:</strong><br>
                    <code>gps</code>, <code>can_bus</code>, <code>fuel</code>, <code>engine_hours</code>
                </div>
                <ul style="margin-top: 1rem; font-size: 0.9rem;">
                    <li>✅ <strong>Reports:</strong> Exact Fuel Consumed, Eco-Driving</li>
                    <li>✅ <strong>Alerts:</strong> Fuel Theft, High RPM, Idling</li>
                    <li>✅ <strong>Analytics:</strong> Cost per Mile, Driver Score</li>
                </ul>
            </div>

            <!-- Scenario C: Refrigerated + Video -->
            <div class="card" style="border-color: var(--purple-color);">
                <h3>Scenario C: Cold Chain + Video</h3>
                <p><strong>Hardware:</strong> GPS + Dashcam + 2 BLE Temp Sensors</p>
                <div class="highlight-box">
                    <strong>Capabilities:</strong><br>
                    <code>gps</code>, <code>video</code>, <code>temperature</code>, <code>door</code>
                </div>
                <ul style="margin-top: 1rem; font-size: 0.9rem;">
                    <li>✅ <strong>Reports:</strong> Temperature Graph, Door Openings</li>
                    <li>✅ <strong>Alerts:</strong> Temp too high, Distracted Driver</li>
                    <li>✅ <strong>Video:</strong> Crash Replay, Live View</li>
                </ul>
            </div>
        </div>

        <!-- LOGIC FLOW DIAGRAM -->
        <div class="card" style="margin-top: 2rem;">
            <h3>⚙️ How the Code Thinks (Logic Flow)</h3>
            <div class="flow-diagram">
                 <div class="flow-step">
                    <strong>User Request</strong><br>
                    "Show Fuel Report"
                 </div>
                 <div class="arrow">→</div>
                 <div class="flow-step warning">
                    <strong>Check Capability</strong><br>
                    <code>has('fuel')?</code>
                 </div>
                 <div class="arrow">→</div>
                 <div class="flow-step active">
                    <strong>Logic</strong><br>
                    If YES: Render<br>
                    If NO: Hide/Upsell
                 </div>
            </div>
            
            <div class="info-box" style="text-align: center;">
                 This means <strong>Scenario A</strong> (Van) will never see the "Fuel Theft Report" menu item.<br>
                 <strong>Scenario B</strong> (Truck) sees it automatically.
            </div>
        </div>
    </div>

    <!-- SECTION 7: PERMUTATION & HISTORY -->
    <div class="section">
        <h2>⏳ Device Permutation & History</h2>
        <p>What happens when you move a device from one vehicle to another? How do reports react?</p>

        <div class="golden-rule" style="text-align: left; padding: 1.5rem;">
            <strong style="color: var(--warning-color);">CORE RULE:</strong><br>
            👉 Never <strong>DELETE</strong> links. Always <strong>CLOSE</strong> them.<br>
            👉 Reports & Alerts bind to the <strong>Vehicle</strong>, not the Device.
        </div>

        <div class="grid">
            <div class="card">
                <h3>1. Temporal Links Table</h3>
                <p>We add time-awareness to <code>device_links</code> and <code>devices</code>.</p>
                <pre class="sql-code">
device_links (Required Update)
------------------------------
id (uuid)
parent_device_id (uuid)
child_device_id (uuid)
started_at (timestamp)  -- Start
ended_at (timestamp)    -- NULL = Active</pre>
                <div class="info-box">
                    <code>ended_at IS NULL</code> is the Current Active Link.<br>
                    <code>ended_at NOT NULL</code> is History.
                </div>
            </div>

            <div class="card">
                <h3>2. Switching Devices (Logic)</h3>
                <p><strong>Scenario:</strong> Moving CAM-1 from Vehicle A to B.</p>
                <ol>
                    <li><strong>CLOSE</strong> old link:<br>
                    <code>UPDATE device_links SET ended_at = NOW() WHERE child = CAM-1</code>
                    </li>
                    <li style="margin-top:0.5rem"><strong>CREATE</strong> new link:<br>
                    <code>INSERT INTO device_links (parent=GPS-B, child=CAM-1, start=NOW())</code>
                    </li>
                </ol>
                <div class="success-box">
                    ✔ Full history preserved<br>
                    ✔ Audit-ready
                </div>
            </div>
        </div>

        <div class="card" style="margin-top: 2rem;">
            <h3>3. Impact on Reports & Alerts</h3>
            <p>Because Reports are query inputs are <code>WHERE vehicle_id = X</code>:</p>
            
            <table style="margin-top: 1rem;">
                <tr>
                    <th>Feature</th>
                    <th>Behavior after Switch</th>
                </tr>
                <tr>
                    <td><strong>Reports</strong></td>
                    <td>
                        <strong>Seamless.</strong><br>
                        Jan-Feb data comes from Old Device.<br>
                        Mar-Apr data comes from New Device.<br>
                        <span class="badge badge-success">Single Vehicle Timeline</span>
                    </td>
                </tr>
                <tr>
                    <td><strong>Alerts</strong></td>
                    <td>
                        <strong>Automatic.</strong><br>
                        Alert rules stay on the Vehicle.<br>
                        They instantly start consuming data from the new device.<br>
                        <span class="badge badge-purple">No Reconfiguration Needed</span>
                    </td>
                </tr>
                <tr>
                    <td><strong>Orphaned Capabilities</strong></td>
                    <td>
                        If you remove a Camera without replacing it:<br>
                        👉 Video Alerts auto-pause (inactive)<br>
                        👉 Video Reports show "No Data" for new dates
                    </td>
                </tr>
            </table>

            <div class="highlight-box" style="text-align: center; margin-top: 1rem;">
                <strong>Vehicle = Stable Entity</strong> &nbsp;|&nbsp; <strong>Device = Swappable Data Source</strong>
            </div>
        </div>

        <div class="golden-rule" style="margin-top: 2rem; text-align: center; border-color: var(--accent-color); background: rgba(88, 166, 255, 0.1);">
            <h3 style="color: var(--accent-color); margin-bottom: 0.5rem;">🧠 Key Schema Principle</h3>
            <p style="font-size: 1.4rem; color: #ffffff; margin-bottom: 0.5rem;">The Device produces the Data.</p>
            <p style="font-size: 1.4rem; color: #ffffff; margin-bottom: 0.5rem;">The Vehicle owns the History.</p>
            <p style="font-size: 1.4rem; color: #ffffff;">The Driver operates the Vehicle.</p>
        </div>

        <div class="card" style="margin-top: 2rem; border-color: var(--purple-color);">
            <h3>👮 Logic: Driver Data</h3>
            <p>If the Device belongs to the Vehicle, what is "Driver Data"?</p>
            
            <div class="flow-diagram">
                <div class="flow-step">
                    <strong>Vehicle Data</strong><br>
                    (Raw Device Stream)
                </div>
                <div class="arrow">+</div>
                <div class="flow-step warning">
                    <strong>Driver Assignment</strong><br>
                    (Time Window)
                </div>
                <div class="arrow">=</div>
                <div class="flow-step active" style="border-color: var(--purple-color); background: rgba(163, 113, 247, 0.1);">
                    <strong>Driver Data</strong><br>
                    (Attributed Trips & Score)
                </div>
            </div>

            <div class="info-box">
                👉 Drivers generate <strong>Events</strong> (Logins, Tacho Cards).<br>
                👉 Drivers inherit <strong>Telemetry</strong> (Speed, Fuel) from the Vehicle they operate.
            </div>
        </div>
    </div>

    <!-- SECTION 8: DATA ENRICHMENT PIPELINE -->
    <div class="section">
        <h2>� Data Enrichment Pipeline</h2>
        <p>How raw device data gets "attached" to Vehicles and Drivers.</p>

        <div class="card" style="background: #161b22; border: 2px solid var(--border-color); padding: 2rem;">
            
            <!-- STEP 1: RAW SOURCE -->
            <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 2rem;">
                <div style="width: 120px; font-weight: bold; color: #8b949e;">1. SOURCE</div>
                <div class="flow-step" style="flex: 1; border: 1px dashed var(--accent-color);">
                     <strong>Peripherals</strong><br>Cam, CAN
                </div>
                <div class="arrow">+</div>
                <div class="flow-step active" style="flex: 1; border: 2px solid var(--success-color);">
                     <strong>Gateway</strong><br>IMEI: 12345
                </div>
            </div>

            <div class="arrow" style="text-align: center; transform: rotate(90deg); margin: -1rem 0 1rem;">➔</div>

            <!-- STEP 2: VEHICLE CONTEXT -->
            <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 2rem;">
                <div style="width: 120px; font-weight: bold; color: #8b949e;">2. CONTEXT</div>
                <div class="flow-step warning" style="flex: 2; text-align: left; padding: 1rem;">
                    <strong>🚛 Attach Vehicle</strong><br>
                    <span style="font-size: 0.8rem; opacity: 0.8;">Query: Who owns Gateway 12345 at 10:00 AM?</span><br>
                    <div style="margin-top:0.5rem; color: var(--warning-color); font-weight: bold;">
                        ➔ Linked to: "Mercedes Truck (V-88)"
                    </div>
                </div>
            </div>

            <div class="arrow" style="text-align: center; transform: rotate(90deg); margin: -1rem 0 1rem;">➔</div>

            <!-- STEP 3: DRIVER CONTEXT -->
            <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 2rem;">
                <div style="width: 120px; font-weight: bold; color: #8b949e;">3. IDENTITY</div>
                <div class="flow-step purple" style="flex: 2; text-align: left; padding: 1rem; border-color: var(--purple-color); background: rgba(163, 113, 247, 0.1);">
                    <strong>�‍✈️ Attach Driver</strong><br>
                    <span style="font-size: 0.8rem; opacity: 0.8;">Query: Who was driving V-88 at 10:00 AM?</span><br>
                    <div style="margin-top:0.5rem; color: var(--purple-color); font-weight: bold;">
                        ➔ Assigned to: "John Doe"
                    </div>
                </div>
            </div>

            <div class="arrow" style="text-align: center; transform: rotate(90deg); margin: -1rem 0 1rem;">➔</div>

            <!-- STEP 4: FINAL OBJECT -->
            <div style="display: flex; gap: 1rem; align-items: center;">
                <div style="width: 120px; font-weight: bold; color: #8b949e;">4. RESULT</div>
                <div class="flow-step" style="flex: 2; text-align: left; font-family: monospace; font-size: 0.9rem;">
                    <strong>Final Data Object:</strong><br>
                    {<br>
                    &nbsp;&nbsp;"telemetry": { speed: 85, fuel: 40% },<br>
                    &nbsp;&nbsp;"device": "IMEI-12345",<br>
                    &nbsp;&nbsp;"vehicle": "V-88",<br>
                    &nbsp;&nbsp;"driver": "John Doe"<br>
                    }
                </div>
            </div>

        </div>
        
        <div class="info-box" style="text-align: center; margin-top: 1rem;">
            Context flows from: <strong>ID (Device) → Asset (Vehicle) → Actor (Driver)</strong>
        </div>
    </div>

</div>

</body>
</html>
