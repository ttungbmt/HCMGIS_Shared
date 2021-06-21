<?php

namespace Larabase\Nova\Actions;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Larabase\NovaFields\Serial;
use Laravel\Nova\Fields\Date;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Shared\Date as DateExcel;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/*
 * https://laraveldaily.com/laravel-excel-export-formatting-and-styling-cells/
 * */

class ExportExcel extends DownloadExcel implements ShouldAutoSize, WithColumnFormatting, WithStyles, WithMapping
{
    public function __construct($columns = [])
    {
        $this
            ->withHeadings()
            ->only($columns)
            ->except('geom');
    }

    public function getResourceFields()
    {
        $only = $this->getOnly();
        $except = $this->getExcept();
        $fields = $this->request->newResource()->indexFields($this->request);
        return collect($only)->except($except)->map(fn ($attr) => $fields->search(fn($f) => $f->attribute === $attr))->filter(fn($f) => $f !== false)->map(fn($index) => $fields[$index]);
    }

    public function columnFormats(): array
    {
        return $this->getResourceFields()->whereInstanceOf(Date::class)->mapWithKeys(fn($value, $key) => [Coordinate::stringFromColumnIndex($key + 1) => NumberFormat::FORMAT_DATE_DDMMYYYY])->all();
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'F2F2F2']],
                'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,]],
            ],
        ];
    }

    public function prepareRows($rows): array
    {
        return $rows->map(function ($model, $key) {
            return $this->toRow($model, $key);
        })->filter()->all();
    }

    protected function toRow($model, $key){
        $only = $this->getOnly();
        $except = $this->getExcept();
        // If user didn't specify a custom except array, use the hidden columns.
        // User can override this by passing an empty array ->except([])
        // When user specifies with only(), ignore if the column is hidden or not.
        if (!$this->onlyIndexFields && $except === null && (!is_array($only) || count($only) === 0)) {
            $except = $model->getHidden();
        }

        // Make all attributes visible
        $model->setHidden([]);

        $resource = $this->resolveResource($model);
        // Support: fieldsForExport
        $fields = $this->resourceFields($resource);

        $fields->whereInstanceOf(Serial::class)->each(function ($field) use ($key) {
            $field->value = $key + 1;
        });

        $fields->whereInstanceOf(Date::class)->each(function ($field) {
            if ($field->value) {
                if ($field->value instanceof DateTime) $field->value = DateExcel::dateTimeToExcel($field->value);
                if (is_string($field->value)) {
                    $value = Carbon::createFromFormat('Y-m-d', $field->value);
                    $field->value = DateExcel::dateTimeToExcel($value);
                }
            }
        });

        $row = $this->replaceRowFieldValuesWhenOnResource($model, $fields, $only);

        if (is_array($except) && count($except) > 0) {
            $row = Arr::except($row, $except);
        }

        return $row;
    }

    protected function replaceRowFieldValuesWhenOnResource(Model $model, $fields, array $only = []): array {
        $row = [];
        foreach ($fields as $field) {
            if (!$this->isExportableField($field)) {
                continue;
            }

            if (\in_array($field->attribute, $only, true)) {
                $row[$field->attribute] = $field->value;
            } elseif (\in_array($field->name, $only, true)) {
                // When no field could be found by their attribute name, it's most likely a computed field.
                $row[$field->name] = $field->value;
            }

        }

        // Add fields that were requested by ->only(), but are not registered as fields in the Nova resource.
        foreach (array_diff($only, array_keys($row)) as $attribute) {
            $value = data_get($model, str_replace('->', '.', $attribute));
            if ($value) {
                $row[$attribute] = $value;
            } else {
                $row[$attribute] = '';
            }
        }

        //Fix sorting
        return array_merge(array_flip($only), $row);
    }

    //    protected $columns = [];
//
//    public function __construct($columns = [])
//    {
//        $this->columns = $columns;
//
//        $this
//            ->allFields()
////            ->withHeadings()
////            ->askForColumns()
//            ->askForFilename()
//            ->askForWriterType();
//    }
//
//    public function handleRequest(ActionRequest $request)
//    {
//        return parent::handleRequest($request); // TODO: Change the autogenerated stub
//    }
//
//
//    public function columns(){
//        return $this->columns;
//    }
//
//    public function headings(): array
//    {
//        return collect($this->getColumns())->pluck('name')->all();
//    }
//
//

//    public function askForColumns(string $label = null, callable $callback = null)
//    {
//        $columns = collect($this->getColumns())->pluck('name', 'attribute')->all();
//        dd($this);
//
//        $field = Multiselect::make($label ?? __('Columns'), 'columns')
//            ->placeholder('Columns to export')
//            ->options($columns)
//            ->reorderable();
//
//        //$field->resolve(['columns' => collect($this->columns())->filter(fn($f) => $f->showOnIndex)->pluck('attribute')]);
//
//        if (is_callable($callback)) $callback($field);
//
//        $this->actionFields[] = $field;
//
//        return $this;
//    }
//
//    protected function getDefaulColumns(){
//        return collect($this->columns())->filter(fn($col) => call_user_func($col->showOnIndex, $this->request));
//    }
//
//    protected function getColumn($attribute){
//        return collect($this->columns())->firstWhere('attribute', $attribute);
//    }
//
//    protected function getColumns(){
//        if(!$this->request) return $this->getDefaulColumns();
//        return !empty($this->request->input('columns')) ? collect($this->request->input('columns'))->map(fn($attribute) => $this->getColumn($attribute)) : $this->getDefaulColumns();
//    }
//


}