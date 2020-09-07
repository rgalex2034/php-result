<?php

require_once __DIR__."/../vendor/autoload.php";

use PHPUnit\Framework\TestCase;
use ARG\Result;

class ResultTest extends TestCase{

    public function __construct(){
        parent::__construct();
    }

    /**
     * @test
     */
    public function testOk(){
        $value = "Test value";
        $result = new Result\Ok($value);

        //Check instance and value
        $this->assertInstanceOf(Result\Ok::class, $result);
        $this->assertEquals($result->unwrap(), $value);
    }

    /**
     * @test
     */
    public function testErr(){
        $error_value = "An error message";
        $result = new Result\Err($error_value);

        //Check instance and value
        $this->assertInstanceOf(Result\Err::class, $result);
        $this->assertEquals($result->handle(), $error_value);

        //Check exception flow and value
        try{
            $result->expect("An error ocurred");
            $this->assertTrue(false);
        }catch(\Exception $e){
            $this->assertTrue(strpos($e->getMessage(), $error_value) > 0);
        }
    }

    /**
     * @test
     */
    public function testDefferred(){
        $ok_value = "A valid value";
        $result = new Result\Deferred(function() use($ok_value){
            return new Result\Ok($ok_value);
        });

        //Check instance and value
        $this->assertInstanceOf(Result\Deferred::class, $result);
        $this->assertEquals($result->unwrap(), $ok_value);
    }

    /**
     * @test
     */
    public function testAnd(){
        $one = 1; $two = 2; $three = 3;

        $ok_one = new Result\Ok($one);
        $ok_two = new Result\Ok($two);
        $err_three = new Result\Err($three);

        //All true and
        $result = $ok_one->and($ok_two);
        $this->assertEquals($result->unwrap(), $two);

        //One err and
        $result = $ok_one->and($err_three)->and($ok_two);
        $this->assertEquals($result->handle(), $three);
    }

    /**
     * @test
     */
    public function testOr(){
        $one = 1; $two = 2; $three = 3;

        $ok_one = new Result\Ok($one);
        $ok_two = new Result\Ok($two);
        $err_three = new Result\Err($three);

        //All true and
        $result = $ok_one->or($ok_two);
        $this->assertEquals($result->unwrap(), $one);

        //One err and
        $result = $err_three->or($ok_one)->or($ok_two);
        $this->assertEquals($result->unwrap(), $one);
    }

}
