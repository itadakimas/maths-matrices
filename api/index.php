<?php
require 'classes/Matrix.php';
require 'classes/MatrixCalculator.php';
require 'classes/MatrixException.php';

// header('Content-Type: application/json');

try
{
    $aMatrix = new Matrix([
        [34,-23,346],
        [-1,0,0],
        [42,567,10],
        [1,3,4],
        [5,7,101]
    ]);

    $aMatrix->debugHTML('A');

    $bMatrix = new Matrix([
        [1,100,666,0,-45,23],
        [87,9909,7,87,987,96],
        [898,7,989,66,0,86]
    ]);

    $bMatrix->debugHTML('B');

    // $result = MatrixCalculator::add($aMatrix, $bMatrix);
    // $result = MatrixCalculator::sub($aMatrix, $bMatrix);
    // $result = MatrixCalculator::multiplyByReal($aMatrix, '-1');
    $result = MatrixCalculator::multiply($aMatrix, $bMatrix);
    // $result = MatrixCalculator::transpose($aMatrix);

    $result->debugHTML('A x B');

    // $response = [
    //     'status'    => 'success',
    //     'resources' => null
    // ];
}
catch (MatrixException $e)
{
    var_dump($e);

    $response = [
        'status'    => 'failure',
        'message'   => $e->getMessage()
    ];

    echo json_encode($response);
}
