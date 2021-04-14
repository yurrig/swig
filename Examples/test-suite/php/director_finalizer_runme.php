<?php

require "tests.php";
require "director_finalizer.php";

// New functions
check::functions(array('deletefoo','getstatus','launder','resetstatus'));
// New classes
check::classes(array('director_finalizer','Foo'));
// No new vars
check::globals(array());

class MyFoo extends Foo {
  function __destruct() {
    $this->orStatus(2);
    if (method_exists(get_parent_class(), "__destruct")) {
      parent::__destruct();
    }
  }
}

resetStatus();

$a = new MyFoo();
unset($a);

check::equal(getStatus(), 3, "getStatus() failed #1");

resetStatus();

$a = new MyFoo();
launder($a);

check::equal(getStatus(), 0, "getStatus() failed #2");

unset($a);

check::equal(getStatus(), 3, "getStatus() failed #3");

resetStatus();

$a = new MyFoo();
$a->thisown = 0;
deleteFoo($a);
unset($a);

check::equal(getStatus(), 3, "getStatus() failed #4");

resetStatus();

$a = new MyFoo();
$a->thisown = 0;
deleteFoo(launder($a));
unset($a);

check::equal(getStatus(), 3, "getStatus() failed #5");

resetStatus();

check::done();
