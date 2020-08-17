<?php
require 'setup.php';
h('Collections');
?>
<section class="section">

    <div class="container">
        
        <nav class="panel">

            <p class="panel-heading">
                Collections
            </p>
            <p class="panel-block">
                <a href="new-col" class="button is-primary">Create collection</a>
            </p>
            <!-- <a class="panel-block">
                <span class="panel-icon">
                <i class="fas fa-book" aria-hidden="true"></i>
                </span>
                marksheet
            </a> -->
            

            <?php

                $r = $db->select('collections', '*');

                if( $r ) {
                    foreach ($r as $row) {
                        ?>
                        <a class="panel-block" href="view-col.php?id=<?= $row['id'] ?>" title="<?= $row['name'] ?>">
                            <span class="panel-icon">
                                <i class="fas fa-book" aria-hidden="true"></i>
                            </span>
                            <?= $row['name'] ?>
                        </a>
                        <?php
                    }
                    
                } else {
                    ?>
                    <p class="panel-block">
                        <i>No collections yet.</i>
                    </p>
                    <?php
                }

            ?>

        </nav>
    </div>
</section>
<?php
f();