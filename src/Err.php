<?php
namespace ARG\Result;

class Err extends Result{

    const TYPE = 1;

    public function __construct($value){
        $this->value = $value;
        $this->type = self::TYPE;
    }

    public function unwrap(){
        $error_data = $this->getValueInfo();
        throw new \Exception("Unhandled Err: ".$error_data);
    }

    public function unwrapOr($default, &$error = null){
        $error = $this->value;
        return $default;
    }

    public function expect($error_msg){
        $error_data = $this->getValueInfo();
        throw new \Exception($error_msg."\n".$error_data);
    }

    public function handle(){
        return $this->value;
    }

    public function and(Result $r): Result{
        return $this;
    }

    public function or(Result $r): Result{
        return $r;
    }

}
