<?php
namespace Larabase\Nova\Filters;

use App\Models\HcQuan;

use AwesomeNova\Filters\DependentFilter;
use Illuminate\Http\Request;

class QuanFilter extends DependentFilter
{
    public $dependentOf = ['ma_tp'];

    protected $modelClass = 'App\Models\HcQuan';

    public $label = 'tenquan';

    public $attribute = 'maquan';

    public function name()
    {
        return __('app.qh');
    }

    public function options(Request $request, array $filters = [])
    {
        if($this->optionsCallback) return call_user_func($this->optionsCallback, $request, $filters);

        $query = new $this->modelClass();
        foreach ($this->dependentOf as $name) $query = $query->where($name, $filters[$name]);
        return $query->pluck($this->label, $this->attribute);
    }
}
