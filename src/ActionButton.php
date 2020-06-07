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
     * @param string|null $action
     * @param $resourceId
     * @return ActionButton
     */
    public function action($action, $resourceId): ActionButton
    {
        return $this->withMeta([
            'action' => $action ? new $action() : null,
            'resourceId' => $resourceId,
        ]);
    }

    /**
     * The text to be displayed inside the button.
     *
     * @param string $text
     */
    public function text(string $text)
    {
        return $this->withMeta(compact('text'));
    }
}
