<script>
import TaskService from "../services/TaskService";

export default {
  data() {
    return {
      boards: [],
      newTask: ""
    }
  },
  mounted() {
    TaskService.getTasksAll().then((boards) => {
      this.boards = boards.data.data
    })
  },
  methods: {
    done(taskId) {
      TaskService.setDone(taskId).then((response) => {
        if (response.data.success) {
          this.getUpdatedTasks()
        }
      }).catch((error) => {
        console.log(error)
      })
    },
    undone(taskId) {
      TaskService.setUnDone(taskId).then((response) => {
        if (response.data.success) {
          this.getUpdatedTasks()
        }
      }).catch((error) => {
        console.log(error)
      })
    },
    remove(taskId) {
      TaskService.remove(taskId).then((response) => {
        if (response.data.success) {
          this.getUpdatedTasks()
        }
      }).catch((error) => {
        console.log(error)
      })
    },
    toUrgent(taskId) {
      TaskService.moveToUrgent(taskId).then((response) => {
        if (response.data.success) {
          this.getUpdatedTasks()
        }
      }).catch((error) => {
        console.log(error)
      })
    },
    addTask(boardId) {
      let title = this.$refs['newTask' + boardId][0].value

      TaskService.createTask(boardId, title.trim()).then((response) => {
        if (response.data.success) {
          for (let i = 0; i < this.boards.length; i++) {
              if (this.boards[i].id == boardId) {
                this.boards[i].tasks.push(response.data.data)
                this.boards[i].count += 1
                this.$refs['newTask' + boardId][0].value = null

                break
              }

          }
        }
      }).catch((error) => {
        console.log(error)
      })
    },
    getUpdatedTasks() {
      TaskService.getTasksAll().then((tasks) => {
        this.boards = tasks.data.data
      })
    }
  }
}
</script>

<template>
  <div class="greetings">
    <h1>Tasks</h1>

    <div class="row py-3">
      <div v-for="(board, index) in boards" class="col-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">
              {{ board.name }}

              <span class="badge rounded-pill bg-primary">
                {{ board.count }}
              </span>
            </h5>

            <div v-for="(task, index) in board.tasks" class="card my-3">
              <div class="card-body" v-show="task">
                <p class="card-text text-bold"
                   :class="task.status ? ' text-decoration-line-through' : ''">
                  {{ task.title }}
                </p>

                <a v-if="!task.status" @click="done(task.id)" class="card-link">done</a>
                <a v-else href="#" @click="undone(task.id)" class="card-link">undone</a>

                <a @click="remove(task.id, board.id)" class="card-link">delete</a>
                <a v-show="board.name !== 'Urgent'" @click="toUrgent(task.id)" href="#" class="card-link">to urgent</a>
              </div>
            </div>

            <form @submit.prevent="addTask(board.id)">
              <input type="text" :ref="'newTask' + board.id" class="form-control" placeholder="New task">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
