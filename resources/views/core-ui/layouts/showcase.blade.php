{{--
    ================================================================================
    CORE UI SHOWCASE LAYOUT
    ================================================================================

    A minimal layout for the component showcase / developer playground.
    This layout is intentionally simple and separate from the main app layout.

    USAGE: @extends('core-ui.layouts.showcase')
    ================================================================================
--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">

    <title>@yield('title', 'UI Component Showcase') | DEV</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700">

    <!-- Global Stylesheets (Metronic) -->
    <link href="{{ asset('assets/css/plugins.bundle.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css">

    <!-- Showcase-specific styles -->
    <style>
        :root {
            --showcase-sidebar-width: 280px;
            --showcase-header-height: 60px;
            --showcase-warning-height: 40px;
        }

        /* DEV Warning Banner */
        .showcase-dev-warning {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--showcase-warning-height);
            background: linear-gradient(135deg, #f39c12, #e74c3c);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            z-index: 1000;
        }

        .showcase-dev-warning i {
            margin-right: 8px;
        }

        /* Main Layout */
        .showcase-wrapper {
            display: flex;
            min-height: 100vh;
            padding-top: var(--showcase-warning-height);
        }

        /* Sidebar */
        .showcase-sidebar {
            position: fixed;
            top: var(--showcase-warning-height);
            left: 0;
            width: var(--showcase-sidebar-width);
            height: calc(100vh - var(--showcase-warning-height));
            background: #1e1e2d;
            overflow-y: auto;
            z-index: 100;
        }

        .showcase-sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .showcase-sidebar-title {
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }

        .showcase-sidebar-subtitle {
            color: rgba(255,255,255,0.5);
            font-size: 12px;
            margin-top: 4px;
        }

        .showcase-nav {
            padding: 15px 0;
        }

        .showcase-nav-category {
            padding: 10px 20px 5px;
            color: rgba(255,255,255,0.4);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .showcase-nav-item {
            display: block;
            padding: 10px 20px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .showcase-nav-item:hover {
            color: #fff;
            background: rgba(255,255,255,0.05);
        }

        .showcase-nav-item.active {
            color: #fff;
            background: rgba(255,255,255,0.1);
            border-left-color: #3699ff;
        }

        .showcase-nav-item i {
            width: 20px;
            margin-right: 10px;
            opacity: 0.7;
        }

        /* Main Content */
        .showcase-main {
            flex: 1;
            margin-left: var(--showcase-sidebar-width);
            background: #f5f8fa;
            min-height: calc(100vh - var(--showcase-warning-height));
        }

        .showcase-header {
            background: #fff;
            padding: 20px 30px;
            border-bottom: 1px solid #e4e6ef;
            position: sticky;
            top: var(--showcase-warning-height);
            z-index: 50;
        }

        .showcase-header-title {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
            color: #181c32;
        }

        .showcase-header-description {
            margin: 5px 0 0;
            color: #a1a5b7;
            font-size: 13px;
        }

        .showcase-content {
            padding: 30px;
        }

        /* Component Section */
        .showcase-section {
            background: #fff;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 0 20px rgba(0,0,0,0.03);
        }

        .showcase-section-header {
            padding: 20px 25px;
            border-bottom: 1px solid #e4e6ef;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .showcase-section-title {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: #181c32;
        }

        .showcase-section-title code {
            font-size: 12px;
            background: #f1f3f5;
            padding: 3px 8px;
            border-radius: 4px;
            margin-left: 10px;
            color: #7e8299;
        }

        .showcase-section-body {
            padding: 25px;
        }

        .showcase-section-footer {
            padding: 15px 25px;
            background: #f9fafb;
            border-top: 1px solid #e4e6ef;
            border-radius: 0 0 12px 12px;
        }

        /* Example Grid */
        .showcase-example {
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px dashed #e4e6ef;
        }

        .showcase-example:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .showcase-example-label {
            font-size: 13px;
            font-weight: 600;
            color: #5e6278;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .showcase-example-label .badge {
            margin-left: 8px;
        }

        .showcase-example-preview {
            background: #fafbfc;
            border: 1px solid #e4e6ef;
            border-radius: 8px;
            padding: 20px;
        }

        /* Code Block */
        .showcase-code {
            background: #1e1e2d;
            color: #e4e6ef;
            padding: 20px;
            border-radius: 8px;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', 'Consolas', monospace;
            font-size: 13px;
            line-height: 1.7;
            overflow-x: auto;
            margin: 0;
            white-space: pre;
            border: 1px solid #2d2d3a;
        }

        /* Legacy code wrapper (hidden by default, used for storing code) */
        .showcase-code-wrapper {
            display: none;
        }

        /* Slide-out Code Panel */
        .showcase-code-panel {
            position: fixed;
            top: var(--showcase-warning-height);
            right: 0;
            width: 550px;
            max-width: 50vw;
            height: calc(100vh - var(--showcase-warning-height));
            background: #1e1e2d;
            z-index: 1000;
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            box-shadow: -5px 0 30px rgba(0, 0, 0, 0.3);
        }

        .showcase-code-panel.open {
            transform: translateX(0);
        }

        .showcase-code-panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: #151521;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        .showcase-code-panel-title {
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .showcase-code-panel-title i {
            color: #3699ff;
        }

        .showcase-code-panel-actions {
            display: flex;
            gap: 8px;
        }

        .showcase-code-panel-btn {
            padding: 6px 12px;
            font-size: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .showcase-code-panel-copy {
            background: #3699ff;
            color: #fff;
        }

        .showcase-code-panel-copy:hover {
            background: #1a73e8;
        }

        .showcase-code-panel-close {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .showcase-code-panel-close:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .showcase-code-panel-body {
            flex: 1;
            overflow: auto;
            padding: 20px;
        }

        .showcase-code-panel-body .showcase-code {
            border-radius: 0;
            border: none;
            background: transparent;
            padding: 0;
            min-height: 100%;
        }

        .showcase-code-panel-label {
            display: inline-block;
            padding: 4px 10px;
            background: rgba(54, 153, 255, 0.2);
            color: #3699ff;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 4px;
        }

        /* Backdrop when panel is open */
        .showcase-code-backdrop {
            position: fixed;
            top: var(--showcase-warning-height);
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
        }

        .showcase-code-backdrop.open {
            opacity: 1;
            visibility: visible;
        }

        .showcase-code .tag {
            color: #e74c3c;
        }

        .showcase-code .attr {
            color: #3498db;
        }

        .showcase-code .string {
            color: #2ecc71;
        }

        /* Toggle Button - Consistent style */
        .showcase-toggle-code {
            font-size: 12px;
            padding: 6px 14px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f1f3f5 !important;
            border: 1px solid #e4e6ef !important;
            color: #5e6278 !important;
        }

        .showcase-toggle-code:hover {
            background: #e9ecef !important;
            border-color: #d1d5db !important;
        }

        .showcase-toggle-code.active {
            background: #3699ff !important;
            border-color: #3699ff !important;
            color: #fff !important;
        }

        .showcase-toggle-code i {
            font-size: 14px;
        }

        /* Environment Badge */
        .showcase-env-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .showcase-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .showcase-sidebar.open {
                transform: translateX(0);
            }

            .showcase-main {
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- DEV Warning Banner -->
    <div class="showcase-dev-warning">
        <i class="ki-outline ki-shield-cross"></i>
        Development Only — This page is not available in production
    </div>

    <div class="showcase-wrapper">
        <!-- Sidebar Navigation -->
        <aside class="showcase-sidebar">
            <div class="showcase-sidebar-header">
                <h1 class="showcase-sidebar-title">
                    <i class="ki-outline ki-abstract-26 me-2"></i>
                    UI Components
                </h1>
                <div class="showcase-sidebar-subtitle">
                    Developer Playground
                </div>
            </div>

            <nav class="showcase-nav">
                @yield('sidebar-nav')
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="showcase-main">
            <header class="showcase-header">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="showcase-header-title">@yield('header-title', 'Component Showcase')</h2>
                        <p class="showcase-header-description">@yield('header-description', 'Visual testing and documentation for global UI components')</p>
                    </div>
                    <div>
                        <span class="showcase-env-badge">
                            <i class="ki-outline ki-code me-1"></i>
                            {{ app()->environment() }}
                        </span>
                    </div>
                </div>
            </header>

            <div class="showcase-content">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Slide-out Code Panel -->
    <div class="showcase-code-backdrop" id="codeBackdrop"></div>
    <div class="showcase-code-panel" id="codePanel">
        <div class="showcase-code-panel-header">
            <h4 class="showcase-code-panel-title">
                <i class="ki-outline ki-code"></i>
                <span id="codePanelTitle">Blade Usage</span>
            </h4>
            <div class="showcase-code-panel-actions">
                <button class="showcase-code-panel-btn showcase-code-panel-copy" id="codePanelCopy">
                    <i class="ki-outline ki-copy"></i>
                    Copy
                </button>
                <button class="showcase-code-panel-btn showcase-code-panel-close" id="codePanelClose">
                    <i class="ki-outline ki-cross"></i>
                </button>
            </div>
        </div>
        <div class="showcase-code-panel-body">
            <pre class="showcase-code" id="codePanelContent"></pre>
        </div>
    </div>

    <!-- Global Scripts (Metronic) -->
    <script src="{{ asset('assets/js/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>

    <!-- Showcase Scripts -->
    <script>
        // Code Panel Elements
        const codePanel = document.getElementById('codePanel');
        const codeBackdrop = document.getElementById('codeBackdrop');
        const codePanelContent = document.getElementById('codePanelContent');
        const codePanelTitle = document.getElementById('codePanelTitle');
        const codePanelCopy = document.getElementById('codePanelCopy');
        const codePanelClose = document.getElementById('codePanelClose');
        let activeCodeButton = null;

        // Open code panel
        function openCodePanel(codeContent, title) {
            codePanelContent.textContent = codeContent;
            codePanelTitle.textContent = title || 'Blade Usage';
            codePanel.classList.add('open');
            codeBackdrop.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        // Close code panel
        function closeCodePanel() {
            codePanel.classList.remove('open');
            codeBackdrop.classList.remove('open');
            document.body.style.overflow = '';

            // Remove active state from button
            if (activeCodeButton) {
                activeCodeButton.classList.remove('active');
                activeCodeButton.innerHTML = '<i class="ki-outline ki-code"></i> Show Code';
                activeCodeButton = null;
            }
        }

        // Toggle code visibility (new slide-out behavior)
        document.querySelectorAll('[data-toggle-code]').forEach(function(btn) {
            // Update button HTML to include icon
            if (!btn.querySelector('i')) {
                btn.innerHTML = '<i class="ki-outline ki-code"></i> Show Code';
            }

            btn.addEventListener('click', function() {
                var targetId = this.dataset.toggleCode;
                var target = document.querySelector(targetId);

                if (target) {
                    // If this button is already active, close the panel
                    if (this.classList.contains('active')) {
                        closeCodePanel();
                        return;
                    }

                    // Close any other active button
                    if (activeCodeButton && activeCodeButton !== this) {
                        activeCodeButton.classList.remove('active');
                        activeCodeButton.innerHTML = '<i class="ki-outline ki-code"></i> Show Code';
                    }

                    // Get code content
                    var codeBlock = target.querySelector('.showcase-code');
                    var codeLabel = target.querySelector('.showcase-code-label');
                    var title = codeLabel ? codeLabel.textContent : 'Blade Usage';
                    var codeContent = codeBlock ? codeBlock.textContent : '';

                    // Update button state
                    this.classList.add('active');
                    this.innerHTML = '<i class="ki-outline ki-eye-slash"></i> Hide Code';
                    activeCodeButton = this;

                    // Open panel
                    openCodePanel(codeContent, title);
                }
            });
        });

        // Close panel events
        codePanelClose.addEventListener('click', closeCodePanel);
        codeBackdrop.addEventListener('click', closeCodePanel);

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && codePanel.classList.contains('open')) {
                closeCodePanel();
            }
        });

        // Copy code to clipboard
        codePanelCopy.addEventListener('click', function() {
            var codeContent = codePanelContent.textContent;
            navigator.clipboard.writeText(codeContent).then(function() {
                codePanelCopy.innerHTML = '<i class="ki-outline ki-check"></i> Copied!';
                setTimeout(function() {
                    codePanelCopy.innerHTML = '<i class="ki-outline ki-copy"></i> Copy';
                }, 2000);
            });
        });

        // Smooth scroll to sections
        document.querySelectorAll('.showcase-nav-item').forEach(function(link) {
            link.addEventListener('click', function(e) {
                var href = this.getAttribute('href');
                if (href && href.startsWith('#')) {
                    e.preventDefault();
                    var target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        // Update active state
                        document.querySelectorAll('.showcase-nav-item').forEach(function(l) {
                            l.classList.remove('active');
                        });
                        this.classList.add('active');
                    }
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
