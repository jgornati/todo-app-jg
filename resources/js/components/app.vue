<template>
    <div class="container w-100 m-auto text-center mt-3">
        <h1>Laravel-Vue ToDo</h1>
        <add-item-form v-on:reloadlist="getTasks()"/>
        <p v-if="tasks.length <= 0" class="mt-5">
            No hay tareas agregue alguna 🚀
        </p>
        <list-view
            :tasks="tasks"
            v-on:reloadlist="getTasks()"
            class="text-center"
        />
    </div>
</template>

<script>
import addItemForm from "./addItemForm.vue";
import listView from "./listView.vue";
import axios from 'axios';
export default {
    components: {
        addItemForm,
        listView
    },

    data: function() {
        return {
            tasks: []
        };
    },
    methods: {
        getTasks() {
            axios
                .get("api/tasks")
                .then(res => {
                    this.tasks = res.data;
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    created() {
        this.getTasks();
    }
};
</script>

<style scoped></style>
