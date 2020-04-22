<?php
// Disable PHP error reporting
error_reporting(0);

// Set default timezone to CET (Central European Time)
date_default_timezone_set('Europe/Amsterdam');

// Enable compression
ob_start('ob_gzhandler');

// Response headers
header('Cache-Control: max-age=86400', true);
header('Content-Language: en-GB', true);
header('Content-Type: text/html; charset=utf-8', true);
header('Referrer-Policy: same-origin', true);
header('Strict-Transport-Security: max-age=31536000; includeSubDomains', true);
header('X-Content-Type-Options: nosniff', true);
header('X-DNS-Prefetch-Control: on', true);
header('X-Frame-Options: SAMEORIGIN', true);
header('X-Robots-Tag: index, follow', true);
header('X-UA-Compatible: IE=edge', true);
header('X-XSS-Protection: 1; mode=block', true);

// HTTP request method and request URI are required
if (
    !isset($_SERVER['REQUEST_METHOD'])
    || !isset($_SERVER['REQUEST_URI'])
    || empty($_SERVER['REQUEST_URI'])
) {
    header('Internal Server Error', true, 500);
    ob_flush();
    flush();
    exit(1);
}

// Allow GET and HEAD requests
$_SERVER['REQUEST_METHOD'] = strtoupper($_SERVER['REQUEST_METHOD']);
if ($_SERVER['REQUEST_METHOD'] === 'HEAD') {
    ob_flush();
    flush();
    exit(0);
}

/**
 * Add page variables: `$canonical` contains the `storecore.io` canonical
 * URL, `$description` the text for the meta tag `description`, and `$title`
 * the page title.  The `$open_graph_image` is an optional URL for the
 * Open Graph `og:image` property.
 *
 * @see https://ogp.me/
 *      The Open Graph protocol
 *
 * @see https://developer.twitter.com/en/docs/tweets/optimize-with-cards/guides/getting-started
 *      Optimize Tweets with Cards - Twitter Developers
 * 
 * @see https://business.twitter.com/en/help/campaign-setup/advertiser-card-specifications.html
 *      Twitter ad specs and formats - Twitter Business
 *
 * @see https://blog.hubspot.com/marketing/open-graph-tags-facebook-twitter-linkedin
 *      How to Optimize Blog Images for Social Sharing: An Intro to Open Graph Tags, by Lindsay Kolowich
 */
$description = '';
$title = 'StoreCore';
$open_graph_image = 'https://www.storecore.io/images/331990-1200x675.jpg';

$_SERVER['REQUEST_URI'] = strip_tags($_SERVER['REQUEST_URI']);
$_SERVER['REQUEST_URI'] = mb_strtolower($_SERVER['REQUEST_URI'], 'UTF-8');
$_SERVER['REQUEST_URI'] = str_replace('.php', null, $_SERVER['REQUEST_URI']);

$uri = strtok($_SERVER['REQUEST_URI'], '?');
$canonical = 'https://www.storecore.io' . $uri;
switch ($uri) {
    case '/':
        $canonical   = 'https://www.storecore.io/';
        $description = 'StoreCore is an open-source e-commerce framework.';
        $title       = 'StoreCore™';
        break;
    case '/contact':
        $canonical        = 'https://www.storecore.io/contact';
        $description      = 'Office location, e-mail address, telephone number, and other contact details for StoreCore in Eindhoven.';
        $open_graph_image = 'https://www.storecore.io/images/380768-1200x675.jpg';
        $title            = 'Contact StoreCore';
        break;
      case '/knowledge-base/':
        $canonical   = 'https://www.storecore.io/knowledge-base/';
        $description = 'The StoreCore knowledge base (KB) contains manuals, guides, and instructions for users, designers, and developers.';
        $title       = 'Knowledge Base (KB)';
        break;
    case '/knowledge-base/user-guides/installation-quickstart-guide':
        $canonical   = 'https://www.storecore.io/knowledge-base/user-guides/installation-quickstart-guide';
        $title       = 'Installation QuickStart Guide (QSG)';
        break;
    case '/license':
    case '/licenses':
        $canonical   = 'https://www.storecore.io/licenses';
        $description = 'StoreCore is available as free and open-source software (FOSS) under the GNU General Public License version 3 (GPLv3) and includes open-source software under a variety of other licenses.';
        $title       = 'Licenses';
        break;
    case '/privacy-policy':
        $canonical   = 'https://www.storecore.io/privacy-policy';
        $title       = 'Privacy policy';
        break;
    default:
        $title = $uri;
        $title = trim($title, '/');
        $title = end(explode('/', $title));
        $title = ucfirst($title);
        $title = str_replace('-', ' ', $title);
        $title = str_replace('/', ' – ', $title);
        $title = str_ireplace('storecore', 'StoreCore', $title);
}

