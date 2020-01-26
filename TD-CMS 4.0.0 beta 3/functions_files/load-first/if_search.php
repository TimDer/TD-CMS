<?php

function if_search() {
    if (isset($_GET['s'])) {
        return TRUE;
    }
    else {
        return FALSE;
    }
}