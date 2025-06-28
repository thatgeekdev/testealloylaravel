<template>
  <div class="task-container">
    <div v-if="store.isLoading">Carregando...</div>
    <div v-else>
      <TaskItem
        v-for="task in store.tasks"
        :key="task.id"
        :task="task"
        @edit="$emit('edit', $event)"
      />
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useTaskStore } from '@/stores/taskStore'
import TaskItem from './TaskItem.vue'

const store = useTaskStore()

onMounted(() => {
  store.fetchTasks()
})
</script>
