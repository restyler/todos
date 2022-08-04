import axios from "axios";

const apiClient = axios.create({
    baseURL: 'http://127.0.0.1:8000',
})

export default {
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
    moveToUrgent(taskId) {
        return apiClient.patch('/task/urgent?id=' + taskId)
    },
    remove(taskId) {
        return apiClient.delete('/task?id=' + taskId)
    },
}