<?php
namespace Larabase\NovaFields;

use Laravel\Nova\Http\Requests\NovaRequest;

class KeyValue extends \Laravel\Nova\Fields\KeyValue
{
    public $component = 'nova-key-value-field';

    public $canSortRow = true;

    /**
     * Disable deleting rows.
     *
     * @return \Laravel\Nova\Fields\KeyValue
     */
    public function disableSortingRows()
    {
        $this->canSortRow = false;

        return $this;
    }

    /**
     * Prepare the field element for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'canSortRow' => $this->canSortRow,
        ]);
    }
}