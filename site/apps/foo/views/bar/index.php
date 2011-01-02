<h1>Foo Bar</h1>
<p>[<?= $this->html->a('/foo/bar/add', 'New item') ?>]</p>
<? foreach ($items as $item): ?>
<?= $item['title'] ?> [<?= $this->html->a('/foo/bar/view/' . $item['id'], 'View') ?>] | [<?= $this->html->a('/foo/bar/edit/' . $item['id'], 'Edit') ?>] | [<?= $this->html->a('/foo/bar/del/' . $item['id'], 'Delete') ?>]<br />
<? endforeach; ?>