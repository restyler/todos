<template>
  <div class="modal" id="todo_form">
    <div class="header">
      <div class="title">Add Todo</div>
      <button class="btn close-modal">&times;</button>
    </div>
    <div class="body">
      <input type="text" id="todo_input"/>
      <input type="submit" value="Add Todo" id="todo_submit"/>
    </div>
  </div>
</template>

<script>
export default {
  name: "AddModal"
}
</script>

<style scoped>

</style>