// Add missing `description` to prevent empty metadata.
if (!isset($description) || empty($description)) {
    $description = $title;
}

// Append ' - StoreCore' to page title.
if (strpos($title, 'StoreCore') === false){
    $title .= ' - StoreCore';
}

?>
<!doctype html>
<html ⚡ dir="ltr" lang="en-uk">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">

    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="description" content="<?= $description ?>">
    <meta name="format-detection" content="telephone=no">
    <meta name="msapplication-TileColor" content="#dcedc8">
    <meta name="msapplication-TileImage" content="/images/StoreCore-icon-144x144.png">
    <meta name="theme-color" content="#689f38">

    <meta name="twitter:card" content="summary"> 
    <meta name="twitter:site" content="@StoreCoreHQ">
    <meta property="og:title" content="<?= $title ?>">
    <meta property="og:url" content="<?= $canonical ?>">
    <meta property="og:description" content="<?= $description ?>">
    <meta property="og:image" content="<?= $open_graph_image ?>">
    <meta property="og:site_name" content="StoreCore">

    <link href="https://cdn.ampproject.org/v0.js" rel="preload" as="script">
    <link crossorigin href="https://fonts.gstatic.com/" rel="preconnect dns-prefetch">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="preload" as="style">

    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <script async custom-element="amp-fx-collection" src="https://cdn.ampproject.org/v0/amp-fx-collection-0.1.js"></script>
    <script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
    <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
    <script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>
