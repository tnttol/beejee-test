<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarToggler">
    <ul class="nav navbar-nav">
      <li>
        <span class="navbar-brand"><?php echo $this->title ?></span>
      </li>
      <li>
        <a class="nav-link" href="/">Home</a>
      </li>
      <li>
        <a class="nav-link" href="/add">Add New Task</a>
      </li>
    </ul>
  </div>

  <ul class="nav navbar-nav navbar-right">
    <li>
        <?php if (!$this->isAuth): ?>
          <a class="btn btn-primary btn-block btn-sm" href="/login">Login</a>
        <?php else: ?>
          <a class="btn btn-primary btn-block btn-sm" href="/logout">Logout</a>
        <?php endif ?>
    </li>
  </ul>
</nav>

