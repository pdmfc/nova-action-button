<template>
    <div>
        <button
            class="btn btn-default btn-primary flex items-center justify-center"
            :class="{ hidden }"
            @click="openConfirmationModal"
            :disabled="disabled"
            :style="`background-color: ${field.buttonColor} !important`"
        >
            <loading v-if="showLoading" :color="field.loadingColor" />
            <span v-else>{{ buttonText }}</span>
            <component v-if="svg" :is="svg"></component>
            <icon v-if="icon" :type="icon"></icon>
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
                @close="closeConfirmationModal"
            />
        </portal>
    </div>
</template>

<script>
import {
    FormField,
    HandlesValidationErrors,
    InteractsWithResourceInformation,
} from 'laravel-nova';

export default {
    mixins: [
        ActionField,
        FormField,
        HandlesValidationErrors,
        InteractsWithResourceInformation,
    ],

    methods: {
        /**
         * Handle the action response. Typically either a message, download or a redirect.
         */
        handleActionResponse(data) {
            if (data.message) {
                this.$parent.$emit('actionExecuted');
                Nova.$emit('action-executed');
                Nova.success(data.message);
            } else if (data.deleted) {
                this.$parent.$emit('actionExecuted');
                Nova.$emit('action-executed');
            } else if (data.danger) {
                this.$parent.$emit('actionExecuted');
                Nova.$emit('action-executed');
                Nova.error(data.danger);
            } else if (data.download) {
                let link = document.createElement('a');
                link.href = data.download;
                link.download = data.name;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else if (data.redirect) {
                window.location = data.redirect;
            } else if (data.push) {
                this.$router.push(data.push);
            } else if (data.openInNewTab) {
                window.open(data.openInNewTab, '_blank');
            } else {
                this.$parent.$emit('actionExecuted');
                Nova.$emit('action-executed');
                Nova.success(this.__('The action ran successfully!'));
            }
        },
    },
};
</script>
