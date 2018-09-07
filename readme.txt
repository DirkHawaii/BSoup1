=== DHD BSoup1 - OOP Twenty Seventeen ===
Contributors: the WordPress team, Dirk Harriman
Requires at least: WordPress 4.7
Tested up to: WordPress 5.0-trunk
Version: 1.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: one-column, two-columns, right-sidebar, flexible-header, accessibility-ready, custom-colors, custom-header, custom-menu, custom-logo, editor-style, featured-images, footer-widgets, post-formats, rtl-language-support, sticky-post, theme-options, threaded-comments, translation-ready

== Description ==

BSoup 1 is an OOP version of Twenty Seventeen. It brings your site to life with header video and immersive featured images. With a focus on business sites, it features multiple sections on the front page as well as widgets, navigation and social menus, a logo, and more. Personalize its asymmetrical grid with a custom color scheme and showcase your multimedia content with post formats. Our default theme for 2017 works great in many languages, for any abilities, and on any device.

/*************************************************************************************************/
== Files and Folders ==

assets/
    css/
        colors-dark.css
        editor-style.css
        ie8.css
        ie9.css
    images/
        coffee.jpg
        espresso.jpg
        header.jpg
        sandwich.jpg
        svg-icons.svg
    js/
        customize-controls.js
        customize-preview.js
        global.js
        html5.js
        jquery.scrollTo.js
        navigation.js
        skip-link-focus-fix.js
css/
    images/
        ui-icons_000000_256x240.png
        ui-icons_354157_256x240.png
        ui-icons_444444_256x240.png
        ui-icons_555555_256x240.png
        ui-icons_777620_256x240.png
        ui-icons_777777_256x240.png
        ui-icons_cc0000_256x240.png
        ui-icons_ffffff_256x240.png
    admin.css
    animate.css
    bootstrap-grid.css
    bootstrap-grid.css.map
    bootstrap-grid.min.css
    bootstrap-grid.min.css.map
    bootstrap-reboot.css
    bootstrap-reboot.css.map
    bootstrap-reboot.min.css
    bootstrap-reboot.min.css.map
    bootstrap.css
    bootstrap.css.map
    bootstrap.min.css
    bootstrap.min.css.map
    flexslider.css
    font-awesome.css
    font-awesome.min.css
    ie10-viewport-bug-workaround.css
    jquery-ui.css
    jquery-ui.css.map
    jquery-ui.min.css
    jquery-ui.scss
    jquery-ui.structure.css
    jquery-ui.structure.min.css
    jquery-ui.theme.css
    jquery-ui.theme.min.css
    jquery-ui3.css
    queries.css
    regForm.css
    site.css
    Site2.css
    styles.css
inc/
    bsoup1-back-compat.php
    bsoup1-carousel.php
    bsoup1-contact.php
    bsoup1-customizer.php
    bsoup1-header.php
    bsoup1-icon.php
    bsoup1-loader.php
    bsoup1-manager.php
    bsoup1-obj.php
    bsoup1-style.php
    bsoup1-template.php
    bsoup1-widgets.php
js/
    easing/
        EasePack.min.js
    plugins/
        AttrPlugin.min.js
        BezierPlugin.min.js
        ColorPropsPlugin.min.js
        CSSPlugin.min.js
        CSSRulePlugin.min.js
        DirectionalRotationPlugin.min.js
        EaselPlugin.min.js
        EndArrayPlugin.min.js
        KineticPlugin.min.js
        RaphaelPlugin.min.js
        RoundPropsPlugin.min.js
        ScrollToPlugin.min.js
        TextPlugin.min.js
    umd/
        alert.js
        button.js
        carousel.js
        collapse.js
        dropdown.js
        modal.js
        popover.js
        scrollspy.js
        tab.js
        tooltip.js
        util.js
    unit/
        alert.js
        button.js
        carousel.js
        collapse.js
        dropdown.js
        modal.js
        popover.js
        scrollspy.js
        tab.js
        tooltip.js
    utils/
        Draggable.min.js
    vendor/
        anchor.min.js
        clipboard.min.js
        holder.min.js
        jquery-slim.min.js
        jquery.js
        jquery.min.js
        popper.min.js
        qunit.css
        qunit.js
    bootstrap.js
    bootstrap.min.js
    contact-img.js
    docs.min.js
    ie-emulation-modes-warning.js
    ie10-viewport-bug-workaround.js
    jquery-ui.js
    jquery-ui.min.js
    jquery.custom.js
    jquery.js
    jquery.min.js
    mult-featured-img.js
    npm.js
    popper.min.js
    TimelineLite.min.js
    TimelineMax.min.js
    TweenLite.min.js
    TweenMax.min.js
lib/
    bootstrap-four-wp-navwalker.php
template-parts/
    footer/
        footer-widgets.php
        site-info.php
    header/
        header-image.php
        site-branding.php
    navigation/
        navigation-top.php
    page/
        content-front-page-panels.php
        content-front-page.php
        content-page.php
    post/
        content-audio.php
        content-excerpt.php
        content-gallery.php
        content-image.php
        content-none.php
        content-video.php
        content.php

404.php...........................
archive.php.......................
comments.php......................
footer.php........................
front-page.php....................
functions.php.....................
header.php........................
index.php.........................
Notes_001.txt.....................
page.php..........................
postmeta.php......................
README.md.........................
readme.txt........................
rtl.css...........................
SASS_Design.txt...................
Scratch.txt.......................
Scratch2.txt......................
screenshot.png....................
search.php........................
searchform.php....................
sidebar.php.......................
single.php........................
style.css.........................
style.scss........................

/*************************************************************************************************/
The Git Ignore File
/*************************************************************************************************/
# .gitignore file for BSoup1 Theme

# IGNORE TEXT FILES, PNG IMAGE FILES AND CSS MAP FILES
*.txt
*.png
*.map

# EXCEPT THE README.TXT FILE
!readme.txt

# IGNORE THE CSS FOLDER
css/animate.css
css/bootstrap.css
css/bootstrap.min.css
css/bootstrap-grid.css
css/bootstrap-grid.min.css
css/bootstrap-reboot.css
css/bootstrap-reboot.min.css
css/flexslider.css
css/font-awesome.css
css/font-awesome.min.css
css/ie10-viewport-bug-workaround.css
css/jquery-ui.min.css
css/jquery-ui.structure.css
css/jquery-ui.structure.min.css
css/jquery-ui.theme.css
css/jquery-ui.theme.min.css
css/jquery-ui3.css
css/queries.css
css/regForm.css
css/site.css
css/Site2.css
css/jquery.css
css/*.map
css/images/
css/.sass-cache/

# IGNORE THE JS FOLDER, EXCEPT THE JS/JQUERY.CUSTOM.JS FILE
js/easing/
js/plugins/
js/umd/
js/unit/
js/utils/
js/vendor/
js/bootstrap.js
js/bootstrap.min.js
js/contact-img.js
js/docs.min.js
js/ie10-viewport-bug-workaround.js
js/ie-emulation-modes-warning.js
js/jquery.js
js/jquery.min.js
js/jquery-ui.js
js/jquery-ui.min.js
js/multi-featured-img.js
js/npm.js
js/popper.min.js
js/TimelineLite.min.js
js/TimelineMax.min.js
js/TweenLite.min.js
js/TweenMax.min.js


# IGNORE THE .SASS-CACHE FOLDER
.sass-cache/

assets/js/html5.js
assets/js/jquery.scrollTo.js

assets/images/



