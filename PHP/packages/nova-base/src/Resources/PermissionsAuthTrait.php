<?php
namespace Larabase\Nova\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Laravel\Nova\Http\Requests\NovaRequest;

trait PermissionsAuthTrait
{
    public static $abilities = [];

    public static function abilities(){
        return static::$abilities;
    }

    public static function hasGate(){
        return !is_null(Gate::getPolicyFor(static::newModel()));
    }

    public static function permissionsForAbilities(){
        $abilities = static::abilities();

        if(empty($abilities)) return [];

        return collect($abilities)->mapWithKeys(fn($name, $k) => [$name => static::policyKey().'.'.Str::kebab($name)])->all();
    }

    public static function abilityExist($ability){
        return collect(static::permissionsForAbilities())->keys()->contains($ability);
    }
    /**
     * Determine if the given resource is authorizable.
     *
     * @return bool
     */
    public static function authorizable()
    {
        return parent::authorizable() || collect(static::permissionsForAbilities())->isNotEmpty();
    }

    /**
     * Determine if the resource should be available for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function authorizeToViewAny(Request $request)
    {
        parent::authorizeToViewAny($request);

        if(in_array('viewAny', static::permissionsForAbilities())){
            $this->authorizeTo($request, 'viewAny');
        }
    }

    /**
     * Determine if the resource should be available for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public static function authorizedToViewAny(Request $request)
    {
        if (! static::authorizable()) {
            return true;
        }

        $gate = Gate::getPolicyFor(static::newModel());

        if(! is_null($gate) && method_exists($gate, 'viewAny')) return Gate::check('viewAny', get_class(static::newModel()));
        if(static::abilityExist('viewAny')) return static::hasPermissionsTo($request, 'viewAny');

        return true;
    }

    /**
     * Determine if the current user can create new resources.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public static function authorizedToCreate(Request $request)
    {
        if (static::authorizable()) {
            if(static::hasGate()) return Gate::check('create', get_class(static::newModel()));
            else return static::hasPermissionsTo($request, 'create');
        }

        return true;
    }

    /**
     * Determine if the user can add / associate models of the given type to the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Model|string  $model
     * @return bool
     */
    public function authorizedToAdd(NovaRequest $request, $model)
    {
        if (! static::authorizable()) {
            return true;
        }

        $gate = Gate::getPolicyFor($this->model());
        $method = 'add'.class_basename($model);
        $ability = 'add-'.Str::lower(class_basename($model));

        if(! is_null($gate) && method_exists($gate, $method)) return Gate::check($method, $this->model());
        if(static::abilityExist($ability)) return static::hasPermissionsTo($request, $ability);

        return true;
    }

    /**
     * Determine if the user can attach any models of the given type to the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Model|string  $model
     * @return bool
     */
    public function authorizedToAttachAny(NovaRequest $request, $model)
    {
        if (! static::authorizable())  return true;

        $gate = Gate::getPolicyFor($this->model());
        $method = 'attachAny'.Str::singular(class_basename($model));

        if (static::authorizable()) {
            if(! is_null($gate) && method_exists($gate, $method)) return Gate::check($method, [$this->model()]);
            else return static::hasPermissionsTo($request, Str::kebab($method));
        }

        return true;
    }

    /**
     * Determine if the user can attach models of the given type to the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Model|string  $model
     * @return bool
     */
    public function authorizedToAttach(NovaRequest $request, $model)
    {
        return parent::authorizedToAttach($request, $model);
    }

    /**
     * Determine if the user can detach models of the given type to the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Model|string  $model
     * @param  string  $relationship
     * @return bool
     */
    public function authorizedToDetach(NovaRequest $request, $model, $relationship)
    {
        return parent::authorizedToDetach($request, $model, $relationship);
    }

    /**
     * Determine if the current user can view the given resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $ability
     * @return bool
     */
    public function authorizedTo(Request $request, $ability)
    {
        if(static::authorizable()) {
            if(static::hasGate()) return Gate::check($ability, $this->resource);
            else return static::hasPermissionsTo($request, $ability);
        }
        return true;
    }


    public static function hasPermissionsTo(Request $request, $ability)
    {
        $abilities = static::permissionsForAbilities();

        if (isset($abilities[$ability])) {
            return $request->user()->can($abilities[$ability]);
        }

        if (isset($abilities['*'])) {
            return $request->user()->can($abilities['*']);
        }

        return false;
    }
}