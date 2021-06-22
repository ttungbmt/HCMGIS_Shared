<?php
namespace Larabase\Nova\Filters;

use AwesomeNova\Filters\DependentFilter;
use Illuminate\Http\Request;

class PhuongFilter extends DependentFilter
{
    public $dependentOf = ['maquan'];

    protected $modelClass = 'App\Models\HcPhuong';

    public $label = 'tenphuong';

    public $attribute = 'maphuong';

    public function name()
    {
        return __('app.px');
    }

    public function options(Request $request, array $filters = [])
    {
        $query = new $this->modelClass();
        foreach ($this->dependentOf as $name) $query = $query->where($name, $filters[$name]);
        return $query->pluck($this->label, $this->attribute);
    }
}
