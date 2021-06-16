<?php
namespace Larabase\Imports;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;

class Import
{
    use Importable;

    protected $count = 0;

    public function getCount(){
        return $this->count;
    }

    protected function validateHeadings($rows, $headings){
        $data = $rows->first()->keys()->filter()->combineValues()->all();
        $rules = collect($headings)->mapWithKeys(fn($v) => [$v => 'required'])->all();

        Validator::make($data, $rules, [
            'required' => 'Cột :attribute không tồn tại',
        ])->validate();
    }
}