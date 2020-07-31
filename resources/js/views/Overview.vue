<template>
    <div class="container">
        <div class="image-container">
            <img class="img-fluid accent-image" src="/images/undraw_content.svg" alt="Image"/>
        </div>
        <div class="display-1 font-weight-lighter text-center">
            Welcome to the CMS Module.
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {

        };
    },

    mounted() {
        // 
    },

    methods: {
        // Add ES6 methods here
    },

    computed: {
        // Add ES6 methods here that needs caching
    }
}
</script>

<style>
.profit-card-graph-bg {
    background: #43A047;
    background: -webkit-linear-gradient(45deg, #004eff 0%, #1de9b6 100%);
    background: linear-gradient(45deg, #004eff 0%, #1de9b6 100%);
    box-shadow: 0 4px 15px 0 rgba(77, 182, 172, 0.5);
}

.sales-card-graph-bg {
    background: #43A047;
    background: -webkit-linear-gradient(45deg, #00bfa5 0%, #1de9b6 100%);
    background: linear-gradient(45deg, #00bfa5 0%, #1de9b6 100%);
    box-shadow: 0 4px 15px 0 rgba(77, 182, 172, 0.5);
}

.accent-image{
    max-width: 50%;
    height: auto;
}

.image-container{
    text-align: center;
}
</style>
