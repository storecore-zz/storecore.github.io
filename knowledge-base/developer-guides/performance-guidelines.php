<?php require '../../includes/header.inc.php'; ?>
<article>
  <nav>
    <ol class="amd-breadcrumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
      <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <a href="https://www.storecore.io/?utm_source=storecore.io&amp;utm_medium=breadcrumb&amp;utm_content=Home" itemid="https://www.storecore.io/" itemprop="item" itemscope itemtype="https://schema.org/WebSite">
          <span itemprop="name">Home</span>
        </a>
        <meta itemprop="position" content="1" />
      </li>
      <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <a href="https://www.storecore.io/knowledge-base/?utm_source=storecore.io&amp;utm_medium=breadcrumb&amp;utm_content=Knowledge%20base" itemid="https://www.storecore.io/knowledge-base/" itemprop="item" itemscope itemtype="https://schema.org/WebPage">
          <span itemprop="name">Knowledge base</span>
        </a>
        <meta itemprop="position" content="2" />
      </li>
      <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <a href="https://www.storecore.io/knowledge-base/developer-guides/?utm_source=storecore.io&amp;utm_medium=breadcrumb&amp;utm_content=Developer%20guides" itemid="https://www.storecore.io/knowledge-base/developer-guides/" itemprop="item" itemscope itemtype="https://schema.org/WebPage">
          <span itemprop="name">Developer guides</span>
        </a>
        <meta itemprop="position" content="3" />
      </li>
      <li itemscope itemprop="itemListElement" itemtype="https://schema.org/ListItem">
        <span itemprop="name">Performance guidelines</span>
        <meta itemprop="position" content="4" />
      </li>
    </ol>
  </nav>

  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Article",
    "author": {
      "@type": "Person",
      "givenName": "Ward",
      "familyName": "van der Put",
      "name": "Ward van der Put"
    },
    "headline": "Performance guidelines",
    "description": "Performance is one of the StoreCore design principles. This StoreCore developer guide contains several do’s and don’ts on PHP and MySQL performance.",
    "mainEntityOfPage": "https://www.storecore.io/knowledge-base/developer-guides/performance-guidelines",
    "image": [
      "https://www.storecore.io/images/performance-guidelines-1200x1200.jpg",
      "https://www.storecore.io/images/performance-guidelines-1200x900.jpg",
      "https://www.storecore.io/images/performance-guidelines-1200x675.jpg"
    ],
    "datePublished": "<?php echo date(DATE_ATOM, filectime(__FILE__)) ?>",
    "dateModified": "<?php echo date(DATE_ATOM, filemtime(__FILE__)) ?>",
    "publisher": {
      "@type": "Organization",
      "name": "StoreCore",
      "alternateName": "StoreCore.io",
      "url": "https://www.storecore.io/",
      "email": "info@storecore.org",
      "logo": {
        "@type": "ImageObject",
        "url": "https://www.storecore.io/images/StoreCore-logo-225x55.png",
        "width": 225,
        "height": 55
      }
    }
  }
  </script>

  <h1>Performance guidelines</h1>
  <p>Performance is one of the StoreCore design principles.  This StoreCore
    developer guide contains several do’s and don’ts on PHP and MySQL
    performance.</p>
  <p>This documentation is a work in progress.  It describes prerelease
    software, and is subject to change.  All code is released as free and
    open-source software (<abbr title="free and open-source software">FOSS</abbr>)
    under the <a href="https://www.gnu.org/licenses/gpl.html"
    rel="nofollow noreferrer">GNU General Public License</a>.</p>

  <section id="do-your-own-math">
    <h2>Do your own math</h2>
    <p>Letting the server recalculate a fixed value over and over again, is
      lazy.  Simply calculate the fixed value once yourself.  Add a comment if
      you would like to clarify a given value.</p>

<h5 class="amd-color--red-700">Incorrect:</h5>
<pre><code>setcookie('language', $lang, time() + 60 * 60 * 24 * 30, '/');</code></pre>

