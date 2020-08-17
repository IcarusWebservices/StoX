<?php
require 'setup.php';

if(!isset($_GET['id'])) die();

$id = $_GET['id'];

$col = $db->select('collections', '*', [
    'id' => $id
]);

if(count($col)<=0) die();
else $col = $col[0];

$metaschema = $db->select('metaschema', '*', [
    'collection' => $id
]);

h('Edit metaschema');
?>
<section class="section">
    <div class="container">
        <a href="view-col.php?id=<?= $id ?>">← Go back</a>
        <h1 class="title"><?= $col['name'] ?></h1>
        <h2 class="subtitle">Edit MetaSchema</h2>
        <a href="metas-item.php?t=new&col=<?= $id ?>" class="button is-primary">New...</a>
        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>Meta field name</th>
                    <th>Is searchable</th>
                    <th><abbr title="An enumerate is a collection of possible values">Is enumerate</abbr></th>
                    <th>Enumerate details</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php

                foreach ($metaschema as $schema) {
                    ?>
                    <tr>
                        <td><?= $schema['meta_key'] ?></td>
                        <td><?php switch($schema['query_me']) { case 1: echo 'True'; break; case 0: echo 'False'; break; } ?></td>
                        <td><?php switch($schema['is_enum']) { case 1: echo 'True'; break; case 0: echo 'False'; break; } ?></td>
                        <?php
                        if( $schema['is_enum'] )
                        {
                            ?><td><?= $schema['enum_vals'] ?></td><?php
                        } else {
                            ?><td><i>No enum</i></td><?php
                        }
                        ?>
                        <td><a href="metas-item.php?t=edit&id=<?= $schema['id'] ?>&col=<?= $schema['collection'] ?>" class="button is-primary">Edit</a> <a href="metas-item.php?col=<?= $schema['collection'] ?>&step=1&t=del&id=<?= $schema['id'] ?>" class="button is-danger">Delete</a></td>
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