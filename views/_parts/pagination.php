<?php
$page = $this->pagination['page'];
$lastPage = $this->pagination['lastPage'];
$orderParams = http_build_query(['order' => $this->order]);

if ($orderParams) {
    $orderParams = '&' . $orderParams;
}
?>

<?php if ($this->pagination['hasPagination']): ?>
  <nav aria-label="Page navigation">
    <ul class="pagination">
        <?php if ($page > 1): ?>
          <li class="page-item"><a class="page-link" href="?page=1<?php echo $orderParams ?>">First</a></li>
          <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1 ?><?php echo $orderParams ?>">&laquo;</a></li>
        <?php endif ?>
        <?php for ($p = 1; $p <= $lastPage; $p++): ?>
          <?php if ($p > $page - 5 && $p < $page + 5): ?>
            <li class="page-item<?php if ($p === $page): echo ' active'; endif ?>">
              <a class="page-link" href="?page=<?php echo $p ?><?php echo $orderParams ?>"><?php echo $p ?></a>
            </li>
          <?php endif ?>
        <?php endfor ?>
        <?php if ($page < $lastPage): ?>
          <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1 ?><?php echo $orderParams ?>">&raquo;</a></li>
          <li class="page-item"><a class="page-link" href="?page=<?php echo $lastPage ?><?php echo $orderParams ?>">Last</a></li>
        <?php endif ?>
    </ul>
  </nav>
<?php endif ?>