<h5 class="amd-color--light-green-700">Correct:</h5>
<pre><code>setcookie('language', $lang, time() + 2592000, '/');</code></pre>

<h5 class="amd-color--light-green-700">Correct:</h5>
<pre><code>// Cookie expires in 60 seconds * 60 minutes * 24 hours * 30 days = 2592000 seconds
setcookie('language', $lang, time() + 2592000, '/');</code></pre>

  </section>

  <section>
    <h2>Order database table columns for performance</h2>
    <p>In some databases, it is more efficient to order the columns in a
      specific manner because of the way the disk access is performed.  The
      optimal order of columns in a MySQL InnoDB table is:</p>

    <ul>
      <li>primary key</li>
      <li>combined primary keys as defined in the <code>KEY</code> order</li>
      <li>foreign keys used in <code>JOIN</code> queries</li>
      <li>columns with an <code>INDEX</code> used in <code>WHERE</code> conditions or <code>ORDER BY</code> statements</li>
      <li>others columns used in <code>WHERE</code> conditions</li>
      <li>others columns used in <code>ORDER BY</code> statements</li>
      <li><code>VARCHAR</code> columns with a variable length</li>
      <li>large <code>TEXT</code> and <code>BLOB</code> columns.</li>
    </ul>

    <p>When there are many <code>VARCHAR</code> columns (with variable length)
      in a MySQL table, the column order MAY affect the performance of queries.
      The less close a column is to the beginning of the row, the more preceding
      columns the InnoDB engine should examine to find out the offset of a given
      one.  Columns that are closer to the beginning of the table are therefore
      selected faster.</p>
  </section>

  <section>
    <h2>Store DateTimes as UTC timestamps</h2>
    <p>Times and dates with times SHOULD be stored in Coordinated Universal Time
      (<abbr title="Coordinated Universal Time">UTC</abbr>).  The following
      examples illustrate this requirement with column definitions in a
      <code>CREATE TABLE</code> statement.</p>

<h5 class="amd-color--red-700">Incorrect:</h5>
<pre><code>`date_added`  DATETIME  NOT NULL</code></pre>

<h5 class="amd-color--light-green-700">Correct:</h5>
<pre><code>`date_added`  TIMESTAMP  NOT NULL  DEFAULT CURRENT_TIMESTAMP</code></pre>

<h5 class="amd-color--red-700">Incorrect:</h5>
<pre><code>`date_modified`  DATETIME  NOT NULL</code></pre>

<h5 class="amd-color--light-green-700">Correct:</h5>
<pre><code>`date_modified`  TIMESTAMP  NOT NULL  ON UPDATE CURRENT_TIMESTAMP</code></pre>

    <p>When there are two timestamps in the same database table, the logical
      thing to do is setting <code>date_added</code> to <code>DEFAULT
      CURRENT_TIMESTAMP</code> for the initial <code>INSERT</code> query and
      <code>date_modified</code> to <code>ON UPDATE CURRENT_TIMESTAMP</code> for
      subsequent <code>UPDATE</code> queries:

<pre><code>`date_added`     TIMESTAMP  NOT NULL  DEFAULT CURRENT_TIMESTAMP,
`date_modified`  TIMESTAMP  NOT NULL  DEFAULT '0000-00-00 00:00:00'  ON UPDATE CURRENT_TIMESTAMP</code></pre>

  <p>This, however, only works in MySQL 5.6+.  Older versions of MySQL will
    report an error: “Incorrect table definition; there can be only one
    <code>TIMESTAMP</code> column with <code>CURRENT_TIMESTAMP</code> in
    <code>DEFAULT</code> or <code>ON UPDATE</code> clause”.</p>

  <p>The workaround currently implemented in StoreCore is to set the
    <code>DEFAULT</code> value for the initial <code>INSERT</code> timestamp to
    <code>'0000-00-00 00:00:00'</code> and only use the
    <code>CURRENT_TIMESTAMP</code> for a subsequent <code>ON UPDATE</code>:

