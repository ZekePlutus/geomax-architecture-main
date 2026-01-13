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

    // Global function to apply theme palette
    window.applyTheme = function(palette) {
        for (const [key, hex] of Object.entries(palette)) {
            // Set the main CSS variable
            document.documentElement.style.setProperty(`--bs-${key}`, hex);
            document.documentElement.style.setProperty(`--bs-text-${key}`, hex);

            // Calculate derived values
            const rgb = hexToRgb(hex);
            if (rgb) {
                // Set RGB variable
                document.documentElement.style.setProperty(`--bs-${key}-rgb`, `${rgb.r}, ${rgb.g}, ${rgb.b}`);
                
                // Set Light variable (90% white mix)
                const lightColor = mixColors(rgb, {r: 255, g: 255, b: 255}, 0.90);
                document.documentElement.style.setProperty(`--bs-${key}-light`, `rgb(${lightColor.r}, ${lightColor.g}, ${lightColor.b})`);

                // Set Active variable (10% darker)
                const activeColor = shadeColor(hex, -10);
                document.documentElement.style.setProperty(`--bs-${key}-active`, activeColor);

                // Set Inverse color
                const inverseColor = getContrastColor(hex);
                document.documentElement.style.setProperty(`--bs-${key}-inverse`, inverseColor);
            }
        }

        // Special case: Link color often matches primary
        if (palette.primary) {
             document.documentElement.style.setProperty('--bs-link-color', palette.primary);
        }
    };

    // Helper functions
    window.hexToRgb = function(hex) {
        const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16)
        } : null;
    };

    window.mixColors = function(color1, color2, weight) {
        return {
            r: Math.round(color1.r * (1 - weight) + color2.r * weight),
            g: Math.round(color1.g * (1 - weight) + color2.g * weight),
            b: Math.round(color1.b * (1 - weight) + color2.b * weight)
        };
    };

    window.getContrastColor = function(hex) {
        const rgb = hexToRgb(hex);
        if (!rgb) return '#ffffff';
        const brightness = (rgb.r * 299 + rgb.g * 587 + rgb.b * 114) / 1000;
        return brightness > 128 ? '#000000' : '#ffffff';
    };

    window.shadeColor = function(color, percent) {
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
    };

    // Restore custom color palette if saved
    var savedPalette = localStorage.getItem('kt_user_theme_palette');
    if (savedPalette) {
        applyTheme(JSON.parse(savedPalette));
    }
</script>
