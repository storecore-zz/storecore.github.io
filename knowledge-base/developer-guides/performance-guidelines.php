<?php require '../../includes/header.inc.php'; ?>
<article>
  <h1>Performance guidelines</h1>
  <p>This <a href="/knowledge-base/developer-guides/">StoreCore developer
    guide</a> contains several do’s and don’ts on PHP and MySQL performance.</p>
  <p>This documentation is a work in progress.  It describes prerelease
    software, and is subject to change.  All code is released as free and
    open-source software (<abbr title="free and open-source software">FOSS</abbr>)
    under the <a href="https://www.gnu.org/licenses/gpl.html">GNU General Public
    License</a>.</p>

<!-- ————+—————————+—————————+—————————+—————————+—————————+—————————+—————— -->

<h5 class="amd-color--red-700">Incorrect</h5>
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

<h5 class="amd-color--light-green-700">Correct</h5>
<pre><code>public function hasDownload()
{
    foreach ($this->getProducts() as $product) {
        if ($product['download']) {
            return true;
        }
    }
    return false;
}</code></pre>

</article>
<?php require '../../includes/footer.inc.php';
