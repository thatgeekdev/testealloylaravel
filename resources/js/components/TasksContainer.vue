<template>
  <Appbar @add="openNewTaskModal" />

  <TaskList @edit="openEditModal" />

  <TaskModal
    :show="showModal"
    :task-to-edit="taskBeingEdited"
    @close="closeModal"
  />
</template>

<script setup>
import { ref } from 'vue'
import Appbar from './Appbar.vue'
import TaskList from './TaskList.vue'
import TaskModal from './TaskModal.vue'
import { useTaskStore } from '@/stores/taskStore'



const taskStore = useTaskStore()

const showModal = ref(false)
const taskBeingEdited = ref(null)

function openNewTaskModal() {
  taskBeingEdited.value = null
  showModal.value = true
}

function openEditModal(task) {
  taskBeingEdited.value = { ...task }
  showModal.value = true
}

function closeModal() {
  showModal.value = false
  taskBeingEdited.value = null
  taskStore.fetchTasks()
}
</script>
