<?php

namespace App\Imports;

use App\Models\Test;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class TestImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $attributes = $row;
        unset($attributes['msisdn']);
        $serializeAttribute = serialize($attributes);

        return new Test([
            'msisdn' => $row['msisdn'],
            'attribute' => $serializeAttribute
        ]);
    }

    // public function rules(): array
    // {
    //     return [
    //         'msisdn' => [
    //             'required'
    //         ]
    //     ];
    // }

    // public function customValidationMessages()
    // {
    //     return [
    //         'msisdn.in' => 'Custom message for jk.',
    //     ];
    // }
}
