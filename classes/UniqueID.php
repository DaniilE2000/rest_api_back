<?php

namespace classes;

/** Class representing a unique_id object. */

class UniqueID
{
    public string $id;
    public int $number;

    public function __construct(int $boundStart, int $boundEnd)
    {
        $this->id = \md5(\time());
        $boundRange = $boundEnd - $boundStart;
        if ($boundRange === 0) {
            $this->number = $boundStart;
        } else {
            $this->number = $boundStart + (\time() % $boundRange);
        }
    }

    public function __toString(): string
    {
        return 'id: ' . \strval($this->id). ', number: ' . \strval($this->number);
    }
}

?>