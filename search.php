<?php
require 'setup.php';
// Search algorithm
// The search can either be global or collection specific;
$collection_specific = true;

// The query being used
$q = isset($_GET['q']) ? $_GET['q'] : null; 

if($q)
{

    // Search item names
    $names = $db->select('items', '*', [
        'name[~]' => $q
    ]);

    // Search meta values
    $meta = $db->select('meta', '*', [
        'meta_value[~]' => $q
    ]);
}

h('Search result');
?>
<section class="section">
    <div class="container">
        <h1 class="title">Search</h1>
        <form action="search.php" method="get">
            <div class="field is-grouped">
                <div class="control">
                    <input class="input" type="text" placeholder="Enter search query" name="q" value="<?= $q ?>">
                </div>
                <div class="control">
                    <input type="submit" class="button is-link" value="Search">
                </div>
            </div>
        </form>
    </div>
</section>
<?php
    if($q)
    {
?>
<section class="section">
    <h2 class="title is-4">Results</h2>
    <?php
        if(count($names) > 0 || count($meta) > 0):
        
            foreach ($names as $bnr) {
                ?>
                <div class="card">
                    <div class="card-content">
                        <div class="media">
                            <div class="media-content">
                                <p class="subtitle"><span class="tag is-primary">Item</span></p>
                                <p class="title is-4"><a href="item.php?src=search&t=edit&item=<?= $bnr['id'] ?>"><?= $bnr['name'] ?></a></p>
                                <p class="subtitle is-6">In collection <?php
                                    $c = $db->select('collections', '*', ['id' => $bnr['collection']]);
                                    if(count($c)>0) echo $c[0]['name'];
                                ?></p>
                            </div>
                        </div>

                        <div class="content">
                            Currently in stock: <b><?= $bnr['stock'] ?></b>
                        </div>
                    </div>
                </div>
                <?php
            }
        else:
        ?>
        <i>No results</i>
        <?php
        endif;
    ?>
    
</section>
<?php
}
f();