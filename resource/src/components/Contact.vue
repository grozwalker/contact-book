<template>
    <p>
        Contact # {{ $route.params.id }}
    </p>
</template>

<script>
    export default {
        name: "Contact",
        props: {
            id: {
                'type': String,
            },
        },
    }
</script>