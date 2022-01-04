<template>
  <panel-item :field="field">
    <template v-slot:value>
      <button
          class="btn btn-default btn-primary flex items-center justify-center"
          :class="{ hidden, 'btn-icon': icon }"
          @click="confirmActionModalOpened = true"
          :disabled="disabled"
          :style="`background-color: ${field.buttonColor} !important`"
          :title="buttonText"
      >
        <loading v-if="showLoading" :color="field.loadingColor" />
        <span v-else>
                    <span v-if="!field.showOnlyAnIcon" :class="{ 'mr-3': icon }">
                        {{ buttonText }}
                    </span>
                    <component v-if="svg" :is="svg"></component>
                    <i v-if="icon" :class="icon"></i>
                </span>
      </button>

      <!-- Action Confirmation Modal -->
      <portal to="modals" transition="fade-transition">
        <component
            v-if="confirmActionModalOpened"
            class="text-left"
            :is="field.action.component"
            :working="working"
            :selected-resources="selectedResources"
            :resource-name="resourceName"
            :action="selectedAction"
            :errors="errors"
            @confirm="executeAction"
            @close="confirmActionModalOpened = false"
        />
      </portal>
    </template>
  </panel-item>
</template>

<script>
import { FormField, HandlesValidationErrors, InteractsWithResourceInformation } from 'laravel-nova';
import ActionField from '../mixins/ActionField';

export default {
    mixins: [
        FormField,
        HandlesValidationErrors,
        InteractsWithResourceInformation,
        ActionField,
    ],

    methods: {
        /**
         * Handle the action response. Typically either a message, download or a redirect.
         */
        handleActionResponse(data) {
            try {
                this.$parent.$parent.$children[2].$emit('actionExecuted')
            } catch (e) {
                // Somehow didn't work. We continue so that the response is processed anyway.
            }
            if (data.message) {
                Nova.$emit('action-executed')
                Nova.success(data.message)
            } else if (data.deleted) {
                Nova.$emit('action-executed')
            } else if (data.danger) {
                Nova.$emit('action-executed')
                Nova.error(data.danger)
            } else if (data.download) {
                let link = document.createElement('a')
                link.href = data.download
                link.download = data.name
                document.body.appendChild(link)
                link.click()
                document.body.removeChild(link)
            } else if (data.redirect) {
                window.location = data.redirect
            } else if (data.push) {
                this.$router.push(data.push)
            } else if (data.openInNewTab) {
                window.open(data.openInNewTab, '_blank')
            } else {
                Nova.$emit('action-executed')
                Nova.success(this.__('The action ran successfully!'))
            }
        },
    },
}
</script>
