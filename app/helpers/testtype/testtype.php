<?php

function TT($str) {
    switch ($str) {
        case 'mcq':
            return TT::$AUTOMCQ;            
        default:
            return -1;
    }
}

class TT {
    public static $AUTOMCQ = 1;
}