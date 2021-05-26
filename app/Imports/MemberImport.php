<?php

namespace App\Imports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;

class MemberImport implements ToModel, WithHeadingRow, WithValidation, WithChunkReading, ShouldQueue
{
    protected $group_id;

    /**
     * constructor
     *
     * @param integer $group_id
     */
    public function __construct(int $group_id)
    {
        $this->group_id = $group_id;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $attributes = $row;
        unset($attributes['msisdn']);

        return new Member([
            'group_id' => $this->group_id,
            'msisdn' => $row['msisdn'],
            'attribute' => $attributes,
        ]);
    }

    public function rules(): array
    {
        return [
            'msisdn' => function ($attribute, $value, $onFailure) {
                if (empty($value) || $value == "") {
                    $onFailure('msisdn cannot be empty');
                }
            }
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
