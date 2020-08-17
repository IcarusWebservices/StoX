<?php
require 'setup.php';

$id = isset($_GET['id']) ? $_GET['id'] : die('Invalid collection, <a href="index.php">go back</a>.');

$col = $db->select('collections', '*', ["id" => $id]);

if( count($col) <= 0 ) die('Collection not found...');
else $col = $col[0];

$metaschema = $db->select('metaschema', '*', ['collection' => $id]);

h('Collections');
?>
<section class="section">
    <div class="container">
        <a href="col.php">← Go back</a>
        <h1 class="title"><?= $col['name'] ?> <a href="edit-col.php?id=<?= $id ?>" class="button is-info">Edit collection</a> <a href="del-col.php?step=1&id=<?= $id ?>" class="button is-danger">Delete collection</a> <a href="col-meta.php?id=<?= $id ?>" class="button is-link">Edit MetaSchema</a></h1> 
        <h2 class="subtitle">Items</h2>
        <a href="item.php?t=new&col=<?= $id ?>" class="button is-primary">New Item</a> 
        <table class="table is-fullwidth">
            
            <thead>
                <tr>
                    <th></th>
                    <th>Stock</th>
                    <th>Name <a href="search.php?type=col&col=<?= $id ?>&filter=name"><i class="fas fa-search"></i></a></th>
                    <?php
                    foreach ($metaschema as $meta) {
                        ?>
                        <th>Meta: <?= $meta['meta_key'] ?> <?php if($meta['query_me']) { ?><a href="search.php?type=col&col=<?= $id ?>&filter=meta&meta=description"><i class="fas fa-search"></i></a> <?php }?></th>
                        <?php
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                    $items = $db->select('items', '*', ['collection' => $id]);
                    foreach ($items as $item) {
                        ?>
                        <tr>
                            <td> <a href="item.php?t=edit&item=<?= $item['id'] ?>"><i class="fad fa-edit"></i></a> </td>
                            <td><?= $item['stock'] ?></td>
                            <td><?= $item['name'] ?></td>
                            <?php 
                                foreach ($metaschema as $meta) {
                                    $f = $db->select('meta', '*', [
                                        "metaschema_id" => $meta['id'],
                                        "stock_id" => $item['id']
                                    ]);

                                    if( count($f) > 0 )
                                    {
                                        ?>
                                        <td><?= $f[0]['meta_value'] ?></td>
                                        <?php
                                    } else {
                                        ?>
                                        <td><i>Empty</i></td>
                                        <?php
                                    }
                                }
                            ?>
                        </tr>
                        <?php
                    }
                ?>
            </tbody>

        </table>
    </div>
</section>
<?php
f();