<?php
/*Question #2.2
The output of the following code is that $variable_a = 4, and $variable_b = 3, explain why.*/

function my_function(&$my_argument)
{
    $response = $my_argument;
    $my_argument += 1;
    
    return $response;
}

$variable_a = 3;
$variable_b = my_function($variable_a);


/*Answer:

The function my_function takes the argument as a reference (&$my_argument) rather than as a value.
Therefore when it is modified in the function it is modifying the $variable_a itself*/