<?php
ob_flush();
flush();
?>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500%7CNoto+Serif:400,400i,700%7CRoboto+Mono:500&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:900&amp;text=Store&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style amp-custom><?php require 'storecore.min.css' ?></style>
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>

    <link rel="canonical" href="<?= $canonical ?>">
    <title><?= $title ?></title>

    <link href="/images/StoreCore-icon-152x152.png" rel="apple-touch-icon-precomposed">
    <link href="/images/StoreCore-icon-196x196.png" rel="shortcut icon" sizes="196x196">
    <link href="/images/StoreCore-icon-152x152.png" rel="apple-touch-icon" sizes="152x152">
    <link href="/images/StoreCore-icon-144x144.png" rel="apple-touch-icon" sizes="144x144">
    <link href="/images/StoreCore-icon-114x114.png" rel="apple-touch-icon" sizes="114x114">
    <link href="/images/StoreCore-icon-196x196.png" rel="icon" sizes="196x196">
    <link href="/images/StoreCore-icon-152x152.png" rel="icon" sizes="152x152">
    <link href="/images/StoreCore-icon-144x144.png" rel="icon" sizes="144x144">
    <link href="/images/StoreCore-icon-114x114.png" rel="icon" sizes="114x114">

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "StoreCore",
      "url": "https://www.storecore.io/",
      "logo": "https://www.storecore.io/images/StoreCore-icon-196x196.png"
    }
    </script>
  </head>
  <body>
    <amp-sidebar id="sidebar" layout="nodisplay" side="left">
      <div class="mdc-drawer__content">
        <div class="mdc-drawer__header">
          <a href="/?utm_source=storecore.io&amp;utm_medium=navigation-drawer&amp;utm_content=logo" title="StoreCore">
            <amp-img alt="StoreCore" height="48" layout="fixed" src="/images/StoreCore-icon-144x144.png" srcset="/images/StoreCore-icon-144x144.webp 144w, /images/StoreCore-icon-196x196.webp 196w" width="48"></amp-img>
            <strong>Store</strong>Core
          </a>
        </div>
        <nav>
          <ul>
            <li><a <?php if ($uri === '/') { echo 'class="mdc-list-item--activated"'; } ?> href="/?utm_source=storecore.io&amp;utm_medium=navigation-drawer&amp;utm_content=Home" hreflang="en-GB"><i class="material-icons" aria-hidden="true">home</i> <span>Home</span></a></li>
            <li><a href="https://www.storecore.io/plans-and-pricing?utm_source=storecore.io&amp;utm_medium=navigation-drawer&amp;utm_content=Plans%20and%20pricing"><i class="material-icons" aria-hidden="true">view_list</i> <span>Plans and pricing</span></a></li>
          </ul>
          <hr>
          <ul>
            <li><a <?php if ($uri === '/knowledge-base/user-guides/') { echo 'class="mdc-list-item--activated"'; } ?> href="/knowledge-base/user-guides/?utm_source=storecore.io&amp;utm_medium=navigation-drawer&amp;utm_content=User%20guides" title="User guides"> <i class="material-icons" aria-hidden="true">local_library</i> <span>User guides</span></a></li>
            <li><a <?php if ($uri === '/knowledge-base/design-guides/') { echo 'class="mdc-list-item--activated"'; } ?> href="/knowledge-base/design-guides/?utm_source=storecore.io&amp;utm_medium=navigation-drawer&amp;utm_content=Design%20guides" title="Design guides"><i class="material-icons" aria-hidden="true">style</i> <span>Design guides</span></a></li>
            <li><a <?php if ($uri === '/knowledge-base/developer-guides/') { echo 'class="mdc-list-item--activated"'; } ?>  href="/knowledge-base/developer-guides/?utm_source=storecore.io&amp;utm_medium=navigation-drawer&amp;utm_content=Developer%20guides" title="Developer guides"><i class="material-icons" aria-hidden="true">build</i> <span>Developer guides</span></a></li>
          </ul>
          <hr>
          <ul>
            <li><a href="https://github.com/storecore/core/issues" rel="noreferrer noopener" title="StoreCore issues on GitHub"><i class="material-icons" aria-hidden="true">bug_report</i> <span>Report a bug</span></a></li>
            <li><a href="https://storecore.freshdesk.com/support/home" rel="noreferrer noopener" title="StoreCore Support"><i class="material-icons" aria-hidden="true">contact_support</i> <span>Contact support</span></a></li>
          </ul>
          <hr>
          <ul>
            <li><a <?php if ($uri === '/licenses') { echo 'class="mdc-list-item--activated"'; } ?> href="/licenses?utm_source=storecore.io&amp;utm_medium=navigation-drawer&amp;utm_content=Licenses" title="Licenses"><i class="material-icons" aria-hidden="true">gavel</i> <span>Licenses</span></a></li>
            <li><a <?php if ($uri === '/privacy-policy') { echo 'class="mdc-list-item--activated"'; } ?> href="/privacy-policy" title="Privacy policy"><i class="material-icons" aria-hidden="true">security</i> <span>Privacy policy</span></a></li>
          </ul>
        </nav>
      </div>
    </amp-sidebar>
    <header amp-fx="float-in-top" class="mdc-top-app-bar mdc-top-app-bar--fixed">
      <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
          <button class="material-icons mdc-top-app-bar__navigation-icon mdc-icon-button" on="tap:sidebar">menu</button>
          <span class="mdc-top-app-bar__title"><a href="https://www.storecore.io/?utm_source=storecore.io&amp;utm_medium=top-app-bar&amp;utm_content=StoreCore" title="StoreCore">StoreCore</a></span>
        </section>
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
          <a aria-label="Help" class="material-icons mdc-top-app-bar__action-item mdc-icon-button" href="/knowledge-base/?utm_source=storecore.io&amp;utm_medium=top-app-bar&amp;utm_content=icon-help-outline" title="Support">help_outline</a>
        </section>
      </div>
    </header>
    <main class="mdc-top-app-bar--fixed-adjust">
