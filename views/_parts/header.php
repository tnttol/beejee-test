<!doctype html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/style.css">
  <title><?php echo $this->title ?></title>
</head>
<body>
<div class="content">
<?php if ($this->notification): ?>
  <div class="alert alert-<?php echo $this->notificationType ?> alert-dismissible fade show" role="alert">
    <?php echo $this->notification ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif ?>
