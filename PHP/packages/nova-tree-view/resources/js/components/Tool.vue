<template>
    <div>
        <heading class="mb-6">Tree View</heading>

        <div class="flex">
            <card style="width: 300px" class="mr-6">
                <div class="card-title p-4 font-bold">Main</div>
                <div class="card-body p-4 border-t">
                    <tree-view />
                </div>
            </card>

            <card style="flex: 1">
                <div class="card-title p-4"><span style="color: #aaa">Home » </span> <span class="font-bold">Name</span>
                </div>
                <div class="card-body p-4">
                    Hello World
                </div>
            </card>
        </div>


    </div>
</template>

<script>
    import TreeView from './TreeView';

    export default {
        metaInfo() {
            return {
                title: 'TreeView',
            }
        },
        components: {
            'tree-view': TreeView
        },
        mounted() {
            //
        },
    }
</script>

<style>
    .card-body {
        border-top: 1px solid rgba(0, 0, 0, .125)
    }
</style>
