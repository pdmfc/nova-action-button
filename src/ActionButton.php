<?php

namespace Pdmfc\NovaFields;

use Laravel\Nova\Fields\Field;

class ActionButton extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-action-button';

    /**
     * @param string $action
     * @param $resourceId
     * @return ActionButton
     */
    public function action(string $action, $resourceId): ActionButton
    {
        return $this->withMeta([
            'action' => new $action(),
            'resourceId' => $resourceId,
        ]);
    }
}
