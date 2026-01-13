@extends('layout.master')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@php
    $breadcrumbs = [
        ['url' => "/", 'label' => 'Home'],
        'Dashboard'
    ];
@endphp

@section('content')
    <!-- Theme Palette Selector Block -->
    <div class="card mb-10">
        <div class="card-header">
            <h3 class="card-title">Theme Customizer</h3>
            <div class="card-toolbar">
                <button id="kt_theme_customizer_save" class="btn btn-sm btn-primary me-2">Save Configuration</button>
                 <button id="kt_theme_customizer_reset" class="btn btn-sm btn-light">Reset Defaults</button>
            </div>
        </div>
        <div class="card-body">
             <div class="mb-5">
                <div class="text-muted fs-7">Select a full color scheme. Visual order: Primary, Secondary, Success, Info, Warning, Danger, Dark, Light.</div>
            </div>

            <div class="row g-5" id="kt_theme_customizer_patterns">
                
                <!-- Default Green -->
                <div class="col-xl-4 col-md-6">
                     <div class="cursor-pointer border border-hover-primary rounded-3 p-4 theme-pattern h-100" 
                          onclick="setTheme({
                              primary: '#17C653', secondary: '#F1F1F4', success: '#1B84FF', info: '#7239EA', warning: '#F6C000', danger: '#F8285A', dark: '#1E2129', light: '#F9F9F9'
                          })">
                          <div class="d-flex flex-column gap-3">
                              <span class="fs-5 fw-bold text-gray-800">Default Green</span>
                              <div class="d-flex rounded-2 overflow-hidden shadow-sm border border-gray-300" style="height: 40px;">
                                  <div class="flex-grow-1" style="background-color: #17C653" title="Primary"></div>
                                  <div class="flex-grow-1" style="background-color: #F1F1F4" title="Secondary"></div>
                                  <div class="flex-grow-1" style="background-color: #1B84FF" title="Success"></div>
                                  <div class="flex-grow-1" style="background-color: #7239EA" title="Info"></div>
                                  <div class="flex-grow-1" style="background-color: #F6C000" title="Warning"></div>
                                  <div class="flex-grow-1" style="background-color: #F8285A" title="Danger"></div>
                                  <div class="flex-grow-1" style="background-color: #1E2129" title="Dark"></div>
                                  <div class="flex-grow-1" style="background-color: #F9F9F9" title="Light"></div>
                              </div>
                          </div>
                     </div>
                </div>

                <!-- Ocean Blue -->
                <div class="col-xl-4 col-md-6">
                     <div class="cursor-pointer border border-hover-primary rounded-3 p-4 theme-pattern h-100" 
                          onclick="setTheme({
                              primary: '#009EF7', secondary: '#F1F1F4', success: '#50CD89', info: '#7239EA', warning: '#FFC700', danger: '#F1416C', dark: '#181C32', light: '#F9F9F9'
                          })">
                          <div class="d-flex flex-column gap-3">
                              <span class="fs-5 fw-bold text-gray-800">Ocean Blue</span>
                               <div class="d-flex rounded-2 overflow-hidden shadow-sm border border-gray-300" style="height: 40px;">
                                  <div class="flex-grow-1" style="background-color: #009EF7"></div>
                                  <div class="flex-grow-1" style="background-color: #F1F1F4"></div>
                                  <div class="flex-grow-1" style="background-color: #50CD89"></div>
                                  <div class="flex-grow-1" style="background-color: #7239EA"></div>
                                  <div class="flex-grow-1" style="background-color: #FFC700"></div>
                                  <div class="flex-grow-1" style="background-color: #F1416C"></div>
                                  <div class="flex-grow-1" style="background-color: #181C32"></div>
                                  <div class="flex-grow-1" style="background-color: #F9F9F9"></div>
                              </div>
                          </div>
                     </div>
                </div>

                <!-- Royal Purple -->
                <div class="col-xl-4 col-md-6">
                     <div class="cursor-pointer border border-hover-primary rounded-3 p-4 theme-pattern h-100" 
                          onclick="setTheme({
                              primary: '#8950FC', secondary: '#EEE5FF', success: '#1BC5BD', info: '#3699FF', warning: '#FFA800', danger: '#F64E60', dark: '#212121', light: '#ffffff'
                          })">
                          <div class="d-flex flex-column gap-3">
                              <span class="fs-5 fw-bold text-gray-800">Royal Purple</span>
                               <div class="d-flex rounded-2 overflow-hidden shadow-sm border border-gray-300" style="height: 40px;">
                                  <div class="flex-grow-1" style="background-color: #8950FC"></div>
                                  <div class="flex-grow-1" style="background-color: #EEE5FF"></div>
                                  <div class="flex-grow-1" style="background-color: #1BC5BD"></div>
                                  <div class="flex-grow-1" style="background-color: #3699FF"></div>
                                  <div class="flex-grow-1" style="background-color: #FFA800"></div>
                                  <div class="flex-grow-1" style="background-color: #F64E60"></div>
                                  <div class="flex-grow-1" style="background-color: #212121"></div>
                                  <div class="flex-grow-1" style="background-color: #ffffff"></div>
                              </div>
                          </div>
                     </div>
                </div>

                <!-- Sunset Warm -->
                <div class="col-xl-4 col-md-6">
                     <div class="cursor-pointer border border-hover-primary rounded-3 p-4 theme-pattern h-100" 
                          onclick="setTheme({
                              primary: '#FD7E14', secondary: '#FFF4E6', success: '#28A745', info: '#17A2B8', warning: '#FFC107', danger: '#DC3545', dark: '#343A40', light: '#ffffff'
                          })">
                          <div class="d-flex flex-column gap-3">
                              <span class="fs-5 fw-bold text-gray-800">Sunset Warm</span>
                               <div class="d-flex rounded-2 overflow-hidden shadow-sm border border-gray-300" style="height: 40px;">
                                  <div class="flex-grow-1" style="background-color: #FD7E14"></div>
                                  <div class="flex-grow-1" style="background-color: #FFF4E6"></div>
                                  <div class="flex-grow-1" style="background-color: #28A745"></div>
                                  <div class="flex-grow-1" style="background-color: #17A2B8"></div>
                                  <div class="flex-grow-1" style="background-color: #FFC107"></div>
                                  <div class="flex-grow-1" style="background-color: #DC3545"></div>
                                  <div class="flex-grow-1" style="background-color: #343A40"></div>
                                  <div class="flex-grow-1" style="background-color: #ffffff"></div>
                              </div>
                          </div>
                     </div>
                </div>

                 <!-- Earth Tones -->
                 <div class="col-xl-4 col-md-6">
                     <div class="cursor-pointer border border-hover-primary rounded-3 p-4 theme-pattern h-100" 
                          onclick="setTheme({
                              primary: '#795548', secondary: '#EFEBE9', success: '#4CAF50', info: '#607D8B', warning: '#FF9800', danger: '#8D6E63', dark: '#3E2723', light: '#F5F5F5'
                          })">
                          <div class="d-flex flex-column gap-3">
                              <span class="fs-5 fw-bold text-gray-800">Earth Tones</span>
                               <div class="d-flex rounded-2 overflow-hidden shadow-sm border border-gray-300" style="height: 40px;">
                                  <div class="flex-grow-1" style="background-color: #795548"></div>
                                  <div class="flex-grow-1" style="background-color: #EFEBE9"></div>
                                  <div class="flex-grow-1" style="background-color: #4CAF50"></div>
                                  <div class="flex-grow-1" style="background-color: #607D8B"></div>
                                  <div class="flex-grow-1" style="background-color: #FF9800"></div>
                                  <div class="flex-grow-1" style="background-color: #8D6E63"></div>
                                  <div class="flex-grow-1" style="background-color: #3E2723"></div>
                                  <div class="flex-grow-1" style="background-color: #F5F5F5"></div>
                              </div>
                          </div>
                     </div>
                </div>
                
                <!-- Midnight Neon -->
                <!-- Crimson Night -->
                 <div class="col-xl-4 col-md-6">
                     <div class="cursor-pointer border border-hover-primary rounded-3 p-4 theme-pattern h-100" 
                          onclick="setTheme({
                              primary: '#D81B60', secondary: '#212121', success: '#00C853', info: '#00B0FF', warning: '#FFAB00', danger: '#D50000', dark: '#000000', light: '#ECEFF1'
                          })">
                          <div class="d-flex flex-column gap-3">
                              <span class="fs-5 fw-bold text-gray-800">Crimson Night</span>
                               <div class="d-flex rounded-2 overflow-hidden shadow-sm border border-gray-300" style="height: 40px;">
                                  <div class="flex-grow-1" style="background-color: #D81B60" title="Primary"></div>
                                  <div class="flex-grow-1" style="background-color: #212121" title="Secondary"></div>
                                  <div class="flex-grow-1" style="background-color: #00C853" title="Success"></div>
                                  <div class="flex-grow-1" style="background-color: #00B0FF" title="Info"></div>
                                  <div class="flex-grow-1" style="background-color: #FFAB00" title="Warning"></div>
                                  <div class="flex-grow-1" style="background-color: #D50000" title="Danger"></div>
                                  <div class="flex-grow-1" style="background-color: #000000" title="Dark"></div>
                                  <div class="flex-grow-1" style="background-color: #ECEFF1" title="Light"></div>
                              </div>
                          </div>
                     </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Your page content here -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Color Results Verification</h3>
        </div>
        <div class="card-body">
            <h2 class="mb-5">Welcome to your Dashboard</h2>
            
            <div class="mb-10">
                <h4 class="mb-3">Solid Buttons</h4>
                <div class="d-flex gap-2 flex-wrap">
                    <button type="button" class="btn btn-primary">Primary</button>
                    <button type="button" class="btn btn-secondary">Secondary</button>
                    <button type="button" class="btn btn-success">Success</button>
                    <button type="button" class="btn btn-info">Info</button>
                    <button type="button" class="btn btn-warning">Warning</button>
                    <button type="button" class="btn btn-danger">Danger</button>
                    <button type="button" class="btn btn-dark">Dark</button>
                    <button type="button" class="btn btn-light">Light</button>
                    <button type="button" class="btn btn-link">Link</button>
                </div>
            </div>

            <div class="mb-10">
                <h4 class="mb-3">Outline Buttons</h4>
                <div class="d-flex gap-2 flex-wrap">
                    <button type="button" class="btn btn-outline-primary">Primary</button>
                    <button type="button" class="btn btn-outline-secondary">Secondary</button>
                    <button type="button" class="btn btn-outline-success">Success</button>
                    <button type="button" class="btn btn-outline-info">Info</button>
                    <button type="button" class="btn btn-outline-warning">Warning</button>
                    <button type="button" class="btn btn-outline-danger">Danger</button>
                    <button type="button" class="btn btn-outline-dark">Dark</button>
                </div>
            </div>

            <div class="mb-10">
                <h4 class="mb-3">Light Buttons (Custom)</h4>
                <div class="d-flex gap-2 flex-wrap">
                    <button type="button" class="btn btn-light-primary">Light Primary</button>
                    <button type="button" class="btn btn-light-success">Light Success</button>
                    <button type="button" class="btn btn-light-info">Light Info</button>
                    <button type="button" class="btn btn-light-warning">Light Warning</button>
                    <button type="button" class="btn btn-light-danger">Light Danger</button>
                </div>
            </div>
            
        </div>
    </div>

    <script>
    let currentPalette = null;

    document.addEventListener('DOMContentLoaded', function() {
        const resetBtn = document.getElementById('kt_theme_customizer_reset');
        const saveBtn = document.getElementById('kt_theme_customizer_save');
        
        if(resetBtn){
            resetBtn.addEventListener('click', function() {
                 localStorage.removeItem('kt_user_theme_palette');
                 location.reload();
            });
        }

        if(saveBtn){
            saveBtn.addEventListener('click', function() {
                if(currentPalette) {
                    localStorage.setItem('kt_user_theme_palette', JSON.stringify(currentPalette));
                    alert('Theme configuration saved successfully!');
                } else {
                    alert('Please select a theme first.');
                }
            });
        }
    });

    function setTheme(palette) {
        currentPalette = palette;

        // Iterate through all keys in the palette object (primary, secondary, etc.)
        for (const [key, hex] of Object.entries(palette)) {
            // Set the main CSS variable (e.g., --bs-primary: #123456)
            document.documentElement.style.setProperty(`--bs-${key}`, hex);

            // Calculate derived values if it's a valid hex
            const rgb = hexToRgb(hex);
            if (rgb) {
                // Set RGB variable (e.g., --bs-primary-rgb: 18, 52, 86)
                document.documentElement.style.setProperty(`--bs-${key}-rgb`, `${rgb.r}, ${rgb.g}, ${rgb.b}`);
                
                // Set Light variable (e.g., --bs-primary-light) - 90% white mix
                const lightColor = mixColors(rgb, {r: 255, g: 255, b: 255}, 0.90);
                document.documentElement.style.setProperty(`--bs-${key}-light`, `rgb(${lightColor.r}, ${lightColor.g}, ${lightColor.b})`);

                // Set Active variable (e.g., --bs-primary-active) - 10% darker
                const activeColor = shadeColor(hex, -10);
                document.documentElement.style.setProperty(`--bs-${key}-active`, activeColor);

                // Set Inverse color (Text color on top of solid background)
                const inverseColor = getContrastColor(hex);
                document.documentElement.style.setProperty(`--bs-${key}-inverse`, inverseColor);
            }
        }

        // Special case: Link color often matches primary
        if (palette.primary) {
             document.documentElement.style.setProperty('--bs-link-color', palette.primary);
        }
    }

    function hexToRgb(hex) {
        const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16)
        } : null;
    }

    // Weight is 0-1, amount of color2 to mix into color1
    function mixColors(color1, color2, weight) {
        return {
            r: Math.round(color1.r * (1 - weight) + color2.r * weight),
            g: Math.round(color1.g * (1 - weight) + color2.g * weight),
            b: Math.round(color1.b * (1 - weight) + color2.b * weight)
        };
    }

    function getContrastColor(hex) {
        const rgb = hexToRgb(hex);
        if (!rgb) return '#ffffff';
        
        // Calculate relative luminance
        const brightness = (rgb.r * 299 + rgb.g * 587 + rgb.b * 114) / 1000;
        
        // Return black for bright colors, white for dark colors
        return brightness > 128 ? '#000000' : '#ffffff';
    }

    function shadeColor(color, percent) {
        var R = parseInt(color.substring(1,3),16);
        var G = parseInt(color.substring(3,5),16);
        var B = parseInt(color.substring(5,7),16);

        R = parseInt(R * (100 + percent) / 100);
        G = parseInt(G * (100 + percent) / 100);
        B = parseInt(B * (100 + percent) / 100);

        R = (R<255)?R:255;  
        G = (G<255)?G:255;  
        B = (B<255)?B:255;  
        
        R = Math.round(R);
        G = Math.round(G);
        B = Math.round(B);

        var RR = ((R.toString(16).length==1)?"0"+R.toString(16):R.toString(16));
        var GG = ((G.toString(16).length==1)?"0"+G.toString(16):G.toString(16));
        var BB = ((B.toString(16).length==1)?"0"+B.toString(16):B.toString(16));

        return "#"+RR+GG+BB;
    }
    </script>
@endsection