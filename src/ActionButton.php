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

        $actionInst = \is_string($action) ? new $action() : $action;

        if ($actionInst) {
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

    /**
     * Hide button
     *
     * @param callable
     */
    public function hide($callback)
    {
        return $this->withMeta(['hidden' => call_user_func($callback)]);
    }

    /**
     * Enable loading animation. 
     *
     * @param bool $loadingAnimation
     */
    public function loadingAnimation(bool $loadingAnimation)
    {
        return $this->withMeta(compact('loadingAnimation'));
    }

    /**
     * Change loading animation color
     *
     * @param string $loadingColor
     */
    public function loadingColor(string $loadingColor)
    {
        return $this->withMeta(compact('loadingColor'));
    }
}
