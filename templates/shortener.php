<?php
$url = '';
$key = '';
$errors = array();

if($app->isPostRequest()) {
  $url = $app->getFilteredPost('url');
  $errors = $app->checkRedirectUrl($url);
  if(!$errors) $key = $app->saveNewRedirect();
}

$view->pageTitle('JURL Shortener');
$view->header();
$base_url = $app->getSiteBaseUrl();
$site_url = $app->getSiteBaseUrl(true);
?>
<div class="main-container">
  <div class="site-width">
    <h2>Welcome to JURL shortener!</h2>
    <p>Enter a url to shorten below and click "Shorten Me." Must be a valid url (e.g. it should begin with "http" or "https")</p>
  <?php if($errors): ?>
    <p class="errors"><?= implode('<br />', $errors) ?></p>
  <?php endif; ?>
    <form action="<?= $base_url ?>" method="post">
      <div class="input-wrap"><input class="text-input" style="width:100%;" type="text" placeholder="URL" name="url" value="<?= $url ?>" /></div>
      <div class="input-wrap"><input class="submit-btn" type="submit" value="Shorten Me" /></div>
    </form>
  <?php if($key): ?>
    <div>
      <div class="input-wrap">
        <input class="text-input the-key" style="width:300px;" type="text" value="<?= $site_url.$key ?>" />
        <button class="copy-btn">Copy</button>
      </div>
    </div>
  <?php endif; ?>
  </div>
</div>
<?php $view->footer(); ?>
