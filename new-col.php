<?php
require 'setup.php';

if($_SERVER['REQUEST_METHOD'] == 'GET'):
h('New collection');
?>
<section class="section">
    <div class="container">
        <h1 class="title">New collection</h1>
        <form class="form" method="post">
            <div class="field">
                <label class="label">Name</label>
                <div class="control">
                    <input class="input" type="text" placeholder="Name of the component" name="name">
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
                    <a class="button is-link is-light" href="col.php">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</section>
<?php
f();
else:
    if(!isset($_POST['name'])) die();

    $db->insert('collections', ['name'=>$_POST['name']]);
    
    header('Location: col.php');
endif;