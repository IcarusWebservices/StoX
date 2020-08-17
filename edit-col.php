<?php
require 'setup.php';

if(!isset($_GET['id'])) die();

$id = $_GET['id'];

$prev = $db->select('collections', '*', [
    'id' => $id
]);

if(count($prev)<=0) die();
else $prev = $prev[0];

if($_SERVER['REQUEST_METHOD'] == 'GET'):
h('Edit ' . $prev['name']);
?>
<section class="section">
    <div class="container">
        <h1 class="title">Edit '<?= $prev['name'] ?>'</h1>
        <form class="form" method="post">
            <div class="field">
                <label class="label">Name</label>
                <div class="control">
                    <input class="input" type="text" placeholder="Name of the component" name="name" value="<?= $prev['name'] ?>">
                </div>
            </div>
            <div class="field">
                <i>Meta data not yet supported</i>
            </div>
            <div class="field is-grouped">
                <div class="control">
                    <input type="submit" value="Save" class="button is-primary">
                </div>
                <div class="control">
                    <a class="button is-link is-light" href="view-col.php?id=<?= $id ?>">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</section>
<?php
f();
else:
if(!isset($_POST['name'])) die();

$db->update('collections', ['name'=>$_POST['name']], ['id'=>$id]);

header('Location: view-col.php?id=' . $id);
endif;