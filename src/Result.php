<?php
namespace ARG\Result;

abstract class Result{

    protected $value;
    protected $type;

    /**
     * Return $value in case of Ok, throw exception in case of Err.
     * @return mixed - The value of this result.
     * @throws Exception - An exception with the error message.
     */
    public abstract function unwrap();

    /**
     * Return $value in case of Ok, or $default in case of Err.
     * @param mixed $default - A default value in case of Err.
     * @param mixed &$error - A reference to a variable where the error will be set.
     * @return mixed - The value of Ok, in case of Err, value of $default.
     */
    public abstract function unwrapOr($default, &$error = null);

    /**
     * Return $value in case of Ok, or throw an exception with Err value and custom $error_msg.
     * @param mixed $error_msg - A custom error message.
     * @return mixed - The value of Ok.
     * @throws Exception - An exception with $error_msg in case of Err.
     */
    public abstract function expect($error_msg);

    /**
     * Return the error value to handle it manually.
     * @return mixed - The Err value. In case of Ok, return false.
     */
    public abstract function handle();

    /**
     * Return $this if it's Err, otherwise return $r
     * @return Result
     */
    public abstract function and(Result $r): Result;

    /**
     * Return $this if it's Ok, otherwise return $r
     * @return Result
     */
    public abstract function or(Result $r): Result;

    /**
     * Check if this Result is Ok.
     * @return bool
     */
    public function isOk(){
        return $this->type === Result_Ok::TYPE;
    }

    /**
     * Check if this Result is Err.
     * @return bool
     */
    public function isErr(){
        return $this->type === Result_Err::TYPE;
    }

    protected function getValueInfo(){
        return var_export($this->value, true);
    }


}
