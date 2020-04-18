<?php require '../../header.inc.php'; ?>
<article>
  <h1>Installation QuickStart Guide</h1>
  <p>This documentation is a work in progress.  It describes prerelease
    software, and is subject to change.</p>
  <section>
    <h5>Installing StoreCore step-by-step</h5>
    <ol>
      <li>Download the latest edition of the StoreCore files from the
        <a href="https://github.com/storecore/core">GitHub repository</a> at 
        <code>github.com/<wbr>storecore</code> if you haven’t already.  Always
        download or fork the <code>master</code> branch of the <code>core</code>
        repository for production purposes.</li>
      <li>Create a new MySQL database for StoreCore on your web server.  Do not
        use the default MySQL <code>test</code> database or a database name with
        the <code>test_</code> prefix.</li>
      <li>Add a MySQL user who has all privileges for accessing and modifying
        the StoreCore database.</li>
      <li>Find the <code>config.php</code> configuration file, then edit the
        file and add your database information in the <code>Database</code>
        section.</li>
      <li>
        <p><strong>Optional.</strong>  If configured correctly, StoreCore is able
          to install the database by itself.  However, the installation MAY run
          faster and smoother if you install the database manually with a database
          administration tool like <a
          href="https://www.mysql.com/products/workbench/"
          rel="noreferrer noopener" title="MySQL Workbench">MySQL Workbench</a>,
          <a href="https://www.phpmyadmin.net/" rel="noreferrer noopener"
          title="phpMyAdmin">phpMyAdmin</a>, or a MySQL command-line interface.</p>
        <p>First run the SQL file <code>core-mysql.sql</code> to create all tables;
          next run the <code>i18n-dml.sql</code> file to add all language pack
          data.  Both SQL files are located in the 
          <code>/StoreCore/Database/</code> folder.</p>
      </li>
      <li>Upload the StoreCore files to the desired location on your web server.
        This usually is a folder called <code>public_html</code> for a domain
        or <code>www</code> for a subdomain like <code>www.example.com</code>.
        Do not upload the <code>/tests/</code> folder to a production server (or
        delete it afterwards): this folder contains PHP unit tests for
        development purposes.</li>
      <li>Run the StoreCore installation by accessing the installer URL in a web
        browser.  If StoreCore was not previously installed, you will be guided
        through the necessary steps to complete the installation.</li>
    </ol>
  </section>
  <section>
    <h2 id="installation-logs">Installation logs</h2>
    <p>All installation and configuration activities are logged to
      <code>.log</code> text files in the <code>/logs/</code> directory.
      If the StoreCore installation fails for any reason, please first check
      these log files for possible errors, warnings or other critical
      messages.</p>
    <p>The location of the <code>/logs/</code> directory is defined in the
      global constant <code>STORECORE_<wbr>FILESYSTEM_<wbr>LOGS_DIR</code> in
      the <code>config.php</code> configuration file.  If this global constant
      is undefined (or the <code>config.php</code> file was not loaded), log
      files MAY be saved in different directories.  This usually is the current
      working directory for the main PHP application, for example the
      <code>/install/</code> directory when you are executing the
      <code>/install/index.php</code> application.</p>
  </section>
  <section>
    <h2 id="resetting-administrator-accounts">Resetting administrator accounts</h2>
    <p>At any given time there MUST be at least one active StoreCore
      administrator account.  If no active administrator account is found,
      StoreCore will automatically display a form to add a new user account with
      administrator privileges.</p>
    <p>If you somehow forgot or lost your administrator username or password,
      the administrator accounts can be reset by clearing the
      <code>sc_users</code> database table.  This requires MySQL database access
      to execute the <code>TRUNCATE TABLE</code> command on the
      <code>sc_users</code> table:
    <pre><code>TRUNCATE TABLE sc_users;</code></pre>
  </section>
  <section>
    <h2>Need assistance?</h2>
    <p>Free installation is included in all <a href="/plans-and-pricing"
      title="Plans and pricing">StoreCore hosting plans</a>.  StoreCore Premium
      also includes free data migration of existing online shops.</p>
  </section>
</article>
<?php require '../../footer.inc.php';
