<?php
namespace ARG\Result;

class Ok extends Result{

    const TYPE = 0;

    public function __construct($value){
        $this->value = $value;
        $this->type = self::TYPE;
    }

    public function unwrap(){
        return $this->value;
    }

    public function unwrapOr($default, &$error = null){
        return $this->unwrap();
    }

    public function expect($error_msg){
        return $this->unwrap();
    }

    public function handle(){
        return false;
    }

    public function and(Result $r): Result{
        return $r;
    }

    public function or(Result $r): Result{
        return $this;
    }

}
