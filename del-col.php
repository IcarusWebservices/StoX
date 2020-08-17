<?php
require 'setup.php';

if(!isset($_GET['step']) || !isset($_GET['id'])) die();

$col = $db->select('collections', '*', [
    'id' => $_GET['id']
]);

if(count($col)<=0) die();
else $col = $col[0];

switch($_GET['step'])
{
    case "1":
        h('Are you sure?');
        ?>
        <section class="section">
            <div class="container">
                <h1 class="title">Are you sure you want to remove <?= $col['name'] ?> and all of its contents?</h1>
                
                <div class="columns">
                    <div class="column">
                        <a href="col.php?view=all" class="button is-light">Go back</a>
                        <a href="del-col.php?step=2&id=<?= $_GET['id'] ?>" class="button is-danger">Remove</a>
                    </div>
                </div>
            </div>
        </section>
        <?php
        f();
    break;

    case "2":
        h('Deleting...');
        ?>
        <section class="section">
            <div class="container">
                <h1 class="title">Removing <?= $col['name'] ?>...</h1>
            </div>
        </section>
        <?php
        f();

        // Delete the items
        $db->delete('items', [
            'collection' => $col['id']
        ]);

        // Delete the meta schema
        $db->delete('metaschema', [
            'collection' => $col['id']
        ]);

        // Delete the individual meta fields
        $db->delete('meta', [
            'collection_id' => $col['id']
        ]);

        // Delete the collection
        $db->delete('collections', [
            'id' => $col['id']
        ]);

        header('Location: col.php');
    break;
}