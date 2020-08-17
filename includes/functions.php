<?php
function item( $where )
{
    global $db;

    $r = $db->select('items', '*', $where);

    if(count($r)>0) {
        return $r;
    } else {
        return array([
            'id' => null,
            'name' => null,
            'collection' => null
        ]);
    }
}

function collection( $where )
{
    global $db;

    $r = $db->select('collections', '*', $where);

    if(count($r)>0) {
        return $r;
    } else {
        return array([
            'id' => null,
            'name' => null
        ]);
    }
}