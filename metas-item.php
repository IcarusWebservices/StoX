<?php
require 'setup.php';

if(!isset($_GET['t'])||!isset($_GET['col'])) die();


$col_id = $_GET['col'];

$method = $_SERVER['REQUEST_METHOD'];

switch($_GET['t'])
{

    case 'new':
    if($method=='GET'):
    h('New meta schema tag');
?>
<section class="section">
    <div class="container">
        <h1 class="title">New meta field</h1>
        <form method="post" class="form">
        <div class="field">
            <label class="label">Key</label>
            <div class="control">
                <input class="input" type="text" placeholder="Text input" name="key">
            </div>
            <p class="help">The name of the field</p>
        </div>
        <div class="field">
            <div class="control">
                <label class="label">Searchable</label>
                <label class="checkbox">
                <input type="checkbox" name="is-searchable">
                Meta field is searchable.
                </label>
                <p class="help">If true, items can be found based on the value of this meta field.</p>
            </div>
        </div>
        <div class="field">
            <div class="control">
                <label class="label">Enumerate</label>
                <label class="checkbox">
                <input type="checkbox" id="enumerate-selector" name="is-enum">
                Meta field is an enumerate.
                </label>
                <p class="help">If true, the value of the meta field can only be selected from a list of predefined values.</p>
            </div>
        </div>
        <script>
            document.getElementById('enumerate-selector').addEventListener('click', (e) => {
                let el = document.getElementById('enumfield')
                if(el.style.display == 'none') el.style.display = 'block'
                else el.style.display = 'none'
            })
        </script>
        <div class="field" id="enumfield" style="display:none;">
            <div class="control">
                <input class="input" type="text" placeholder="Enumerate values" name="enum-vals">
                <p class="help">The possible values of the enumerate. Seperate sentences with a comma: {Word or sentence}, {Word or sentence}</p>
            </div>
        </div>
        <div class="field is-grouped">
                <div class="control">
                    <input type="submit" value="Save" class="button is-primary">
                </div>
                <div class="control">
                    <a class="button is-link is-light" href="col-meta.php?id=<?= $col_id ?>">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</section>
<?php
    f();
    else:
        // POST HANDLER
        if(!isset($_POST['key'])) die();


        $key = $_POST['key'];
        $is_searchable = isset($_POST['is-searchable']) ? $_POST['is-searchable'] : 'off' ;
        $is_enum = isset($_POST['is-enum']) ? $_POST['is-enum'] : 'off' ;

        if($is_enum == 'on')
        {
            if(!isset($_POST['enum-vals'])) die();
            $enum_vals = $_POST['enum-vals'];

            $is_enum = 1;

        } else {
            $enum_vals = null;
            $is_enum = 0;
        } 

        if($is_searchable == 'on') $is_searchable = 1;
        else $is_searchable = 0;

        $db->insert( 'metaschema', [
            'collection' => $col_id,
            'meta_key' => $key,
            'query_me' => $is_searchable,
            'is_enum' => $is_enum,
            'enum_vals' => $enum_vals
        ]);

        header('Location: col-meta.php?id=' . $col_id);
    endif;
    break;

    case 'edit':
        if(!isset($_GET['id'])) die();

        $id = $_GET['id'];

        $schema = $db->select('metaschema', '*', [
            'id' => $id
        ]);
        
        if(count($schema)<=0) die();
        else $schema = $schema[0];

        if($method=='GET'):
            h('New meta schema tag');
        ?>
        <section class="section">
            <div class="container">
                <h1 class="title">Edit meta field "<?= $schema['meta_key'] ?>"</h1>
                <form method="post" class="form">
                <div class="field">
                    <label class="label">Key</label>
                    <div class="control">
                        <input class="input" type="text" placeholder="Text input" name="key" value="<?= $schema['meta_key'] ?>">
                    </div>
                    <p class="help">The name of the field</p>
                </div>
                <div class="field">
                    <div class="control">
                        <label class="label">Searchable</label>
                        <label class="checkbox">
                        <input type="checkbox" name="is-searchable" <?php if($schema['query_me']) echo 'checked'; ?>>
                        Meta field is searchable.
                        </label>
                        <p class="help">If true, items can be found based on the value of this meta field.</p>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <label class="label">Enumerate</label>
                        <label class="checkbox">
                        <input type="checkbox" id="enumerate-selector" name="is-enum"  <?php if($schema['is_enum']) echo 'checked'; ?>>
                        Meta field is an enumerate.
                        </label>
                        <p class="help">If true, the value of the meta field can only be selected from a list of predefined values.</p>
                    </div>
                </div>
                <script>
                    document.getElementById('enumerate-selector').addEventListener('click', (e) => {
                        let el = document.getElementById('enumfield')
                        if(el.style.display == 'none') el.style.display = 'block'
                        else el.style.display = 'none'
                    })
                </script>
                <div class="field" id="enumfield" style="<?php if(!$schema['is_enum']) echo 'display:none'; ?>">
                    <div class="control">
                        <input class="input" type="text" placeholder="Enumerate values" name="enum-vals" value="<?= $schema['enum_vals']; ?>">
                        <p class="help">The possible values of the enumerate. Seperate sentences with a comma: {Word or sentence}, {Word or sentence}</p>
                    </div>
                </div>
                <div class="field is-grouped">
                        <div class="control">
                            <input type="submit" value="Save" class="button is-primary">
                        </div>
                        <div class="control">
                            <a class="button is-link is-light" href="col-meta.php?id=<?= $col_id ?>">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <?php
            f();
            else:
                // POST HANDLER
                if(!isset($_POST['key'], $_POST['is-searchable'], $_POST['is-enum'])) die();
        
                $key = $_POST['key'];
                $is_searchable = $_POST['is-searchable'];
                $is_enum = $_POST['is-enum'];
        
                if($is_enum == 'on')
                {
        
                    if(!isset($_POST['enum-vals'])) die();
        
                    $enum_vals = $_POST['enum-vals'];
        
                    $is_enum = 1;
        
                } else {
                    $enum_vals = null;
                    $is_enum = 0;
                } 
        
                if($is_searchable == 'on') $is_searchable = 1;
                else $is_searchable = 0;
        
                $db->update( 'metaschema', [
                    'collection' => $col_id,
                    'meta_key' => $key,
                    'query_me' => $is_searchable,
                    'is_enum' => $is_enum,
                    'enum_vals' => $enum_vals
                ], ['id' => $schema['id']]);
        
                header('Location: col-meta.php?id=' . $col_id);
            endif;
    break;

    case 'del':

        if(!isset($_GET['step'], $_GET['id'])) die();

        $id = $_GET['id'];

        $schema = $db->select('metaschema', '*', [
            'id' => $id
        ]);
        
        if(count($schema)<=0) die();
        else $schema = $schema[0];

        switch($_GET['step'])
        {
            case 1:
                h('Do you want to remove ' . $schema['meta_key'] . '?');
                ?>
                <section class="section">
                    <div class="container">
                        <h1 class="title">Are you sure you want to remove <?= $schema['meta_key'] ?> and all of its contents?</h1>
                        
                        <div class="columns">
                            <div class="column">
                                <a href="col-meta.php?id=<?= $col_id ?>" class="button is-light">Go back</a>
                                <a href="metas-item.php?t=del&col=<?= $col_id ?>&step=2&id=<?= $id ?>" class="button is-danger">Remove</a>
                            </div>
                        </div>
                    </div>
                </section>
                <?php
                f();
            break;

            case 2:
                $db->delete('metaschema', [
                    'id' => $schema['id']
                ]);

                $db->delete('meta', [
                    'metaschema_id' => $schema['id']
                ]);

                header('Location: col-meta.php?id=' . $schema['collection']);
            break;
        }

    break;
}