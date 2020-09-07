<?php

namespace Pdmfc\NovaFields;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Actions\Action;

class ActionButton extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-action-button';

    /**
     * @param Action|string|null $action
     * @param $resourceId
     * @return ActionButton
     */
    public function action($action, $resourceId): ActionButton
    {
        $actionInst = null;

        if ($action) {
            $actionInst = \is_string($action) ? new $action() : $action;
            $actionInst->withMeta([
                'resourceId' => $resourceId
            ]);
        }

        return $this->withMeta([
            'action' => $actionInst,
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
