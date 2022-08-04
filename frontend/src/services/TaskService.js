import axios from "axios";

const apiClient = axios.create({
    baseURL: 'http://127.0.0.1:8000',
})

export default {
    createTask(board, title) {
        return apiClient.post('/task', {
            title: title,
            board: board
        })
    },
    getTasks(boardId) {
        return apiClient.get('/tasks?id=' + boardId)
    },
    getTasksAll() {
        return apiClient.get('/tasks/all')
    },
    setDone(taskId) {
        return apiClient.patch('/task/done?id=' + taskId)
    },
    setUnDone(taskId) {
        return apiClient.patch('/task/undone?id=' + taskId)
    },
    move(taskId, boardId) {
        return apiClient.patch('/task/move', {
            id: taskId,
            board: boardId
        })
    },
    remove(taskId) {
        return apiClient.delete('/task?id=' + taskId)
    },
}