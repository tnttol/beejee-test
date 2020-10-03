<?php
$this->title = 'Task List';

$params = ['page' => $this->pagination['page']];

function getOrderLink(string $name, array $order) {
    if (!isset($params['order'])) {
        $params['order'] = [];
    }
    if (isset($order[$name])) {
        if ($order[$name] === 'desc') {
            $icon = 'fa-sort-down';
            $params['order'][$name] = 'asc';
        } else {
            $icon = 'fa-sort-up';
            $params['order'][$name] = 'desc';
        }
    } else {
        $icon = 'fa-sort';
        $params['order'][$name] = 'asc';
    }

    $params = http_build_query($params);

    return '<a href="?' . $params . '"><i class="fa ' . $icon . '" aria-hidden="true"></a>';
}
?>

<?php include '../views/_parts/header.php' ?>
<?php include '../views/_parts/navbar.php' ?>

<table class="table">
  <thead>
  <tr>
    <th scope="col" class="text-nowrap">User <?php echo getOrderLink('username', $this->order) ?></i></th>
    <th scope="col" class="text-nowrap">Email <?php echo getOrderLink('email', $this->order) ?></th>
    <th scope="col" class="text-nowrap">Task</th>
    <th scope="col" class="text-nowrap">Status <?php echo getOrderLink('status', $this->order) ?></th>
    <?php if ($this->isAuth): ?>
      <th scope="col">Edit</th>
    <?php endif ?>
  </tr>
  </thead>
  <tbody>

  <?php foreach ($this->pagination['items'] as $task): ?>
    <tr>
      <td><?php echo $task['username'] ?></td>
      <td><span class="list-email"><?php echo $task['email'] ?></span></td>
      <td><?php echo $task['description'] ?></td>
      <td>
        <span class="badge <?php echo (int)$task['status'] === \App\Model\Enum\TaskStatus::Completed ? 'badge-success' : 'badge-info' ?>">
            <?php echo(new \App\Model\Enum\TaskStatus($task['status'])) ?>
        </span>
        <?php if ((bool)($task['edited'] ?? false)): ?>
          <span class="badge badge-secondary">Edited</span>
        <?php endif ?>
      </td>
      <?php if ($this->isAuth): ?>
        <td><a class="btn btn-primary btn-sm" href="/edit?id=<?php echo $task['id'] ?>">Edit</a></td>
      <?php endif ?>
    </tr>
  <?php endforeach ?>

  <?php if (empty($this->pagination['items'])): ?>
    <tr>
      <th scope="row" colspan="<?php echo $this->isAuth ? '5' : '4' ?>">No Tasks</th>
    </tr>
  <?php endif ?>
  </tbody>
</table>

<?php include '../views/_parts/pagination.php' ?>

<?php include '../views/_parts/footer.php' ?>
