import { Errors } from 'laravel-nova';
import Loading from '../components/Loading';

export default {
    components: {
        Loading,
    },

    props: {
        resourceName: String,
        field: Object,
        queryString: {
            type: Object,
            default: () => ({
                currentSearch: '',
                encodedFilters: '',
                currentTrashed: '',
                viaResource: '',
                viaResourceId: '',
                viaRelationship: '',
            }),
        },
    },

    data: () => ({
        working: false,
        loading: false,
        confirmActionModalOpened: false,
    }),

    methods: {
        /**
         * Confirm with the user that they actually want to run the selected action.
         */
        openConfirmationModal() {
            this.loading = true;
            this.confirmActionModalOpened = true;
        },

        /**
         * Close the action confirmation modal.
         */
        closeConfirmationModal() {
            this.confirmActionModalOpened = false;
            this.errors = new Errors();
            this.loading = false;
        },

        /**
         * Execute the selected action.
         */
        executeAction() {
            this.working = true;
            this.loading = true;

            if (this.selectedResources.length == 0) {
                alert(this.__('Please select a resource to perform this action on.'));
                return;
            }

            Nova.request({
                method: 'post',
                url: this.endpoint || `/nova-api/${this.resourceName}/action`,
                params: this.actionRequestQueryString,
                data: this.actionFormData(),
            })
                .then((response) => {
                    this.confirmActionModalOpened = false;
                    this.handleActionResponse(response.data);
                    this.working = false;
                    this.loading = false;
                })
                .catch((error) => {
                    this.working = false;
                    this.loading = false;

                    if (error.response.status == 422) {
                        this.errors = new Errors(error.response.data.errors);
                        Nova.error(this.__('There was a problem executing the action.'));
                    }
                });
        },

        /**
         * Gather the action FormData for the given action.
         */
        actionFormData() {
            return _.tap(new FormData(), (formData) => {
                formData.append('resources', this.selectedResources);

                _.each(this.selectedAction.fields, (field) => {
                    field.fill(formData);
                });
            });
        },
    },

    computed: {
        selectedResources() {
            return this.field.resourceId;
        },

        selectedAction() {
            return this.field.action;
        },

        /**
         * Get the query string for an action request.
         */
        actionRequestQueryString() {
            return {
                action: this.selectedAction.uriKey,
                search: this.queryString.currentSearch,
                filters: this.queryString.encodedFilters,
                trashed: this.queryString.currentTrashed,
                viaResource: this.queryString.viaResource,
                viaResourceId: this.queryString.viaResourceId,
                viaRelationship: this.queryString.viaRelationship,
            };
        },

        hidden() {
            return this.field.hidden || false;
        },

        showLoading() {
            return (this.field.showLoadingAnimation || false) && this.loading;
        },

        disabled() {
            return this.field.readonly || ((this.field.showLoadingAnimation || false) && this.loading);
        },

        buttonText() {
            return this.field.text || this.__('Run');
        },

        svg() {
            return this.field.svg || false;
        },

        icon() {
            return this.field.icon || false;
        }
    }
};
