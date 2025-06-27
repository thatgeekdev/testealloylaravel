<script setup>
import { ref, onMounted } from 'vue';
import TaskList from '@/components/TaskList.vue';
import TaskModal from '@/components/TaskModal.vue';
import { useTaskStore } from '@/stores/taskStore';
import { storeToRefs } from 'pinia';

const store = useTaskStore();
const { tasks, selectedTask } = storeToRefs(store);
const showModal = ref(true);

onMounted(() => {
  store.fetchTasks();
});

const openModal = (task = null) => {
  
  store.selectTask(task);
  showModal.value = true;
};

const closeModal = () => {
  store.clearSelected();
  showModal.value = false;
};

const saveTask = async (task) => {
  if (task.id) {
    await store.editTask(task);
  } else {
    if (!task.finalizado) task.finalizado = false;
    await store.addTask(task);
  }
  closeModal();
};

const deleteTask = async (id) => {
  await store.removeTask(id);
};

const toggleTask = async (id) => {
  await store.toggleTaskFinalizado(id);
};
</script>

<template>
  <div class="content-tasks">

    <TaskList
      :tasks="tasks"
      @delete="deleteTask"
      @toggle="toggleTask"
      @edit="openModal"
    />

    <TaskModal
      :visible="showModal"
      :task="selectedTask"
      @close="closeModal"
      @save="saveTask"
    />
  </div>
</template>
