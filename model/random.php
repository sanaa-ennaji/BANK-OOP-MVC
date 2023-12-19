<?php

    class Random {
        public function get(){
            // $time = gettimeofday();
            // $rand = $time['sec'] . "-" . $time['usec'] . "-" . rand();
            $rand = uniqid(mt_rand(), true);
            return $rand;
        }
    }

?>