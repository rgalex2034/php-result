<?php
namespace ARG\Result;

class Deferred extends Result{

    private $deferred_function;
    private $result;

    public function __construct(callable $deferred_function){
        $this->deferred_function = $deferred_function;
    }

    public function unwrap(){
        $this->getResult();
        return $this->result->unwrap();
    }

    public function unwrapOr($default, &$error = null){
        $this->getResult();
        return $this->result->unwrapOr($default, $error);
    }

    public function expect($error_msg){
        $this->getResult();
        return $this->result->expect($error_msg);
    }

    public function handle(){
        $this->getResult();
        return $this->result->handle();
    }

    public function and(Result $r): Result{
        $this->getResult();
        return $this->result->and($r);
    }

    public function or(Result $r): Result{
        $this->getResult();
        return $this->result->or($r);
    }

    public function isOk(){
        $this->getResult();
        return $this->result->isOk();
    }

    public function isErr(){
        $this->getResult();
        return $this->result->isErr();
    }

    private function getResult(){
        if(!$this->result) $this->result = ($this->deferred_function)();
        return $this->result;
    }

}
