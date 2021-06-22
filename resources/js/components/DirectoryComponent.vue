<template>
    <div>Hi</div>
</template>

<script>
export default {
    name: 'Folder',
    props: ['id'],
    data() {
        return {
            welcome: 'This is your profile'
        }
    },
    mounted() {
        console.log(this.id);

    },
    methods:{
        getInfo()
        {
            let id = this.$route.params.id
        }
    }
}
</script>
