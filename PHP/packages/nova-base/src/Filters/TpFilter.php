<?php
namespace Larabase\Nova\Filters;

use App\Models\HcTp;
use AwesomeNova\Filters\DependentFilter;
use Illuminate\Http\Request;

class TpFilter extends DependentFilter
{
    protected $modelClass = 'App\Models\HcTp';

    public $label = 'ten_tp';

    public $attribute = 'ma_tp';

    public function name()
    {
        return __('app.tp');
    }

    public function options(Request $request, array $filters = [])
    {
        $columns = [$this->label, $this->attribute];
        return (new $this->modelClass)::all($columns)->pluck(...$columns);
    }
}
