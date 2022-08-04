<script>
export default {
  props: ['tasks']
}
</script>
<template>
  <div v-for="(task, index) in tasks" class="card">
    <div class="card-body">
      <h5 class="card-title">
        {{ task.title }}
      </h5>
      <p class="card-text">
        {{ task.description }}
      </p>
      <a href="#" class="card-link">Удалить</a>
      <a href="#" class="card-link">Пометить сделанной</a>
    </div>
  </div>
</template>
