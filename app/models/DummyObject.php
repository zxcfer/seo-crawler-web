<?php 

/* DummyObject obeys */
class DummyObject{

    function __get($var){
        if(isset($this->{$var})){
            return $this->{$var};
        }
        return NULL;
    }

    function __set($var, $val){
        $this->{$var} = $val;
    }

}