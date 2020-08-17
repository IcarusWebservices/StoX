<?php
require 'setup.php';

if( !isset($_GET['t']) ) die();

if( $_GET['t'] == 'edit' )
{

    if(!isset($_GET['item'])) die();

    $id = $_GET['item'];

    $item = $db->select('items', '*', ['id'=>$id]);

    if(count($item)<=0) die();
    else $item = $item[0];
    
    if( $_SERVER['REQUEST_METHOD'] == 'POST' )
    {
        if(!isset($_POST['type'])) die();
    
        $type = $_POST['type'];
    
        switch( $type )
        {
    
            case 'stock':
                if( !isset($_POST['mutation']) || !isset($_POST['amount']) ) die();
    
                if(!is_numeric($_POST['amount'])) die('ERROR: AMOUNT NEEDS TO BE NUMERIC');
    
                $previous_amount = $item['stock'];
    
                $new_amount = 0;
    
                switch( $_POST['mutation'] )
                {
                    case 'add':
                        $new_amount = $previous_amount + (int) $_POST['amount'];
                    break;
    
                    case 'sub':
                        $new_amount = $previous_amount - (int) $_POST['amount'];
                    break;
    
                    case 'set':
                        $new_amount = (int) $_POST['amount'];
                    break;
                }
    
                $db->update('items', ['stock' => $new_amount], ['id' => $id]);
    
                header('Location: item.php?t=edit&item=' . $id);
            break;
    
        }
    }
    
    h($item['name']);
    ?>
    <div class="modal" id="change-stock">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
            <p class="modal-card-title">Update stock of <?= $item['name'] ?></p>
            <button class="delete" aria-label="close" id="close-modal"></button>
            </header>
            <section class="modal-card-body">
                <form class="form" id="update-stock" method="post">
                    <input type="hidden" name="type" value="stock">
                    <div class="field">
                        <label class="label">Mutation</label>
                        <div class="control">
                            <div class="select">
                            <select name="mutation">
                                <option value="add">Add</option>
                                <option value="sub">Subtract</option>
                                <option value="set">Set to</option>
                            </select>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Amount</label>
                            <div class="control">
                                <input class="input" type="number" placeholder="Amount" name="amount">
                            </div>
                        </div>
                    </div>
                </form>
            </section>
            <footer class="modal-card-foot">
            <input type="submit" class="button is-success" value="Save" form="update-stock">
            </footer>
        </div>
    </div>
    <section class="section">
        <div class="container">
            <?php
            $source = isset($_GET['src']) ? $_GET['src'] : null;
            $bu;
            switch( $source )
            {
                case 'search':
                    $bu = 'search.php';
                break;

                default:
                    $bu = "view-col.php?id=". $item['collection'];
                break;
            }
            ?>
            <small><a href="<?= $bu ?>">← Go back</a></small>
            <h1 class="title"><?= $item['name'] ?></h1>
            
            <h2 class="subtitle">Item in collection <a href="view-col.php?id=<?= $item['collection'] ?>"><?= collection(['id' => $item['collection']])[0]['name'] ?></a></h2>
            <div class="card">
                <div class="card-content">
                    <p class="title">
                    <h1 class="title"><?= $item['stock'] ?></h1>
                    </p>
                    <p class="subtitle">
                    Currently in stock
                    </p>
                </div>
                <footer class="card-footer">
                    <a class="card-footer-item button is-primary" id="open-modal-stock">
                        <span>
                            Update
                        </span>
                    </a>
                </footer>
            </div>
        </div>
    </section>
    <script>
        document.getElementById('open-modal-stock').addEventListener('click', (e) => {
            document.getElementById('change-stock').classList.add('is-active')
        })
    
        document.getElementById('close-modal').addEventListener('click', (e) => {
            document.getElementById('change-stock').classList.remove('is-active')
        })
    </script>
    <?php
    f();
} elseif( $_GET['t'] == 'new' ) {

    if(!isset($_GET['col'])) die();

    $col = $_GET['col'];

    if($_SERVER['REQUEST_METHOD'] == 'POST'):

        if(!isset($_POST['name']) || !isset($_POST['amount'])) die();
        
        $name = $_POST['name'];
        $amount = $_POST['amount'];

        if(!is_numeric($amount)) die();

        $db->insert('items', [
            'stock' => $amount,
            'name' => $name,
            'collection' => $col
        ]);

        header('Location: view-col.php?id=' . $col);

    else:
    h('New item');
    ?>
    <section class="section">
        <div class="container">
            <h1 class="title">New item</h1>

            <form class="form" method="post">
                <div class="field">
                    <label class="label">Name</label>
                    <div class="control">
                        <input class="input" type="text" placeholder="The name of the item" name="name">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Starting amount</label>
                    <div class="control">
                        <input class="input" type="number" placeholder="The starting amount" value="0" name="amount">
                    </div>
                </div>
                <div class="field is-grouped">
                    <div class="control">
                        <input type="submit" value="Save" class="button is-primary">
                    </div>
                    <div class="control">
                        <a class="button is-link is-light" href="view-col.php?id=<?= $col ?>">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <?php
    f();
    endif;
} elseif( $_GET['t'] == 'del' ) {

    if(!isset($_GET['step']) || !isset($_GET['id'])) die();

    $id = $_GET['id'];

    $item = $db->select('items', '*', ['id'=>$id]);

    if(count($item)<=0) die();
    else $item = $item[0];

    $step = $_GET['step'];

    switch($step) {

        case '1':
            ?>
            <section class="section">
                <div class="container">
                    <h1 class="title">Are you sure you want to remove <?= $item['name'] ?> and all of its contents?</h1>
                    
                    <div class="columns">
                        <div class="column">
                            <a href="item.php?t=edit&id=<?= $_GET['id'] ?>" class="button is-light">Go back</a>
                            <a href="item.php?t=del&step=2&id=<?= $_GET['id'] ?>" class="button is-danger">Remove</a>
                        </div>
                    </div>
                </div>
            </section>
            <?php
        break;

    }

}

