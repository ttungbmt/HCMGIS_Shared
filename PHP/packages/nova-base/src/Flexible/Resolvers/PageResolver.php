<?php

namespace Larabase\Nova\Flexible\Resolvers;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Whitecube\NovaFlexibleContent\Value\ResolverInterface;

class PageResolver implements ResolverInterface
{
    /**
     * get the field's value
     *
     * @param  mixed  $resource
     * @param  string $attribute
     * @param  \Whitecube\NovaFlexibleContent\Layouts\Collection $layouts
     * @return \Illuminate\Support\Collection
     */
    public function get($resource, $attribute, $layouts)
    {
        $blocks = $resource->{$attribute}()->get();

        return $blocks->map(function($block) use ($layouts, $attribute) {
            $layout = $block->layout ? $layouts->find($block->layout) : $layouts->first();
            if(!$layout) return;

            $values = collect($block->toArray())->keys()->mapWithKeys(fn($i) => [$i => $block->{$i}])->all();
            return $layout->duplicateAndHydrate($block->id, $values);
        })->filter();
    }

    /**
     * Set the field's value
     *
     * @param  mixed  $model
     * @param  string $attribute
     * @param  \Illuminate\Support\Collection $groups
     * @return string
     */
    public function set($model, $attribute, $groups)
    {
        $class = get_class($model);

        $class::saved(function ($model) use ($groups, $attribute) {
            $blocks = $groups->map(function ($group, $index){
                $attribute = $group->getAttributes();
                $attribute['order'] = $index + 1;
                $attribute['layout'] = $group->name();
                return $attribute;
            });

            $model->{$attribute}()->sync($blocks);
        });
    }
}
