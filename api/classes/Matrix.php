<?php
class Matrix
{
    private $array;
    private $columnsCount;
    private $linesCount;

    // CONSTRUCTOR
    ////////////////////////////////////////////////////////////////////////////////////////

    function __construct($matrixArray)
    {
        self::validateMatrixArray($matrixArray);

        $this->array = $matrixArray;
        $this->linesCount = count($matrixArray);
        $this->columnsCount = max(self::getLinesLengths($matrixArray));
    }

    // GETTERS
    ////////////////////////////////////////////////////////////////////////////////////////

    public function getArray()
    {
        return $this->array;
    }
    public function getColumnsCount()
    {
        return $this->columnsCount;
    }
    public function getLinesCount()
    {
        return $this->linesCount;
    }

    // PUBLIC METHODS
    ////////////////////////////////////////////////////////////////////////////////////////

    public function isSquare()
    {
        if ($this->getLinesCount() === $this->getColumnsCount())
        {
            return true;
        }
        return false;
    }
    public function debugHTML($matrixName = '(undefined)')
    {
        $html[] = '<table style="border:1px solid black; border-collapse: collapse;">';
        $html[] = "<caption>Matrix $matrixName</caption>";
        $html[] = '<thead>';
        $html[] = '<tr>';
        $html[] = '<th style="border:1px solid black; background-color: #BBB; padding: 5px;">i / j</th>';

        for ($j = 0; $j < $this->getColumnsCount(); $j++)
        {
            $html[] = '<th style="border:1px solid black; background-color: #BBB; padding: 5px;">'.($j + 1).'</th>';
        }

        $html[] = '</tr>';
        $html[] = '</thead>';
        $html[] = '<tbody>';

        foreach ($this->getArray() as $i => $columns)
        {
            $html[] = '<tr>';
            $html[] = '<th style="border:1px solid black; background-color: #BBB; padding: 5px;">'.$i.'</th>';

            foreach ($columns as $cellValue)
            {
                $html[] = '<td style="border:1px solid black; text-align: center; padding: 5px;">'.$cellValue.'</td>';
            }

            $html[] = '</tr>';
        }

        $html[] = '</tbody>';
        $html[] = '</table>';
        echo implode('', $html);
    }

    // PRIVATE STATIC METHODS
    ////////////////////////////////////////////////////////////////////////////////////////

    private static function convertCellValue(&$matrixCell)
    {
        $intValue = filter_var($matrixCell, FILTER_VALIDATE_INT);
        $floatValue = filter_var($matrixCell, FILTER_VALIDATE_FLOAT);

        if ($intValue !== false)
        {
            $matrixCell = $intValue;
        }
        else if ($floatValue !== false)
        {
            $matrixCell = $floatValue;
        }
        else
        {
            throw new MatrixException("$matrixCell is not a valid cell value");
        }
    }
    private static function getLinesLengths($matrixArray)
    {
        return array_map('count', $matrixArray);
    }
    private static function hasEqualLinesLengths($matrixLinesLengths)
    {
        return count(array_unique($matrixLinesLengths)) === 1 ? true : false;
    }
    private static function validateMatrixArray(&$matrixArray)
    {
        if (!is_array($matrixArray))
        {
            throw new MatrixException('the constructor expects an array');
        }
        foreach ($matrixArray as $lineIndex => &$matrixLine)
        {
            if (!is_array($matrixLine) || count($matrixLine) === 0)
            {
                throw new MatrixException("Line n°$lineIndex has no column");
            }
            foreach ($matrixLine as $columnIndex => &$matrixCell)
            {
                if (!is_numeric($matrixCell))
                {
                    throw new MatrixException("Cell $lineIndex,$columnIndex doesn't contain a numeric value");
                }
                self::convertCellValue($matrixCell);
            }
        }

        $matrixLinesLengths = self::getLinesLengths($matrixArray);

        if (!self::hasEqualLinesLengths($matrixLinesLengths))
        {
            throw new MatrixException('each line need to have the same number of columns');
        }
    }
}
