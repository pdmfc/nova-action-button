<?php

namespace Pdmfc\NovaFields;

use Laravel\Nova\Actions\Action;
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
     * @param Action|string|null $action
     * @param $resourceId
     */
    public function action($action, $resourceId): ActionButton
    {
        $actionInst = \is_string($action) ? new $action() : $action;

        if ($actionInst) {
            $actionInst->withMeta([
                'resourceId' => $resourceId,
            ]);
        }

        return $this->withMeta([
            'action' => $actionInst,
            'resourceId' => $resourceId,
        ]);
    }

    /**
     * The text to be displayed inside the button.
     */
    public function text(string $text)
    {
        return $this->withMeta(compact('text'));
    }

    /**
     * Hide button.
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
     * @param $callback
     */
    public function showLoadingAnimation($callback = true)
    {
        return $this->withMeta(
            [
                'showLoadingAnimation' => is_callable($callback) ? $callback() : $callback,
            ]
        );
    }

    /**
     * Change loading animation color.
     */
    public function loadingColor(string $loadingColor)
    {
        return $this->withMeta(compact('loadingColor'));
    }

    /**
     * Change button color.
     */
    public function buttonColor(string $buttonColor)
    {
        return $this->withMeta(compact('buttonColor'));
    }
}
