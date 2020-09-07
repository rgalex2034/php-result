# php-result
An utility wrapper for return values and propagations of errors.

This is heavily based on what Rust offers as a Result struct.

## Usage
This library provides a `Result` interface to wrap and chain result values returned from functions.

A result provides the `isErr()` and `isOk()` methods to allow to identify what type of value is about.

To handle values, it provides the `unwrap()`, `unwrapOr()`, `expect()` and `handle()` methods.
 - unwrap(): Returns the wrapped value if it's an Ok object, othewrise throws an Exception.
 - unwrapOr($default): Returns the wrapped value if it's and Ok object, otherwise returns the $default parameter.
 - expect($message): Returns the wrapped value if it's an Ok object, othewrise throws an Exception with a custom $message.
 - handle(): Returns the value if it's an Err, otherwise returns null.

To handle chaining, it provides `and()` and `or()` methods.
 - and($result): If the result is Ok, it returns $result, otherwise it returns itself.
 - or($result): If the result is Ok, it returns itself, otherwise it returns $result.

There is also a `Deferred` class which wraps a `Result` interface and the result is processed in a lazy way.
It requires a function on it's constructor that must return a Result. The function will be executed once a Deferred result make use
of any of it's functions mentioned before.

It's useful while chaining results through the `and()` and `or()` methods, as it value is never calculated unless it needs to be processed.

## Example
This shows a wrapper to `fopen()` and `fwrite()` which handles errors and throw an exception if something goes wrong on any step.
```php
<?php
use ARG\Result;

//Wrapped implementation of fopen() and fwrite()
function safe_fopen($file, $mode){
  $fh = fopen($file, $mode);
  return $fh ? new Result\Ok($fh) : new Result\Err(error_get_last());
}

function safe_fwrite($fh, $data){
  $ok = fwrite($fh, $data);
  return $ok ? new Result\Ok(true) : new Result\Err(error_get_last());
}

//Usage of functions which makes use of the Result interface.
$fh = safe_fopen("/tmp/test", "w")->expect("Unable to open file for writing!");
safe_fwrite($fh, "First line\n")->and(safe_fwrite($fh, "Second line\n"))->expect("Unable to write data to file");
echo "Everything went ok\n";
```
