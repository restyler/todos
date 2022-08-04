<script>
import BoardService from "../services/BoardService";
import Task from "./Task.vue";
import TaskService from "../services/TaskService";

export default {
  data() {
    return {
      boards: []
    }
  },
  mounted() {
    BoardService.getBoards().then((boards) => {
      this.boards = boards.data.data

      for (let i = 0; i < this.boards.length; i++) {
        TaskService.getTasks(this.boards[i].id).then((tasks) => {
          this.boards[i].tasks = tasks.data.data
        })
      }
    })
  },
  methods: {
    done(taskId) {
      TaskService.setDone(taskId).then((response) => {
        if (response.data.success) {
          for (let i = 0; i < this.boards.length; i++) {
            for (let j = 0; j < this.boards[i].tasks.length; j++) {
              if (this.boards[i].tasks[j].id == taskId) {
                this.boards[i].tasks[j].status = 1

                break
              }
            }
          }
        }
      }).catch((error) => {
        console.log(error)
      })
    },
    undone(taskId) {
      TaskService.setUnDone(taskId).then((response) => {
        if (response.data.success) {
          for (let i = 0; i < this.boards.length; i++) {
            for (let j = 0; j < this.boards[i].tasks.length; j++) {
              if (this.boards[i].tasks[j].id == taskId) {
                this.boards[i].tasks[j].status = 0

                break
              }
            }
          }
        }
      }).catch((error) => {
        console.log(error)
      })
    },
    remove(taskId, boardId) {
      TaskService.remove(taskId).then((response) => {
        if (response.data.success) {
          TaskService.getTasksAll().then((tasks) => {
            this.boards = tasks.data.data
          })
        }
      }).catch((error) => {
        console.log(error)
      })
    },
    toUrgent(taskId) {
      TaskService.moveToUrgent(taskId).then((response) => {
        if (response.data.success) {
          TaskService.getTasksAll().then((tasks) => {
            this.boards = tasks.data.data
          })
        }
      }).catch((error) => {
        console.log(error)
      })
    },
  }
}
</script>

<template>
  <div class="greetings">
    <h1>Boards</h1>

    <div class="row">
      <div v-for="(board, index) in boards" class="col-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{ board.name }}</h5>

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
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
