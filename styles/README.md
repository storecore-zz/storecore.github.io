Amplified Material Design
=========================

The [StoreCore website](http://storecore.io/) runs on *Amplified Material
Design:* a subset of [Material Design Lite (MDL)](https://getmdl.io/) that is
optimized for [Accelerated Mobile Pages (AMP)](https://www.ampproject.org/).

Amplified Material Design resolves four limitations in CSS for AMP:

- external, linked CSS files are not allowed;
- CSS in `<style amp-custom>...</style>` cannot exceed 50,000 characters;
- CSS can only be applied through HTML `class` and `id` selectors;
- JavaScript is not supported.


## MDL components

The current design is based on the MDL version 1.3.0 default CSS stylesheet
with the Material Design colors Light Green and Light Blue.  This original
stylesheet is included in the master `material.min.css` file for reference
purposes.

Individual MDL components that are not used by all web pages, were moved out to
separate files with the `mdl-` prefix and a `.material.min.css` suffix.  For
example, the `mdl-menu.material.min.css` file contains all CSS code for the MDL
menu component.  These components may be brought back in if they are needed for
a specific web page.


## No custom JavaScript

Custom JavaScript is not allowed in an AMP page.  Therefore the ripple
animation effect and JavaScript layout upgrades are not supported in Amplified
Material Design.  CSS classes like `ripple` or `ripple-container` and the
`is-upgraded` modifiers were stripped from the original MDL code.
