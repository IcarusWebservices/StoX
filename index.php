<?php 
require 'setup.php'; 
h('Home');
?>

    <section class="hero is-danger is-medium">
        <div class="hero-body">
            <div class="container">
            <h1 class="title">
                Welcome!
            </h1>
            <h2 class="subtitle">
                Stock Management System v. 1.0.0
            </h2>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <nav class="panel">
                <p class="panel-heading">
                    Actions
                </p>
                <a class="panel-block" href="col.php?view=all">
                    See all collections.
                </a>
                <a class="panel-block" href="new-col.php">
                    Create a new collection.
                </a>
            </nav>
        </div>
    </section>
    
</body>
</html>
<?php f(); ?>