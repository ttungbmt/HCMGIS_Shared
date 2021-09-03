<?php

namespace Larabase\Imports;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use MStaack\LaravelPostgis\Geometries\Point;

class Import
{
    use Importable;

    protected $modelClass;

    protected $count = 0;

    protected $dates = [];

    public function getCount()
    {
        return $this->count;
    }

    protected function validateHeadings($rows, $headings)
    {
        $data = $rows->first()->keys()->filter()->combineValues()->all();
        $rules = collect($headings)->mapWithKeys(fn($v) => [$v => 'required'])->all();

        Validator::make($data, $rules, [
            'required' => 'Cột :attribute không tồn tại',
        ])->validate();
    }

    protected function toValues($row, $fields = [])
    {
        return collect($fields)->mapWithKeys(function ($f, $k) use ($row) {
            try {
                if(is_numeric($k)) $k = $f;

                if (!isset($row[$k])) return [];

                $value = data_get($row, $k);

                if (is_string($f)) return [$f => $row[$f]];

                $resolveCallback = $f->resolveCallback;

                if (is_null($value)) return [$f->attribute => null];

                if ($resolveCallback) {
                    $value = call_user_func($resolveCallback, $value);
                }
            } catch (\Exception $e) {
                dd($e);
            }

            return [$f->attribute => $value];
        })->mapWithKeys(function ($v, $k){
            if(is_string($v)){
                $v = trim($v);
                $v = ($v == "") ? null : $v;
            }

            return [$k => $v];
        });
    }

    protected function fields()
    {
        return [];
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $k => $row) {
            $row = $row->toArray();
            if(empty($this->fields())){
                $values = $row;
            } else {
                $values = $this->toValues($row, $this->fields())->all();
            }

            foreach ($this->dates as $field){
                $values[$field] = to_date($values[$field]);
            }

            $model = isset($values['id']) && $values['id'] ? $this->modelClass::find($values['id']) : new $this->modelClass;
            $model->fill($values);
            collect($values)->filter(fn($v, $k) => Str::contains($k, '->'))->map(fn($v, $k) => $model->{$k} = $v);

            if (
                isset($values['lat']) && $values['lat'] &&
                isset($values['lng']) && $values['lng']
            ) $model->geom = new Point($values['lat'], $values['lng']);

            $model->save();

            $this->count = $k + 1;
        }

        session()->flash('importCount', $this->count);
    }
}