<pre><code>`date_added`     TIMESTAMP  NOT NULL  DEFAULT '0000-00-00 00:00:00',
`date_modified`  TIMESTAMP  NOT NULL  DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP</code></pre>

  </section>

  <section>
    <h2>Don’t cast MySQL integers to strings</h2>
    <p>String equality comparisons are much more expensive database operations
    than integer compares.  If a database value is an integer, it MUST NOT be
    treated as a numeric string.  This holds especially true for primary keys
    and foreign keys.</p>

<h5 class="amd-color--red-700">Incorrect:</h5>
<pre><code>$sql = "
    UPDATE sc_addresses
    SET customer_id = '" . (int)$customer_id . "'
    WHERE address_id = '" . (int)$address_id . "'";</code></pre>

<h5 class="amd-color--light-green-700">Correct:</h5>
<pre><code>$sql = '
    UPDATE sc_addresses
    SET customer_id = ' . (int)$customer_id . '
    WHERE address_id = ' . (int)$address_id;</code></pre>

    <p>The first PHP statement creates an SQL expression with numeric strings
      and the second statement an expression with true integer values:</p>

<h5 class="amd-color--red-700">Incorrect:</h5>
<pre><code>UPDATE sc_addresses
   SET customer_id = '54321'
 WHERE address_id  = '67890';</code></pre>

<h5 class="amd-color--light-green-700">Correct:</h5>
<pre><code>UPDATE sc_addresses
   SET customer_id = 54321
 WHERE address_id  = 67890;</code></pre>

  </section>

  <section>
    <h2>Don’t close and immediately re-open PHP tags</h2>
    <p>A common mistake in PHP templates and <abbr
      title="Model-View-Controller">MVC</abbr> views is closing and immediately
      re-opening PHP-tags.</p>

<h5 class="amd-color--red-700">Incorrect:</h5>
<pre><code>&lt;?php echo $header; ?&gt;&lt;?php echo $menu; ?&gt;</code></pre>

<h5 class="amd-color--red-700">Incorrect:</h5>
<pre><code>&lt;?php echo $header; ?&gt;
&lt;?php echo $menu; ?&gt;</code></pre>

<h5 class="amd-color--light-green-700">Correct:</h5>
<pre><code>&lt;?php
echo $header;
echo $menu;
?&gt;</code></pre>

<h5 class="amd-color--light-green-700">Correct:</h5>
<pre><code>&lt;?php
echo $header, $menu;
?&gt;</code></pre>

<h5 class="amd-color--light-green-700">Correct:</h5>
<pre><code>&lt;?php echo $header, $menu; ?&gt;</code></pre>

  </section>

  <section>
    <h2 id="return-early ">Return early</h2>
    <p>Once the outcome of a PHP method or procedure has been established, it
      SHOULD be returned.  The examples below demonstrate this may save memory
      and computations.</p>

<h5 class="amd-color--red-700">Incorrect:</h5>
<pre><code>public function hasDownload()
{
    $download = false;

    foreach ($this->getProducts() as $product) {
        if ($product['download']) {
            $download = true;
            break;
        }
    }

    return $download;
}</code></pre>

<h5 class="amd-color--light-green-700">Correct:</h5>
<pre><code>public function hasDownload()
{
    foreach ($this->getProducts() as $product) {
        if ($product['download']) {
            return true;
        }
    }
    return false;
}</code></pre>

    <p>Adding a temporary variable and two lines of code for a simple true or
      false does not really make sense.  First breaking from an <code>if</code>
      nested in a <code>foreach</code> loop doesn’t make much sense either if
      you can just as well return the result immediately.</p> 
  </section>

  <aside>
    <p><small>Except as otherwise noted, the content of this page is licensed under the <a href="https://creativecommons.org/licenses/by/4.0/" rel="nofollow noreferrer">Creative Commons Attribution&nbsp;4.0 License</a>, and code samples are licensed under the <a href="https://www.gnu.org/licenses/gpl.html" rel="nofollow noreferrer">GNU General Public License version&nbsp;3 (GPLv3)</a>.</small></p>
  </aside>
</article>
<?php require '../../includes/footer.inc.php';
