<template>
    <div v-if="tasks.length > 0" class="mt-4 mb-1 w-100 m-auto flex justify-content-between">
        <button v-if="!!show" class="btn btn-outline-danger" @click="deleteAll()">
            🗑 &nbsp;Borrar todo
        </button>
        <button v-if="!show" @click="deleteSelectedTasks()">
            🗑 &nbsp;Borrar seleccion
        </button>

        <button v-if="tasks.length > 1" class="btn btn-outline-primary" @click="show = !show">
            <span v-if="!!show">
                ✅ &nbsp;Seleccionar
            </span>
            <span v-if="!show">
                🔙 &nbsp;Cancelar
            </span>
        </button>
    </div>
    <div class="">
        <ul class="list-group">
            <list-item
                :task="task"
                :select="show"
                v-on:taskchanged="$emit('reloadlist')"
                v-on:taskSelected="addTaskToDeleteArray"
                v-for="task in tasks"
                v-bind:key="task.id"
                :key="task.id"
                class="m-auto text-justify text-wrap"
            />
        </ul>
    </div>
</template>

<script>
import listItem from "./listItem.vue";
import axios from "axios";

export default {
    data() {
        return {
            show: true,
            listTaskToDelete: []
        }
    },
    components: {
        listItem
    },
    props: ["tasks"],
    watch: {
        show: function () {
            this.listTaskToDelete = [];
        }
    },
    methods: {
        deleteSelectedTasks() {
            axios
                .post(`api/task`, {tasks: this.listTaskToDelete})
                .then(res => {
                    if (res.status == 200) {
                        this.$emit('reloadlist')
                    }
                })
                .catch(error => {
                    console.log("error from axios delte ", error);
                });
        },
        addTaskToDeleteArray(task) {
            this.listTaskToDelete.push(task);
            console.log(this.listTaskToDelete)
        },
        deleteAll() {
            axios
                .post(`api/task`)
                .then(res => {
                    if (res.status == 200) {
                        this.$emit('reloadlist')
                    }
                })
                .catch(error => {
                    console.log("error from axios delte ", error);
                });

        }
    }
};
</script>

<style scoped></style>
