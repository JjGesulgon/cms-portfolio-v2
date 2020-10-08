<template>
    <div>
        <div v-if="$parent.ifReady">
            <fieldset disabled>
                <slot></slot>
            </fieldset>
        </div>
        <div v-else>
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            apiPath: String,
            routePrefixName: String,
            singularName: String,
            toastMessage: String,
            object: Object,
            selectedProperty: String,
        },
    }
</script>
