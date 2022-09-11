<template>
    <li class="list-group-item d-flex align-items-center justify-content-between w-50">
        <input
            type="checkbox"
            @change="handleCompleteTask()"
            v-model="task.completed"
            class="form-check-input"
            :value="task.completed"
            :id="task.id"
            v-bind:id="task.id"
            :checked="task.completed"
            value="accepted"
        />
        <span :class="[task.completed ? 'completed' : '', 'task']">
            {{ task.title }}
        </span>
        <button v-if="!!select" class="btn btn-danger" @click="removeTask()">X</button>
        <button v-if="!select" class="btn btn-outline-primary" @click="selectTask()"
                style="min-width: 37px;min-height: 37px;">
            {{ task.deleted === true ? "✓" : "" }}
        </button>
    </li>
</template>

<script>
import axios from "axios";

export default {
    props: ["task", "select"],
    watch: {
        select: function () {
            this.task.deleted = false;
        }
    },
    methods: {
        selectTask() {
            this.task.deleted = !this.task.deleted;
            this.$emit("taskSelected", this.task);
        },
        handleCompleteTask() {
            axios
                .put(`api/task/${this.task.id}`, {
                    task: this.task
                })
                .then(res => {
                    if (res.status == 200) {
                        this.$emit("taskchanged");
                    }
                })
                .catch(error => {
                    console.log("error from axios put", errors);
                });
        },
        removeTask() {
            axios
                .delete(`api/task/${this.task.id}`)
                .then(res => {
                    if (res.status == 200) {
                        this.$emit("taskchanged");
                    }
                })
                .catch(error => {
                    console.log("error from axios delte ", error);
                });
        }
    }
};
</script>

<style>
.completed {
    text-decoration: line-through;
    color: gray;
}

.task {
    word-break: break-all;
}
</style>
