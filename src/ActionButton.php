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
                'showLoadingAnimation' => is_callable($callback) ? $callback() : $callback
            ]
        );
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

    /**
     * Pass a vue component containing a svg
     *
     * @param string $svg
     */
    public function svg(string $svg)
    {
        return $this->withMeta(['svg' => $svg]);
    }

    /**
     * Pass a nova icon to be displayed using the Nova Icon component
     *
     * @param string $icon
     */
    public function icon(string $icon)
    {
        return $this->withMeta(['icon' => $icon]);
    }

    /**
     * Change button color.
     */
    public function buttonColor(string $buttonColor)
    {
        return $this->withMeta(compact('buttonColor'));
    }
}
