<?php
namespace services;

use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CSVModal implements ToCollection
{
    private $data = [];
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            if (!empty($row[0])){
                array_push($this->data, [
                    "name" => $row[0],
                ]);
            }
        }
    }

    public function getData(){
        return $this->data;
    }
}
