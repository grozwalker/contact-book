<template>
    <b-container class="bv-example-row">
        <b-row>
            <b-col>
                <h1>{{ $route.params.id }}</h1>

            </b-col>
        </b-row>
    </b-container>
</template>

<script>
    export default {
        name: "Contact",
        props: {
            id: {
                'type': String,
            },
        },
        data() {
            return {
                contact: [],
            }
        },
        created() {
            this.$api.get('contact/' + this.$route.params.id).then(response => {
                console.log('response', response.data)
                this.contact = response.data;
            })
        }
    }
</script>