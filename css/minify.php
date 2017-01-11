<?php
/**
 * AMP Custom CSS Minify Helper.
 *
 * This small PHP helper minifies CSS files for the http://storecore.io/ GitHub
 * repository at https://github.com/storecore/storecore.github.io.  Use the
 * unminified CSS stylesheet files as a reference for available formatting and
 * to add or update styles.  Then run the minifier to create a copy for the
 * AMP <style amp-custom>...</style> section of an HTML document.
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @version   1.0.0
 */

// Local files to minify
$files = array(
    'help-amp-custom.css',
);

foreach ($files as $file) {
    $filename = realpath(__DIR__ . DIRECTORY_SEPARATOR . $file);
    if (is_file($filename)) {
        $css = file_get_contents($filename);

        $css = str_ireplace("\r\n", "\n", $css);

        // Remove double-spaced indentation.
        $css = str_ireplace("\t", '  ', $css);
        $css = str_ireplace("\n      ", "\n", $css);
        $css = str_ireplace("\n    ", "\n", $css);
        $css = str_ireplace("\n  ", "\n", $css);

        // Shorten common CSS structures.
        $css = str_ireplace(' {', '{', $css);
        $css = str_ireplace(";\n}", '}', $css);
        $css = str_ireplace(': ', ':', $css);
        $css = str_ireplace(', ', ',', $css);
        $css = str_ireplace("\n", null, $css);

        // Shorten known components.
        $css = str_ireplace('rgba(0,0,0,0.14)', 'rgba(0,0,0,.14)', $css);
        $css = str_ireplace('rgba(0,0,0,0.2)', 'rgba(0,0,0,.2)', $css);

        // Save the minified CSS file.
        $filename = substr($filename, 0, strlen($filename) - 4) . '.min.css';
        $fp = fopen($filename, 'w');
        fwrite($fp, $css);
        fclose($fp);
    }
}
