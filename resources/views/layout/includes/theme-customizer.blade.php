<script>
    var defaultThemeMode = "light";
    var themeMode;
    if (document.documentElement) {
        if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
        } else {
            if (localStorage.getItem("data-bs-theme") !== null) {
                themeMode = localStorage.getItem("data-bs-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }
        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-bs-theme", themeMode);
    }

    // Restore custom color palette if saved
    var savedPalette = localStorage.getItem('kt_user_theme_palette');
    if (savedPalette) {
        var palette = JSON.parse(savedPalette);
        for (const [key, hex] of Object.entries(palette)) {
            document.documentElement.style.setProperty(`--bs-${key}`, hex);
            
            // Re-calculate derived values (RGB, Light, Active, Inverse)
            // Note: repeated logic from welcome.blade.php but necessary for early execution
            var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
            if(result) {
                var r = parseInt(result[1], 16);
                var g = parseInt(result[2], 16);
                var b = parseInt(result[3], 16);
                document.documentElement.style.setProperty(`--bs-${key}-rgb`, `${r}, ${g}, ${b}`);

                // Light (Mix with white 90%)
                var lightR = Math.round(r * 0.1 + 255 * 0.9);
                var lightG = Math.round(g * 0.1 + 255 * 0.9);
                var lightB = Math.round(b * 0.1 + 255 * 0.9);
                document.documentElement.style.setProperty(`--bs-${key}-light`, `rgb(${lightR}, ${lightG}, ${lightB})`);

                // Active (Shade -10%)
                // Simple shade function for early init
                 var R_a = parseInt(r * 0.9);
                 var G_a = parseInt(g * 0.9);
                 var B_a = parseInt(b * 0.9);
                 var RR = ((R_a.toString(16).length==1)?"0"+R_a.toString(16):R_a.toString(16));
                 var GG = ((G_a.toString(16).length==1)?"0"+G_a.toString(16):G_a.toString(16));
                 var BB = ((B_a.toString(16).length==1)?"0"+B_a.toString(16):B_a.toString(16));
                 document.documentElement.style.setProperty(`--bs-${key}-active`, "#"+RR+GG+BB);

                 // Inverse / Contrast
                 var brightness = (r * 299 + g * 587 + b * 114) / 1000;
                 var inverse = brightness > 128 ? '#000000' : '#ffffff';
                 document.documentElement.style.setProperty(`--bs-${key}-inverse`, inverse);
            }
        }
        if (palette.primary) {
             document.documentElement.style.setProperty('--bs-link-color', palette.primary);
        }
    }
</script>
