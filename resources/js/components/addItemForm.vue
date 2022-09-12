<template>
    <div class="mt-5">
        <form class="input-group m-auto" @submit.prevent="addItem()">
            <input type="text"
                   class="form-control"
                   placeholder="Agregar item"
                   aria-label="Agregar item"
                   aria-describedby="add-btn"
                   v-model="task.title"
            />
            <button class="btn btn-primary"
                    type="submit"
                    id="add-btn"
            >
                +Agregar
            </button>
        </form>
    </div>
</template>
<script>
import axios from "axios";

export default {
    data: function () {
        return {
            task: {
                title: ""
            }
        };
    },
    methods: {
        addItem() {
            if (this.task.title == "") {
                return;
            }
            axios
                .post("api/task/store", {
                    task: this.task
                })
                .then(res => {
                    if (res.status == 201) {
                        this.task.title = "";
                        this.$emit("reloadlist");
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
};
</script>

<style scoped>
.active {
    color: white;
    background-color: blue;
}

.inactive {
    color: gray;
}
</style>
